<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-slate-100">
            <!-- Mobile sidebar -->
            <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-40 lg:hidden" aria-hidden="true">
                <div class="absolute inset-0 z-40 bg-slate-900/60" @click="sidebarOpen = false"></div>
                <div class="absolute inset-y-0 left-0 z-50 w-72 bg-slate-900 p-4 shadow-xl" @click.stop>
                    <div class="flex items-center justify-between">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                            <div class="h-9 w-9 rounded-lg bg-indigo-600/90 text-white grid place-items-center font-bold">{{ strtoupper(substr(config('app.name', 'A'), 0, 1)) }}</div>
                            <div class="text-white">
                                <div class="text-sm font-semibold leading-5">{{ config('app.name', 'Laravel') }}</div>
                                <div class="text-xs text-slate-300">Admin Panel</div>
                            </div>
                        </a>
                        <button type="button" class="rounded-md p-2 text-slate-200 hover:bg-slate-800" @click="sidebarOpen = false" aria-label="Close sidebar">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </button>
                    </div>

                    <div class="mt-6">
                        @include('layouts.sidebar')
                    </div>
                </div>
            </div>

            <div class="flex min-h-screen">
                <!-- Desktop sidebar -->
                <aside class="hidden lg:flex lg:w-72 lg:flex-col lg:bg-slate-900 lg:text-white lg:sticky lg:top-0 lg:h-screen lg:self-start">
                    <div class="flex h-16 items-center gap-3 px-4 border-b border-slate-800">
                        <div class="h-9 w-9 rounded-lg bg-indigo-600/90 text-white grid place-items-center font-bold">{{ strtoupper(substr(config('app.name', 'A'), 0, 1)) }}</div>
                        <div class="min-w-0">
                            <div class="text-sm font-semibold leading-5 truncate">{{ config('app.name', 'Laravel') }}</div>
                            <div class="text-xs text-slate-300">Admin Panel</div>
                        </div>
                    </div>
                    <div class="flex-1 overflow-y-auto p-4">
                        @include('layouts.sidebar')
                    </div>
                </aside>

                <!-- Main content -->
                <div class="flex min-w-0 flex-1 flex-col">
                    <header class="sticky top-0 z-30 bg-white/95 backdrop-blur border-b border-slate-200">
                        <div class="flex h-16 items-center justify-between px-4 lg:px-6">
                            <div class="flex items-center gap-3">
                                <button type="button" class="lg:hidden rounded-md p-2 text-slate-600 hover:bg-slate-100" @click="sidebarOpen = true" aria-label="Open sidebar">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </button>

                                <div class="hidden sm:block text-sm text-slate-500">
                                    {{ now()->format('l, d M Y') }}
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="inline-flex items-center gap-2 rounded-md border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50">
                                            <span class="hidden sm:block">{{ Auth::user()->name }}</span>
                                            <span class="grid h-8 w-8 place-items-center rounded-full bg-indigo-600 text-white text-xs font-semibold">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            </span>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('profile.edit')">
                                            {{ __('Profile') }}
                                        </x-dropdown-link>

                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>

                        @isset($header)
                            <div class="px-4 lg:px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <div class="min-w-0">
                                        {{ $header }}
                                    </div>
                                </div>
                            </div>
                        @endisset
                    </header>

                    <main class="flex-1 px-4 lg:px-6 py-6">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>
