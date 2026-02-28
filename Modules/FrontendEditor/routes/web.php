<?php

use App\Http\Controllers\Admin\FrontendSettingsController;
use Illuminate\Support\Facades\Route;
use Modules\FrontendEditor\Http\Controllers\Admin\FrontendEditorController;

Route::middleware(['auth', 'verified', 'role:admin', 'backend.locale'])
    ->prefix('admin/frontend-editor')
    ->name('admin.frontend-editor.')
    ->group(function (): void {
        Route::get('/', [FrontendEditorController::class, 'index'])->name('index');

        Route::patch('/header-settings', [FrontendSettingsController::class, 'updateHeader'])
            ->name('header-settings.update');

        Route::post('/{page}/sections', [FrontendEditorController::class, 'store'])->name('sections.store');

        Route::patch('/sections/{section}', [FrontendEditorController::class, 'update'])->name('sections.update');

        Route::patch('/{page}/sections/bulk', [FrontendEditorController::class, 'bulkUpdate'])
            ->name('sections.bulk-update');
    });
