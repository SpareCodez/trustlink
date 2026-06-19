<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TrustLink Admin{{ View::hasSection('title') ? ' | '.View::yieldContent('title') : '' }}</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        admin: {
                            bg: '#f4f6f5',
                            panel: '#ffffff',
                            border: '#d9dfdc',
                            text: '#18201c',
                            muted: '#59655f',
                            subtle: '#eef2f0',
                            sidebar: '#10291f',
                            sidebarHover: '#1b3b2f',
                            green: '#087a55',
                            greenDark: '#056342',
                            greenSoft: '#e2f3ec',
                            amber: '#9a5b00',
                            amberSoft: '#fff1d6',
                            red: '#b42318',
                            redSoft: '#fee4e2',
                            cyan: '#176b87',
                            cyanSoft: '#e3f3f8',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    fontSize: {
                        'admin-xs': ['11px', { lineHeight: '1.35', letterSpacing: '0' }],
                        'admin-sm': ['12px', { lineHeight: '1.4', letterSpacing: '0' }],
                        'admin-base': ['13px', { lineHeight: '1.45', letterSpacing: '0' }],
                        'admin-lg': ['14px', { lineHeight: '1.4', letterSpacing: '0' }],
                        'admin-title': ['17px', { lineHeight: '1.35', letterSpacing: '0' }],
                        'admin-metric': ['23px', { lineHeight: '1.2', letterSpacing: '0' }],
                    },
                    borderRadius: {
                        'admin': '6px',
                    },
                    boxShadow: {
                        'admin': '0 1px 2px rgba(16, 41, 31, 0.05)',
                    },
                },
            },
        };
    </script>
    <style>
        [data-cloak] { display: none !important; }
        .material-symbols-outlined {
            display: inline-block;
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 20;
            vertical-align: middle;
        }
        .filled-icon { font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 20; }
        .admin-scrollbar { scrollbar-width: thin; scrollbar-color: #738079 transparent; }
        .admin-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .admin-scrollbar::-webkit-scrollbar-thumb { background: #738079; border-radius: 5px; }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { scroll-behavior: auto !important; transition-duration: 0.01ms !important; }
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen overflow-x-hidden bg-admin-bg font-sans text-admin-base text-admin-text antialiased">
    <div id="admin-overlay" class="fixed inset-0 z-40 hidden bg-black/45 lg:hidden" aria-hidden="true"></div>

    <aside id="admin-sidebar"
           class="admin-scrollbar fixed inset-y-0 left-0 z-50 flex w-56 -translate-x-full flex-col overflow-y-auto border-r border-white/10 bg-admin-sidebar text-white transition-transform duration-200 lg:translate-x-0"
           aria-label="Admin navigation">
        <div class="flex h-14 shrink-0 items-center gap-3 border-b border-white/10 px-4">
            <div class="flex h-8 w-8 items-center justify-center rounded-admin bg-white text-admin-sidebar">
                <span class="material-symbols-outlined filled-icon text-[19px]">shield_with_heart</span>
            </div>
            <div class="min-w-0">
                <div class="truncate text-admin-lg font-bold text-white">TrustLink</div>
                <div class="truncate text-admin-xs font-medium text-white/70">Operations console</div>
            </div>
            <button id="close-admin-nav" type="button"
                    class="ml-auto flex h-8 w-8 items-center justify-center rounded-admin text-white hover:bg-white/10 lg:hidden"
                    aria-label="Close navigation" title="Close navigation">
                <span class="material-symbols-outlined text-[19px]">close</span>
            </button>
        </div>

        @php
            $navItems = [
                ['route' => 'admin.dashboard', 'icon' => 'dashboard', 'label' => 'Overview'],
                ['route' => 'admin.transactions', 'icon' => 'receipt_long', 'label' => 'Transactions'],
                ['route' => 'admin.merchants', 'icon' => 'storefront', 'label' => 'Merchants'],
                ['route' => 'admin.disputes', 'icon' => 'gavel', 'label' => 'Disputes', 'badge' => $disputeCount ?? 0],
                ['route' => 'admin.payouts', 'icon' => 'payments', 'label' => 'Payouts'],
                ['route' => 'admin.webhooks', 'icon' => 'webhook', 'label' => 'Webhooks'],
                ['route' => 'admin.settings', 'icon' => 'settings', 'label' => 'Settings'],
            ];
        @endphp

        <nav class="flex-1 px-3 py-4">
            <div class="mb-2 px-3 text-admin-xs font-semibold text-white/60">Workspace</div>
            <div class="space-y-1">
                @foreach($navItems as $item)
                    @php
                        $active = request()->routeIs($item['route'].'.*') || request()->routeIs($item['route']);
                        $available = Route::has($item['route']);
                    @endphp
                    @if($available)
                        <a href="{{ route($item['route']) }}"
                           @if($active) aria-current="page" @endif
                           class="flex min-h-10 items-center gap-3 rounded-admin px-3 py-2 text-admin-base font-medium text-white transition-colors {{ $active ? 'bg-white/15' : 'hover:bg-admin-sidebarHover' }}">
                            <span class="material-symbols-outlined text-[19px] {{ $active ? 'filled-icon' : '' }}">{{ $item['icon'] }}</span>
                            <span class="min-w-0 flex-1 truncate">{{ $item['label'] }}</span>
                            @if(!empty($item['badge']))
                                <span class="min-w-5 rounded-admin bg-white px-1.5 py-0.5 text-center text-admin-xs font-bold text-admin-sidebar">{{ $item['badge'] }}</span>
                            @endif
                        </a>
                    @else
                        <span class="flex min-h-10 cursor-not-allowed items-center gap-3 rounded-admin px-3 py-2 text-admin-base font-medium text-white" aria-disabled="true">
                            <span class="material-symbols-outlined text-[19px]">{{ $item['icon'] }}</span>
                            <span class="min-w-0 flex-1 truncate">{{ $item['label'] }}</span>
                            @if(!empty($item['badge']))
                                <span class="min-w-5 rounded-admin bg-white/15 px-1.5 py-0.5 text-center text-admin-xs font-bold text-white">{{ $item['badge'] }}</span>
                            @endif
                        </span>
                    @endif
                @endforeach
            </div>
        </nav>

        <div class="border-t border-white/10 p-3">
            @auth
                @php
                    $parts = explode(' ', trim(auth()->user()->name));
                    $initials = strtoupper(substr($parts[0], 0, 1));
                    if (count($parts) > 1) $initials .= strtoupper(substr(end($parts), 0, 1));
                @endphp
                <div class="mb-2 flex min-w-0 items-center gap-3 rounded-admin px-2 py-2">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-admin border border-white/25 bg-white/10 text-admin-sm font-bold text-white">{{ $initials }}</div>
                    <div class="min-w-0 flex-1">
                        <div class="truncate text-admin-sm font-semibold text-white">{{ auth()->user()->name }}</div>
                        <div class="truncate text-admin-xs text-white/70">Administrator</div>
                    </div>
                </div>
            @endauth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex min-h-9 w-full items-center gap-3 rounded-admin px-2 py-2 text-admin-sm font-medium text-white hover:bg-white/10">
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                    <span>Sign out</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="min-h-screen lg:pl-56">
        <header class="sticky top-0 z-30 flex h-14 items-center gap-3 border-b border-admin-border bg-white px-4 shadow-admin sm:px-5 lg:px-6">
            <button id="open-admin-nav" type="button"
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-admin text-admin-muted hover:bg-admin-subtle lg:hidden"
                    aria-label="Open navigation" aria-expanded="false" title="Open navigation">
                <span class="material-symbols-outlined text-[20px]">menu</span>
            </button>

            <div class="min-w-0">
                <div class="text-admin-xs font-medium text-admin-muted">Operations / @yield('page-section', 'Overview')</div>
                <h1 class="truncate text-admin-title font-semibold text-admin-text">@yield('page-title', 'Dashboard')</h1>
            </div>

            <div class="ml-auto flex min-w-0 items-center gap-2">
                <label class="relative hidden w-52 lg:block">
                    <span class="sr-only">Search admin records</span>
                    <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-[17px] text-admin-muted">search</span>
                    <input type="search" placeholder="Search records"
                           class="h-9 w-full rounded-admin border-admin-border bg-admin-subtle py-1.5 pl-8 pr-3 text-admin-sm text-admin-text placeholder:text-admin-muted focus:border-admin-green focus:ring-1 focus:ring-admin-green">
                </label>
                @yield('header-actions')
                <button type="button" class="flex h-9 w-9 items-center justify-center rounded-admin text-admin-muted hover:bg-admin-subtle hover:text-admin-text" aria-label="Notifications" title="Notifications">
                    <span class="material-symbols-outlined text-[19px]">notifications</span>
                </button>
                <button type="button" class="hidden h-9 w-9 items-center justify-center rounded-admin text-admin-muted hover:bg-admin-subtle hover:text-admin-text sm:flex" aria-label="Help" title="Help">
                    <span class="material-symbols-outlined text-[19px]">help</span>
                </button>
            </div>
        </header>

        <main class="mx-auto w-full max-w-[1600px] p-4 sm:p-5 lg:p-6">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
    <script>
        const adminSidebar = document.getElementById('admin-sidebar');
        const adminOverlay = document.getElementById('admin-overlay');
        const openAdminNav = document.getElementById('open-admin-nav');
        const closeAdminNav = document.getElementById('close-admin-nav');

        function setAdminNavigation(open) {
            adminSidebar.classList.toggle('-translate-x-full', !open);
            adminOverlay.classList.toggle('hidden', !open);
            openAdminNav.setAttribute('aria-expanded', open ? 'true' : 'false');
            document.body.classList.toggle('overflow-hidden', open);
        }

        openAdminNav.addEventListener('click', () => setAdminNavigation(true));
        closeAdminNav.addEventListener('click', () => setAdminNavigation(false));
        adminOverlay.addEventListener('click', () => setAdminNavigation(false));
        document.addEventListener('keydown', event => {
            if (event.key === 'Escape') setAdminNavigation(false);
        });
    </script>
</body>
</html>
