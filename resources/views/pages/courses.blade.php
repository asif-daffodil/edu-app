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
                <article class="reveal rounded-3xl bg-white/5 p-6 ring-1 ring-white/10 transition hover:bg-white/7">
                    <h3 class="text-lg font-semibold text-white">Web Development</h3>
                    <p class="mt-1 text-sm text-slate-200">Front-end + back-end fundamentals with real projects.</p>
                </article>
                <article class="reveal rounded-3xl bg-white/5 p-6 ring-1 ring-white/10 transition hover:bg-white/7">
                    <h3 class="text-lg font-semibold text-white">SEO</h3>
                    <p class="mt-1 text-sm text-slate-200">Technical SEO + content + analytics.</p>
                </article>
                <article class="reveal rounded-3xl bg-white/5 p-6 ring-1 ring-white/10 transition hover:bg-white/7">
                    <h3 class="text-lg font-semibold text-white">.NET Development</h3>
                    <p class="mt-1 text-sm text-slate-200">C# + ASP.NET Core for modern applications.</p>
                </article>
                <article class="reveal rounded-3xl bg-white/5 p-6 ring-1 ring-white/10 transition hover:bg-white/7">
                    <h3 class="text-lg font-semibold text-white">Graphics Design</h3>
                    <p class="mt-1 text-sm text-slate-200">Branding + marketing visuals + portfolio.</p>
                </article>
                <article class="reveal rounded-3xl bg-white/5 p-6 ring-1 ring-white/10 transition hover:bg-white/7">
                    <h3 class="text-lg font-semibold text-white">UI/UX (Optional)</h3>
                    <p class="mt-1 text-sm text-slate-200">Design systems, wireframes and prototyping fundamentals.</p>
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
