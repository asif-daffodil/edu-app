<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name', 'iTechBD Ltd'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    @stack('head')

    <style>
        :root {
            --bg1: 99 102 241;
            --bg2: 14 165 233;
            --bg3: 16 185 129;
        }

        @media (prefers-reduced-motion: reduce) {
            .animate-float,
            .animate-gradient,
            .reveal {
                animation: none !important;
                transition: none !important;
            }
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradientMove 14s ease infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .animate-float { animation: floatY 6s ease-in-out infinite; }
        .animate-float-slow { animation: floatY 9s ease-in-out infinite; }

        @keyframes floatY {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .reveal {
            opacity: 0;
            transform: translateY(14px);
            transition: opacity 700ms cubic-bezier(0.2, 0.8, 0.2, 1), transform 700ms cubic-bezier(0.2, 0.8, 0.2, 1);
        }
        .reveal.is-visible { opacity: 1; transform: translateY(0); }

        .mentor-carousel {
            scroll-snap-type: x mandatory;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .mentor-carousel::-webkit-scrollbar {
            display: none;
        }

        .mentor-card {
            scroll-snap-align: start;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    <!-- Background -->
    <div class="fixed inset-0 -z-10">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-950 to-slate-900"></div>
        <div class="absolute -top-40 -left-40 h-[28rem] w-[28rem] rounded-full blur-3xl opacity-35 animate-float"
             style="background: radial-gradient(circle at 30% 30%, rgba(var(--bg1), .55), rgba(var(--bg1), 0) 60%);"></div>
        <div class="absolute top-24 -right-44 h-[30rem] w-[30rem] rounded-full blur-3xl opacity-30 animate-float-slow"
             style="background: radial-gradient(circle at 30% 30%, rgba(var(--bg2), .50), rgba(var(--bg2), 0) 60%);"></div>
        <div class="absolute -bottom-48 left-1/4 h-[34rem] w-[34rem] rounded-full blur-3xl opacity-25 animate-float"
             style="background: radial-gradient(circle at 30% 30%, rgba(var(--bg3), .45), rgba(var(--bg3), 0) 60%);"></div>
        <div class="absolute inset-0 opacity-[0.08] [background-image:radial-gradient(#ffffff_1px,transparent_1px)] [background-size:18px_18px]"></div>
    </div>

    <!-- Top bar / Nav -->
    <header class="sticky top-0 z-50 border-b border-white/10 bg-slate-950/70 backdrop-blur">
        <div class="border-b border-white/10 bg-slate-950/40">
            <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-2 text-xs text-slate-300 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <div class="inline-flex items-center gap-2">
                    <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4 text-slate-300" aria-hidden="true">
                        <path d="M12 22s7-4.5 7-11a7 7 0 1 0-14 0c0 6.5 7 11 7 11Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round" />
                        <path d="M12 11.5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" stroke="currentColor" stroke-width="1.7" />
                    </svg>
                    <span>Dhaka, Bangladesh</span>
                </div>

                <div class="flex flex-wrap items-center gap-x-4 gap-y-1">
                    <a href="tel:+8801000000000" class="inline-flex items-center gap-2 hover:text-white">
                        <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4 text-slate-300" aria-hidden="true">
                            <path d="M7 3h2l2 5-2 1c1 3 3 5 6 6l1-2 5 2v2c0 1-1 2-2 2-9 0-16-7-16-16 0-1 1-2 2-2Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round" />
                        </svg>
                        <span>+880 10 0000 0000</span>
                    </a>
                    <a href="mailto:info@example.com" class="inline-flex items-center gap-2 hover:text-white">
                        <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4 text-slate-300" aria-hidden="true">
                            <path d="M4 6h16v12H4V6Z" stroke="currentColor" stroke-width="1.7" />
                            <path d="m4 7 8 6 8-6" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round" />
                        </svg>
                        <span>info@example.com</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="group inline-flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 ring-1 ring-white/10">
                    <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5 text-white" aria-hidden="true">
                        <path d="M4 19V6.5a2.5 2.5 0 0 1 2.5-2.5H20v15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                        <path d="M8 8h8M8 12h8M8 16h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                    </svg>
                </span>
                <span class="leading-tight">
                    <span class="block text-base font-semibold tracking-tight">{{ config('app.name', 'iTechBD Ltd') }}</span>
                    <span class="block text-xs text-slate-300/80">Training Institute • Career-focused</span>
                </span>
            </a>

            <nav class="hidden items-center gap-5 text-sm text-slate-200 md:flex">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <a href="{{ route('about') }}" class="hover:text-white">About</a>
                <a href="{{ route('courses') }}" class="hover:text-white">Courses</a>
                <a href="{{ route('mentors') }}" class="hover:text-white">Mentors</a>
                <a href="{{ route('reviews') }}" class="hover:text-white">Reviews</a>
                <a href="{{ route('news') }}" class="hover:text-white">News</a>
                <a href="{{ route('contact') }}" class="hover:text-white">Contact</a>
            </nav>

            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="inline-flex items-center rounded-xl bg-white/10 px-4 py-2 text-sm font-medium text-white ring-1 ring-white/10 transition hover:bg-white/15">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="hidden rounded-xl px-4 py-2 text-sm text-slate-200 ring-1 ring-white/10 transition hover:bg-white/10 sm:inline-flex">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-slate-100">
                                Enroll Now
                            </a>
                        @else
                            <a href="{{ route('contact') }}"
                               class="inline-flex items-center rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-slate-100">
                                Contact
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    @yield('content')

    <footer class="relative border-t border-white/10 bg-slate-950/50">
        <div class="absolute inset-x-0 -top-px h-px bg-gradient-to-r from-indigo-400/0 via-sky-300/70 to-emerald-300/0"></div>

        <div class="mx-auto max-w-7xl px-4 py-12 text-sm text-slate-300 sm:px-6 lg:px-8">
            <div class="mb-10 overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-500/15 via-sky-500/10 to-emerald-500/15 p-6 ring-1 ring-white/10 sm:p-8">
                <div class="relative">
                    <div class="pointer-events-none absolute -right-24 -top-24 h-56 w-56 rounded-full bg-sky-400/10 blur-3xl"></div>
                    <div class="pointer-events-none absolute -left-24 -bottom-24 h-56 w-56 rounded-full bg-indigo-400/10 blur-3xl"></div>

                    <div class="relative flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-white ring-1 ring-white/10">
                                <span class="inline-flex h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                Mentor-led • Career-focused
                            </div>
                            <div class="mt-4 text-lg font-semibold text-white">Ready to learn with mentors?</div>
                            <div class="mt-1 text-sm text-slate-200">Get schedule, fees, and course outline in one message.</div>

                            <div class="mt-5 flex flex-wrap gap-2 text-xs text-slate-200">
                                <span class="inline-flex items-center gap-2 rounded-full bg-slate-950/30 px-3 py-1 ring-1 ring-white/10">Weekly reviews</span>
                                <span class="inline-flex items-center gap-2 rounded-full bg-slate-950/30 px-3 py-1 ring-1 ring-white/10">Portfolio projects</span>
                                <span class="inline-flex items-center gap-2 rounded-full bg-slate-950/30 px-3 py-1 ring-1 ring-white/10">Career support</span>
                            </div>
                        </div>

                        <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row">
                            <a href="{{ route('courses') }}" class="inline-flex items-center justify-center rounded-2xl bg-white px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-slate-100">Explore Courses</a>
                            <a href="{{ route('contact') }}" class="inline-flex items-center justify-center rounded-2xl bg-white/10 px-6 py-3 text-sm font-semibold text-white ring-1 ring-white/10 transition hover:bg-white/15">Contact</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid items-stretch gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="h-full sm:col-span-2">
                    <div class="flex h-full flex-col rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                        <div class="inline-flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 ring-1 ring-white/10">
                            <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5 text-white" aria-hidden="true">
                                <path d="M4 19V6.5a2.5 2.5 0 0 1 2.5-2.5H20v15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                                <path d="M8 8h8M8 12h8M8 16h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                            </svg>
                        </span>
                        <div>
                            <div class="font-semibold text-white">{{ config('app.name', 'iTechBD Ltd') }}</div>
                            <div class="text-xs text-slate-300">Training Institute • Career-focused</div>
                        </div>
                    </div>
                    <p class="mt-4 max-w-md text-sm text-slate-200">Training institute for career-focused tech & creative skills. Learn with practical projects, reviews, and ongoing mentor support.</p>

                        <div class="mt-6 rounded-3xl bg-slate-950/30 p-5 ring-1 ring-white/10">
                            <div class="text-xs font-semibold uppercase tracking-wider text-slate-200">Get updates</div>
                            <div class="mt-2 text-sm text-slate-200">Drop your email to get batch updates and workshop news.</div>

                            <form class="mt-4" onsubmit="return false;">
                                <label class="sr-only" for="footerEmail">Email</label>
                                <div class="flex items-stretch overflow-hidden rounded-2xl bg-slate-950/40 ring-1 ring-white/10 transition focus-within:ring-2 focus-within:ring-sky-300/40">
                                    <div class="flex items-center pl-4 text-slate-400">
                                        <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" aria-hidden="true">
                                            <path d="M4 6h16v12H4V6Z" stroke="currentColor" stroke-width="1.7" opacity="0.9" />
                                            <path d="m4 7 8 6 8-6" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round" opacity="0.9" />
                                        </svg>
                                    </div>
                                    <input id="footerEmail" type="email" inputmode="email" autocomplete="email" placeholder="you@example.com"
                                           class="w-full flex-1 bg-transparent px-3 py-3 text-sm text-white placeholder:text-slate-400 outline-none" />
                                    <button type="button"
                                            class="inline-flex items-center gap-2 bg-gradient-to-r from-sky-300 to-emerald-300 px-5 text-sm font-semibold text-slate-950 transition hover:opacity-95">
                                        Notify
                                        <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4" aria-hidden="true">
                                            <path d="M7 17 17 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                            <path d="M10 7h7v7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="mt-2 text-xs text-slate-400">No spam. Only important updates.</div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="h-full">
                    <div class="flex h-full flex-col rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                        <div class="text-xs font-semibold uppercase tracking-wider text-slate-200">Quick Links</div>
                        <div class="mt-4 grid gap-2">
                            <a href="{{ route('home') }}" class="group inline-flex items-center justify-between rounded-xl px-2 py-1.5 transition hover:bg-white/5 hover:text-white"><span>Home</span><span class="opacity-0 transition group-hover:opacity-100">→</span></a>
                            <a href="{{ route('about') }}" class="group inline-flex items-center justify-between rounded-xl px-2 py-1.5 transition hover:bg-white/5 hover:text-white"><span>About</span><span class="opacity-0 transition group-hover:opacity-100">→</span></a>
                            <a href="{{ route('courses') }}" class="group inline-flex items-center justify-between rounded-xl px-2 py-1.5 transition hover:bg-white/5 hover:text-white"><span>Courses</span><span class="opacity-0 transition group-hover:opacity-100">→</span></a>
                            <a href="{{ route('mentors') }}" class="group inline-flex items-center justify-between rounded-xl px-2 py-1.5 transition hover:bg-white/5 hover:text-white"><span>Mentors</span><span class="opacity-0 transition group-hover:opacity-100">→</span></a>
                            <a href="{{ route('reviews') }}" class="group inline-flex items-center justify-between rounded-xl px-2 py-1.5 transition hover:bg-white/5 hover:text-white"><span>Reviews</span><span class="opacity-0 transition group-hover:opacity-100">→</span></a>
                            <a href="{{ route('news') }}" class="group inline-flex items-center justify-between rounded-xl px-2 py-1.5 transition hover:bg-white/5 hover:text-white"><span>News</span><span class="opacity-0 transition group-hover:opacity-100">→</span></a>
                            <a href="{{ route('contact') }}" class="group inline-flex items-center justify-between rounded-xl px-2 py-1.5 transition hover:bg-white/5 hover:text-white"><span>Contact</span><span class="opacity-0 transition group-hover:opacity-100">→</span></a>
                        </div>
                    </div>
                </div>

                <div class="h-full">
                    <div class="flex h-full flex-col rounded-3xl bg-white/5 p-6 ring-1 ring-white/10">
                        <div class="text-xs font-semibold uppercase tracking-wider text-slate-200">Social Media</div>
                        <div class="mt-4 grid grid-cols-3 gap-2">
                            <a href="#" class="group flex flex-col items-center justify-center gap-2 rounded-2xl bg-white/5 p-3 ring-1 ring-white/10 transition hover:bg-white/10 hover:text-white" aria-label="Facebook">
                                <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5 text-indigo-100" aria-hidden="true">
                                    <path d="M14 8.5h2V6h-2c-1.9 0-3.5 1.6-3.5 3.5V12H8v2.5h2.5V20H13v-5.5h2.5L16 12h-3V9.5c0-.6.4-1 1-1Z" fill="currentColor" opacity="0.95"/>
                                </svg>
                                <span class="text-xs text-slate-200 group-hover:text-white">Facebook</span>
                            </a>
                            <a href="#" class="group flex flex-col items-center justify-center gap-2 rounded-2xl bg-white/5 p-3 ring-1 ring-white/10 transition hover:bg-white/10 hover:text-white" aria-label="LinkedIn">
                                <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5 text-sky-100" aria-hidden="true">
                                    <path d="M6.5 7.5V17.8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                    <path d="M6.5 6.2a1.2 1.2 0 1 0 0-2.4 1.2 1.2 0 0 0 0 2.4Z" fill="currentColor"/>
                                    <path d="M10.2 10.2v7.6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                    <path d="M10.2 12.1c.7-1.3 1.8-2 3.2-2 2 0 3.6 1.6 3.6 3.6v4.1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                </svg>
                                <span class="text-xs text-slate-200 group-hover:text-white">LinkedIn</span>
                            </a>
                            <a href="#" class="group flex flex-col items-center justify-center gap-2 rounded-2xl bg-white/5 p-3 ring-1 ring-white/10 transition hover:bg-white/10 hover:text-white" aria-label="YouTube">
                                <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5 text-emerald-100" aria-hidden="true">
                                    <path d="M12 20.2c5.1 0 8.2-3.1 8.2-8.2S17.1 3.8 12 3.8 3.8 6.9 3.8 12 6.9 20.2 12 20.2Z" stroke="currentColor" stroke-width="1.3" opacity="0.85"/>
                                    <path d="M10.4 9.8v4.6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                    <path d="M9 8.6h0" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                                    <path d="M13.6 9.8c1.6 0 2.8 1.2 2.8 2.8v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                </svg>
                                <span class="text-xs text-slate-200 group-hover:text-white">YouTube</span>
                            </a>
                        </div>

                        <div class="mt-7 text-xs font-semibold uppercase tracking-wider text-slate-200">Contact Info</div>
                        <div class="mt-4 grid gap-2">
                        <a href="tel:+8801000000000" class="group inline-flex items-center gap-3 rounded-2xl bg-white/0 px-3 py-2 ring-1 ring-transparent transition hover:bg-white/5 hover:text-white hover:ring-white/10">
                            <span class="grid h-9 w-9 place-items-center rounded-xl bg-white/5 ring-1 ring-white/10">
                                <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4 text-slate-200" aria-hidden="true">
                                    <path d="M7 3h2l2 5-2 1c1 3 3 5 6 6l1-2 5 2v2c0 1-1 2-2 2-9 0-16-7-16-16 0-1 1-2 2-2Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span>
                                <span class="block text-xs text-slate-400">Phone</span>
                                <span class="block text-sm">+880 10 0000 0000</span>
                            </span>
                        </a>

                        <a href="mailto:info@example.com" class="group inline-flex items-center gap-3 rounded-2xl bg-white/0 px-3 py-2 ring-1 ring-transparent transition hover:bg-white/5 hover:text-white hover:ring-white/10">
                            <span class="grid h-9 w-9 place-items-center rounded-xl bg-white/5 ring-1 ring-white/10">
                                <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4 text-slate-200" aria-hidden="true">
                                    <path d="M4 6h16v12H4V6Z" stroke="currentColor" stroke-width="1.7" />
                                    <path d="m4 7 8 6 8-6" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span>
                                <span class="block text-xs text-slate-400">Email</span>
                                <span class="block text-sm">info@example.com</span>
                            </span>
                        </a>

                        <div class="inline-flex items-center gap-3 rounded-2xl bg-white/0 px-3 py-2 text-slate-200 ring-1 ring-transparent">
                            <span class="grid h-9 w-9 place-items-center rounded-xl bg-white/5 ring-1 ring-white/10">
                                <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4 text-slate-200" aria-hidden="true">
                                    <path d="M12 22s7-4.5 7-11a7 7 0 1 0-14 0c0 6.5 7 11 7 11Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round" />
                                    <path d="M12 11.5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" stroke="currentColor" stroke-width="1.7" />
                                </svg>
                            </span>
                            <span>
                                <span class="block text-xs text-slate-400">Location</span>
                                <span class="block text-sm">Dhaka, Bangladesh</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex flex-col gap-2 border-t border-white/10 pt-6 text-xs text-slate-400 sm:flex-row sm:items-center sm:justify-between">
                <div>© {{ date('Y') }} {{ config('app.name', 'iTechBD Ltd') }}. All rights reserved.</div>
                <div class="flex flex-wrap gap-x-4 gap-y-1">
                    <a href="{{ route('privacy') }}" class="hover:text-slate-200">Privacy</a>
                    <a href="{{ route('terms') }}" class="hover:text-slate-200">Terms</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
