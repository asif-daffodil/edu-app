@extends('layouts.site')

@section('title', 'Contact • ' . config('app.name', 'iTechBD Ltd'))

@section('content')
<main>
    <section class="border-b border-white/10">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            @php
                $hero = $cmsSectionsByKey->get('hero');
                $emailSection = $cmsSectionsByKey->get('contact_email');
                $phoneSection = $cmsSectionsByKey->get('contact_phone');

                $emailLabel = optional($emailSection)->title ?: __('frontend.contact_email_label');
                $emailValue = trim((string) (optional($emailSection)->content ?: 'info@example.com'));
                $emailHref = optional($emailSection)->button_link ?: ('mailto:' . $emailValue);

                $phoneLabel = optional($phoneSection)->title ?: __('frontend.contact_phone_label');
                $phoneValue = trim((string) (optional($phoneSection)->content ?: '+880 10 0000 0000'));
                $phoneHref = optional($phoneSection)->button_link ?: ('tel:' . preg_replace('/\s+/', '', $phoneValue));
            @endphp

            <div class="reveal">
                <h1 class="text-3xl font-semibold text-white sm:text-4xl">{{ optional($hero)->title ?: __('frontend.contact_title') }}</h1>
                <p class="mt-3 max-w-2xl text-slate-200">{{ optional($hero)->content ?: __('frontend.contact_subtitle') }}</p>
            </div>

            <div class="reveal mt-10 grid gap-6 lg:grid-cols-2">
                <div class="rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                    <div class="text-sm font-semibold text-white">{{ $emailLabel }}</div>
                    <a href="{{ $emailHref }}" class="mt-2 inline-flex text-sm text-sky-200 hover:text-sky-100">{{ $emailValue }}</a>
                </div>
                <div class="rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                    <div class="text-sm font-semibold text-white">{{ $phoneLabel }}</div>
                    <a href="{{ $phoneHref }}" class="mt-2 inline-flex text-sm text-sky-200 hover:text-sky-100">{{ $phoneValue }}</a>
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
