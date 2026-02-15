@php
    $user = Auth::user();
    $isAdmin = $user && method_exists($user, 'hasRole') ? $user->hasRole('admin') : false;

    $linkBase = 'group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition';
    $active = 'bg-indigo-600 text-white shadow-sm';
    $inactive = 'text-slate-300 hover:bg-slate-800 hover:text-white';
@endphp

<nav class="space-y-1">
    <a href="{{ route('dashboard') }}"
        @click="sidebarOpen = false"
        class="{{ $linkBase }} {{ request()->routeIs('dashboard') ? $active : $inactive }}">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path d="M10.707 1.707a1 1 0 00-1.414 0l-7 7A1 1 0 003 10h1v7a1 1 0 001 1h4a1 1 0 001-1v-4h2v4a1 1 0 001 1h4a1 1 0 001-1v-7h1a1 1 0 00.707-1.707l-7-7z" />
        </svg>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('users.index') }}"
        @click="sidebarOpen = false"
        class="{{ $linkBase }} {{ request()->routeIs('users.*') ? $active : $inactive }}">
        <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path d="M10 2a4 4 0 100 8 4 4 0 000-8z" />
            <path fill-rule="evenodd" d="M.458 16.944A10 10 0 0110 12c3.59 0 6.73 1.89 8.542 4.944A1 1 0 0117.66 18H2.34a1 1 0 01-1.882-1.056z" clip-rule="evenodd" />
        </svg>
        <span>Users</span>
    </a>

    @if($isAdmin)
        <a href="{{ route('dashboard.mentors.index') }}"
            @click="sidebarOpen = false"
            class="{{ $linkBase }} {{ request()->routeIs('dashboard.mentors.*') ? $active : $inactive }}">
            <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M10 2 1.5 6 10 10l8.5-4L10 2Z" />
                <path d="M4 9.2V13c0 .6.4 1.2 1 1.5 1.4.8 3.2 1.5 5 1.5s3.6-.7 5-1.5c.6-.3 1-.9 1-1.5V9.2L10 12 4 9.2Z" />
                <path d="M18.5 6.5v6.5a1 1 0 0 1-2 0V7.4l2-.9Z" />
            </svg>
            <span>Mentors</span>
        </a>

        <a href="{{ route('roles.index') }}"
            @click="sidebarOpen = false"
            class="{{ $linkBase }} {{ request()->routeIs('roles.*') ? $active : $inactive }}">
            <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5 2a3 3 0 00-3 3v2a3 3 0 003 3h2a3 3 0 003-3V5a3 3 0 00-3-3H5zm0 10a3 3 0 00-3 3v1a2 2 0 002 2h3a3 3 0 003-3v-1a2 2 0 00-2-2H5zm8-10a2 2 0 00-2 2v3a3 3 0 003 3h1a2 2 0 002-2V5a3 3 0 00-3-3h-1zm1 10a3 3 0 00-3 3v1a2 2 0 002 2h1a3 3 0 003-3v-1a2 2 0 00-2-2h-1z" clip-rule="evenodd" />
            </svg>
            <span>Roles</span>
        </a>

        <a href="{{ route('permissions.index') }}"
            @click="sidebarOpen = false"
            class="{{ $linkBase }} {{ request()->routeIs('permissions.*') ? $active : $inactive }}">
            <svg class="h-5 w-5 shrink-0 opacity-90" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 1a1 1 0 01.894.553l1.5 3A1 1 0 0013.289 5h3.211a1 1 0 01.707 1.707l-2.5 2.5a1 1 0 00-.277.894l.75 3.75a1 1 0 01-1.451 1.07L10 13.347l-3.479 1.574a1 1 0 01-1.45-1.07l.75-3.75a1 1 0 00-.278-.894l-2.5-2.5A1 1 0 013.5 5h3.211a1 1 0 00.895-.447l1.5-3A1 1 0 0110 1z" clip-rule="evenodd" />
            </svg>
            <span>Permissions</span>
        </a>
    @endif
</nav>
