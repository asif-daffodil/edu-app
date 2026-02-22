<?php

namespace Modules\Batch\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Modules\Batch\Models\Batch;

class MyMentorBatchesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        abort_unless($user, 403);

        $batches = $user->mentorBatches()
            ->with(['course:id,title'])
            ->withCount(['students', 'classSchedules'])
            ->orderByDesc('batches.id')
            ->paginate(12);

        return view('batch::mentor.batches.index', compact('batches'));
    }

    public function show(Batch $batch)
    {
        $user = Auth::user();
        abort_unless($user, 403);

        $isAssigned = $user->mentorBatches()->whereKey($batch->id)->exists();
        abort_unless($isAssigned, 403);

        abort_unless(Gate::allows('view', $batch), 403);

        $batch->load(['course:id,title', 'classSchedules' => fn ($q) => $q->orderBy('class_date')]);

        return view('batch::mentor.batches.show', compact('batch'));
    }
}
