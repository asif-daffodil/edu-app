<?php

// phpcs:disable

namespace Modules\Batch\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Modules\Batch\Models\Batch;
use Yajra\DataTables\Facades\DataTables;

class AdminBatchesController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('role:admin|permission:readBatch', only: ['index']),
        ];
    }

    public function index()
    {
        if (request()->ajax() && request()->has('draw')) {
            $query = Batch::query()
                ->with(['course:id,title'])
                ->select([
                    'id',
                    'course_id',
                    'name',
                    'class_days',
                    'class_time',
                    'status',
                    'start_date',
                    'end_date',
                    'created_at',
                ])
                ->withCount(['mentors', 'students', 'classSchedules'])
                ->latest();

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('course_title', fn (Batch $batch) => e($batch->course?->title ?? '-'))
                ->addColumn('batch_display', function (Batch $batch) {
                    $days = (array) ($batch->class_days ?? []);
                    $daysText = $days ? implode(', ', $days) : '-';
                    $timeText = (string) ($batch->class_time ?? '');

                    return '<div class="font-semibold text-slate-900">'
                        . e($batch->name)
                        . '</div><div class="mt-1 text-xs text-slate-500">'
                        . e($daysText)
                        . ' • '
                        . e($timeText)
                        . '</div>';
                })
                ->addColumn('actions', function (Batch $batch) {
                    $openUrl = $batch->course_id
                        ? route('dashboard.courses.batches.show', [$batch->course_id, $batch])
                        : null;

                    $scheduleUrl = route('dashboard.batches.schedules.index', $batch);
                    $mentorsUrl = route('dashboard.batches.mentors.edit', $batch);
                    $studentsUrl = route('dashboard.batches.students.edit', $batch);

                    $buttons = '<div class="inline-flex items-center gap-2">';

                    if ($openUrl) {
                        $buttons .= '<a href="' . e($openUrl) . '" class="rounded-md border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">Open</a>';
                    }

                    $buttons .= '<a href="' . e($scheduleUrl) . '" class="rounded-md border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">Schedule</a>'
                        . '<a href="' . e($mentorsUrl) . '" class="rounded-md border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">Mentors</a>'
                        . '<a href="' . e($studentsUrl) . '" class="rounded-md border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">Students</a>'
                        . '</div>';

                    return $buttons;
                })
                ->filterColumn('course_title', function ($query, $keyword) {
                    $query->whereHas('course', function ($q) use ($keyword) {
                        $q->where('title', 'like', "%{$keyword}%");
                    });
                })
                ->rawColumns(['batch_display', 'actions'])
                ->toJson();
        }

        return view('batch::admin.batches.all');
    }
}

// phpcs:enable
