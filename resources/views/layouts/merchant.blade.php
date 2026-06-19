<!DOCTYPE html>
<html class="light overflow-x-hidden" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TrustLink{{ View::hasSection('title') ? ' | ' . View::yieldContent('title') : '' }}</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "secondary-fixed-dim": "#a0d1bc", "outline": "#6d7a73",
                        "on-error-container": "#93000a", "on-secondary-fixed-variant": "#214f3f",
                        "on-tertiary": "#ffffff", "on-surface": "#191c1d",
                        "surface-bright": "#f8f9fa", "on-background": "#191c1d",
                        "tertiary": "#006857", "outline-variant": "#bccac1",
                        "on-surface-variant": "#3d4943", "background": "#f8f9fa",
                        "primary": "#00694c", "on-secondary": "#ffffff",
                        "tertiary-fixed-dim": "#55dcbd", "surface-container-lowest": "#ffffff",
                        "surface-container-high": "#e7e8e9", "primary-fixed-dim": "#68dbae",
                        "surface": "#f8f9fa", "surface-container-highest": "#e1e3e4",
                        "inverse-on-surface": "#f0f1f2", "surface-dim": "#d9dadb",
                        "on-error": "#ffffff", "primary-container": "#008560",
                        "secondary-container": "#b9ead4", "inverse-primary": "#68dbae",
                        "secondary-fixed": "#bcedd7", "on-tertiary-fixed-variant": "#005142",
                        "on-primary-container": "#f5fff7", "on-primary-fixed-variant": "#00513a",
                        "on-tertiary-container": "#f4fffa", "inverse-surface": "#2e3132",
                        "error": "#ba1a1a", "tertiary-fixed": "#75f9d9",
                        "secondary": "#396756", "tertiary-container": "#00846e",
                        "surface-container-low": "#f3f4f5", "on-primary": "#ffffff",
                        "on-primary-fixed": "#002115", "surface-tint": "#006c4e",
                        "error-container": "#ffdad6", "on-secondary-fixed": "#002116",
                        "surface-variant": "#e1e3e4", "on-tertiary-fixed": "#002019",
                        "surface-container": "#edeeef", "primary-fixed": "#86f8c9",
                        "on-secondary-container": "#3e6b5a",
                    },
                    borderRadius: { "DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem" },
                    spacing: {
                        "stack-xs": "0.25rem", "stack-md": "1rem", "stack-lg": "2rem",
                        "gutter": "1rem", "container-margin": "1.5rem", "stack-sm": "0.5rem",
                    },
                    fontFamily: {
                        "body-lg": ["Inter"], "body-md": ["Inter"], "label-caps": ["Inter"],
                        "headline-sm": ["Inter"], "headline-lg": ["Inter"], "headline-md": ["Inter"],
                        "body-sm": ["Inter"], "label-muted": ["Inter"],
                    },
                    fontSize: {
                        "body-lg": ["15px", { lineHeight: "1.5", fontWeight: "400" }],
                        "body-md": ["13px", { lineHeight: "1.45", fontWeight: "400" }],
                        "label-caps": ["10px", { lineHeight: "1", letterSpacing: "0.05em", fontWeight: "600" }],
                        "headline-sm": ["16px", { lineHeight: "1.35", fontWeight: "500" }],
                        "headline-lg": ["28px", { lineHeight: "1.15", letterSpacing: "0", fontWeight: "500" }],
                        "headline-md": ["22px", { lineHeight: "1.25", fontWeight: "500" }],
                        "body-sm": ["12px", { lineHeight: "1.35", fontWeight: "400" }],
                        "label-muted": ["9px", { lineHeight: "1", fontWeight: "400" }],
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .filled-icon { font-variation-settings: 'FILL' 1; }
        .hairline-border { border: 0.5px solid #bccac1; }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen bg-background text-on-background text-[14px]">

    {{-- Sidebar --}}
    <aside class="hidden md:flex flex-col fixed left-0 top-0 h-full p-stack-md w-64 bg-surface border-r-[0.5px] border-outline-variant z-50">
        <div class="mb-stack-lg flex items-center gap-3">
            <div class="w-10 h-10 bg-primary flex items-center justify-center rounded-lg">
                <span class="material-symbols-outlined text-white filled-icon">shield_with_heart</span>
            </div>
            <div>
                <h1 class="font-headline-sm text-headline-sm font-bold text-primary">TrustLink</h1>
                <p class="text-[9px] font-label-caps uppercase tracking-wider text-outline">Verified Merchant</p>
            </div>
        </div>

        @php
            $navItems = [
                ['route' => 'home',                'icon' => 'dashboard',    'label' => 'Dashboard'],
                ['route' => 'merchant.transactions','icon' => 'receipt_long', 'label' => 'Transactions'],
                ['route' => 'merchant.links',      'icon' => 'link',         'label' => 'Links'],
                ['route' => 'merchant.messages',   'icon' => 'forum',        'label' => 'Messages'],
                ['route' => 'merchant.settings',   'icon' => 'settings',     'label' => 'Settings'],
            ];
        @endphp

        <nav class="flex-1 space-y-1">
            @foreach($navItems as $item)
                @php
                    $active = request()->routeIs($item['route'] . '*');
                    $href   = Route::has($item['route']) ? route($item['route']) : '#';
                @endphp
                <a href="{{ $href }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all duration-200 font-body-md text-body-md
                          {{ $active
                              ? 'bg-secondary-container text-on-secondary-container font-medium'
                              : 'text-on-surface-variant hover:bg-surface-container' }}">
                    <span class="material-symbols-outlined {{ $active ? 'filled-icon' : '' }}">{{ $item['icon'] }}</span>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="mt-auto">
                <button class="w-full py-2.5 bg-primary text-white rounded-xl text-body-md font-medium flex items-center justify-center gap-2 hover:bg-primary-container transition-all active:scale-[0.98]">
                <span class="material-symbols-outlined text-sm">add</span>
                Generate Link
            </button>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="min-w-0 md:ml-64 min-h-screen flex flex-col">

        {{-- Top Bar --}}
        <header class="flex justify-between items-center gap-3 w-full px-4 sm:px-container-margin h-16 sticky top-0 z-40 bg-surface border-b-[0.5px] border-outline-variant overflow-hidden">
            <div class="flex items-center flex-1 min-w-0 max-w-xl">
                <div class="relative w-full">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                    <input id="top-search"
                           class="w-full bg-surface-container-low border-[0.5px] border-outline-variant rounded-xl pl-10 pr-4 py-2 text-body-md focus:ring-2 focus:ring-primary/10 focus:border-primary outline-none transition-all"
                           placeholder="Search transactions, links or customers…"
                           type="text"/>
                </div>
            </div>
            <div class="flex items-center gap-2 sm:gap-3 lg:gap-4 min-w-0 shrink-0">
                <button class="w-10 h-10 flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high rounded-full transition-colors">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <button class="w-10 h-10 flex items-center justify-center text-on-surface-variant hover:bg-surface-container-high rounded-full transition-colors">
                    <span class="material-symbols-outlined">help</span>
                </button>
                <div class="hidden lg:block h-8 w-[0.5px] bg-outline-variant mx-1 xl:mx-2"></div>
                @auth
                @php
                    $parts = explode(' ', trim(auth()->user()->name));
                    $av    = strtoupper(substr($parts[0], 0, 1));
                    if (count($parts) > 1) $av .= strtoupper(substr(end($parts), 0, 1));
                @endphp
                <a href="{{ route('merchant.show', auth()->user()) }}" class="flex items-center gap-2 sm:gap-3 min-w-0 cursor-pointer group">
                    <div class="hidden sm:block min-w-0 max-w-[160px] lg:max-w-[220px] text-right">
                        <p class="font-body-sm font-semibold leading-none truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[9px] text-outline font-label-caps mt-1 truncate">MERCHANT ID: {{ auth()->id() }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full border-[0.5px] border-outline-variant bg-secondary-container flex items-center justify-center shrink-0">
                        <span class="font-body-sm font-bold text-on-secondary-container">{{ $av }}</span>
                    </div>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-10 h-10 flex items-center justify-center text-on-surface-variant hover:text-error hover:bg-error-container rounded-full transition-colors"
                            aria-label="Sign out" title="Sign out">
                        <span class="material-symbols-outlined">logout</span>
                    </button>
                </form>
                @endauth
            </div>
        </header>

        {{-- Page Content --}}
        <div class="p-4 sm:p-6 lg:p-8 max-w-7xl w-full min-w-0 mx-auto space-y-6 lg:space-y-8">
            @yield('content')
        </div>

    </main>

    @stack('scripts')
    <script>
        document.querySelectorAll('button').forEach(btn => {
            btn.addEventListener('mousedown', () => btn.style.transform = 'scale(0.98)');
            btn.addEventListener('mouseup',   () => btn.style.transform = 'scale(1)');
            btn.addEventListener('mouseleave',() => btn.style.transform = 'scale(1)');
        });
        const search = document.getElementById('top-search');
        if (search) {
            search.addEventListener('focus', () => search.parentElement.classList.add('ring-2', 'ring-primary/20'));
            search.addEventListener('blur',  () => search.parentElement.classList.remove('ring-2', 'ring-primary/20'));
        }
    </script>
</body>
</html>
