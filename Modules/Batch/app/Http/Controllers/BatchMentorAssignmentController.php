<?php

namespace Modules\Batch\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Modules\Batch\Http\Requests\UpdateBatchMentorsRequest;
use Modules\Batch\Models\Batch;

class BatchMentorAssignmentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role:admin|permission:assignMentorsToBatch'),
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Batch $batch)
    {
        abort_unless(Gate::allows('assignMentors', $batch), 403);

        $mentors = User::query()->role('mentor')->orderBy('name')->get(['id', 'name', 'email']);
        $selectedMentorIds = $batch->mentors()->pluck('users.id')->all();

        return view('batch::admin.batches.mentors', compact('batch', 'mentors', 'selectedMentorIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBatchMentorsRequest $request, Batch $batch)
    {
        abort_unless(Gate::allows('assignMentors', $batch), 403);

        $mentorIds = array_map('intval', $request->validated()['mentor_ids'] ?? []);
        $allowedMentorIds = User::query()->role('mentor')->whereIn('id', $mentorIds)->pluck('id')->all();

        $batch->mentors()->sync($allowedMentorIds);

        return redirect()
            ->route('dashboard.batches.mentors.edit', $batch)
            ->with('success', 'Batch mentors updated successfully.');
    }
}
