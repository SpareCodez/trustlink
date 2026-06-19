<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TrustLink{{ View::hasSection('title') ? ' – ' . View::yieldContent('title') : '' }}</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
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
            display: inline-block;
            vertical-align: middle;
        }
        .filled-icon { font-variation-settings: 'FILL' 1; }
        .hairline-border { border: 0.5px solid #bccac1; }
    </style>
    @stack('styles')
</head>
<body class="bg-surface font-body-md text-on-surface antialiased @yield('body-class', 'overflow-hidden')">
<main class="flex @yield('main-class', 'h-screen') w-full">

    {{-- Left Panel --}}
    <aside class="hidden md:flex w-[240px] bg-[#0B3D2E] flex-col justify-between py-stack-lg px-6 text-white shrink-0 @yield('aside-class')">
        <div class="space-y-12">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-primary-fixed rounded flex items-center justify-center">
                    <span class="material-symbols-outlined text-on-primary-fixed font-bold">link</span>
                </div>
                <span class="font-headline-sm text-headline-sm font-black tracking-tight">TrustLink</span>
            </div>
            <nav class="space-y-6">
                <div class="flex items-start gap-3">
                    <div class="mt-1 flex-shrink-0 w-5 h-5 rounded-full bg-secondary-fixed-dim/20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-secondary-fixed-dim text-[16px] filled-icon">check_circle</span>
                    </div>
                    <p class="font-body-sm text-body-sm leading-tight text-white/90">Funds held safely until delivery confirmed</p>
                </div>
                <div class="flex items-start gap-3">
                    <div class="mt-1 flex-shrink-0 w-5 h-5 rounded-full bg-secondary-fixed-dim/20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-secondary-fixed-dim text-[16px] filled-icon">check_circle</span>
                    </div>
                    <p class="font-body-sm text-body-sm leading-tight text-white/90">4-digit PIN protects every hand-off</p>
                </div>
                <div class="flex items-start gap-3">
                    <div class="mt-1 flex-shrink-0 w-5 h-5 rounded-full bg-secondary-fixed-dim/20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-secondary-fixed-dim text-[16px] filled-icon">check_circle</span>
                    </div>
                    <p class="font-body-sm text-body-sm leading-tight text-white/90">MoMo payout fires automatically on release</p>
                </div>
            </nav>
        </div>
        <div class="space-y-4 border-t border-white/10 pt-8">
            <div>
                <p class="font-label-muted text-label-muted text-white/50 uppercase tracking-widest mb-1">Active escrows</p>
                <p class="font-headline-sm text-headline-sm font-bold">GH¢ 48,320</p>
            </div>
            <div>
                <p class="font-label-muted text-label-muted text-white/50 uppercase tracking-widest mb-1">Completed today</p>
                <p class="font-headline-sm text-headline-sm font-bold">37 transactions</p>
            </div>
        </div>
    </aside>

    {{-- Right Panel --}}
    <section class="flex-1 bg-white flex flex-col items-center justify-center px-container-margin @yield('section-class', 'relative')">
        @yield('content')
        <div class="md:hidden mt-stack-lg text-center space-y-2 opacity-60">
            <p class="font-label-muted text-label-muted">TrustLink Global © 2024</p>
        </div>
    </section>

</main>
@stack('scripts')
</body>
</html>
