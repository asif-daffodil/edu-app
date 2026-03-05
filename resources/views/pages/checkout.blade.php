@extends('layouts.site')

@section('title', __('frontend.checkout') . ' • ' . config('app.name', 'iTechBD Ltd'))

@section('content')
<main>
    <section class="border-b border-slate-200/70 dark:border-white/10">
        <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
            <a href="/courses/{{ $course->getRouteKey() }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 dark:text-slate-200 dark:hover:text-white">← {{ __('frontend.view_details') }}</a>

            <div class="mt-4 grid grid-cols-1 gap-8 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <h1 class="text-3xl font-semibold text-slate-900 dark:text-white sm:text-4xl">{{ __('frontend.checkout') }}</h1>
                    <p class="mt-3 text-slate-600 dark:text-slate-200">{{ __('frontend.checkout_subtitle') }}</p>

                    <div class="mt-8 rounded-3xl bg-white p-6 ring-1 ring-slate-200/70 shadow-sm shadow-slate-200/60 dark:bg-white/5 dark:ring-white/10 dark:shadow-none sm:p-8">
                        <div class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-200">{{ __('frontend.selected_course') }}</div>
                        <div class="mt-2 text-xl font-semibold text-slate-900 dark:text-white">{{ $course->title }}</div>

                        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="rounded-2xl bg-slate-50 p-4 ring-1 ring-slate-200/70 dark:bg-white/5 dark:ring-white/10">
                                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-white/70">{{ __('frontend.course_fee') }}</div>
                                <div class="mt-1 text-2xl font-semibold text-slate-900 dark:text-white">{{ number_format((float) $amount, 2) }}</div>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4 ring-1 ring-slate-200/70 dark:bg-white/5 dark:ring-white/10">
                                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-white/70">{{ __('frontend.checkout_status') }}</div>
                                <div class="mt-1 text-sm font-semibold text-slate-900 dark:text-white">{{ __('frontend.checkout_pending') }}</div>
                                <div class="mt-1 text-sm text-slate-600 dark:text-slate-200">{{ __('frontend.checkout_pending_help') }}</div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('checkout.store', $course) }}" class="mt-8 space-y-4">
                            @csrf

                            @if($course->relationLoaded('batches') && $course->batches->count())
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200">Select batch</label>
                                    <select name="batch_id" class="mt-2 w-full rounded-2xl border-slate-300 bg-white text-slate-900 dark:border-white/10 dark:bg-slate-900 dark:text-slate-100 dark:[color-scheme:dark]">
                                        <option value="" class="text-slate-900 dark:text-slate-100">-- Select a batch --</option>
                                        @foreach($course->batches as $batch)
                                            @php($isJoined = isset($joinedBatchIds) && in_array((int) $batch->id, (array) $joinedBatchIds, true))
                                            <option value="{{ $batch->id }}"
                                                    class="text-slate-900 dark:text-slate-100"
                                                    @selected((string) old('batch_id') === (string) $batch->id)
                                                    @disabled($isJoined)>
                                                {{ $batch->name }} — starts {{ optional($batch->start_date)->format('d M, Y') }} ({{ ucfirst($batch->status) }})@if($isJoined) — Already joined @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('batch_id')
                                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif

                            <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800 dark:bg-white dark:text-slate-950 dark:hover:bg-slate-100">
                                {{ __('frontend.confirm_order') }}
                            </button>
                        </form>

                        <div class="mt-4 text-xs text-slate-500 dark:text-slate-300">
                            {{ __('frontend.checkout_note') }}
                        </div>
                    </div>
                </div>

                <aside class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">
                        <div class="rounded-3xl bg-white p-6 ring-1 ring-slate-200/70 shadow-sm shadow-slate-200/60 dark:bg-white/5 dark:ring-white/10 dark:shadow-none">
                            <div class="text-sm font-semibold text-slate-900 dark:text-white">{{ __('frontend.need_details') }}</div>
                            <div class="mt-1 text-sm text-slate-600 dark:text-slate-200">{{ __('frontend.course_details_help') }}</div>
                            <div class="mt-5">
                                <a href="/contact" class="inline-flex w-full items-center justify-center rounded-2xl bg-sky-700 px-6 py-3 text-sm font-semibold text-white hover:bg-sky-800">
                                    {{ __('frontend.contact') }}
                                </a>
                            </div>
                        </div>

                        <div class="rounded-3xl bg-white p-6 ring-1 ring-slate-200/70 shadow-sm shadow-slate-200/60 dark:bg-white/5 dark:ring-white/10 dark:shadow-none">
                            <div class="text-sm font-semibold text-slate-900 dark:text-white">{{ __('frontend.secure_checkout') }}</div>
                            <ul class="mt-3 space-y-2 text-sm text-slate-600 dark:text-slate-200">
                                <li>• {{ __('frontend.secure_checkout_item_1') }}</li>
                                <li>• {{ __('frontend.secure_checkout_item_2') }}</li>
                                <li>• {{ __('frontend.secure_checkout_item_3') }}</li>
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</main>
@endsection
