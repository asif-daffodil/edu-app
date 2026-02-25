<?php

namespace App\Providers;

use App\Models\FrontendSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Application service provider.
 *
 * @category Provider
 * @package  App\Providers
 * @author   Unknown <unknown@example.invalid>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://laravel.com
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        View::composer(
            'layouts.site',
            function ($view) {
                $defaults = [
                    'site_address' => app()->getLocale() === 'bn'
                        ? 'ঢাকা, বাংলাদেশ'
                        : 'Dhaka, Bangladesh',
                    'site_phone' => '+880 10 0000 0000',
                    'site_email' => 'info@example.com',
                    'site_logo_path' => null,
                ];

                if (! Schema::hasTable('frontend_settings')) {
                    $view->with('frontendSettings', $defaults);

                    return;
                }

                $keyed = FrontendSetting::getCachedKeyed();

                $get = function (string $key) use ($keyed, $defaults) {
                    $setting = $keyed->get($key);

                    return $setting ? $setting->localizedValue() : $defaults[$key];
                };

                $frontendSettings = [
                    'site_address' => $get('site_address'),
                    'site_phone' => $get('site_phone'),
                    'site_email' => $get('site_email'),
                    'site_logo_path' => $get('site_logo_path'),
                ];

                $view->with('frontendSettings', $frontendSettings);
            }
        );
    }
}
