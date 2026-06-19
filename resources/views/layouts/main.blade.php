<!DOCTYPE html>
<html class="light overflow-x-hidden" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TrustLink{{ View::hasSection('title') ? ' | ' . View::yieldContent('title') : '' }}</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
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
                        "body-lg": ["16px", { lineHeight: "1.5", fontWeight: "400" }],
                        "body-md": ["14px", { lineHeight: "1.5", fontWeight: "400" }],
                        "label-caps": ["11px", { lineHeight: "1", letterSpacing: "0.05em", fontWeight: "600" }],
                        "headline-sm": ["18px", { lineHeight: "1.4", fontWeight: "500" }],
                        "headline-lg": ["32px", { lineHeight: "1.2", letterSpacing: "-0.02em", fontWeight: "500" }],
                        "headline-md": ["24px", { lineHeight: "1.3", fontWeight: "500" }],
                        "body-sm": ["13px", { lineHeight: "1.4", fontWeight: "400" }],
                        "label-muted": ["10px", { lineHeight: "1", fontWeight: "400" }],
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .filled-icon { font-variation-settings: 'FILL' 1; }
        .hairline-border { border: 0.5px solid #bccac1; }
        .border-hairline { border-width: 0.5px; }
        .border-t-hairline { border-top-width: 0.5px; }
        .border-b-hairline { border-bottom-width: 0.5px; }
    </style>
    @stack('styles')
</head>
<body class="bg-background text-on-background font-body-md min-h-screen pb-20 md:pb-0">

    {{-- Top App Bar --}}
    <header class="bg-surface flex justify-between items-center px-container-margin h-16 sticky top-0 z-40 border-b-hairline border-outline-variant">
        <div class="flex items-center gap-stack-md">
            <a href="{{ url('/home') }}" class="font-headline-sm text-headline-sm font-black text-on-surface">TrustLink</a>
        </div>
        <div class="flex items-center gap-stack-lg">
            <nav class="hidden md:flex gap-stack-lg">
                <a href="#" class="text-on-surface-variant hover:text-primary transition-colors font-body-md text-body-md">Analytics</a>
                <a href="#" class="text-on-surface-variant hover:text-primary transition-colors font-body-md text-body-md">Help Center</a>
            </nav>
            <div class="flex items-center gap-stack-sm">
                <button class="p-2 text-on-surface-variant hover:text-primary transition-transform active:scale-95">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                @auth
                <a href="{{ route('merchant.show', auth()->user()) }}" class="w-8 h-8 rounded-full bg-secondary-container border-hairline border-outline-variant flex items-center justify-center">
                    @php
                        $parts = explode(' ', trim(auth()->user()->name));
                        $av = strtoupper(substr($parts[0], 0, 1));
                        if (count($parts) > 1) $av .= strtoupper(substr(end($parts), 0, 1));
                    @endphp
                    <span class="font-label-caps text-label-caps text-on-secondary-container font-bold">{{ $av }}</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-9 h-9 flex items-center justify-center text-on-surface-variant hover:text-error hover:bg-error-container rounded-full transition-colors"
                            aria-label="Sign out" title="Sign out">
                        <span class="material-symbols-outlined">logout</span>
                    </button>
                </form>
                @endauth
            </div>
        </div>
    </header>

    {{-- Page Content --}}
    <main class="@yield('main-class', 'max-w-[600px] mx-auto py-stack-lg px-container-margin')">
        @yield('content')
    </main>

    {{-- Bottom Nav Bar (Mobile) --}}
    <nav class="md:hidden fixed bottom-0 w-full z-50 bg-surface-container-lowest border-t-hairline border-outline-variant flex justify-around items-center h-16 px-4">
        @php
            $navItems = [
                ['route' => 'home',            'icon' => 'home',     'label' => 'Home'],
                ['route' => 'payments.index',  'icon' => 'payments', 'label' => 'Payments'],
                ['route' => 'links.index',     'icon' => 'link',     'label' => 'Links'],
                ['route' => 'merchant.show',   'icon' => 'person',   'label' => 'Profile'],
            ];
        @endphp
        @foreach($navItems as $item)
            @php
                $isActive = request()->routeIs($item['route']) ||
                    ($item['route'] === 'merchant.show' && request()->routeIs('merchant.*'));
                $href = match($item['route']) {
                    'merchant.show' => auth()->check() ? route('merchant.show', auth()->user()) : route('login'),
                    default => Route::has($item['route']) ? route($item['route']) : '#',
                };
            @endphp
            <a href="{{ $href }}"
               class="flex flex-col items-center justify-center active:scale-90 duration-150 {{ $isActive ? 'bg-secondary-container text-on-secondary-container rounded-full px-4 py-1' : 'text-on-surface-variant' }}">
                <span class="material-symbols-outlined {{ $isActive ? 'filled-icon' : '' }}">{{ $item['icon'] }}</span>
                <span class="font-label-muted text-label-muted mt-1">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    @stack('scripts')
</body>
</html>
