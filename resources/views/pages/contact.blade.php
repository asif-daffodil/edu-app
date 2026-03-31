@extends('layouts.site')

@section('title', 'Contact • ' . config('app.name', 'iTechBD Ltd'))

@section('content')
<main>
    <section class="border-b border-slate-200/70 dark:border-white/10">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            @php
                $hero = $cmsSectionsByKey->get('hero');
                $emailSection = $cmsSectionsByKey->get('contact_email');
                $phoneSection = $cmsSectionsByKey->get('contact_phone');

                $normalizeInlineText = function ($value): string {
                    $text = trim((string) $value);
                    if ($text === '') {
                        return '';
                    }

                    $text = preg_replace('/<\s*br\s*\/?\s*>/i', "\n", $text) ?? $text;
                    $text = strip_tags($text);
                    $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    $text = preg_replace('/\s+/u', ' ', $text) ?? $text;

                    return trim($text);
                };

                $rawEmailText = $normalizeInlineText(optional($emailSection)->content);
                $rawPhoneText = $normalizeInlineText(optional($phoneSection)->content);

                $emailLabel = optional($emailSection)->title ?: __('frontend.contact_email_label');
                $emailValue = $rawEmailText;
                if ($emailValue !== '' && preg_match('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}/i', $emailValue, $m)) {
                    $emailValue = $m[0];
                }
                $emailValue = $emailValue !== '' ? $emailValue : 'info@example.com';
                $emailHref = optional($emailSection)->button_link ?: ('mailto:' . $emailValue);

                $phoneLabel = optional($phoneSection)->title ?: __('frontend.contact_phone_label');
                $phoneValue = $rawPhoneText;
                if ($phoneValue !== '' && preg_match('/\+?[0-9][0-9\s\-().]{6,}/', $phoneValue, $m)) {
                    $phoneValue = trim($m[0]);
                }
                $phoneValue = $phoneValue !== '' ? $phoneValue : '+880 10 0000 0000';

                $phoneTel = preg_replace('/[^\d+]/', '', $phoneValue);
                $phoneHref = optional($phoneSection)->button_link ?: ('tel:' . $phoneTel);
            @endphp

            <div class="reveal">
                <h1 class="text-3xl font-semibold text-slate-900 dark:text-white sm:text-4xl">{{ optional($hero)->title ?: __('frontend.contact_title') }}</h1>
                <p class="mt-3 max-w-2xl text-slate-600 dark:text-slate-200">{{ optional($hero)->content ?: __('frontend.contact_subtitle') }}</p>
            </div>

            <div class="reveal mt-10 grid gap-6 lg:grid-cols-2">
                <div class="rounded-3xl bg-white p-6 ring-1 ring-slate-200/70 shadow-sm shadow-slate-200/60 dark:bg-white/5 dark:ring-white/10 dark:shadow-none">
                    <div class="text-sm font-semibold text-slate-900 dark:text-white">{{ $emailLabel }}</div>
                    <a href="{{ $emailHref }}" class="mt-2 inline-flex text-sm text-sky-700 hover:text-sky-800 dark:text-sky-200 dark:hover:text-sky-100">{{ $emailValue }}</a>
                </div>
                <div class="rounded-3xl bg-white p-6 ring-1 ring-slate-200/70 shadow-sm shadow-slate-200/60 dark:bg-white/5 dark:ring-white/10 dark:shadow-none">
                    <div class="text-sm font-semibold text-slate-900 dark:text-white">{{ $phoneLabel }}</div>
                    <a href="{{ $phoneHref }}" class="mt-2 inline-flex text-sm text-sky-700 hover:text-sky-800 dark:text-sky-200 dark:hover:text-sky-100">{{ $phoneValue }}</a>
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
