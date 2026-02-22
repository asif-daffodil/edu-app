<?php

use Illuminate\Support\Facades\Route;
use Modules\Mentors\Http\Controllers\MentorController;

Route::middleware(['auth', 'backend.locale'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(
        function () {
            Route::resource('mentors', MentorController::class)->names('mentors');
        }
    );
