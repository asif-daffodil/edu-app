<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-slate-900 leading-tight">Add Course</h2>
            <p class="mt-1 text-sm text-slate-500">Create a new course.</p>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        <form method="POST" action="{{ route('dashboard.courses.store') }}" enctype="multipart/form-data" class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700">Title</label>
                <input name="title" value="{{ old('title') }}" class="mt-1 w-full rounded-lg border-slate-300" required />
                @error('title') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Description</label>
                <textarea name="description" rows="5" class="wysiwyg mt-1 w-full rounded-lg border-slate-300" required>{{ old('description') }}</textarea>
                @error('description') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Thumbnail</label>
                <input type="file" name="thumbnail" accept="image/*" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white file:mr-4 file:rounded-lg file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200" />
                <p class="mt-1 text-xs text-slate-500">Upload a course thumbnail image (jpg/png/webp). Max size 2MB.</p>
                @error('thumbnail') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Status</label>
                <select name="status" class="mt-1 w-full rounded-lg border-slate-300" required>
                    <option value="active" @selected(old('status', 'active') === 'active')>Active</option>
                    <option value="inactive" @selected(old('status') === 'inactive')>Inactive</option>
                </select>
                @error('status') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-2">
                <a href="{{ route('dashboard.courses.index') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
                <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Create</button>
            </div>
        </form>
    </div>
</x-app-layout>
