<?php

use Illuminate\Support\Facades\Route;
use Modules\Batch\Http\Controllers\AdminBatchesController;
use Modules\Batch\Http\Controllers\BatchMentorAssignmentController;
use Modules\Batch\Http\Controllers\BatchStudentAssignmentController;
use Modules\Batch\Http\Controllers\ClassScheduleController;
use Modules\Batch\Http\Controllers\CourseBatchController;
use Modules\Batch\Http\Controllers\MyMentorBatchesController;
use Modules\Batch\Http\Controllers\MyStudentBatchesController;

$adminAssignmentRoutes = static function (): void {
    $mentorEditAction = [
        BatchMentorAssignmentController::class,
        'edit',
    ];
    $mentorUpdateAction = [
        BatchMentorAssignmentController::class,
        'update',
    ];
    $studentEditAction = [
        BatchStudentAssignmentController::class,
        'edit',
    ];
    $studentUpdateAction = [
        BatchStudentAssignmentController::class,
        'update',
    ];

    $scopedRoutes = static function () use (
        $mentorEditAction,
        $mentorUpdateAction,
        $studentEditAction,
        $studentUpdateAction
    ): void {
        Route::get('mentors', $mentorEditAction)->name('mentors.edit');
        Route::put('mentors', $mentorUpdateAction)->name('mentors.update');

        Route::get('students', $studentEditAction)->name('students.edit');
        Route::put('students', $studentUpdateAction)->name('students.update');
    };

    Route::prefix('batches/{batch}')->name('batches.')->group($scopedRoutes);
};

$adminBatchRoutes = static function () use ($adminAssignmentRoutes): void {
    $adminBatchesIndexAction = [AdminBatchesController::class, 'index'];

    Route::get('batches', $adminBatchesIndexAction)->name('batches.index');
    Route::resource('courses.batches', CourseBatchController::class);
    $adminAssignmentRoutes();
};

$mentorBatchRoutes = static function (): void {
    $mentorIndexAction = [MyMentorBatchesController::class, 'index'];
    $mentorShowAction = [MyMentorBatchesController::class, 'show'];

    Route::get('batches', $mentorIndexAction)->name('batches.index');
    Route::get('batches/{batch}', $mentorShowAction)->name('batches.show');
};

$studentBatchRoutes = static function (): void {
    $studentIndexAction = [MyStudentBatchesController::class, 'index'];
    $studentShowAction = [MyStudentBatchesController::class, 'show'];

    Route::get('batches', $studentIndexAction)->name('batches.index');
    Route::get('batches/{batch}', $studentShowAction)->name('batches.show');
};

$dashboardRoutes = static function () use (
    $adminBatchRoutes,
    $mentorBatchRoutes,
    $studentBatchRoutes
): void {
    $adminGroup = Route::middleware(['role:admin']);
    $adminGroup->group($adminBatchRoutes);

    Route::resource('batches.schedules', ClassScheduleController::class)
        ->parameters(['schedules' => 'classSchedule'])
        ->except(['destroy']);

    $mentorGroup = Route::middleware(['role:mentor']);
    $mentorGroup = $mentorGroup->prefix('mentor');
    $mentorGroup = $mentorGroup->name('mentor.');
    $mentorGroup->group($mentorBatchRoutes);

    $studentGroup = Route::middleware(['role:student']);
    $studentGroup = $studentGroup->prefix('student');
    $studentGroup = $studentGroup->name('student.');
    $studentGroup->group($studentBatchRoutes);
};

$webRoutes = static function () use ($dashboardRoutes): void {
    $dashboardGroup = Route::prefix('dashboard')->name('dashboard.');
    $dashboardGroup->group($dashboardRoutes);
};

Route::middleware(['auth', 'verified', 'backend.locale'])->group($webRoutes);
