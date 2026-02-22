<?php

namespace Modules\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Modules\Course\Http\Requests\StoreCourseRequest;
use Modules\Course\Http\Requests\UpdateCourseRequest;
use Modules\Course\Models\Course;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role:admin|permission:readCourse', only: ['index', 'show']),
            new Middleware('role:admin|permission:addCourse', only: ['create', 'store']),
            new Middleware('role:admin|permission:editCourse', only: ['edit', 'update']),
            new Middleware('role:admin|permission:deleteCourse', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_unless(Gate::allows('viewAny', Course::class), 403);

        if (request()->ajax() && request()->has('draw')) {
            $query = Course::query()
                ->select(['id', 'title', 'description', 'status', 'created_at'])
                ->withCount('batches')
                ->latest();

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('status_badge', function (Course $course) {
                    if ($course->status === 'active') {
                        return '<span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-100">Active</span>';
                    }

                    return '<span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700 ring-1 ring-slate-200">Inactive</span>';
                })
                ->addColumn('actions', function (Course $course) {
                    $user = Auth::user();

                    $viewUrl = route('dashboard.courses.show', $course);
                    $editUrl = route('dashboard.courses.edit', $course);
                    $deleteUrl = route('dashboard.courses.destroy', $course);

                    $buttons = '<div class="inline-flex items-center gap-2">'
                        . '<a href="' . e($viewUrl) . '" class="rounded-md border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">View</a>';

                    if ($user && $user->can('update', $course)) {
                        $buttons .= '<a href="' . e($editUrl) . '" class="rounded-md border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-800 hover:bg-amber-100">Edit</a>';
                    }

                    if ($user && $user->can('delete', $course)) {
                        $buttons .= '<form method="POST" action="' . e($deleteUrl) . '" onsubmit="return confirm(\'Delete this course?\');">'
                            . '<input type="hidden" name="_token" value="' . e(csrf_token()) . '">'
                            . '<input type="hidden" name="_method" value="DELETE">'
                            . '<button type="submit" class="rounded-md border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-800 hover:bg-rose-100">Delete</button>'
                            . '</form>';
                    }

                    $buttons .= '</div>';

                    return $buttons;
                })
                ->filterColumn('title', function ($query, $keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->where('title', 'like', "%{$keyword}%")
                            ->orWhere('description', 'like', "%{$keyword}%");
                    });
                })
                ->rawColumns(['status_badge', 'actions'])
                ->toJson();
        }

        return view('course::courses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_unless(Gate::allows('create', Course::class), 403);

        return view('course::courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        abort_unless(Gate::allows('create', Course::class), 403);

        $validated = $request->validated();

        $course = Course::query()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'thumbnail' => $validated['thumbnail'] ?? null,
            'status' => $validated['status'],
            'created_by' => (int) Auth::id(),
        ]);

        return redirect()
            ->route('dashboard.courses.show', $course)
            ->with('success', 'Course created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show(Course $course)
    {
        abort_unless(Gate::allows('view', $course), 403);

        $course->load(['batches' => function ($query) {
            $query->withCount(['mentors', 'students'])->orderByDesc('id');
        }]);

        return view('course::courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        abort_unless(Gate::allows('update', $course), 403);

        return view('course::courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        abort_unless(Gate::allows('update', $course), 403);

        $validated = $request->validated();

        $course->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'thumbnail' => $validated['thumbnail'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('dashboard.courses.show', $course)
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        abort_unless(Gate::allows('delete', $course), 403);

        $course->delete();

        return redirect()
            ->route('dashboard.courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
