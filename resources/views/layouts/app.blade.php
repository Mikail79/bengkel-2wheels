<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '2WHEELS HOUSE - POS Terminal')</title>
    <meta name="description" content="@yield('meta_description', '2WHEELS HOUSE - Premium Motorcycle Workshop POS System')">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800;900&family=Inter:wght@400;500;600&family=Space+Mono&display=swap" rel="stylesheet"/>
    
    <!-- Fallback check for Anime.js -->
    <script>
        document.documentElement.classList.add('js-enabled');
        window.animeFallbackTimeout = setTimeout(function() {
            document.documentElement.classList.remove('js-enabled');
        }, 800);
    </script>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "tertiary-container": "#319db6",
                        "inverse-surface": "#fadcd8",
                        "text-primary": "#FFFFFF",
                        "outline": "#ab8985",
                        "on-secondary-fixed": "#1b1b1c",
                        "error": "#ffb4ab",
                        "surface-container-high": "#372624",
                        "tertiary-fixed-dim": "#72d4ef",
                        "surface-dim": "#1e0f0e",
                        "surface-container": "#2c1b1a",
                        "inverse-primary": "#bb171c",
                        "secondary-fixed": "#e5e2e1",
                        "on-secondary-container": "#b7b5b4",
                        "on-error": "#690005",
                        "primary": "#ffb4ac",
                        "error-container": "#93000a",
                        "secondary-fixed-dim": "#c8c6c5",
                        "surface-bright": "#483432",
                        "racing-red": "#E53935",
                        "tertiary": "#72d4ef",
                        "surface": "#1E1E1E",
                        "primary-fixed-dim": "#ffb4ac",
                        "on-tertiary": "#003641",
                        "on-background": "#fadcd8",
                        "tertiary-fixed": "#afecff",
                        "background": "#121212",
                        "surface-container-low": "#271716",
                        "primary-container": "#ff544c",
                        "on-surface-variant": "#e4beb9",
                        "on-secondary": "#303030",
                        "secondary": "#c8c6c5",
                        "on-primary-fixed-variant": "#93000d",
                        "outline-variant": "#5b403d",
                        "primary-fixed": "#ffdad6",
                        "on-primary": "#690006",
                        "text-secondary": "#A0A0A0",
                        "secondary-container": "#474746",
                        "on-tertiary-fixed-variant": "#004e5d",
                        "inverse-on-surface": "#3e2c2a",
                        "surface-variant": "#43302e",
                        "surface-container-highest": "#43302e",
                        "surface-tint": "#ffb4ac",
                        "on-tertiary-fixed": "#001f27",
                        "on-tertiary-container": "#002e39",
                        "surface-container-lowest": "#180a09",
                        "on-surface": "#fadcd8",
                        "on-primary-container": "#5c0005",
                        "on-secondary-fixed-variant": "#474746",
                        "emerald-success": "#2E7D32",
                        "on-primary-fixed": "#410002",
                        "on-error-container": "#ffdad6"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "input-height": "48px",
                        "gutter": "16px",
                        "base": "8px",
                        "container-padding": "24px"
                    },
                    "fontFamily": {
                        "label-sm": ["Inter"],
                        "receipt-mono": ["Space Mono"],
                        "headline-lg": ["Montserrat"],
                        "headline-md": ["Montserrat"],
                        "display-lg": ["Montserrat"],
                        "body-md": ["Inter"],
                        "body-lg": ["Inter"]
                    },
                    "fontSize": {
                        "label-sm": ["12px", {"lineHeight": "1", "letterSpacing": "0.05em", "fontWeight": "600"}],
                        "receipt-mono": ["14px", {"lineHeight": "1.4", "fontWeight": "400"}],
                        "headline-lg": ["32px", {"lineHeight": "1.2", "letterSpacing": "-0.02em", "fontWeight": "800"}],
                        "headline-md": ["24px", {"lineHeight": "1.2", "fontWeight": "800"}],
                        "display-lg": ["48px", {"lineHeight": "1.1", "letterSpacing": "-0.05em", "fontWeight": "900"}],
                        "body-md": ["16px", {"lineHeight": "1.5", "fontWeight": "400"}],
                        "body-lg": ["18px", {"lineHeight": "1.5", "fontWeight": "500"}]
                    }
                }
            }
        }
    </script>
    <style>
        /* === GLASS PANEL === */
        .glass-panel {
            background-color: rgba(30, 30, 30, 0.65);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(160, 160, 160, 0.1);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), border-color 0.3s ease;
        }

        /* === MESH BACKGROUND === */
        .mesh-bg {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            z-index: -1;
            background: #121212;
            overflow: hidden;
        }
        .mesh-blob-1 {
            position: absolute;
            top: -10%; left: -5%;
            width: 50vw; height: 50vw;
            background: radial-gradient(circle, rgba(229,57,53,0.08) 0%, rgba(18,18,18,0) 70%);
            border-radius: 50%;
        }
        .mesh-blob-2 {
            position: absolute;
            bottom: -20%; right: -10%;
            width: 60vw; height: 60vw;
            background: radial-gradient(circle, rgba(49,157,182,0.05) 0%, rgba(18,18,18,0) 70%);
            border-radius: 50%;
        }

        /* === ANIMATIONS & MICRO-INTERACTIONS === */
        @keyframes slideUpFade {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulseGlow {
            0% { box-shadow: 0 0 15px rgba(229,57,53,0.3); transform: scale(1); }
            50% { box-shadow: 0 0 25px rgba(229,57,53,0.6); transform: scale(1.02); }
            100% { box-shadow: 0 0 15px rgba(229,57,53,0.3); transform: scale(1); }
        }
        @keyframes floatAnim {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
            100% { transform: translateY(0px); }
        }
        @keyframes digitRoll {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .animate-entrance {
            animation: slideUpFade 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
        .delay-5 { animation-delay: 0.5s; }

        .btn-pulse:hover {
            animation: pulseGlow 2s infinite ease-in-out;
        }
        .animate-float {
            animation: floatAnim 4s ease-in-out infinite;
        }
        .animate-digit-roll {
            animation: digitRoll 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* === GLOW CARD (Mouse-tracking glassmorphic hover) === */
        .glow-card {
            position: relative;
            overflow: hidden;
        }
        .glow-card::before {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: radial-gradient(800px circle at var(--mouse-x) var(--mouse-y), rgba(255,255,255,0.06), transparent 40%);
            opacity: 0;
            transition: opacity 0.5s;
            pointer-events: none;
            z-index: 1;
        }
        .glow-card:hover {
            transform: translateY(-2px);
            border-color: rgba(255, 255, 255, 0.2);
        }
        .glow-card:hover::before {
            opacity: 1;
        }
        .glow-card > * {
            position: relative;
            z-index: 2;
        }

        /* === NAV ITEM === */
        .nav-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .nav-item::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 0%; height: 2px;
            background-color: rgba(255, 255, 255, 0.3);
            transition: width 0.3s ease;
        }
        .nav-item:hover::after {
            width: 100%;
        }

        /* === SIDEBAR SECTION DIVIDER === */
        .nav-section-label {
            font-size: 10px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #A0A0A0;
            padding: 16px 12px 6px 12px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
        }

        /* === CUSTOM SCROLLBAR === */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgba(91, 64, 61, 0.5);
            border-radius: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: rgba(91, 64, 61, 0.8);
        }

        /* === TABLE ROW HOVER GLOW === */
        .table-row-glow {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .table-row-glow:hover {
            background-color: rgba(55, 38, 36, 0.6);
            box-shadow: inset 0 0 0 1px rgba(91, 64, 61, 0.8);
        }

        /* === STATUS BADGE PULSE === */
        .badge-pulse {
            position: relative;
        }
        .badge-pulse::after {
            content: '';
            position: absolute;
            top: -2px; right: -2px;
            width: 8px; height: 8px;
            border-radius: 50%;
            background: #E53935;
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* === REDUCED MOTION === */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        }

        /* === REMOVE DEFAULT SELECT ARROW (TAILWIND FORMS PRESET) === */
        select {
            background-image: none !important;
            padding-right: 1.5rem !important;
        }

        /* === ANIME.JS INITIAL STATES (PREVENT FLASH OF UNANIMATED CONTENT) === */
        .js-enabled .animate-entrance {
            animation: none !important;
            opacity: 0;
        }
        .js-enabled aside {
            opacity: 0;
            transform: translateX(-260px);
        }
        .js-enabled header {
            opacity: 0;
            transform: translateY(-50px);
        }
        .js-enabled aside nav .nav-item, .js-enabled aside .mt-auto .nav-item {
            opacity: 0;
            transform: translateX(-20px);
        }

        /* === CLICK INTERACTIVE RIPPLES & PARTICLES === */
        .click-ripple {
            transition: none !important;
            will-change: width, height, opacity;
        }
        .click-particle {
            transition: none !important;
            will-change: left, top, scale, opacity;
        }
    </style>
</head>
<body class="bg-background text-text-primary font-body-md antialiased overflow-hidden selection:bg-racing-red selection:text-text-primary">
    <!-- Interactive Custom Cursor follower -->
    <div id="custom-cursor" class="fixed pointer-events-none z-[9999] w-4 h-4 rounded-full border-2 border-racing-red bg-racing-red/10 -translate-x-1/2 -translate-y-1/2 opacity-0 hidden md:block select-none shadow-[0_0_8px_rgba(229,57,53,0.6)]"></div>
    
    <!-- Industrial Mesh Gradient Background -->
    <div class="mesh-bg">
        <div class="mesh-blob-1"></div>
        <div class="mesh-blob-2"></div>
    </div>

    <div class="flex h-screen w-full relative z-0">

        {{-- ============================================================ --}}
        {{-- SIDENAV BAR --}}
        {{-- ============================================================ --}}
        <aside class="bg-surface-dim/90 backdrop-blur-xl fixed left-0 h-screen w-64 border-r border-outline-variant flex flex-col py-container-padding gap-base z-20 shrink-0 hidden md:flex animate-entrance">
            
            <!-- Header/Brand Area -->
            <div class="px-gutter mb-4 flex flex-col items-center gap-1">
                <div class="w-full flex justify-center py-2 overflow-hidden">
                    <img alt="2WHEELS HOUSE Logo" class="h-12 object-contain" src="{{ asset('images/logo.png') }}?v=1"/>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 flex flex-col gap-0.5 px-3 overflow-y-auto custom-scrollbar">

                {{-- SECTION: Transactions --}}
                <div class="nav-section-label">Transactions</div>

                <a id="nav-service-desk" class="nav-item flex items-center gap-3 px-3 h-input-height rounded {{ request()->routeIs('service-desk*') ? 'bg-racing-red text-text-primary font-bold shadow-[0_0_15px_rgba(229,57,53,0.3)] btn-pulse' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high' }} active:translate-x-1 transition-transform" href="{{ route('service-desk') }}">
                    <span class="material-symbols-outlined" style='font-variation-settings: "FILL" {{ request()->routeIs('service-desk*') ? "1" : "0" }};'>add_circle</span>
                    <span class="font-label-sm text-label-sm uppercase tracking-wider">Service Desk</span>
                </a>

                <a id="nav-inbound-po" class="nav-item flex items-center gap-3 px-3 h-input-height rounded {{ request()->routeIs('inbound-po*') ? 'bg-racing-red text-text-primary font-bold shadow-[0_0_15px_rgba(229,57,53,0.3)] btn-pulse' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high' }} active:translate-x-1 transition-transform" href="{{ route('inbound-po') }}">
                    <span class="material-symbols-outlined" style='font-variation-settings: "FILL" {{ request()->routeIs('inbound-po*') ? "1" : "0" }};'>local_shipping</span>
                    <span class="font-label-sm text-label-sm uppercase tracking-wider">Inbound PO</span>
                </a>

                {{-- SECTION: Master Data --}}
                <div class="nav-section-label mt-2">Master Data</div>

                <a id="nav-inventory" class="nav-item flex items-center gap-3 px-3 h-input-height rounded {{ request()->routeIs('inventory*') ? 'bg-racing-red text-text-primary font-bold shadow-[0_0_15px_rgba(229,57,53,0.3)] btn-pulse' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high' }} active:translate-x-1 transition-transform" href="{{ route('inventory') }}">
                    <span class="material-symbols-outlined" style='font-variation-settings: "FILL" {{ request()->routeIs('inventory*') ? "1" : "0" }};'>inventory_2</span>
                    <span class="font-label-sm text-label-sm uppercase tracking-wider">Inventory</span>
                </a>

                <a id="nav-customers" class="nav-item flex items-center gap-3 px-3 h-input-height rounded {{ request()->routeIs('customers*') ? 'bg-racing-red text-text-primary font-bold shadow-[0_0_15px_rgba(229,57,53,0.3)] btn-pulse' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high' }} active:translate-x-1 transition-transform" href="{{ route('customers') }}">
                    <span class="material-symbols-outlined" style='font-variation-settings: "FILL" {{ request()->routeIs('customers*') ? "1" : "0" }};'>group</span>
                    <span class="font-label-sm text-label-sm uppercase tracking-wider">Customers</span>
                </a>

                <a id="nav-staff" class="nav-item flex items-center gap-3 px-3 h-input-height rounded {{ request()->routeIs('staff*') ? 'bg-racing-red text-text-primary font-bold shadow-[0_0_15px_rgba(229,57,53,0.3)] btn-pulse' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high' }} active:translate-x-1 transition-transform" href="{{ route('staff') }}">
                    <span class="material-symbols-outlined" style='font-variation-settings: "FILL" {{ request()->routeIs('staff*') ? "1" : "0" }};'>badge</span>
                    <span class="font-label-sm text-label-sm uppercase tracking-wider">Staff</span>
                </a>

                <a id="nav-suppliers" class="nav-item flex items-center gap-3 px-3 h-input-height rounded {{ request()->routeIs('suppliers*') ? 'bg-racing-red text-text-primary font-bold shadow-[0_0_15px_rgba(229,57,53,0.3)] btn-pulse' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high' }} active:translate-x-1 transition-transform" href="{{ route('suppliers') }}">
                    <span class="material-symbols-outlined" style='font-variation-settings: "FILL" {{ request()->routeIs('suppliers*') ? "1" : "0" }};'>factory</span>
                    <span class="font-label-sm text-label-sm uppercase tracking-wider">Suppliers</span>
                </a>

                {{-- SECTION: System --}}
                <div class="nav-section-label mt-2">System</div>

                <a id="nav-history" class="nav-item flex items-center gap-3 px-3 h-input-height rounded {{ request()->routeIs('history*') ? 'bg-racing-red text-text-primary font-bold shadow-[0_0_15px_rgba(229,57,53,0.3)] btn-pulse' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high' }} active:translate-x-1 transition-transform" href="#">
                    <span class="material-symbols-outlined">history</span>
                    <span class="font-label-sm text-label-sm uppercase tracking-wider">History</span>
                </a>

                <a id="nav-settings" class="nav-item flex items-center gap-3 px-3 h-input-height rounded {{ request()->routeIs('settings*') ? 'bg-racing-red text-text-primary font-bold shadow-[0_0_15px_rgba(229,57,53,0.3)] btn-pulse' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high' }} active:translate-x-1 transition-transform" href="#">
                    <span class="material-symbols-outlined">manage_accounts</span>
                    <span class="font-label-sm text-label-sm uppercase tracking-wider">Settings</span>
                </a>

            </nav>

            <!-- Footer Area -->
            <div class="mt-auto px-3 pt-4 border-t border-outline-variant/30">
                <a id="nav-logout" class="nav-item flex items-center gap-3 px-3 h-input-height rounded text-on-surface-variant hover:text-racing-red hover:bg-surface-container-high group active:translate-x-1 transition-transform" href="#">
                    <span class="material-symbols-outlined group-hover:text-racing-red transition-colors">logout</span>
                    <span class="font-label-sm text-label-sm uppercase tracking-wider">Logout</span>
                </a>
            </div>
        </aside>

        {{-- ============================================================ --}}
        {{-- MAIN CONTENT CANVAS --}}
        {{-- ============================================================ --}}
        <main class="flex-1 flex flex-col h-screen overflow-hidden relative md:ml-64">

            <!-- TOP APP BAR -->
            <header class="bg-background/80 backdrop-blur-md fixed top-0 right-0 left-0 md:left-64 border-b border-outline-variant flex justify-between items-center px-gutter h-input-height z-10 shrink-0 animate-entrance delay-1">
                <!-- Brand Title -->
                <div class="flex items-center gap-4">
                    <h1 id="brand-title" class="font-headline-lg text-headline-lg font-black text-racing-red tracking-tighter">2WHEELS HOUSE</h1>
                </div>
                <!-- Trailing Actions & Search -->
                <div class="flex items-center gap-4">
                    <div class="relative hidden sm:block">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-sm">search</span>
                        <input id="global-search" class="bg-surface-container border border-outline-variant rounded-full pl-9 pr-4 py-1.5 text-sm text-text-primary focus:border-racing-red focus:ring-1 focus:ring-racing-red outline-none w-64 transition-all placeholder:text-text-secondary" placeholder="Search parts, customers..." type="text"/>
                    </div>
                    <div class="flex items-center gap-2 text-on-surface-variant">
                        <button id="btn-notifications" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-surface-variant/50 transition-colors opacity-80 hover:opacity-100 active:scale-95 relative">
                            <span class="material-symbols-outlined">notifications</span>
                        </button>
                        <button id="btn-settings-top" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-surface-variant/50 transition-colors opacity-80 hover:opacity-100 active:scale-95">
                            <span class="material-symbols-outlined">settings</span>
                        </button>
                        <button id="btn-profile" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-surface-variant/50 transition-colors opacity-80 hover:opacity-100 active:scale-95">
                            <span class="material-symbols-outlined text-2xl" style='font-variation-settings: "FILL" 1;'>account_circle</span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- INTERACTIVE CANVAS WORKSPACE -->
            <div class="flex-1 overflow-y-auto custom-scrollbar pt-input-height">
                <div class="p-container-padding pb-32">
                    @yield('content')
                </div>
            </div>

        </main>
    </div>

    <!-- Fullscreen Logout Transition Overlay -->
    <div id="logout-overlay" class="fixed inset-0 z-50 bg-[#121212] hidden items-center justify-center" style="opacity: 0;">
        <!-- Mesh Background inside overlay -->
        <div class="mesh-bg">
            <div class="mesh-blob-1 opacity-40"></div>
            <div class="mesh-blob-2 opacity-30"></div>
        </div>
        <div class="flex flex-col items-center gap-4 text-center z-10 px-6">
            <div class="logout-logo w-24 h-24 mb-2 opacity-0">
                <img alt="Logo" class="w-full h-full object-contain" src="{{ asset('images/logo.png') }}?v=1"/>
            </div>
            <h2 id="logout-title" class="font-headline-lg text-headline-lg text-text-primary uppercase tracking-wider opacity-0">2WHEELS HOUSE</h2>
            <div id="logout-subtitle" class="font-label-sm text-label-sm text-text-secondary uppercase tracking-widest opacity-0">Logging out of system...</div>
            <div class="w-48 h-1 bg-surface-container-highest rounded overflow-hidden mt-2 opacity-0 logout-bar-container">
                <div id="logout-progress" class="h-full bg-racing-red w-0"></div>
            </div>
        </div>
    </div>

    <!-- Glow Card Mouse Tracking Script -->
    <script>
        document.querySelectorAll('.glow-card').forEach(card => {
            card.addEventListener('mousemove', e => {
                const rect = card.getBoundingClientRect(),
                      x = e.clientX - rect.left,
                      y = e.clientY - rect.top;
                card.style.setProperty('--mouse-x', `${x}px`);
                card.style.setProperty('--mouse-y', `${y}px`);
            });
        });
    </script>

    <!-- Anime.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.2/anime.min.js"></script>

    <!-- App Entrance & Exit Animations -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Clear fallback timeout since JS loaded successfully
            if (window.animeFallbackTimeout) {
                clearTimeout(window.animeFallbackTimeout);
            }

            // Prepare typography splitting for brand title (keeping words intact for layout stability)
            const brandTitle = document.querySelector('#brand-title');
            if (brandTitle) {
                const words = brandTitle.textContent.trim().split(' ');
                brandTitle.innerHTML = words.map(word => {
                    const letters = word.split('').map(char => `<span class="letter inline-block origin-center">${char}</span>`).join('');
                    return `<span class="inline-block whitespace-nowrap">${letters}</span>`;
                }).join('&nbsp;');
            }

            // Set up entrance timeline
            const tl = anime.timeline({
                easing: 'easeOutExpo',
                duration: 1000
            });

            tl.add({
                targets: 'aside',
                translateX: [-260, 0],
                opacity: [0, 1],
                duration: 1100,
                easing: 'easeOutQuint'
            })
            .add({
                targets: 'aside nav .nav-item, aside .mt-auto .nav-item',
                translateX: [-20, 0],
                opacity: [0, 1],
                delay: anime.stagger(40),
                duration: 800,
                easing: 'easeOutQuad'
            }, '-=850')
            .add({
                targets: 'header',
                translateY: [-50, 0],
                opacity: [0, 1],
                duration: 900,
                easing: 'easeOutExpo'
            }, '-=850')
            .add({
                targets: '#brand-title .letter',
                scale: [0.5, 1],
                opacity: [0, 1],
                translateY: [15, 0],
                easing: "easeOutExpo",
                duration: 800,
                delay: anime.stagger(25)
            }, '-=750')
            .add({
                targets: 'main .animate-entrance',
                translateY: [25, 0],
                opacity: [0, 1],
                delay: anime.stagger(60),
                duration: 900,
                easing: 'easeOutExpo'
            }, '-=750');

            // Set up exit/logout animation
            const logoutBtn = document.getElementById('nav-logout');
            const logoutOverlay = document.getElementById('logout-overlay');

            if (logoutBtn && logoutOverlay) {
                logoutBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    
                    // Prepare logout title typography splitting
                    const logoutTitle = document.querySelector('#logout-title');
                    if (logoutTitle && !logoutTitle.querySelector('.letter')) {
                        const words = logoutTitle.textContent.trim().split(' ');
                        logoutTitle.innerHTML = words.map(word => {
                            const letters = word.split('').map(char => `<span class="letter inline-block origin-center">${char}</span>`).join('');
                            return `<span class="inline-block whitespace-nowrap">${letters}</span>`;
                        }).join('&nbsp;');
                    }

                    // Show overlay
                    logoutOverlay.classList.remove('hidden');
                    logoutOverlay.classList.add('flex');

                    // Exit Timeline
                    const exitTl = anime.timeline({
                        easing: 'easeOutExpo'
                    });

                    exitTl.add({
                        targets: logoutOverlay,
                        opacity: [0, 1],
                        duration: 500,
                        easing: 'linear'
                    })
                    .add({
                        targets: '#logout-overlay .logout-logo',
                        scale: [0.5, 1],
                        opacity: [0, 1],
                        duration: 800,
                        easing: 'easeOutElastic(1, 0.6)'
                    }, '-=200')
                    .add({
                        targets: '#logout-title .letter',
                        scale: [0.5, 1],
                        opacity: [0, 1],
                        translateY: [15, 0],
                        duration: 600,
                        delay: anime.stagger(25)
                    }, '-=500')
                    .add({
                        targets: '#logout-subtitle',
                        opacity: [0, 1],
                        translateY: [10, 0],
                        duration: 400
                    }, '-=300')
                    .add({
                        targets: '#logout-overlay .logout-bar-container',
                        opacity: [0, 1],
                        duration: 300
                    }, '-=200')
                    .add({
                        targets: '#logout-progress',
                        width: '100%',
                        duration: 1500,
                        easing: 'easeInOutQuad',
                        complete: () => {
                            const subtitle = document.getElementById('logout-subtitle');
                            if (subtitle) {
                                subtitle.innerHTML = 'Session Closed. <button onclick="location.reload()" class="mt-4 px-6 py-2.5 bg-racing-red text-text-primary rounded font-label-sm text-label-sm uppercase tracking-wider hover:bg-primary-container transition-colors shadow-[0_0_15px_rgba(229,57,53,0.4)] active:scale-95">Sign In Again</button>';
                                anime({
                                    targets: subtitle,
                                    opacity: [0, 1],
                                    translateY: [10, 0],
                                    duration: 500
                                });
                            }
                            
                            anime({
                                targets: '#logout-overlay .logout-bar-container',
                                opacity: 0,
                                duration: 300
                            });
                        }
                    }, '-=100');
                });
            }

            // === INTERACTIVE CUSTOM CURSOR & CLICK RIPPLES ===
            const cursor = document.getElementById('custom-cursor');
            const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;

            if (isTouchDevice && cursor) {
                cursor.remove();
            } else if (cursor) {
                let mouseX = 0, mouseY = 0;
                let cursorX = 0, cursorY = 0;

                // Mouse movement tracking
                document.addEventListener('mousemove', (e) => {
                    mouseX = e.clientX;
                    mouseY = e.clientY;
                    if (cursor.style.opacity === '0' || cursor.style.opacity === '') {
                        cursor.style.opacity = '1';
                    }
                });

                // Smooth coordinates interpolation (lerp)
                function updateCursor() {
                    cursorX += (mouseX - cursorX) * 0.18;
                    cursorY += (mouseY - cursorY) * 0.18;
                    cursor.style.left = `${cursorX}px`;
                    cursor.style.top = `${cursorY}px`;
                    requestAnimationFrame(updateCursor);
                }
                requestAnimationFrame(updateCursor);

                // Show/hide when leaving viewport
                document.addEventListener('mouseleave', () => cursor.style.opacity = '0');
                document.addEventListener('mouseenter', () => cursor.style.opacity = '1');

                // Hover states for interactive elements
                const addHoverEffects = () => {
                    document.querySelectorAll('a, button, input, select, textarea, [onclick], .table-row-glow').forEach(el => {
                        if (el.dataset.hasCursorHover) return;
                        el.dataset.hasCursorHover = 'true';

                        el.addEventListener('mouseenter', () => {
                            anime({
                                targets: cursor,
                                scale: 1.8,
                                borderColor: '#72d4ef',
                                backgroundColor: 'rgba(114, 212, 239, 0.05)',
                                duration: 250,
                                easing: 'easeOutQuad'
                            });
                        });
                        el.addEventListener('mouseleave', () => {
                            anime({
                                targets: cursor,
                                scale: 1.0,
                                borderColor: '#E53935',
                                backgroundColor: 'rgba(229, 57, 53, 0.1)',
                                duration: 250,
                                easing: 'easeOutQuad'
                            });
                        });
                    });
                };
                
                addHoverEffects();
                
                // Keep observing DOM changes to attach hover effect to new dynamic items
                const observer = new MutationObserver(() => addHoverEffects());
                observer.observe(document.body, { childList: true, subtree: true });

                // Click scaling effect
                document.addEventListener('mousedown', () => {
                    anime({
                        targets: cursor,
                        scale: 0.6,
                        duration: 100,
                        easing: 'easeOutQuad'
                    });
                });
                document.addEventListener('mouseup', () => {
                    anime({
                        targets: cursor,
                        scale: 1.0,
                        duration: 150,
                        easing: 'easeOutQuad'
                    });
                });
            }

            // Click ripple and particle scatter animation
            document.addEventListener('click', (e) => {
                if (e.target.closest('#logout-overlay')) return;

                // 1. Create expanding ripple ring
                const ripple = document.createElement('div');
                ripple.className = 'click-ripple fixed pointer-events-none z-[9998] rounded-full border border-racing-red/50 bg-racing-red/5 -translate-x-1/2 -translate-y-1/2 select-none';
                ripple.style.left = `${e.clientX}px`;
                ripple.style.top = `${e.clientY}px`;
                ripple.style.width = '0px';
                ripple.style.height = '0px';
                document.body.appendChild(ripple);

                anime({
                    targets: ripple,
                    width: ['0px', '80px'],
                    height: ['0px', '80px'],
                    opacity: [1, 0],
                    duration: 600,
                    easing: 'easeOutExpo',
                    complete: () => ripple.remove()
                });

                // 2. Scatter particles
                for (let i = 0; i < 6; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'click-particle fixed pointer-events-none z-[9998] w-1 h-1 rounded-full bg-racing-red -translate-x-1/2 -translate-y-1/2 select-none shadow-[0_0_4px_rgba(229,57,53,0.8)]';
                    particle.style.left = `${e.clientX}px`;
                    particle.style.top = `${e.clientY}px`;
                    document.body.appendChild(particle);

                    const angle = Math.random() * Math.PI * 2;
                    const distance = 15 + Math.random() * 25;
                    const destX = e.clientX + Math.cos(angle) * distance;
                    const destY = e.clientY + Math.sin(angle) * distance;

                    anime({
                        targets: particle,
                        left: destX,
                        top: destY,
                        scale: [1.2, 0],
                        opacity: [1, 0],
                        duration: 350 + Math.random() * 250,
                        easing: 'easeOutQuad',
                        complete: () => particle.remove()
                    });
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
