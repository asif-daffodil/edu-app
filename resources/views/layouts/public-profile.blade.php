<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased text-slate-900">
        <div class="min-h-screen bg-gradient-to-b from-indigo-950 via-slate-950 to-slate-950">
            <div class="relative">
                <div class="pointer-events-none absolute inset-0 overflow-hidden">
                    <div class="absolute -top-24 -left-24 h-72 w-72 rounded-full bg-fuchsia-500/20 blur-3xl"></div>
                    <div class="absolute top-12 right-0 h-80 w-80 rounded-full bg-indigo-500/20 blur-3xl"></div>
                    <div class="absolute bottom-0 left-1/3 h-96 w-96 rounded-full bg-cyan-500/10 blur-3xl"></div>
                </div>

                <header class="sticky top-0 z-30 border-b border-white/10 bg-slate-950/70 backdrop-blur">
                    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-14 items-center justify-between">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-lg bg-gradient-to-br from-indigo-500 to-fuchsia-500 text-white grid place-items-center font-bold shadow-sm shadow-indigo-500/20">
                            {{ strtoupper(substr(config('app.name', 'A'), 0, 1)) }}
                        </div>
                        <div class="font-semibold text-white">
                            {{ config('app.name', 'Laravel') }}
                        </div>
                    </a>

                    <div class="flex items-center gap-2">
                        @auth
                            <a href="{{ route('dashboard') }}" class="rounded-md bg-white/10 px-3 py-2 text-sm font-medium text-white hover:bg-white/15 ring-1 ring-white/10">
                                {{ __('Dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-sm font-medium text-slate-200 hover:bg-white/10">
                                {{ __('Log in') }}
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-md bg-gradient-to-r from-indigo-500 to-fuchsia-500 px-3 py-2 text-sm font-medium text-white hover:from-indigo-600 hover:to-fuchsia-600 shadow-sm shadow-indigo-500/20">
                                    {{ __('Register') }}
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
                    </div>
                </header>

                <main class="relative">
                    @yield('content')
                </main>

                <footer class="border-t border-white/10 bg-slate-950/40">
                    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-8 text-sm text-slate-400">
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                            <div>© {{ now()->year }} {{ config('app.name', 'Laravel') }}</div>
                            <div>{{ __('Public CV / portfolio') }}</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
