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
            @php
                $homeHeroKeys = [
                    'hero_primary',
                    'hero_emphasis',
                    'hero_paragraph',
                    'hero_cta_primary',
                    'hero_side_heading',

                    'home_about_title',
                    'home_about_subtitle',
                    'home_about_card_1',
                    'home_about_card_2',
                    'home_about_card_3',
                        'home_skill_tracks_title',
                        'home_skill_tracks_subtitle',
                        'home_skill_tracks_cta',
                ];

                $sectionsByKey = $sections->keyBy('section_key');

                $reasonSections = $sections
                    ->filter(fn ($section) => str_starts_with($section->section_key, 'hero_different_reason_'))
                    ->sortBy(function ($section) {
                        if (preg_match('/^hero_different_reason_(\d+)$/', $section->section_key, $m)) {
                            return (int) $m[1];
                        }

                        return 9999;
                    })
                    ->values();

                $otherSections = $sections->reject(function ($section) use ($homeHeroKeys) {
                    return in_array($section->section_key, $homeHeroKeys, true)
                        || str_starts_with($section->section_key, 'hero_different_reason_')
                        || str_starts_with($section->section_key, 'home_skill_track_');
                });

                    $skillTrackSections = $sections
                        ->filter(fn ($section) => str_starts_with($section->section_key, 'home_skill_track_'))
                        ->sortBy(function ($section) {
                            if (preg_match('/^home_skill_track_(\d+)$/', $section->section_key, $m)) {
                                return (int) $m[1];
                            }

                            return 9999;
                        })
                        ->values();

                    $existingSkillTrackIndexes = $skillTrackSections->toBase()
                        ->map(function ($section) {
                            if (preg_match('/^home_skill_track_(\d+)$/', $section->section_key, $m)) {
                                return (int) $m[1];
                            }

                            return null;
                        })
                        ->filter()
                        ->unique()
                        ->sort()
                        ->values();

                    $skillTrackIndexes = $existingSkillTrackIndexes;
                    for ($i = 1; $i <= 5; $i++) {
                        if (! $skillTrackIndexes->contains($i)) {
                            $skillTrackIndexes->push($i);
                        }
                    }
                    $skillTrackIndexes = $skillTrackIndexes->sort()->values();
                    $nextSkillTrackIndex = (int) ($skillTrackIndexes->max() ?? 0) + 1;

                $existingReasonIndexes = $reasonSections->toBase()
                    ->map(function ($section) {
                        if (preg_match('/^hero_different_reason_(\d+)$/', $section->section_key, $m)) {
                            return (int) $m[1];
                        }

                        return null;
                    })
                    ->filter()
                    ->unique()
                    ->sort()
                    ->values();

                $reasonIndexes = $existingReasonIndexes;
                for ($i = 1; $i <= 4; $i++) {
                    if (! $reasonIndexes->contains($i)) {
                        $reasonIndexes->push($i);
                    }
                }
                $reasonIndexes = $reasonIndexes->sort()->values();
                $nextReasonIndex = (int) ($reasonIndexes->max() ?? 0) + 1;
            @endphp

            @if($selectedPage->slug === 'home')
                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-slate-900">Home Hero</h3>
                        <p class="mt-1 text-sm text-slate-500">Edit all hero fields in one save.</p>
                    </div>

                    <form method="POST"
                          action="{{ route('admin.frontend-editor.sections.bulk-update', $selectedPage) }}"
                          class="space-y-6">
                        @csrf
                        @method('PATCH')

                        {{-- hero_primary --}}
                        @php $heroPrimary = $sectionsByKey->get('hero_primary'); @endphp
                        <div class="rounded-xl border border-slate-200 p-5">
                            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                                <div>
                                    <div class="text-sm text-slate-500">Section Key</div>
                                    <div class="text-base font-semibold text-slate-900">hero_primary</div>
                                </div>
                                <select name="sections[hero_primary][status]"
                                        class="rounded-md border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="active" @selected(old('sections.hero_primary.status', optional($heroPrimary)->status ?? 'active') === 'active')>Active</option>
                                    <option value="inactive" @selected(old('sections.hero_primary.status', optional($heroPrimary)->status) === 'inactive')>Inactive</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Title (BN)</label>
                                    <input name="sections[hero_primary][title_bn]" value="{{ old('sections.hero_primary.title_bn', optional($heroPrimary)->title_bn) }}"
                                           class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Title (EN)</label>
                                    <input name="sections[hero_primary][title_en]" value="{{ old('sections.hero_primary.title_en', optional($heroPrimary)->title_en) }}"
                                           class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>
                        </div>

                        {{-- hero_emphasis --}}
                        @php $heroEmphasis = $sectionsByKey->get('hero_emphasis'); @endphp
                        <div class="rounded-xl border border-slate-200 p-5">
                            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                                <div>
                                    <div class="text-sm text-slate-500">Section Key</div>
                                    <div class="text-base font-semibold text-slate-900">hero_emphasis</div>
                                </div>
                                <select name="sections[hero_emphasis][status]"
                                        class="rounded-md border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="active" @selected(old('sections.hero_emphasis.status', optional($heroEmphasis)->status ?? 'active') === 'active')>Active</option>
                                    <option value="inactive" @selected(old('sections.hero_emphasis.status', optional($heroEmphasis)->status) === 'inactive')>Inactive</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Title (BN)</label>
                                    <input name="sections[hero_emphasis][title_bn]" value="{{ old('sections.hero_emphasis.title_bn', optional($heroEmphasis)->title_bn) }}"
                                           class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Title (EN)</label>
                                    <input name="sections[hero_emphasis][title_en]" value="{{ old('sections.hero_emphasis.title_en', optional($heroEmphasis)->title_en) }}"
                                           class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>
                        </div>

                        {{-- hero_paragraph --}}
                        @php $heroParagraph = $sectionsByKey->get('hero_paragraph'); @endphp
                        <div class="rounded-xl border border-slate-200 p-5">
                            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                                <div>
                                    <div class="text-sm text-slate-500">Section Key</div>
                                    <div class="text-base font-semibold text-slate-900">hero_paragraph</div>
                                </div>
                                <select name="sections[hero_paragraph][status]"
                                        class="rounded-md border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="active" @selected(old('sections.hero_paragraph.status', optional($heroParagraph)->status ?? 'active') === 'active')>Active</option>
                                    <option value="inactive" @selected(old('sections.hero_paragraph.status', optional($heroParagraph)->status) === 'inactive')>Inactive</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Content (BN)</label>
                                    <textarea name="sections[hero_paragraph][content_bn]" rows="5"
                                              class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('sections.hero_paragraph.content_bn', optional($heroParagraph)->content_bn) }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Content (EN)</label>
                                    <textarea name="sections[hero_paragraph][content_en]" rows="5"
                                              class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('sections.hero_paragraph.content_en', optional($heroParagraph)->content_en) }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- hero_cta_primary --}}
                        @php $heroCtaPrimary = $sectionsByKey->get('hero_cta_primary'); @endphp
                        <div class="rounded-xl border border-slate-200 p-5">
                            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                                <div>
                                    <div class="text-sm text-slate-500">Section Key</div>
                                    <div class="text-base font-semibold text-slate-900">hero_cta_primary</div>
                                </div>
                                <select name="sections[hero_cta_primary][status]"
                                        class="rounded-md border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="active" @selected(old('sections.hero_cta_primary.status', optional($heroCtaPrimary)->status ?? 'active') === 'active')>Active</option>
                                    <option value="inactive" @selected(old('sections.hero_cta_primary.status', optional($heroCtaPrimary)->status) === 'inactive')>Inactive</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Button Text (BN)</label>
                                    <input name="sections[hero_cta_primary][button_text_bn]" value="{{ old('sections.hero_cta_primary.button_text_bn', optional($heroCtaPrimary)->button_text_bn) }}"
                                           class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Button Text (EN)</label>
                                    <input name="sections[hero_cta_primary][button_text_en]" value="{{ old('sections.hero_cta_primary.button_text_en', optional($heroCtaPrimary)->button_text_en) }}"
                                           class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Button Link</label>
                                    <input name="sections[hero_cta_primary][button_link]" value="{{ old('sections.hero_cta_primary.button_link', optional($heroCtaPrimary)->button_link) }}"
                                           placeholder="e.g. /courses"
                                           class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>
                        </div>

                        {{-- hero_side_heading --}}
                        @php $heroSideHeading = $sectionsByKey->get('hero_side_heading'); @endphp
                        <div class="rounded-xl border border-slate-200 p-5">
                            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                                <div>
                                    <div class="text-sm text-slate-500">Section Key</div>
                                    <div class="text-base font-semibold text-slate-900">hero_side_heading</div>
                                </div>
                                <select name="sections[hero_side_heading][status]"
                                        class="rounded-md border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="active" @selected(old('sections.hero_side_heading.status', optional($heroSideHeading)->status ?? 'active') === 'active')>Active</option>
                                    <option value="inactive" @selected(old('sections.hero_side_heading.status', optional($heroSideHeading)->status) === 'inactive')>Inactive</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Title (BN)</label>
                                    <input name="sections[hero_side_heading][title_bn]" value="{{ old('sections.hero_side_heading.title_bn', optional($heroSideHeading)->title_bn) }}"
                                           class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Title (EN)</label>
                                    <input name="sections[hero_side_heading][title_en]" value="{{ old('sections.hero_side_heading.title_en', optional($heroSideHeading)->title_en) }}"
                                           class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div class="mt-3 text-xs text-slate-500">
                                Used on the home hero side panel heading (frontend falls back to translations if empty).
                            </div>
                        </div>

                        {{-- hero_different_reason_* (dynamic) --}}
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm font-semibold text-slate-900">Hero Different Reasons</div>
                                <div class="mt-1 text-xs text-slate-500">Use content lines: first line = subtitle, rest = description.</div>
                            </div>
                            <button type="button"
                                    id="addHeroReason"
                                    data-next-index="{{ $nextReasonIndex }}"
                                    class="inline-flex items-center rounded-lg bg-slate-900 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-800">
                                Add Reason
                            </button>
                        </div>

                        <div id="heroReasonsContainer" class="space-y-6">
                            @foreach($reasonIndexes as $i)
                                @php $reasonKey = 'hero_different_reason_' . $i; @endphp
                                @php $reasonSection = $sectionsByKey->get($reasonKey); @endphp

                                <div class="hero-reason-block rounded-xl border border-slate-200 p-5" data-index="{{ $i }}" data-existing="{{ $reasonSection ? 1 : 0 }}">
                                    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                                        <div>
                                            <div class="text-sm text-slate-500">Section Key</div>
                                            <div class="text-base font-semibold text-slate-900">{{ $reasonKey }}</div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <select name="sections[{{ $reasonKey }}][status]"
                                                    class="rounded-md border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="active" @selected(old('sections.' . $reasonKey . '.status', optional($reasonSection)->status ?? 'active') === 'active')>Active</option>
                                                <option value="inactive" @selected(old('sections.' . $reasonKey . '.status', optional($reasonSection)->status) === 'inactive')>Inactive</option>
                                            </select>
                                            <button type="button"
                                                    class="remove-hero-reason inline-flex items-center rounded-lg bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-700 ring-1 ring-slate-200 hover:bg-slate-200">
                                                Deactivate
                                            </button>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700">Title (BN)</label>
                                            <input name="sections[{{ $reasonKey }}][title_bn]" value="{{ old('sections.' . $reasonKey . '.title_bn', optional($reasonSection)->title_bn) }}"
                                                   class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700">Title (EN)</label>
                                            <input name="sections[{{ $reasonKey }}][title_en]" value="{{ old('sections.' . $reasonKey . '.title_en', optional($reasonSection)->title_en) }}"
                                                   class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-slate-700">Content (BN)</label>
                                            <textarea name="sections[{{ $reasonKey }}][content_bn]" rows="4"
                                                      class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('sections.' . $reasonKey . '.content_bn', optional($reasonSection)->content_bn) }}</textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700">Content (EN)</label>
                                            <textarea name="sections[{{ $reasonKey }}][content_en]" rows="4"
                                                      class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('sections.' . $reasonKey . '.content_en', optional($reasonSection)->content_en) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <template id="heroReasonTemplate">
                            <div class="hero-reason-block rounded-xl border border-slate-200 p-5" data-index="__INDEX__" data-existing="0">
                                <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                                    <div>
                                        <div class="text-sm text-slate-500">Section Key</div>
                                        <div class="text-base font-semibold text-slate-900">hero_different_reason___INDEX__</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <select name="sections[hero_different_reason___INDEX__][status]"
                                                class="rounded-md border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="active" selected>Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                        <button type="button"
                                                class="remove-hero-reason inline-flex items-center rounded-lg bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-700 ring-1 ring-slate-200 hover:bg-slate-200">
                                            Remove
                                        </button>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Title (BN)</label>
                                        <input name="sections[hero_different_reason___INDEX__][title_bn]"
                                               class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Title (EN)</label>
                                        <input name="sections[hero_different_reason___INDEX__][title_en]"
                                               class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Content (BN)</label>
                                        <textarea name="sections[hero_different_reason___INDEX__][content_bn]" rows="4"
                                                  class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Content (EN)</label>
                                        <textarea name="sections[hero_different_reason___INDEX__][content_en]" rows="4"
                                                  class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <script>
                            (function () {
                                var addBtn = document.getElementById('addHeroReason');
                                var container = document.getElementById('heroReasonsContainer');
                                var template = document.getElementById('heroReasonTemplate');

                                if (!addBtn || !container || !template) {
                                    return;
                                }

                                function bindRemove(root) {
                                    var buttons = root.querySelectorAll('.remove-hero-reason');
                                    buttons.forEach(function (btn) {
                                        btn.addEventListener('click', function () {
                                            var block = btn.closest('.hero-reason-block');
                                            if (!block) {
                                                return;
                                            }

                                            var isExisting = block.getAttribute('data-existing') === '1';

                                            if (!isExisting) {
                                                block.remove();
                                                return;
                                            }

                                            var statusSelect = block.querySelector('select[name$="[status]"]');
                                            if (statusSelect) {
                                                statusSelect.value = 'inactive';
                                            }

                                            block.classList.add('opacity-60');
                                            btn.textContent = 'Deactivated';
                                            btn.disabled = true;
                                            btn.classList.add('cursor-not-allowed');
                                        });
                                    });
                                }

                                bindRemove(container);

                                addBtn.addEventListener('click', function () {
                                    var nextIndex = parseInt(addBtn.getAttribute('data-next-index') || '1', 10);
                                    if (!Number.isFinite(nextIndex) || nextIndex < 1) {
                                        nextIndex = 1;
                                    }

                                    var html = template.innerHTML.split('__INDEX__').join(String(nextIndex));
                                    var wrapper = document.createElement('div');
                                    wrapper.innerHTML = html;
                                    var node = wrapper.firstElementChild;
                                    if (!node) {
                                        return;
                                    }

                                    container.appendChild(node);
                                    bindRemove(node);

                                    addBtn.setAttribute('data-next-index', String(nextIndex + 1));
                                });
                            })();
                        </script>

                        <div class="flex items-center justify-end">
                            <button type="submit"
                                    class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                Save Home Hero
                            </button>
                        </div>
                    </form>
                </div>

                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-slate-900">Home About (Why Choose iTechBD)</h3>
                        <p class="mt-1 text-sm text-slate-500">This controls the “কেন iTechBD বেছে নেবেন” section on the home page.</p>
                    </div>

                    @php
                        $homeAboutTitleBnFallback = __('frontend.home_about_title', [], 'bn');
                        $homeAboutTitleEnFallback = __('frontend.home_about_title', [], 'en');

                        $homeAboutSubtitleBnFallback = __('frontend.home_about_subtitle', [], 'bn');
                        $homeAboutSubtitleEnFallback = __('frontend.home_about_subtitle', [], 'en');
                    @endphp

                    <form method="POST"
                          action="{{ route('admin.frontend-editor.sections.bulk-update', $selectedPage) }}"
                          class="space-y-6">
                        @csrf
                        @method('PATCH')

                        {{-- home_about_title --}}
                        @php $homeAboutTitle = $sectionsByKey->get('home_about_title'); @endphp
                        <div class="rounded-xl border border-slate-200 p-5">
                            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                                <div>
                                    <div class="text-sm text-slate-500">Section Key</div>
                                    <div class="text-base font-semibold text-slate-900">home_about_title</div>
                                </div>
                                <select name="sections[home_about_title][status]"
                                        class="rounded-md border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="active" @selected(old('sections.home_about_title.status', optional($homeAboutTitle)->status ?? 'active') === 'active')>Active</option>
                                    <option value="inactive" @selected(old('sections.home_about_title.status', optional($homeAboutTitle)->status) === 'inactive')>Inactive</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Title (BN)</label>
                                    <input name="sections[home_about_title][title_bn]" value="{{ old('sections.home_about_title.title_bn', optional($homeAboutTitle)->title_bn ?: $homeAboutTitleBnFallback) }}"
                                           class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Title (EN)</label>
                                    <input name="sections[home_about_title][title_en]" value="{{ old('sections.home_about_title.title_en', optional($homeAboutTitle)->title_en ?: $homeAboutTitleEnFallback) }}"
                                           class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>
                        </div>

                        {{-- home_about_subtitle --}}
                        @php $homeAboutSubtitle = $sectionsByKey->get('home_about_subtitle'); @endphp
                        <div class="rounded-xl border border-slate-200 p-5">
                            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                                <div>
                                    <div class="text-sm text-slate-500">Section Key</div>
                                    <div class="text-base font-semibold text-slate-900">home_about_subtitle</div>
                                </div>
                                <select name="sections[home_about_subtitle][status]"
                                        class="rounded-md border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="active" @selected(old('sections.home_about_subtitle.status', optional($homeAboutSubtitle)->status ?? 'active') === 'active')>Active</option>
                                    <option value="inactive" @selected(old('sections.home_about_subtitle.status', optional($homeAboutSubtitle)->status) === 'inactive')>Inactive</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Content (BN)</label>
                                    <textarea name="sections[home_about_subtitle][content_bn]" rows="4"
                                              class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('sections.home_about_subtitle.content_bn', optional($homeAboutSubtitle)->content_bn ?: $homeAboutSubtitleBnFallback) }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Content (EN)</label>
                                    <textarea name="sections[home_about_subtitle][content_en]" rows="4"
                                              class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('sections.home_about_subtitle.content_en', optional($homeAboutSubtitle)->content_en ?: $homeAboutSubtitleEnFallback) }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- home_about_card_1..3 --}}
                        @php $aboutCardKeys = ['home_about_card_1', 'home_about_card_2', 'home_about_card_3']; @endphp
                        @foreach($aboutCardKeys as $cardKey)
                            @php $cardSection = $sectionsByKey->get($cardKey); @endphp
                            @php
                                $cardIndex = null;
                                if (preg_match('/^home_about_card_(\d+)$/', $cardKey, $m)) {
                                    $cardIndex = (int) $m[1];
                                }
                                $cardTitleKey = $cardIndex ? ('frontend.home_about_card_' . $cardIndex . '_title') : null;
                                $cardDescKey = $cardIndex ? ('frontend.home_about_card_' . $cardIndex . '_desc') : null;

                                $cardTitleBnFallback = $cardTitleKey ? __($cardTitleKey, [], 'bn') : '';
                                $cardTitleEnFallback = $cardTitleKey ? __($cardTitleKey, [], 'en') : '';
                                $cardDescBnFallback = $cardDescKey ? __($cardDescKey, [], 'bn') : '';
                                $cardDescEnFallback = $cardDescKey ? __($cardDescKey, [], 'en') : '';
                            @endphp
                            <div class="rounded-xl border border-slate-200 p-5">
                                <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                                    <div>
                                        <div class="text-sm text-slate-500">Section Key</div>
                                        <div class="text-base font-semibold text-slate-900">{{ $cardKey }}</div>
                                    </div>
                                    <select name="sections[{{ $cardKey }}][status]"
                                            class="rounded-md border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="active" @selected(old('sections.' . $cardKey . '.status', optional($cardSection)->status ?? 'active') === 'active')>Active</option>
                                        <option value="inactive" @selected(old('sections.' . $cardKey . '.status', optional($cardSection)->status) === 'inactive')>Inactive</option>
                                    </select>
                                </div>
                                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Title (BN)</label>
                                        <input name="sections[{{ $cardKey }}][title_bn]" value="{{ old('sections.' . $cardKey . '.title_bn', optional($cardSection)->title_bn ?: $cardTitleBnFallback) }}"
                                               class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Title (EN)</label>
                                        <input name="sections[{{ $cardKey }}][title_en]" value="{{ old('sections.' . $cardKey . '.title_en', optional($cardSection)->title_en ?: $cardTitleEnFallback) }}"
                                               class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Content (BN)</label>
                                        <textarea name="sections[{{ $cardKey }}][content_bn]" rows="4"
                                                  class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('sections.' . $cardKey . '.content_bn', optional($cardSection)->content_bn ?: $cardDescBnFallback) }}</textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Content (EN)</label>
                                        <textarea name="sections[{{ $cardKey }}][content_en]" rows="4"
                                                  class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('sections.' . $cardKey . '.content_en', optional($cardSection)->content_en ?: $cardDescEnFallback) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="flex items-center justify-end">
                            <button type="submit"
                                    class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                Save Home About
                            </button>
                        </div>
                    </form>
                </div>

                <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-slate-900">Home Skill Tracks</h3>
                        <p class="mt-1 text-sm text-slate-500">Controls the “আমাদের স্কিল ট্র্যাকসমূহ” section on the home page.</p>
                    </div>

                    @php
                        $skillTracksTitleBnFallback = __('frontend.home_skill_tracks_title', [], 'bn');
                        $skillTracksTitleEnFallback = __('frontend.home_skill_tracks_title', [], 'en');

                        $skillTracksSubtitleBnFallback = __('frontend.home_skill_tracks_subtitle', [], 'bn');
                        $skillTracksSubtitleEnFallback = __('frontend.home_skill_tracks_subtitle', [], 'en');

                        $skillTracksDefaultItems = [
                            1 => [
                                'title' => 'Web Development',
                                'content' => "Front-end + back-end fundamentals with real projects.\nHTML, CSS, TailwindCSS, JavaScript\nResponsive UI + animations + components\nAPIs, database basics, deployment basics",
                            ],
                            2 => [
                                'title' => 'SEO (Search Engine Optimization)',
                                'content' => "Technical SEO + content + analytics.\nOn-page, off-page, technical SEO\nKeyword research + content planning\nAnalytics basics + reporting",
                            ],
                            3 => [
                                'title' => '.NET Development',
                                'content' => "C# + ASP.NET Core for modern applications.\nC# fundamentals + OOP\nASP.NET Core APIs + auth basics\nDatabase + EF Core basics",
                            ],
                            4 => [
                                'title' => 'Graphics Design',
                                'content' => "Branding + marketing visuals + portfolio.\nPhotoshop / Illustrator fundamentals\nBranding, typography, layouts\nPortfolio + client workflow",
                            ],
                            5 => [
                                'title' => 'Extra Topics (Optional)',
                                'content' => "UI/UX, Git, communication and teamwork.\nUI/UX basics (Figma)\nGit basics + teamwork\nClient communication",
                            ],
                        ];
                    @endphp

                    <form method="POST"
                          action="{{ route('admin.frontend-editor.sections.bulk-update', $selectedPage) }}"
                          class="space-y-6">
                        @csrf
                        @method('PATCH')

                        {{-- home_skill_tracks_title --}}
                        @php $skillTracksTitle = $sectionsByKey->get('home_skill_tracks_title'); @endphp
                        <div class="rounded-xl border border-slate-200 p-5">
                            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                                <div>
                                    <div class="text-sm text-slate-500">Section Key</div>
                                    <div class="text-base font-semibold text-slate-900">home_skill_tracks_title</div>
                                </div>
                                <select name="sections[home_skill_tracks_title][status]"
                                        class="rounded-md border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="active" @selected(old('sections.home_skill_tracks_title.status', optional($skillTracksTitle)->status ?? 'active') === 'active')>Active</option>
                                    <option value="inactive" @selected(old('sections.home_skill_tracks_title.status', optional($skillTracksTitle)->status) === 'inactive')>Inactive</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Title (BN)</label>
                                    <input name="sections[home_skill_tracks_title][title_bn]" value="{{ old('sections.home_skill_tracks_title.title_bn', optional($skillTracksTitle)->title_bn ?: $skillTracksTitleBnFallback) }}"
                                           class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Title (EN)</label>
                                    <input name="sections[home_skill_tracks_title][title_en]" value="{{ old('sections.home_skill_tracks_title.title_en', optional($skillTracksTitle)->title_en ?: $skillTracksTitleEnFallback) }}"
                                           class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>
                        </div>

                        {{-- home_skill_tracks_subtitle --}}
                        @php $skillTracksSubtitle = $sectionsByKey->get('home_skill_tracks_subtitle'); @endphp
                        <div class="rounded-xl border border-slate-200 p-5">
                            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                                <div>
                                    <div class="text-sm text-slate-500">Section Key</div>
                                    <div class="text-base font-semibold text-slate-900">home_skill_tracks_subtitle</div>
                                </div>
                                <select name="sections[home_skill_tracks_subtitle][status]"
                                        class="rounded-md border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="active" @selected(old('sections.home_skill_tracks_subtitle.status', optional($skillTracksSubtitle)->status ?? 'active') === 'active')>Active</option>
                                    <option value="inactive" @selected(old('sections.home_skill_tracks_subtitle.status', optional($skillTracksSubtitle)->status) === 'inactive')>Inactive</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Content (BN)</label>
                                    <textarea name="sections[home_skill_tracks_subtitle][content_bn]" rows="3"
                                              class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('sections.home_skill_tracks_subtitle.content_bn', optional($skillTracksSubtitle)->content_bn ?: $skillTracksSubtitleBnFallback) }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Content (EN)</label>
                                    <textarea name="sections[home_skill_tracks_subtitle][content_en]" rows="3"
                                              class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('sections.home_skill_tracks_subtitle.content_en', optional($skillTracksSubtitle)->content_en ?: $skillTracksSubtitleEnFallback) }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- home_skill_tracks_cta --}}
                        @php $skillTracksCta = $sectionsByKey->get('home_skill_tracks_cta'); @endphp
                        <div class="rounded-xl border border-slate-200 p-5">
                            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                                <div>
                                    <div class="text-sm text-slate-500">Section Key</div>
                                    <div class="text-base font-semibold text-slate-900">home_skill_tracks_cta</div>
                                </div>
                                <select name="sections[home_skill_tracks_cta][status]"
                                        class="rounded-md border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="active" @selected(old('sections.home_skill_tracks_cta.status', optional($skillTracksCta)->status ?? 'active') === 'active')>Active</option>
                                    <option value="inactive" @selected(old('sections.home_skill_tracks_cta.status', optional($skillTracksCta)->status) === 'inactive')>Inactive</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Button Text (BN)</label>
                                    <input name="sections[home_skill_tracks_cta][button_text_bn]" value="{{ old('sections.home_skill_tracks_cta.button_text_bn', optional($skillTracksCta)->button_text_bn ?: 'How we help you get hired →') }}"
                                           class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Button Text (EN)</label>
                                    <input name="sections[home_skill_tracks_cta][button_text_en]" value="{{ old('sections.home_skill_tracks_cta.button_text_en', optional($skillTracksCta)->button_text_en ?: 'How we help you get hired →') }}"
                                           class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Button Link</label>
                                    <input name="sections[home_skill_tracks_cta][button_link]" value="{{ old('sections.home_skill_tracks_cta.button_link', optional($skillTracksCta)->button_link ?: '#outcomes') }}"
                                           class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>
                        </div>

                        {{-- home_skill_track_* (dynamic) --}}
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm font-semibold text-slate-900">Skill Track Items</div>
                                <div class="mt-1 text-xs text-slate-500">Content format: first line = short description, next lines = bullet points.</div>
                            </div>
                            <button type="button"
                                    id="addSkillTrack"
                                    data-next-index="{{ $nextSkillTrackIndex }}"
                                    class="inline-flex items-center rounded-lg bg-slate-900 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-800">
                                Add Track
                            </button>
                        </div>

                        <div id="skillTracksContainer" class="space-y-6">
                            @foreach($skillTrackIndexes as $i)
                                @php $trackKey = 'home_skill_track_' . $i; @endphp
                                @php $trackSection = $sectionsByKey->get($trackKey); @endphp
                                @php
                                    $defaults = $skillTracksDefaultItems[$i] ?? ['title' => '', 'content' => ''];
                                    $fallbackTitle = (string) ($defaults['title'] ?? '');
                                    $fallbackContent = (string) ($defaults['content'] ?? '');
                                @endphp

                                <div class="skill-track-block rounded-xl border border-slate-200 p-5" data-index="{{ $i }}" data-existing="{{ $trackSection ? 1 : 0 }}">
                                    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                                        <div>
                                            <div class="text-sm text-slate-500">Section Key</div>
                                            <div class="text-base font-semibold text-slate-900">{{ $trackKey }}</div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <select name="sections[{{ $trackKey }}][status]"
                                                    class="rounded-md border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="active" @selected(old('sections.' . $trackKey . '.status', optional($trackSection)->status ?? 'active') === 'active')>Active</option>
                                                <option value="inactive" @selected(old('sections.' . $trackKey . '.status', optional($trackSection)->status) === 'inactive')>Inactive</option>
                                            </select>
                                            <button type="button"
                                                    class="remove-skill-track inline-flex items-center rounded-lg bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-700 ring-1 ring-slate-200 hover:bg-slate-200">
                                                Deactivate
                                            </button>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700">Title (BN)</label>
                                            <input name="sections[{{ $trackKey }}][title_bn]" value="{{ old('sections.' . $trackKey . '.title_bn', optional($trackSection)->title_bn ?: $fallbackTitle) }}"
                                                   class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700">Title (EN)</label>
                                            <input name="sections[{{ $trackKey }}][title_en]" value="{{ old('sections.' . $trackKey . '.title_en', optional($trackSection)->title_en ?: $fallbackTitle) }}"
                                                   class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-slate-700">Content (BN)</label>
                                            <textarea name="sections[{{ $trackKey }}][content_bn]" rows="5"
                                                      class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('sections.' . $trackKey . '.content_bn', optional($trackSection)->content_bn ?: $fallbackContent) }}</textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700">Content (EN)</label>
                                            <textarea name="sections[{{ $trackKey }}][content_en]" rows="5"
                                                      class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('sections.' . $trackKey . '.content_en', optional($trackSection)->content_en ?: $fallbackContent) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <template id="skillTrackTemplate">
                            <div class="skill-track-block rounded-xl border border-slate-200 p-5" data-index="__INDEX__" data-existing="0">
                                <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                                    <div>
                                        <div class="text-sm text-slate-500">Section Key</div>
                                        <div class="text-base font-semibold text-slate-900">home_skill_track___INDEX__</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <select name="sections[home_skill_track___INDEX__][status]"
                                                class="rounded-md border-slate-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="active" selected>Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                        <button type="button"
                                                class="remove-skill-track inline-flex items-center rounded-lg bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-700 ring-1 ring-slate-200 hover:bg-slate-200">
                                            Remove
                                        </button>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Title (BN)</label>
                                        <input name="sections[home_skill_track___INDEX__][title_bn]"
                                               class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Title (EN)</label>
                                        <input name="sections[home_skill_track___INDEX__][title_en]"
                                               class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Content (BN)</label>
                                        <textarea name="sections[home_skill_track___INDEX__][content_bn]" rows="5"
                                                  class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700">Content (EN)</label>
                                        <textarea name="sections[home_skill_track___INDEX__][content_en]" rows="5"
                                                  class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <script>
                            (function () {
                                var addBtn = document.getElementById('addSkillTrack');
                                var container = document.getElementById('skillTracksContainer');
                                var template = document.getElementById('skillTrackTemplate');

                                if (!addBtn || !container || !template) {
                                    return;
                                }

                                function bindRemove(root) {
                                    var buttons = root.querySelectorAll('.remove-skill-track');
                                    buttons.forEach(function (btn) {
                                        btn.addEventListener('click', function () {
                                            var block = btn.closest('.skill-track-block');
                                            if (!block) {
                                                return;
                                            }

                                            var isExisting = block.getAttribute('data-existing') === '1';

                                            if (!isExisting) {
                                                block.remove();
                                                return;
                                            }

                                            var statusSelect = block.querySelector('select[name$="[status]"]');
                                            if (statusSelect) {
                                                statusSelect.value = 'inactive';
                                            }

                                            block.classList.add('opacity-60');
                                            btn.textContent = 'Deactivated';
                                            btn.disabled = true;
                                            btn.classList.add('cursor-not-allowed');
                                        });
                                    });
                                }

                                bindRemove(container);

                                addBtn.addEventListener('click', function () {
                                    var nextIndex = parseInt(addBtn.getAttribute('data-next-index') || '1', 10);
                                    if (!Number.isFinite(nextIndex) || nextIndex < 1) {
                                        nextIndex = 1;
                                    }

                                    var html = template.innerHTML.split('__INDEX__').join(String(nextIndex));
                                    var wrapper = document.createElement('div');
                                    wrapper.innerHTML = html;
                                    var node = wrapper.firstElementChild;
                                    if (!node) {
                                        return;
                                    }

                                    container.appendChild(node);
                                    bindRemove(node);

                                    addBtn.setAttribute('data-next-index', String(nextIndex + 1));
                                });
                            })();
                        </script>

                        <div class="flex items-center justify-end">
                            <button type="submit"
                                    class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                Save Skill Tracks
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-slate-900">Sections</h3>
                    <p class="mt-1 text-sm text-slate-500">Edit sections for <span class="font-semibold">{{ $selectedPage->slug }}</span>.</p>
                </div>

                @php
                    $sectionsForList = $selectedPage->slug === 'home' ? $otherSections : $sections;
                @endphp

                @if($sectionsForList->isEmpty())
                    <div class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                        No sections found for this page.
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($sectionsForList as $section)
                            @php
                                $isHeroSideHeading = $section->section_key === 'hero_side_heading';
                            @endphp
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

                                    @if(! $isHeroSideHeading)
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
                                    @endif

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
