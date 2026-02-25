<?php

namespace App\Http\Controllers;

use App\Models\FrontendPage;
use App\Models\FrontendSection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Modules\Mentors\Models\Mentor;

/**
 * Public site controller.
 *
 * @category Controller
 * @package  App\Http\Controllers
 * @author   Unknown <unknown@example.invalid>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://laravel.com
 */
class SiteController extends Controller
{
    /**
     * Load CMS page + sections for a given slug.
     *
     * @param string $slug Page slug.
     *
     * @return array{
     *     cmsPage: FrontendPage,
     *     cmsSections: Collection<int, FrontendSection>,
     *     cmsSectionsByKey: Collection<string, FrontendSection>
     * }
     */
    protected function loadCms(string $slug): array
    {
        $hasPagesTable = Schema::hasTable('frontend_pages');
        $hasSectionsTable = Schema::hasTable('frontend_sections');

        if (! $hasPagesTable || ! $hasSectionsTable) {
            $cmsPage = new FrontendPage(['slug' => $slug]);
            $cmsSections = new Collection();

            /**
             * Empty keyed sections collection.
             *
             * @var Collection<string, FrontendSection> $cmsSectionsByKey
             */
            $cmsSectionsByKey = new Collection();

            return compact('cmsPage', 'cmsSections', 'cmsSectionsByKey');
        }

        $cmsPage = FrontendPage::query()->firstOrCreate(['slug' => $slug]);

        $cmsSections = FrontendSection::query()
            ->where('frontend_page_id', $cmsPage->id)
            ->active()
            ->orderBy('section_key')
            ->get();

        /**
         * Keyed sections collection.
         *
         * @var Collection<string, FrontendSection> $cmsSectionsByKey
         */
        $cmsSectionsByKey = $cmsSections->keyBy('section_key');

        return compact('cmsPage', 'cmsSections', 'cmsSectionsByKey');
    }

    /**
     * Show the home page.
     *
     * @return View
     */
    public function home(): View
    {
        $cms = $this->loadCms('home');

        $mentors = Mentor::query()
            ->where('is_active', true)
            ->orderByDesc('id')
            ->limit(12)
            ->get(['id', 'name', 'topic', 'bio']);

        return view('welcome', array_merge($cms, compact('mentors')));
    }

    /**
     * Show the mentors page.
     *
     * @return View
     */
    public function mentors(): View
    {
        $cms = $this->loadCms('mentors');

        $mentors = Mentor::query()
            ->where('is_active', true)
            ->orderByDesc('id')
            ->paginate(12);

        return view('pages.mentors', array_merge($cms, compact('mentors')));
    }

    /**
     * Show a generic CMS-driven page.
     *
     * @param string $slug Page slug.
     *
     * @return View
     */
    public function page(string $slug): View
    {
        $cms = $this->loadCms($slug);

        return view('pages.' . $slug, $cms);
    }
}
