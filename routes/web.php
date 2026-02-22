<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('home');

Route::view('/about', 'pages.about')->name('about');
Route::view('/courses', 'pages.courses')->name('courses');
Route::get('/mentors', [SiteController::class, 'mentors'])->name('mentors');
Route::view('/reviews', 'pages.reviews')->name('reviews');
Route::view('/news', 'pages.news')->name('news');
Route::view('/contact', 'pages.contact')->name('contact');

Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/terms', 'pages.terms')->name('terms');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

