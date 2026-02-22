<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-slate-900 leading-tight">Edit Course</h2>
            <p class="mt-1 text-sm text-slate-500">Update course details.</p>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        <form method="POST" action="{{ route('dashboard.courses.update', $course) }}" class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-700">Title</label>
                <input name="title" value="{{ old('title', $course->title) }}" class="mt-1 w-full rounded-lg border-slate-300" required />
                @error('title') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Description</label>
                <textarea name="description" rows="5" class="mt-1 w-full rounded-lg border-slate-300" required>{{ old('description', $course->description) }}</textarea>
                @error('description') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Thumbnail (path/url)</label>
                <input name="thumbnail" value="{{ old('thumbnail', $course->thumbnail) }}" class="mt-1 w-full rounded-lg border-slate-300" />
                @error('thumbnail') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Status</label>
                <select name="status" class="mt-1 w-full rounded-lg border-slate-300" required>
                    <option value="active" @selected(old('status', $course->status) === 'active')>Active</option>
                    <option value="inactive" @selected(old('status', $course->status) === 'inactive')>Inactive</option>
                </select>
                @error('status') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-2">
                <a href="{{ route('dashboard.courses.show', $course) }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
                <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Save</button>
            </div>
        </form>
    </div>
</x-app-layout>
