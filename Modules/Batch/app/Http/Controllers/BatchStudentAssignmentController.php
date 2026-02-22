<?php

namespace Modules\Batch\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Modules\Batch\Http\Requests\UpdateBatchStudentsRequest;
use Modules\Batch\Models\Batch;

class BatchStudentAssignmentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role:admin|permission:assignStudentsToBatch'),
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Batch $batch)
    {
        abort_unless(Gate::allows('assignStudents', $batch), 403);

        $students = User::query()->role('student')->orderBy('name')->get(['id', 'name', 'email']);
        $selectedStudentIds = $batch->students()->pluck('users.id')->all();

        return view('batch::admin.batches.students', compact('batch', 'students', 'selectedStudentIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBatchStudentsRequest $request, Batch $batch)
    {
        abort_unless(Gate::allows('assignStudents', $batch), 403);

        $studentIds = array_map('intval', $request->validated()['student_ids'] ?? []);
        $allowedStudentIds = User::query()->role('student')->whereIn('id', $studentIds)->pluck('id')->all();

        $batch->students()->sync($allowedStudentIds);

        return redirect()
            ->route('dashboard.batches.students.edit', $batch)
            ->with('success', 'Batch students updated successfully.');
    }
}
