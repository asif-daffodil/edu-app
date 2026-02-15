<?php

namespace Modules\Mentors\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
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

        return view('mentors::mentors.create');
    }

    public function store(Request $request)
    {
        abort_unless(Gate::allows('create', Mentor::class), 403);

        $validated = $request->validate([
            'email' => 'required|email|max:255|unique:users,email',
            'name' => 'required|string|max:255',
            'topic' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:2000',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = (bool) ($request->boolean('is_active'));

        DB::transaction(function () use ($validated) {
            $user = User::query()->create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => '12345678',
                'must_change_password' => true,
            ]);

            $user->assignRole('mentor');

            Mentor::query()->create([
                'user_id' => $user->id,
                'name' => $validated['name'],
                'topic' => $validated['topic'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'is_active' => $validated['is_active'],
            ]);
        });

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

        $mentor->load(['user:id,name,email']);

        return view('mentors::mentors.edit', compact('mentor'));
    }

    public function update(Request $request, Mentor $mentor)
    {
        abort_unless(Gate::allows('update', $mentor), 403);

        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($mentor->user_id),
            ],
            'name' => 'required|string|max:255',
            'topic' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:2000',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = (bool) ($request->boolean('is_active'));

        DB::transaction(function () use ($mentor, $validated) {
            $mentor->loadMissing(['user']);

            if ($mentor->user) {
                $mentor->user->update([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                ]);
            } else {
                $user = User::query()->create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => '12345678',
                    'must_change_password' => true,
                ]);
                $user->assignRole('mentor');
                $mentor->user()->associate($user);
            }

            $mentor->update([
                'name' => $validated['name'],
                'topic' => $validated['topic'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'is_active' => $validated['is_active'],
            ]);
        });

        return redirect()->route('dashboard.mentors.index')->with('success', 'Mentor updated successfully.');
    }

    public function destroy(Mentor $mentor)
    {
        abort_unless(Gate::allows('delete', $mentor), 403);

        $mentor->delete();

        return redirect()->route('dashboard.mentors.index')->with('success', 'Mentor deleted successfully.');
    }
}
