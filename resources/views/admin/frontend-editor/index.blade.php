<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-slate-900 leading-tight">Frontend Editor</h2>
            <p class="mt-1 text-sm text-slate-500">Edit frontend page sections (BN + EN).</p>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @php
        $isHeaderTab = ($tab ?? 'pages') === 'header';
    @endphp

    <div class="mb-6 flex flex-wrap items-center gap-2">
        @foreach($pages as $page)
            @php
                $isActive = ! $isHeaderTab && $selectedPage->id === $page->id;
                $base = 'inline-flex items-center rounded-lg px-4 py-2 text-sm font-semibold transition';
                $active = 'bg-indigo-600 text-white';
                $inactive = 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50';
            @endphp

            <a href="{{ route('admin.frontend-editor.index', ['page' => $page->slug]) }}"
               class="{{ $base }} {{ $isActive ? $active : $inactive }}">
                {{ ucfirst($page->slug) }}
            </a>
        @endforeach

        @php
            $base = 'inline-flex items-center rounded-lg px-4 py-2 text-sm font-semibold transition';
            $active = 'bg-indigo-600 text-white';
            $inactive = 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50';
        @endphp
        <a href="{{ route('admin.frontend-editor.index', ['tab' => 'header']) }}"
           class="{{ $base }} {{ $isHeaderTab ? $active : $inactive }}">
            Header Settings
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6">
        @if($isHeaderTab)
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-slate-900">Header Settings</h3>
                    <p class="mt-1 text-sm text-slate-500">Update top header address, phone, email and logo.</p>
                </div>

                @if (!\Illuminate\Support\Facades\Schema::hasTable('frontend_settings'))
                    <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
                        Frontend settings table not found. Run migrations first.
                    </div>
                @else
                    <form method="POST"
                          action="{{ route('admin.frontend-editor.header-settings.update') }}"
                          enctype="multipart/form-data"
                          class="grid grid-cols-1 gap-6">
                        @csrf
                        @method('PATCH')

                        <div class="grid gap-4 lg:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Address (EN)</label>
                                <input
                                    name="site_address_en"
                                    value="{{ old('site_address_en', optional($settings->get('site_address'))->value_en) }}"
                                    class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required
                                />
                                @error('site_address_en')
                                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">Address (BN)</label>
                                <input
                                    name="site_address_bn"
                                    value="{{ old('site_address_bn', optional($settings->get('site_address'))->value_bn) }}"
                                    class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required
                                />
                                @error('site_address_bn')
                                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">Phone</label>
                                <input
                                    name="site_phone"
                                    value="{{ old('site_phone', optional($settings->get('site_phone'))->value_en) }}"
                                    class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required
                                />
                                @error('site_phone')
                                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">Email</label>
                                <input
                                    type="email"
                                    name="site_email"
                                    value="{{ old('site_email', optional($settings->get('site_email'))->value_en) }}"
                                    class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required
                                />
                                @error('site_email')
                                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">Logo Upload</label>
                            @php
                                $logoPath = optional($settings->get('site_logo_path'))->value_en
                                    ?: optional($settings->get('site_logo_path'))->value_bn;
                            @endphp

                            @if ($logoPath)
                                <div class="mt-3 flex items-center gap-4">
                                    <img
                                        src="{{ asset('storage/' . $logoPath) }}"
                                        alt="Site logo"
                                        class="h-12 w-auto rounded bg-slate-50 ring-1 ring-slate-200"
                                    />
                                    <div class="text-xs text-slate-500">Current logo</div>
                                </div>
                            @endif

                            <input
                                type="file"
                                name="site_logo"
                                accept="image/*"
                                class="mt-3 block w-full text-sm text-slate-700"
                            />
                            @error('site_logo')
                                <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                            @enderror

                            <p class="mt-2 text-xs text-slate-500">
                                Stored in <span class="font-mono">storage/app/public/logo</span>
                            </p>
                        </div>

                        <div class="flex items-center justify-end">
                            <button
                                type="submit"
                                class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500"
                            >
                                Save Settings
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        @else
            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-slate-900">Add Section</h3>
                    <p class="mt-1 text-sm text-slate-500">Create a new section for <span class="font-semibold">{{ $selectedPage->slug }}</span>.</p>
                </div>

                <form method="POST"
                      action="{{ route('admin.frontend-editor.sections.store', $selectedPage) }}"
                      enctype="multipart/form-data"
                      class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                    @csrf

                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-slate-700">Section Key</label>
                        <input name="section_key" value="{{ old('section_key') }}"
                               placeholder="e.g. hero, about_text, footer"
                               class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        @error('section_key')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Title (BN)</label>
                        <input name="title_bn" value="{{ old('title_bn') }}"
                               class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        @error('title_bn')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Title (EN)</label>
                        <input name="title_en" value="{{ old('title_en') }}"
                               class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        @error('title_en')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Content (BN)</label>
                        <textarea name="content_bn" rows="5"
                                  class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('content_bn') }}</textarea>
                        @error('content_bn')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Content (EN)</label>
                        <textarea name="content_en" rows="5"
                                  class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('content_en') }}</textarea>
                        @error('content_en')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Image</label>
                        <input type="file" name="image"
                               class="mt-1 block w-full text-sm text-slate-700 file:mr-4 file:rounded-md file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200" />
                        @error('image')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Button Link</label>
                        <input name="button_link" value="{{ old('button_link') }}" placeholder="e.g. /contact"
                               class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        @error('button_link')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Button Text (BN)</label>
                        <input name="button_text_bn" value="{{ old('button_text_bn') }}"
                               class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        @error('button_text_bn')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Button Text (EN)</label>
                        <input name="button_text_en" value="{{ old('button_text_en') }}"
                               class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        @error('button_text_en')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Status</label>
                        <select name="status"
                                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="active" @selected(old('status', 'active') === 'active')>Active</option>
                            <option value="inactive" @selected(old('status') === 'inactive')>Inactive</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-end justify-end lg:col-span-2">
                        <button type="submit"
                                class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                            Create Section
                        </button>
                    </div>
                </form>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-slate-900">Sections</h3>
                    <p class="mt-1 text-sm text-slate-500">Edit sections for <span class="font-semibold">{{ $selectedPage->slug }}</span>.</p>
                </div>

                @if($sections->isEmpty())
                    <div class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                        No sections found for this page. Create one above.
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($sections as $section)
                            <div class="rounded-xl border border-slate-200 bg-white p-5">
                                <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                                    <div>
                                        <div class="text-sm text-slate-500">Section Key</div>
                                        <div class="text-base font-semibold text-slate-900">{{ $section->section_key }}</div>
                                    </div>

                                    <div class="text-xs font-semibold">
                                        @if($section->status === 'active')
                                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-emerald-700 ring-1 ring-emerald-100">Active</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-slate-700 ring-1 ring-slate-200">Inactive</span>
                                        @endif
                                    </div>
                                </div>

                                <form method="POST"
                                      action="{{ route('admin.frontend-editor.sections.update', $section) }}"
                                      enctype="multipart/form-data"
                                      class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                    @csrf
                                    @method('PATCH')

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Title (BN)</label>
                                        <input name="title_bn" value="{{ old('title_bn', $section->title_bn) }}"
                                               class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Title (EN)</label>
                                        <input name="title_en" value="{{ old('title_en', $section->title_en) }}"
                                               class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Content (BN)</label>
                                        <textarea name="content_bn" rows="6"
                                                  class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('content_bn', $section->content_bn) }}</textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Content (EN)</label>
                                        <textarea name="content_en" rows="6"
                                                  class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('content_en', $section->content_en) }}</textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Image</label>
                                        <input type="file" name="image"
                                               class="mt-1 block w-full text-sm text-slate-700 file:mr-4 file:rounded-md file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200" />

                                        @if($section->image_path)
                                            <div class="mt-3">
                                                <div class="text-xs text-slate-500">Current</div>
                                                <img
                                                    src="{{ asset('storage/' . $section->image_path) }}"
                                                    alt="{{ $section->section_key }}"
                                                    class="mt-1 h-20 w-auto rounded-lg border border-slate-200"
                                                />
                                            </div>
                                        @endif
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Button Link</label>
                                        <input name="button_link" value="{{ old('button_link', $section->button_link) }}"
                                               placeholder="e.g. /contact"
                                               class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Button Text (BN)</label>
                                        <input name="button_text_bn" value="{{ old('button_text_bn', $section->button_text_bn) }}"
                                               class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Button Text (EN)</label>
                                        <input name="button_text_en" value="{{ old('button_text_en', $section->button_text_en) }}"
                                               class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Status</label>
                                        <select name="status"
                                                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="active" @selected(old('status', $section->status) === 'active')>Active</option>
                                            <option value="inactive" @selected(old('status', $section->status) === 'inactive')>Inactive</option>
                                        </select>
                                    </div>

                                    <div class="flex items-end justify-end lg:col-span-2">
                                        <button type="submit"
                                                class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-app-layout>
