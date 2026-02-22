<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="min-w-0">
                <h2 class="text-xl font-semibold text-slate-900 leading-tight truncate">{{ $course->title }}</h2>
                <p class="mt-1 text-sm text-slate-500">Course details and batches.</p>
            </div>

            <div class="flex items-center gap-2">
                @can('editCourse')
                    <a href="{{ route('dashboard.courses.edit', $course) }}" class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-800 hover:bg-amber-100">Edit</a>
                @endcan
                @can('addBatch')
                    <a href="{{ route('dashboard.courses.batches.index', $course) }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Manage Batches</a>
                @endcan
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-emerald-50 p-4 text-sm text-emerald-800 ring-1 ring-emerald-100">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <div class="flex items-center gap-3">
                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Status</div>
                <div class="text-sm font-semibold text-slate-900">{{ ucfirst($course->status) }}</div>
            </div>

            <div class="mt-4">
                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Description</div>
                <div class="mt-2 text-sm text-slate-700 whitespace-pre-line">{{ $course->description }}</div>
            </div>
        </div>

        <div class="rounded-xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="border-b border-slate-200 px-6 py-4">
                <div class="text-sm font-semibold text-slate-900">Batches</div>
            </div>
            <div class="divide-y divide-slate-200">
                @forelse($course->batches as $batch)
                    <div class="px-6 py-4">
                        <div class="font-semibold text-slate-900">{{ $batch->name }}</div>
                        <div class="mt-1 text-xs text-slate-500">
                            {{ $batch->status }} • mentors: {{ $batch->mentors_count }} • students: {{ $batch->students_count }}
                        </div>
                        @can('readBatch')
                            <div class="mt-2">
                                <a class="text-sm font-semibold text-indigo-600 hover:text-indigo-500" href="{{ route('dashboard.courses.batches.show', [$course, $batch]) }}">Open batch</a>
                            </div>
                        @endcan
                    </div>
                @empty
                    <div class="px-6 py-8 text-sm text-slate-500">No batches yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
