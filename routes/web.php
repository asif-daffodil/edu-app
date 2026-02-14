<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::view('/about', 'pages.about')->name('about');
Route::view('/courses', 'pages.courses')->name('courses');
Route::view('/mentors', 'pages.mentors')->name('mentors');
Route::view('/reviews', 'pages.reviews')->name('reviews');
Route::view('/news', 'pages.news')->name('news');
Route::view('/contact', 'pages.contact')->name('contact');

Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/terms', 'pages.terms')->name('terms');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
