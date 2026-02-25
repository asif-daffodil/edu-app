<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Frontend setting model.
 *
 * @category Model
 * @package  App\Models
 * @author   Unknown <unknown@example.invalid>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://laravel.com
 */
class FrontendSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'value_en',
        'value_bn',
    ];

    /**
     * Get value for current locale with fallback.
     *
     * @param string|null $locale Locale code.
     *
     * @return string|null
     */
    public function localizedValue(?string $locale = null): ?string
    {
        $locale = $locale ?: app()->getLocale();

        if ($locale === 'bn') {
            return $this->value_bn ?: $this->value_en;
        }

        return $this->value_en ?: $this->value_bn;
    }

    /**
     * Cached settings keyed by `key`.
     *
     * @return Collection<string, self>
     */
    public static function getCachedKeyed(): Collection
    {
        /**
         * Cached collection.
         *
         * @var Collection<string, self> $keyed
         */
        $keyed = Cache::rememberForever(
            'frontend_settings.keyed',
            function () {
                return self::query()->get()->keyBy('key');
            }
        );

        return $keyed;
    }

    /**
     * Forget settings cache.
     *
     * @return void
     */
    public static function forgetCache(): void
    {
        Cache::forget('frontend_settings.keyed');
    }
}
