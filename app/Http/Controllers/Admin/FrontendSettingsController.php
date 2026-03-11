<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateFrontendHeaderSettingsRequest;
use App\Models\FrontendSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Manage frontend settings.
 *
 * @category Controller
 * @package  App\Http\Controllers\Admin
 * @author   Unknown <unknown@example.invalid>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://laravel.com
 */
class FrontendSettingsController extends Controller implements HasMiddleware
{
    /**
     * Controller middleware.
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
     * Update the header settings.
     *
     * @param UpdateFrontendHeaderSettingsRequest $request Request.
     *
     * @return RedirectResponse
     */
    public function updateHeader(
        UpdateFrontendHeaderSettingsRequest $request
    ): RedirectResponse {
        $this->upsertSetting(
            'site_address',
            [
                'value_en' => $request->validated('site_address_en'),
                'value_bn' => $request->validated('site_address_bn'),
            ]
        );

        $phone = $request->validated('site_phone');
        $email = $request->validated('site_email');

        $this->upsertSetting(
            'site_phone',
            [
                'value_en' => $phone,
                'value_bn' => $phone,
            ]
        );
        $this->upsertSetting(
            'site_email',
            [
                'value_en' => $email,
                'value_bn' => $email,
            ]
        );

        if ($request->hasFile('site_logo')) {
            $logoPath = $request->file('site_logo')->store('logo', 'public');

            $existing = FrontendSetting::query()
                ->where('key', 'site_logo_path')
                ->first();

            $oldPath = $existing
                ? ($existing->value_en ?: $existing->value_bn)
                : null;

            $oldPath = is_string($oldPath)
                ? $this->normalizePublicStoragePath($oldPath)
                : null;

            $newPath = $this->normalizePublicStoragePath($logoPath);

            $this->upsertSetting(
                'site_logo_path',
                [
                    'value_en' => $newPath,
                    'value_bn' => $newPath,
                ]
            );

            if ($oldPath && $oldPath !== $newPath) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        if ($request->hasFile('site_favicon')) {
            $faviconPath = $request->file('site_favicon')->store('favicon', 'public');

            $existingFavicon = FrontendSetting::query()
                ->where('key', 'site_favicon_path')
                ->first();

            $oldFaviconPath = $existingFavicon
                ? ($existingFavicon->value_en ?: $existingFavicon->value_bn)
                : null;

            $oldFaviconPath = is_string($oldFaviconPath)
                ? $this->normalizePublicStoragePath($oldFaviconPath)
                : null;

            $newFaviconPath = $this->normalizePublicStoragePath($faviconPath);

            $this->upsertSetting(
                'site_favicon_path',
                [
                    'value_en' => $newFaviconPath,
                    'value_bn' => $newFaviconPath,
                ]
            );

            if ($oldFaviconPath && $oldFaviconPath !== $newFaviconPath) {
                Storage::disk('public')->delete($oldFaviconPath);
            }
        }

        FrontendSetting::forgetCache();

        return redirect()
            ->route('admin.frontend-editor.index', ['tab' => 'header'])
            ->with('success', 'Header settings updated.');
    }

    /**
     * Upsert a setting by key.
     *
     * @param string               $key    Setting key.
     * @param array<string, mixed> $values Values.
     *
     * @return void
     */
    protected function upsertSetting(string $key, array $values): void
    {
        FrontendSetting::query()->updateOrCreate(
            ['key' => $key],
            array_merge(['key' => $key], $values)
        );
    }

    /**
     * Normalize a logo path to a public-disk relative path.
     *
     * Examples:
     * - https://domain.com/storage/logo/a.png -> logo/a.png
     * - /storage/logo/a.png -> logo/a.png
     * - storage/logo/a.png -> logo/a.png
     * - logo/a.png -> logo/a.png
     */
    protected function normalizePublicStoragePath(string $path): string
    {
        $value = trim($path);

        $parsedPath = parse_url($value, PHP_URL_PATH);
        if (is_string($parsedPath) && $parsedPath !== '') {
            $value = $parsedPath;
        }

        $value = ltrim($value, '/');

        if (Str::startsWith($value, 'storage/')) {
            $value = (string) Str::after($value, 'storage/');
        }

        return $value;
    }
}
