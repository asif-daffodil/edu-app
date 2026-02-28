<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-slate-900 leading-tight">Edit Mentor</h2>
            <p class="mt-1 text-sm text-slate-500">Update mentor details.</p>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <form method="POST" action="{{ route('dashboard.mentors.update', $mentor) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', optional($mentor->user)->email) }}" class="mt-1 w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="mentor@example.com" required />
                    @error('email')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Name</label>
                    <input type="text" name="name" value="{{ old('name', $mentor->name) }}" class="mt-1 w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" required />
                    @error('name')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Topic</label>
                    <input type="text" name="topic" value="{{ old('topic', $mentor->topic) }}" class="mt-1 w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g., Web Development" />
                    @error('topic')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Bio</label>
                    <textarea name="bio" rows="5" class="wysiwyg mt-1 w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Short description...">{{ old('bio', $mentor->bio) }}</textarea>
                    @error('bio')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-2">
                    <input id="is_active" type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" @checked(old('is_active', $mentor->is_active)) />
                    <label for="is_active" class="text-sm text-slate-700">Active (visible)</label>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard.mentors.index') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
                    <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
