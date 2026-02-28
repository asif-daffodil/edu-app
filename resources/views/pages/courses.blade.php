@extends('layouts.site')

@section('title', __('frontend.courses') . ' • ' . config('app.name', 'iTechBD Ltd'))

@section('content')
<main>
    <section class="border-b border-white/10">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            @php
                $hero = $cmsSectionsByKey->get('hero');
            @endphp

            <div class="reveal flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-white sm:text-4xl">{{ optional($hero)->title ?: __('frontend.courses_title') }}</h1>
                    <p class="mt-3 max-w-2xl text-slate-200">{{ optional($hero)->content ?: __('frontend.courses_subtitle') }}</p>
                </div>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @php
                    /** @var \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection $courses */
                    $hasCourses = isset($courses) && $courses->count() > 0;
                @endphp

                @forelse($courses as $course)
                    @php
                        $thumbUrl = $course->thumbnail_url;
                        $excerpt = \Illuminate\Support\Str::limit(trim(strip_tags((string) $course->description)), 140);
                    @endphp
                    <article class="reveal overflow-hidden rounded-3xl bg-white/5 ring-1 ring-white/10 transition hover:bg-white/[0.07]">
                        <div class="aspect-[16/9] bg-slate-950/30">
                            @if($thumbUrl)
                                <img src="{{ $thumbUrl }}" alt="{{ $course->title }} thumbnail" class="h-full w-full object-cover" loading="lazy">
                            @else
                                <div class="flex h-full w-full items-center justify-center text-xs text-slate-300">
                                    {{ __('frontend.no_image') }}
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-white">{{ $course->title }}</h3>
                            <p class="mt-2 text-sm text-slate-200">{{ $excerpt }}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="inline-flex items-center rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-200 ring-1 ring-emerald-500/20">
                                    {{ __('frontend.enroll_now') }}
                                </span>
                                <a href="{{ route('contact') }}" class="text-sm font-semibold text-white/90 hover:text-white">
                                    {{ __('frontend.contact') }} →
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="reveal rounded-3xl bg-white/5 p-8 ring-1 ring-white/10 md:col-span-2 xl:col-span-3">
                        <div class="text-white font-semibold">{{ __('frontend.no_courses_title') }}</div>
                        <div class="mt-2 text-sm text-slate-200">{{ __('frontend.no_courses_body') }}</div>
                    </div>
                @endforelse
            </div>

            @if(isset($courses) && method_exists($courses, 'links'))
                <div class="mt-10">
                    {{ $courses->links() }}
                </div>
            @endif
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    (function () {
        var revealEls = Array.prototype.slice.call(document.querySelectorAll('.reveal'));
        if (!('IntersectionObserver' in window)) {
            revealEls.forEach(function (el) { el.classList.add('is-visible'); });
            return;
        }
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -10% 0px' });
        revealEls.forEach(function (el) { observer.observe(el); });
    })();
</script>
@endpush
