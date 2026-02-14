<?php

namespace Modules\Mentors\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Modules\Mentors\Models\Mentor;

class MentorController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:readMentor', only: ['index', 'show']),
            new Middleware('permission:addMentor', only: ['create', 'store']),
            new Middleware('permission:editMentor', only: ['edit', 'update']),
            new Middleware('permission:deleteMentor', only: ['destroy']),
        ];
    }

    public function index()
    {
        abort_unless(Gate::allows('viewAny', Mentor::class), 403);

        $mentors = Mentor::query()
            ->with(['user:id,name,email'])
            ->orderByDesc('id')
            ->paginate(12);

        return view('mentors::mentors.index', compact('mentors'));
    }

    public function create()
    {
        abort_unless(Gate::allows('create', Mentor::class), 403);

        $users = User::query()->orderBy('name')->get(['id', 'name', 'email']);

        return view('mentors::mentors.create', compact('users'));
    }

    public function store(Request $request)
    {
        abort_unless(Gate::allows('create', Mentor::class), 403);

        $validated = $request->validate([
            'user_id' => 'nullable|integer|exists:users,id',
            'name' => 'required|string|max:255',
            'topic' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:2000',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = (bool) ($request->boolean('is_active'));

        if (! empty($validated['user_id'])) {
            // one mentor profile per user
            $existing = Mentor::query()->where('user_id', $validated['user_id'])->first();
            if ($existing) {
                return back()->withErrors(['user_id' => 'This user already has a mentor profile.'])->withInput();
            }
        }

        Mentor::create($validated);

        return redirect()->route('dashboard.mentors.index')->with('success', 'Mentor created successfully.');
    }

    public function show(Mentor $mentor)
    {
        abort_unless(Gate::allows('view', $mentor), 403);

        $mentor->load(['user:id,name,email']);

        return view('mentors::mentors.show', compact('mentor'));
    }

    public function edit(Mentor $mentor)
    {
        abort_unless(Gate::allows('update', $mentor), 403);

        $users = User::query()->orderBy('name')->get(['id', 'name', 'email']);

        return view('mentors::mentors.edit', compact('mentor', 'users'));
    }

    public function update(Request $request, Mentor $mentor)
    {
        abort_unless(Gate::allows('update', $mentor), 403);

        $validated = $request->validate([
            'user_id' => 'nullable|integer|exists:users,id',
            'name' => 'required|string|max:255',
            'topic' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:2000',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = (bool) ($request->boolean('is_active'));

        if (! empty($validated['user_id'])) {
            $existing = Mentor::query()
                ->where('user_id', $validated['user_id'])
                ->where('id', '!=', $mentor->id)
                ->first();

            if ($existing) {
                return back()->withErrors(['user_id' => 'This user already has a mentor profile.'])->withInput();
            }
        }

        $mentor->update($validated);

        return redirect()->route('dashboard.mentors.index')->with('success', 'Mentor updated successfully.');
    }

    public function destroy(Mentor $mentor)
    {
        abort_unless(Gate::allows('delete', $mentor), 403);

        $mentor->delete();

        return redirect()->route('dashboard.mentors.index')->with('success', 'Mentor deleted successfully.');
    }
}
