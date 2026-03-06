<?php

use Illuminate\Support\Facades\Route;
use Modules\Invoice\Http\Controllers\MyInvoicesController;

$studentInvoicesIndexAction = [MyInvoicesController::class, 'index'];
$studentInvoicesShowAction = [MyInvoicesController::class, 'show'];
$studentInvoicesDownloadAction = [MyInvoicesController::class, 'download'];

$studentInvoiceRoutes = static function () use (
    $studentInvoicesIndexAction,
    $studentInvoicesShowAction,
    $studentInvoicesDownloadAction
): void {
    Route::get('invoices', $studentInvoicesIndexAction)->name('invoices.index');
    Route::get('invoices/{order}', $studentInvoicesShowAction)
        ->name('invoices.show');
    Route::get('invoices/{order}/download', $studentInvoicesDownloadAction)
        ->name('invoices.download');
};

$dashboardRoutes = static function () use ($studentInvoiceRoutes): void {
    $studentGroup = Route::middleware(['role:student']);
    $studentGroup = $studentGroup->prefix('student');
    $studentGroup = $studentGroup->name('student.');
    $studentGroup->group($studentInvoiceRoutes);
};

$webRoutes = static function () use ($dashboardRoutes): void {
    $dashboardGroup = Route::prefix('dashboard')->name('dashboard.');
    $dashboardGroup->group($dashboardRoutes);
};

Route::middleware(['auth', 'verified', 'backend.locale'])->group($webRoutes);
