<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-900 leading-tight">Assign Students</h2>
                <p class="mt-1 text-sm text-slate-500">Batch: <span class="font-semibold">{{ $batch->name }}</span></p>
            </div>
            <a href="{{ route('dashboard.batches.schedules.index', $batch) }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">View Schedule</a>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-emerald-50 p-4 text-sm text-emerald-800 ring-1 ring-emerald-100">{{ session('success') }}</div>
    @endif

    <div class="max-w-3xl">
        <form method="POST" action="{{ route('dashboard.batches.students.update', $batch) }}" class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-700">Students</label>
                <select name="student_ids[]" multiple size="10" class="mt-2 w-full rounded-lg border-slate-300">
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" @selected(in_array($student->id, $selectedStudentIds, true))>
                            {{ $student->name }} ({{ $student->email }})
                        </option>
                    @endforeach
                </select>
                @error('student_ids') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                @error('student_ids.*') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-2">
                <a href="{{ route('dashboard.batches.schedules.index', $batch) }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
                <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Save</button>
            </div>
        </form>
    </div>
</x-app-layout>
