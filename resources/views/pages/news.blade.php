@extends('layouts.site')

@section('title', 'News • ' . config('app.name', 'iTechBD Ltd'))

@section('content')
<main>
    <section class="border-b border-white/10">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="reveal flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-white sm:text-4xl">{{ __('frontend.home_news_title') }}</h1>
                    <p class="mt-3 max-w-2xl text-slate-200">{{ __('frontend.home_news_subtitle') }}</p>
                </div>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-3">
                <article class="reveal rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                    <div class="text-xs text-slate-300">Batch Update</div>
                    <h3 class="mt-2 text-base font-semibold text-white">New batch enrollment open</h3>
                    <p class="mt-2 text-sm text-slate-200">Limited seats with mentor-led support and weekly reviews.</p>
                </article>
                <article class="reveal rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                    <div class="text-xs text-slate-300">Workshop</div>
                    <h3 class="mt-2 text-base font-semibold text-white">Portfolio & LinkedIn session</h3>
                    <p class="mt-2 text-sm text-slate-200">Improve your profile and showcase projects professionally.</p>
                </article>
                <article class="reveal rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                    <div class="text-xs text-slate-300">Freelancing</div>
                    <h3 class="mt-2 text-base font-semibold text-white">Client communication Q&A</h3>
                    <p class="mt-2 text-sm text-slate-200">Learn proposals, scope, and how to handle real clients.</p>
                </article>
            </div>
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
