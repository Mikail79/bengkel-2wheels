<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>2WHEELS HOUSE — System Entry</title>
    <meta name="description" content="2WHEELS HOUSE Internal Portal — Authentication Required">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800;900&family=Inter:wght@400;500;600&family=Space+Mono&display=swap" rel="stylesheet"/>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "tertiary-container": "#319db6",
                        "text-primary": "#FFFFFF",
                        "outline": "#ab8985",
                        "error": "#ffb4ab",
                        "surface-container-high": "#372624",
                        "surface-dim": "#1e0f0e",
                        "surface-container": "#2c1b1a",
                        "racing-red": "#E53935",
                        "tertiary": "#72d4ef",
                        "surface": "#1E1E1E",
                        "on-tertiary": "#003641",
                        "background": "#121212",
                        "surface-container-low": "#271716",
                        "primary-container": "#ff544c",
                        "on-surface-variant": "#e4beb9",
                        "outline-variant": "#5b403d",
                        "text-secondary": "#A0A0A0",
                        "emerald-success": "#2E7D32",
                        "surface-variant": "#43302e",
                        "surface-container-highest": "#43302e",
                        "on-surface": "#fadcd8",
                        "on-error-container": "#ffdad6"
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

        /* === ANIMATIONS === */
        @keyframes slideUpFade {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulseGlow {
            0% { box-shadow: 0 0 15px rgba(229,57,53,0.3); }
            50% { box-shadow: 0 0 30px rgba(229,57,53,0.6); }
            100% { box-shadow: 0 0 15px rgba(229,57,53,0.3); }
        }
        @keyframes scanLine {
            0% { top: -2px; }
            100% { top: calc(100% + 2px); }
        }
        @keyframes typewriter {
            from { width: 0; }
            to { width: 100%; }
        }
        @keyframes blinkCaret {
            0%, 100% { border-color: transparent; }
            50% { border-color: #E53935; }
        }

        .animate-entrance {
            animation: slideUpFade 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
        .delay-1 { animation-delay: 0.15s; }
        .delay-2 { animation-delay: 0.3s; }
        .delay-3 { animation-delay: 0.45s; }
        .delay-4 { animation-delay: 0.6s; }
        .delay-5 { animation-delay: 0.75s; }

        /* === INPUT FOCUS LINE === */
        .input-underline {
            position: relative;
        }
        .input-underline::after {
            content: '';
            position: absolute;
            bottom: 0; left: 50%;
            width: 0; height: 2px;
            background: #E53935;
            transition: width 0.3s ease, left 0.3s ease;
        }
        .input-underline:focus-within::after {
            width: 100%;
            left: 0;
        }

        /* === SCAN LINE ACCENT (decorative) === */
        .scan-line::after {
            content: '';
            position: absolute;
            left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(229,57,53,0.4), transparent);
            animation: scanLine 3s linear infinite;
            pointer-events: none;
        }

        /* === REMOVE DEFAULT SELECT ARROW === */
        select {
            background-image: none !important;
            padding-right: 1.5rem !important;
        }

        /* === REDUCED MOTION === */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body class="bg-background text-text-primary font-body-md antialiased selection:bg-racing-red selection:text-text-primary">
    
    <!-- Industrial Mesh Gradient Background -->
    <div class="mesh-bg">
        <div class="mesh-blob-1"></div>
        <div class="mesh-blob-2"></div>
    </div>

    <!-- Full-screen centered portal -->
    <div class="min-h-screen flex items-center justify-center px-4 py-8 relative">

        <!-- Login Card -->
        <div class="w-full max-w-md relative">

            <!-- Decorative scan-line accent above card -->
            <div class="scan-line relative h-0 mb-4 animate-entrance"></div>

            <!-- Brand Header -->
            <div class="text-center mb-8 animate-entrance delay-1">
                <div class="flex justify-center mb-4">
                    <img alt="2WHEELS HOUSE Logo" class="h-16 object-contain" src="{{ asset('images/logo.png') }}?v=1"/>
                </div>
                <div class="mt-2 flex items-center justify-center gap-2">
                    <div class="w-8 h-px bg-outline-variant"></div>
                    <span class="font-label-sm text-[10px] text-text-secondary uppercase tracking-[0.3em]">Internal System Portal</span>
                    <div class="w-8 h-px bg-outline-variant"></div>
                </div>
            </div>

            <!-- Glass Login Panel -->
            <div class="glass-panel rounded-xl overflow-hidden animate-entrance delay-2">
                
                <!-- Red accent line top -->
                <div class="h-0.5 bg-gradient-to-r from-transparent via-racing-red to-transparent"></div>

                <!-- Panel Header -->
                <div class="px-8 pt-8 pb-4">
                    <div class="flex items-center gap-3 mb-1">
                        <span class="material-symbols-outlined text-racing-red text-lg" style='font-variation-settings: "FILL" 1;'>lock</span>
                        <h2 class="font-headline-md text-[20px] text-on-surface uppercase tracking-tight font-extrabold">Authentication</h2>
                    </div>
                    <p class="font-label-sm text-[11px] text-text-secondary uppercase tracking-widest ml-8">Authorized personnel only</p>
                </div>

                <!-- Error Display -->
                @if ($errors->any())
                <div class="mx-8 mb-2 px-4 py-3 rounded-lg bg-error/10 border border-error/20 flex items-center gap-3 animate-entrance">
                    <span class="material-symbols-outlined text-error text-lg">warning</span>
                    <span class="font-label-sm text-label-sm text-error">{{ $errors->first() }}</span>
                </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="px-8 pb-8 flex flex-col gap-5">
                    @csrf

                    <!-- Email -->
                    <div class="input-underline">
                        <label for="email" class="font-label-sm text-[10px] text-text-secondary uppercase tracking-widest mb-2 block">Operator Email</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-0 top-1/2 -translate-y-1/2 text-text-secondary text-lg">mail</span>
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                required 
                                autofocus
                                autocomplete="email"
                                value="{{ old('email') }}"
                                class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-body-md pl-8 pr-0 py-2.5 focus:ring-0 transition-colors placeholder:text-surface-container-highest/80"
                                placeholder="admin@2wheels.local"
                            />
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="input-underline">
                        <label for="password" class="font-label-sm text-[10px] text-text-secondary uppercase tracking-widest mb-2 block">Access Code</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-0 top-1/2 -translate-y-1/2 text-text-secondary text-lg">key</span>
                            <input 
                                id="password" 
                                name="password" 
                                type="password" 
                                required 
                                autocomplete="current-password"
                                class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-body-md pl-8 pr-10 py-2.5 focus:ring-0 transition-colors placeholder:text-surface-container-highest/80"
                                placeholder="••••••••"
                            />
                            <button type="button" id="toggle-password" class="absolute right-0 top-1/2 -translate-y-1/2 text-text-secondary hover:text-text-primary transition-colors">
                                <span class="material-symbols-outlined text-lg" id="eye-icon">visibility</span>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center gap-2">
                        <input 
                            id="remember" 
                            name="remember" 
                            type="checkbox" 
                            class="w-4 h-4 rounded border-outline-variant bg-[#1A1A1A] text-racing-red focus:ring-racing-red focus:ring-offset-0 cursor-pointer"
                        />
                        <label for="remember" class="font-label-sm text-[11px] text-text-secondary uppercase tracking-wider cursor-pointer select-none">Keep me signed in</label>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full h-12 bg-racing-red text-text-primary font-label-sm text-label-sm uppercase tracking-widest rounded flex items-center justify-center gap-2 shadow-[0_0_20px_rgba(229,57,53,0.3)] hover:shadow-[0_0_30px_rgba(229,57,53,0.5)] hover:bg-primary-container transition-all active:scale-[0.98] mt-2"
                    >
                        <span class="material-symbols-outlined text-lg">login</span>
                        Access System
                    </button>
                </form>

                <!-- Red accent line bottom -->
                <div class="h-px bg-gradient-to-r from-transparent via-outline-variant/30 to-transparent"></div>
            </div>

            <!-- Footer Metadata -->
            <div class="mt-6 text-center animate-entrance delay-3">
                <div class="flex items-center justify-center gap-3 mb-2">
                    <div class="flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-success animate-pulse"></span>
                        <span class="font-receipt-mono text-[10px] text-text-secondary uppercase tracking-wider">System Online</span>
                    </div>
                    <span class="text-outline-variant">|</span>
                    <span class="font-receipt-mono text-[10px] text-text-secondary uppercase tracking-wider">v1.0.0</span>
                    <span class="text-outline-variant">|</span>
                    <span class="font-receipt-mono text-[10px] text-text-secondary uppercase tracking-wider" id="live-clock"></span>
                </div>
                <p class="font-receipt-mono text-[9px] text-surface-container-highest uppercase tracking-wider">© {{ date('Y') }} 2WHEELS HOUSE — Workshop Management System</p>
            </div>
        </div>
    </div>

    <!-- Anime.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.2/anime.min.js"></script>

    <script>
        // === LIVE CLOCK ===
        function updateClock() {
            const now = new Date();
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const s = String(now.getSeconds()).padStart(2, '0');
            const el = document.getElementById('live-clock');
            if (el) el.textContent = `${h}:${m}:${s}`;
        }
        updateClock();
        setInterval(updateClock, 1000);

        // === PASSWORD TOGGLE ===
        const toggleBtn = document.getElementById('toggle-password');
        const pwField = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        if (toggleBtn && pwField && eyeIcon) {
            toggleBtn.addEventListener('click', () => {
                const isPassword = pwField.type === 'password';
                pwField.type = isPassword ? 'text' : 'password';
                eyeIcon.textContent = isPassword ? 'visibility_off' : 'visibility';
            });
        }

        // === ENTRANCE ANIMATION WITH ANIME.JS ===
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof anime === 'undefined') return;

            // Animate the brand title letters
            const brandTitle = document.querySelector('h1');
            if (brandTitle) {
                const original = brandTitle.textContent;
                const words = original.trim().split(' ');
                brandTitle.innerHTML = words.map(word => {
                    const letters = word.split('').map(c => `<span class="letter inline-block origin-center">${c}</span>`).join('');
                    return `<span class="inline-block whitespace-nowrap">${letters}</span>`;
                }).join('&nbsp;');

                anime({
                    targets: 'h1 .letter',
                    scale: [0.4, 1],
                    opacity: [0, 1],
                    translateY: [20, 0],
                    easing: 'easeOutExpo',
                    duration: 800,
                    delay: anime.stagger(30, { start: 400 })
                });
            }

            // Submit button pulse
            anime({
                targets: 'button[type="submit"]',
                boxShadow: [
                    '0 0 20px rgba(229,57,53,0.3)',
                    '0 0 35px rgba(229,57,53,0.5)',
                    '0 0 20px rgba(229,57,53,0.3)'
                ],
                duration: 2500,
                loop: true,
                easing: 'easeInOutSine',
                delay: 1500
            });
        });
    </script>
</body>
</html>
