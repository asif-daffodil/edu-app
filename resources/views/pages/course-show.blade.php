@extends('layouts.site')

@section('title', $course->title . ' • ' . config('app.name', 'iTechBD Ltd'))

@section('content')
<main>
    <section class="border-b border-slate-200/70 dark:border-white/10">
        <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <a href="{{ route('courses') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 dark:text-slate-200 dark:hover:text-white">← {{ __('frontend.courses') }}</a>
                    <h1 class="mt-2 text-3xl font-semibold text-slate-900 dark:text-white sm:text-4xl">{{ $course->title }}</h1>

                    @php
                        $oldPrice = $course->old_price;
                        $discountPrice = $course->discount_price;
                    @endphp

                    @if(!is_null($oldPrice) || !is_null($discountPrice))
                        <div class="mt-3 flex flex-wrap items-baseline gap-x-4 gap-y-1">
                            @if(!is_null($oldPrice))
                                <div class="text-sm text-slate-600 dark:text-slate-200">
                                    <span class="font-semibold">{{ __('frontend.old_price') }}:</span>
                                    <span class="line-through">{{ number_format((float) $oldPrice, 2) }}</span>
                                </div>
                            @endif

                            @if(!is_null($discountPrice))
                                <div class="text-sm text-slate-600 dark:text-slate-200">
                                    <span class="font-semibold">{{ __('frontend.discount_price') }}:</span>
                                    <span class="font-semibold text-emerald-700 dark:text-emerald-200">{{ number_format((float) $discountPrice, 2) }}</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-950 dark:hover:bg-slate-100">
                    {{ __('frontend.contact') }}
                </a>
            </div>

            @php
                $thumbUrl = $course->thumbnail_url;
                $description = trim((string) $course->description);
            @endphp

            <div class="mt-8 overflow-hidden rounded-3xl bg-white ring-1 ring-slate-200/70 shadow-sm shadow-slate-200/60 dark:bg-white/5 dark:ring-white/10 dark:shadow-none">
                <div class="aspect-[16/9] bg-slate-100 dark:bg-slate-950/30">
                    @if($thumbUrl)
                        <img src="{{ $thumbUrl }}" alt="{{ $course->title }} thumbnail" class="h-full w-full object-cover" loading="lazy">
                    @else
                        <div class="flex h-full w-full items-center justify-center text-xs text-slate-500 dark:text-slate-300">
                            {{ __('frontend.no_image') }}
                        </div>
                    @endif
                </div>

                <div class="p-6 sm:p-8">
                    <div class="prose prose-slate max-w-none dark:prose-invert">
                        {!! nl2br(e($description)) !!}
                    </div>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <span class="inline-flex items-center rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-500/20 dark:text-emerald-200">
                            {{ __('frontend.enroll_now') }}
                        </span>

                        <div class="flex gap-3">
                            <a href="{{ route('courses') }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:border-white/10 dark:bg-white/5 dark:text-white/90 dark:hover:bg-white/[0.07]">
                                {{ __('frontend.courses') }}
                            </a>
                            <a href="{{ route('contact') }}" class="rounded-xl bg-sky-700 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-800">
                                {{ __('frontend.contact') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
