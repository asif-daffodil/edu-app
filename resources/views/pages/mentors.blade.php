@extends('layouts.site')

@section('title', 'Mentors • ' . config('app.name', 'iTechBD Ltd'))

@section('content')
<main>
    <section class="border-b border-white/10">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="reveal">
                <h1 class="text-3xl font-semibold text-white sm:text-4xl">Mentors</h1>
                <p class="mt-3 max-w-2xl text-slate-200">Meet mentors from different topics and learn with weekly guidance.</p>
            </div>

            <div class="reveal mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @php
                    $mentors = [
                        ['role' => 'Senior Web Engineer', 'tag' => 'Web Dev'],
                        ['role' => 'SEO Lead', 'tag' => 'SEO'],
                        ['role' => '.NET Developer', 'tag' => '.NET'],
                        ['role' => 'Creative Designer', 'tag' => 'Design'],
                        ['role' => 'UI/UX Specialist', 'tag' => 'UI/UX'],
                        ['role' => 'Mobile App Developer', 'tag' => 'Flutter'],
                        ['role' => 'DevOps Engineer', 'tag' => 'DevOps'],
                        ['role' => 'Data Analyst', 'tag' => 'Data'],
                    ];
                @endphp

                @foreach ($mentors as $m)
                    <div class="rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                        <div class="aspect-square w-full overflow-hidden rounded-2xl bg-slate-950/30 ring-1 ring-white/10 grid place-items-center">
                            <svg viewBox="0 0 24 24" fill="none" class="h-24 w-24 text-slate-200/70" aria-hidden="true">
                                <path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z" fill="currentColor" opacity="0.85" />
                                <path d="M3.2 21c2.3-4.3 6.2-6.7 8.8-6.7S18.5 16.7 20.8 21" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" opacity="0.85" />
                            </svg>
                        </div>
                        <div class="mt-4 text-sm font-semibold text-white">{{ $m['role'] }}</div>
                        <div class="mt-1 text-xs text-slate-300">{{ $m['tag'] }} • Weekly support</div>
                        <p class="mt-3 text-sm text-slate-200">Project review, guidance, and best practices to level up fast.</p>
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
