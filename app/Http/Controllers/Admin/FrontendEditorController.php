<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFrontendSectionRequest;
use App\Http\Requests\Admin\UpdateFrontendSectionRequest;
use App\Models\FrontendPage;
use App\Models\FrontendSetting;
use App\Models\FrontendSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Frontend editor controller.
 *
 * @category Controller
 * @package  App\Http\Controllers\Admin
 * @author   Unknown <unknown@example.invalid>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://laravel.com
 */
class FrontendEditorController extends Controller implements HasMiddleware
{
    /**
     * Define controller middleware.
     *
     * @return array<int, Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('verified'),
            new Middleware('role:admin'),
            new Middleware('backend.locale'),
        ];
    }

    /**
     * Display the frontend editor.
     *
     * @param Request $request The incoming request.
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $allowedSlugs = ['home', 'about', 'courses', 'contact'];

        $tab = (string) $request->query('tab', 'pages');
        if (!in_array($tab, ['pages', 'header'], true)) {
            $tab = 'pages';
        }

        foreach ($allowedSlugs as $slug) {
            FrontendPage::query()->firstOrCreate(['slug' => $slug]);
        }

        $pages = FrontendPage::query()
            ->whereIn('slug', $allowedSlugs)
            ->orderByRaw("FIELD(slug, 'home', 'about', 'courses', 'contact')")
            ->get();

        $selectedSlug = (string) $request->query('page', 'home');
        if (!in_array($selectedSlug, $allowedSlugs, true)) {
            $selectedSlug = 'home';
        }

        $selectedPage = $pages->firstWhere('slug', $selectedSlug)
            ?: FrontendPage::query()->where('slug', 'home')->firstOrFail();

        $sections = collect();
        if ($tab === 'pages') {
            $sections = FrontendSection::query()
                ->where('frontend_page_id', $selectedPage->id)
                ->orderBy('section_key')
                ->get();
        }

        $settings = collect();
        if ($tab === 'header' && Schema::hasTable('frontend_settings')) {
            $settings = FrontendSetting::query()->get()->keyBy('key');
        }

        return view(
            'admin.frontend-editor.index',
            [
                'pages' => $pages,
                'selectedPage' => $selectedPage,
                'sections' => $sections,
                'allowedSlugs' => $allowedSlugs,
                'tab' => $tab,
                'settings' => $settings,
            ]
        );
    }

    /**
     * Store a new section for a page.
     *
     * @param StoreFrontendSectionRequest $request The validated request.
     * @param FrontendPage                $page    The page model.
     *
     * @return RedirectResponse
     */
    public function store(
        StoreFrontendSectionRequest $request,
        FrontendPage $page
    ): RedirectResponse {
        $validated = $request->validated();

        $data = [
            'frontend_page_id' => $page->id,
            'section_key' => $validated['section_key'],
            'title_bn' => $validated['title_bn'] ?? null,
            'title_en' => $validated['title_en'] ?? null,
            'content_bn' => $validated['content_bn'] ?? null,
            'content_en' => $validated['content_en'] ?? null,
            'button_text_bn' => $validated['button_text_bn'] ?? null,
            'button_text_en' => $validated['button_text_en'] ?? null,
            'button_link' => $validated['button_link'] ?? null,
            'status' => $validated['status'],
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data['image_path'] = $image->store('frontend-sections', 'public');
        }

        FrontendSection::query()->create($data);

        return redirect()
            ->route('admin.frontend-editor.index', ['page' => $page->slug])
            ->with('success', 'Section created successfully.');
    }

    /**
     * Update an existing section.
     *
     * @param UpdateFrontendSectionRequest $request The validated request.
     * @param FrontendSection              $section The section model.
     *
     * @return RedirectResponse
     */
    public function update(
        UpdateFrontendSectionRequest $request,
        FrontendSection $section
    ): RedirectResponse {
        $validated = $request->validated();

        $data = [
            'title_bn' => $validated['title_bn'] ?? null,
            'title_en' => $validated['title_en'] ?? null,
            'content_bn' => $validated['content_bn'] ?? null,
            'content_en' => $validated['content_en'] ?? null,
            'button_text_bn' => $validated['button_text_bn'] ?? null,
            'button_text_en' => $validated['button_text_en'] ?? null,
            'button_link' => $validated['button_link'] ?? null,
            'status' => $validated['status'],
        ];

        if ($request->hasFile('image')) {
            $oldPath = $section->image_path;
            $image = $request->file('image');
            $data['image_path'] = $image->store('frontend-sections', 'public');

            if (is_string($oldPath) && $oldPath !== '') {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $section->update($data);

        $pageSlug = $section->page ? $section->page->slug : 'home';

        return redirect()
            ->route('admin.frontend-editor.index', ['page' => $pageSlug])
            ->with('success', 'Section updated successfully.');
    }

    /**
     * Bulk update (upsert) multiple sections for a page.
     *
     * Currently used by the Home tab to edit hero-related fields in a single
     * form.
     *
     * @param Request      $request The incoming request.
     * @param FrontendPage $page    The page model.
     *
     * @return RedirectResponse
     */
    public function bulkUpdate(
        Request $request,
        FrontendPage $page
    ): RedirectResponse {
        $fixedKeys = [
            'hero_cta_primary',
            'hero_emphasis',
            'hero_paragraph',
            'hero_primary',
            'hero_side_heading',

            'home_about_title',
            'home_about_subtitle',
            'home_about_card_1',
            'home_about_card_2',
            'home_about_card_3',

            'home_skill_tracks_title',
            'home_skill_tracks_subtitle',
            'home_skill_tracks_cta',
        ];

        $validated = $request->validate(
            [
                'sections' => ['required', 'array'],
                'sections.*' => ['array'],

                'sections.*.title_bn' => ['nullable', 'string', 'max:255'],
                'sections.*.title_en' => ['nullable', 'string', 'max:255'],
                'sections.*.content_bn' => ['nullable', 'string'],
                'sections.*.content_en' => ['nullable', 'string'],
                'sections.*.button_text_bn' => [
                    'nullable',
                    'string',
                    'max:255',
                ],
                'sections.*.button_text_en' => [
                    'nullable',
                    'string',
                    'max:255',
                ],
                'sections.*.button_link' => ['nullable', 'string', 'max:255'],
                'sections.*.status' => [
                    'required',
                    Rule::in(['active', 'inactive']),
                ],
            ],
            [],
            [
                'sections.*.title_bn' => 'Bangla title',
                'sections.*.title_en' => 'English title',
                'sections.*.content_bn' => 'Bangla content',
                'sections.*.content_en' => 'English content',
                'sections.*.button_text_bn' => 'Bangla button text',
                'sections.*.button_text_en' => 'English button text',
                'sections.*.button_link' => 'Button link',
                'sections.*.status' => 'Status',
            ]
        );

        $sectionsPayload = $validated['sections'] ?? [];

        foreach ($sectionsPayload as $sectionKey => $payload) {
            $sectionKey = (string) $sectionKey;

            $isFixed = in_array($sectionKey, $fixedKeys, true);
            $isHeroReason = false;
            $isSkillTrack = false;

            if (preg_match('/^hero_different_reason_(\d+)$/', $sectionKey, $m)) {
                $index = (int) $m[1];
                $isHeroReason = $index >= 1 && $index <= 50;
            }

            if (preg_match('/^home_skill_track_(\d+)$/', $sectionKey, $m)) {
                $index = (int) $m[1];
                $isSkillTrack = $index >= 1 && $index <= 20;
            }

            if (! $isFixed && ! $isHeroReason && ! $isSkillTrack) {
                continue;
            }

            $payload = is_array($payload) ? $payload : [];

            FrontendSection::query()->updateOrCreate(
                [
                    'frontend_page_id' => $page->id,
                    'section_key' => $sectionKey,
                ],
                [
                    'title_bn' => $payload['title_bn'] ?? null,
                    'title_en' => $payload['title_en'] ?? null,
                    'content_bn' => $payload['content_bn'] ?? null,
                    'content_en' => $payload['content_en'] ?? null,
                    'button_text_bn' => $payload['button_text_bn'] ?? null,
                    'button_text_en' => $payload['button_text_en'] ?? null,
                    'button_link' => $payload['button_link'] ?? null,
                    'status' => $payload['status'] ?? FrontendSection::STATUS_ACTIVE,
                ]
            );
        }

        return redirect()
            ->route('admin.frontend-editor.index', ['page' => $page->slug])
            ->with('success', 'Home hero sections updated successfully.');
    }
}
