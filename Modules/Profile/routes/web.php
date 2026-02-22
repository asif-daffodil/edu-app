<?php

use Illuminate\Support\Facades\Route;
use Modules\Profile\Http\Controllers\Admin\UserProfileController as AdminUserProfileController;
use Modules\Profile\Http\Controllers\PublicProfileController;
use Modules\Profile\Http\Controllers\ProfileController;

Route::get('/p/{public_url}', [PublicProfileController::class, 'show'])
    ->name('profile.public.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::patch('/profile/public-url', [ProfileController::class, 'updatePublicUrl'])
        ->name('profile.public-url.update');

    Route::patch('/profile/details', [ProfileController::class, 'updateDetails'])->name('profile.details.update');
    Route::put('/profile/address', [ProfileController::class, 'updateAddress'])->name('profile.address.update');

    Route::post('/profile/educations', [ProfileController::class, 'storeEducation'])->name('profile.educations.store');
    Route::patch('/profile/educations/{education}', [ProfileController::class, 'updateEducation'])->name('profile.educations.update');
    Route::delete('/profile/educations/{education}', [ProfileController::class, 'destroyEducation'])->name('profile.educations.destroy');

    Route::post('/profile/experiences', [ProfileController::class, 'storeExperience'])->name('profile.experiences.store');
    Route::patch('/profile/experiences/{experience}', [ProfileController::class, 'updateExperience'])->name('profile.experiences.update');
    Route::delete('/profile/experiences/{experience}', [ProfileController::class, 'destroyExperience'])->name('profile.experiences.destroy');

    Route::post('/profile/skills', [ProfileController::class, 'storeSkill'])->name('profile.skills.store');
    Route::patch('/profile/skills/{skill}', [ProfileController::class, 'updateSkill'])->name('profile.skills.update');
    Route::delete('/profile/skills/{skill}', [ProfileController::class, 'destroySkill'])->name('profile.skills.destroy');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin/users/{user}/profile')
    ->name('admin.users.profile.')
    ->group(function () {
        Route::get('/', [AdminUserProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [AdminUserProfileController::class, 'update'])->name('update');

        Route::patch('/details', [AdminUserProfileController::class, 'updateDetails'])->name('details.update');
        Route::put('/address', [AdminUserProfileController::class, 'updateAddress'])->name('address.update');

        Route::post('/educations', [AdminUserProfileController::class, 'storeEducation'])->name('educations.store');
        Route::patch('/educations/{education}', [AdminUserProfileController::class, 'updateEducation'])->name('educations.update');
        Route::delete('/educations/{education}', [AdminUserProfileController::class, 'destroyEducation'])->name('educations.destroy');

        Route::post('/experiences', [AdminUserProfileController::class, 'storeExperience'])->name('experiences.store');
        Route::patch('/experiences/{experience}', [AdminUserProfileController::class, 'updateExperience'])->name('experiences.update');
        Route::delete('/experiences/{experience}', [AdminUserProfileController::class, 'destroyExperience'])->name('experiences.destroy');

        Route::post('/skills', [AdminUserProfileController::class, 'storeSkill'])->name('skills.store');
        Route::patch('/skills/{skill}', [AdminUserProfileController::class, 'updateSkill'])->name('skills.update');
        Route::delete('/skills/{skill}', [AdminUserProfileController::class, 'destroySkill'])->name('skills.destroy');
    });
