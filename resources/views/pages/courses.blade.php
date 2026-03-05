@extends('layouts.site')

@section('title', __('frontend.courses') . ' • ' . config('app.name', 'iTechBD Ltd'))

@section('content')
<main>
    <section class="border-b border-slate-200/70 dark:border-white/10">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            @php
                $hero = $cmsSectionsByKey->get('hero');
            @endphp

            <div class="reveal flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-slate-900 dark:text-white sm:text-4xl">{{ optional($hero)->title ?: __('frontend.courses_title') }}</h1>
                    <p class="mt-3 max-w-2xl text-slate-600 dark:text-slate-200">{{ optional($hero)->content ?: __('frontend.courses_subtitle') }}</p>
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
                    <article class="reveal overflow-hidden rounded-3xl bg-white ring-1 ring-slate-200/70 shadow-sm shadow-slate-200/60 transition hover:bg-slate-50 dark:bg-white/5 dark:ring-white/10 dark:hover:bg-white/[0.07] dark:shadow-none">
                        <div class="aspect-[16/9] bg-slate-100 dark:bg-slate-950/30">
                            @if($thumbUrl)
                                <img src="{{ $thumbUrl }}" alt="{{ $course->title }} thumbnail" class="h-full w-full object-cover" loading="lazy">
                            @else
                                <div class="flex h-full w-full items-center justify-center text-xs text-slate-500 dark:text-slate-300">
                                    {{ __('frontend.no_image') }}
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $course->title }}</h3>

                            @php
                                $oldPrice = $course->old_price;
                                $discountPrice = $course->discount_price;
                            @endphp

                            <div class="mt-2">
                                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-white/60">{{ __('frontend.course_fee') }}</div>
                                <div class="mt-1 flex items-baseline gap-2">
                                    @if(!is_null($oldPrice) && !is_null($discountPrice) && (float) $discountPrice < (float) $oldPrice)
                                        <span class="text-sm font-semibold text-slate-500 line-through dark:text-white/60">{{ number_format((float) $oldPrice, 2) }}</span>
                                        <span class="text-base font-semibold text-emerald-700 dark:text-emerald-200">{{ number_format((float) $discountPrice, 2) }}</span>
                                    @elseif(!is_null($discountPrice))
                                        <span class="text-base font-semibold text-emerald-700 dark:text-emerald-200">{{ number_format((float) $discountPrice, 2) }}</span>
                                    @elseif(!is_null($oldPrice))
                                        <span class="text-base font-semibold text-slate-900 dark:text-white">{{ number_format((float) $oldPrice, 2) }}</span>
                                    @else
                                        <span class="text-sm text-slate-600 dark:text-slate-200">{{ __('frontend.contact_for_fee') }}</span>
                                    @endif
                                </div>
                            </div>

                            <p class="mt-2 text-sm text-slate-600 dark:text-slate-200">{{ $excerpt }}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <a href="/courses/{{ $course->getRouteKey() }}/checkout"
                                   @guest data-auth-trigger="login" data-auth-redirect="/courses/{{ $course->getRouteKey() }}/checkout" @endguest
                                   class="inline-flex items-center rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold text-white shadow-sm shadow-slate-900/10 hover:bg-slate-800 dark:bg-white dark:text-slate-950 dark:hover:bg-slate-100">
                                    {{ __('frontend.buy_now') }}
                                </a>
                                <div class="flex items-center gap-4">
                                    <a href="/courses/{{ $course->getRouteKey() }}" class="text-sm font-semibold text-slate-900 hover:text-slate-950 dark:text-white/90 dark:hover:text-white">
                                        {{ __('frontend.view_details') }} →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="reveal rounded-3xl bg-white p-8 ring-1 ring-slate-200/70 shadow-sm shadow-slate-200/60 dark:bg-white/5 dark:ring-white/10 dark:shadow-none md:col-span-2 xl:col-span-3">
                        <div class="text-slate-900 dark:text-white font-semibold">{{ __('frontend.no_courses_title') }}</div>
                        <div class="mt-2 text-sm text-slate-600 dark:text-slate-200">{{ __('frontend.no_courses_body') }}</div>
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
