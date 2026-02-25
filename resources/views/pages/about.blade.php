@extends('layouts.site')

@section('title', __('frontend.about') . ' • ' . config('app.name', 'iTechBD Ltd'))

@section('content')
<main>
    <section class="border-b border-white/10">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            @php
                $hero = $cmsSectionsByKey->get('hero');
            @endphp

            <div class="reveal">
                <h1 class="text-3xl font-semibold text-white sm:text-4xl">{{ optional($hero)->title ?: __('frontend.about_title') }}</h1>
                <p class="mt-3 max-w-3xl text-slate-200">{{ optional($hero)->content ?: __('frontend.about_subtitle') }}</p>
            </div>

            <div class="reveal mt-10 grid gap-6 md:grid-cols-3">
                <div class="rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                    <div class="text-sm font-semibold text-white">Mentor-led learning</div>
                    <p class="mt-2 text-sm text-slate-200">Weekly guidance, reviews, and a structured path from fundamentals to advanced skills.</p>
                </div>
                <div class="rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                    <div class="text-sm font-semibold text-white">Portfolio first</div>
                    <p class="mt-2 text-sm text-slate-200">Projects that prove your ability and make you stand out to employers and clients.</p>
                </div>
                <div class="rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                    <div class="text-sm font-semibold text-white">Career & freelancing support</div>
                    <p class="mt-2 text-sm text-slate-200">CV + interview practice, proposals, and communication guidance for real clients.</p>
                </div>
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
