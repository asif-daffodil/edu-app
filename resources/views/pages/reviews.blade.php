@extends('layouts.site')

@section('title', 'Reviews • ' . config('app.name', 'iTechBD Ltd'))

@section('content')
<main>
    <section class="border-b border-white/10">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="reveal">
                <h1 class="text-3xl font-semibold text-white sm:text-4xl">{{ __('frontend.home_reviews_title') }}</h1>
                <p class="mt-3 max-w-2xl text-slate-200">{{ __('frontend.home_reviews_subtitle') }}</p>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-3">
                @php
                    $reviews = [
                        ['name' => 'Student', 'quote' => 'Mentors were very supportive. The project reviews helped me build a strong portfolio.'],
                        ['name' => 'Freelancer', 'quote' => 'I learned how to communicate with clients and improved my proposals. Great guidance for freelancing.'],
                        ['name' => 'Job Seeker', 'quote' => 'The CV + interview practice sessions were super helpful. I felt confident applying for roles.'],
                    ];
                @endphp

                @foreach ($reviews as $r)
                    <div class="reveal rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                        <div class="flex items-center gap-1 text-amber-300" aria-label="5 star rating">
                            @for ($i = 0; $i < 5; $i++)
                                <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.71c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 0 0 .951-.69l1.07-3.292Z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="mt-4 text-sm text-slate-200">“{{ $r['quote'] }}”</p>
                        <div class="mt-4 text-xs font-semibold text-white">— {{ $r['name'] }}</div>
                    </div>
                @endforeach
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
