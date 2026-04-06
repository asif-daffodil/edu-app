<?php

use App\Http\Controllers\SiteController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\WysiwygUploadController;
use Illuminate\Support\Facades\Route;

Route::get(
    '/language/{lang}',
    function (string $lang) {
        if (in_array($lang, ['en', 'bn'], true)) {
            session(['locale' => $lang]);
        }

        return redirect()->back();
    }
)->name('language.switch');

Route::middleware('frontend.locale')->group(
    function () {
        Route::get('/', [SiteController::class, 'home'])->name('home');

        Route::get('/about', [SiteController::class, 'page'])
            ->defaults('slug', 'about')
            ->name('about');

        Route::get('/courses', [SiteController::class, 'page'])
            ->defaults('slug', 'courses')
            ->name('courses');

        Route::get('/courses/{course}', [SiteController::class, 'course'])
            ->whereNumber('course')
            ->name('courses.show');

        Route::middleware('auth')->group(
            function () {
                Route::get(
                    '/courses/{course}/checkout',
                    [CheckoutController::class, 'show']
                )
                    ->whereNumber('course')
                    ->name('checkout.show');

                Route::post(
                    '/courses/{course}/checkout',
                    [CheckoutController::class, 'store']
                )
                    ->whereNumber('course')
                    ->name('checkout.store');

                Route::get(
                    '/checkout/orders/{order}',
                    [CheckoutController::class, 'success']
                )
                    ->whereNumber('order')
                    ->name('checkout.success');
            }
        );

        Route::get('/mentors', [SiteController::class, 'mentors'])->name('mentors');

        Route::get('/mentors/{mentor}', [SiteController::class, 'mentorShow'])
            ->whereNumber('mentor')
            ->name('mentors.show');

        Route::get('/reviews', [SiteController::class, 'page'])
            ->defaults('slug', 'reviews')
            ->name('reviews');

        Route::get('/news', [SiteController::class, 'news'])->name('news');
        Route::get('/news/data', [SiteController::class, 'newsData'])->name('news.data');
        Route::get('/news/{newsUpdate}', [SiteController::class, 'newsShow'])->name('news.show');

        Route::get('/privacy', [SiteController::class, 'page'])
            ->defaults('slug', 'privacy')
            ->name('privacy');

        Route::get('/terms', [SiteController::class, 'page'])
            ->defaults('slug', 'terms')
            ->name('terms');

        include __DIR__.'/auth.php';
    }
);

Route::get(
    '/dashboard',
    function () {
        return view('dashboard');
    }
)->middleware(['auth', 'verified', 'backend.locale'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:admin', 'backend.locale'])
    ->prefix('admin')
    ->name('admin.')
    ->group(
        function () {
            Route::post(
                '/wysiwyg/upload',
                [WysiwygUploadController::class, 'upload']
            )->name('wysiwyg.upload');
        }
    );

