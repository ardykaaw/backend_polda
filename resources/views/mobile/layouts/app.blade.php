<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    
    <!-- PWA Meta Tags -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="application-name" content="Absen DitLantas">
    <meta name="apple-mobile-web-app-title" content="Absen DitLantas">
    <meta name="theme-color" content="#1e3a8a">
    <meta name="msapplication-navbutton-color" content="#1e3a8a">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="msapplication-starturl" content="/mobile/dashboard">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- PWA Icons -->
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('icons/icon-512x512.png') }}">
    <link rel="apple-touch-icon" type="image/png" sizes="512x512" href="{{ asset('icons/icon-512x512.png') }}">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    
    <!-- iOS specific meta tags -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Absen DitLantas">
    
    <!-- iOS icons -->
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-512x512.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('icons/icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/icon-180x180.png') }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('icons/icon-167x167.png') }}">
    
    <!-- iOS splash screens -->
    <link rel="apple-touch-startup-image" href="{{ asset('splash/apple-splash-2048-2732.png') }}" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="{{ asset('splash/apple-splash-1668-2388.png') }}" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="{{ asset('splash/apple-splash-1536-2048.png') }}" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="{{ asset('splash/apple-splash-1242-2688.png') }}" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="{{ asset('splash/apple-splash-1125-2436.png') }}" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="{{ asset('splash/apple-splash-828-1792.png') }}" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    
    <title>@yield('title', 'Absen DitLantas')</title>

    <!-- Existing styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    @if(request()->routeIs('mobile.dashboard'))
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    @endif

    <style>
        /* Prevent pull-to-refresh and other mobile gestures */
        html {
            height: 100%;
            overflow: hidden;
        }
        
        body {
            height: 100%;
            overflow: auto;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior-y: none;
        }

        /* Hide browser UI in standalone mode */
        @media all and (display-mode: standalone) {
            header {
                padding-top: env(safe-area-inset-top);
            }
            
            .mobile-nav {
                padding-bottom: env(safe-area-inset-bottom);
            }
        }

        /* Mobile-specific styles */
        .mobile-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .mobile-content {
            flex: 1;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 60px; /* Height of bottom nav */
        }

        /* Bottom Navigation */
        .mobile-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid #e5e7eb;
            padding: 8px 0;
            z-index: 50;
        }

        .mobile-nav a {
            padding: 8px 16px;
            transition: all 0.2s ease;
        }

        .mobile-nav a:active {
            transform: scale(0.95);
        }

        .mobile-nav i {
            font-size: 1.25rem;
            margin-bottom: 2px;
        }

        /* Camera styles */
        .camera-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: black;
            z-index: 1000;
        }

        /* Make buttons more touchable */
        .touch-target {
            min-height: 44px;
            min-width: 44px;
        }

        /* Updated Header/Navbar styles */
        .app-header {
            background: #1e3a8a;
            padding: 0.5rem 0;
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 40;
            height: 3.5rem;
        }

        /* Logo container styles */
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .logo-container img {
            width: 2.75rem; /* 44px */
            height: 2.75rem; /* 44px */
            object-fit: contain;
            flex-shrink: 0; /* Prevent logo from shrinking */
        }

        /* Brand text styles */
        .brand-text {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-left: 0.5rem;
            flex-shrink: 0; /* Prevent text from shrinking */
        }

        .brand-text-primary {
            font-size: 1rem;
            font-weight: 600;
            color: white;
            line-height: 1.2;
            white-space: nowrap; /* Prevent text wrapping */
        }

        .brand-text-secondary {
            font-size: 0.75rem;
            color: #93c5fd;
            font-weight: 500;
            line-height: 1.2;
            margin-top: 0.125rem;
            white-space: nowrap; /* Prevent text wrapping */
        }

        /* Profile image specific styles */
        .app-header a img,
        .app-header a div {
            transition: all 0.2s ease-in-out;
        }

        .app-header a:hover img,
        .app-header a:hover div {
            transform: scale(1.05);
            border-color: #93c5fd;
        }

        /* Adjust content padding */
        .mobile-content {
            padding-top: 3.5rem;
            padding-bottom: 60px;
        }

        .no-header {
            padding-top: 0 !important;
        }

        /* Profile page specific styles */
        .profile-bg {
            background: linear-gradient(to bottom, #1e3a8a 0%, #1e3a8a 60%, #f3f4f6 60%, #f3f4f6 100%);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="mobile-container">
        @auth
            @if(!request()->routeIs('mobile.profile'))
                <!-- Header -->
                <header class="app-header">
                    <!-- Main container with three columns -->
                    <div class="w-full px-4 flex justify-between items-center">
                        <!-- Left spacer -->
                        <div class="w-10"></div>
                        
                        <!-- Center: Logo and Text -->
                        <div class="logo-container">
                            <img src="{{ asset('logo.png') }}" 
                                 alt="Logo Ditlantas" 
                                 class="w-11 h-11 object-contain" 
                                 style="aspect-ratio: 1/1;">
                            <div class="brand-text">
                                <span class="brand-text-primary">SATLANTAS</span>
                                <span class="brand-text-secondary">POLDA SULTRA</span>
                            </div>
                        </div>

                        <!-- Right: Profile Image -->
                        <a href="{{ route('mobile.profile') }}" class="w-10 h-10 flex items-center justify-center">
                            @if(auth()->user()->profile_image)
                                <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" 
                                     alt="Profile" 
                                     class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm hover:border-blue-300 transition-all"
                                     style="aspect-ratio: 1/1;"
                                     onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.png') }}';">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-100 border-2 border-white shadow-sm hover:border-blue-300 transition-all flex items-center justify-center">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                            @endif
                        </a>
                    </div>
                </header>
            @endif

            <!-- Main Content -->
            <main class="mobile-content {{ request()->routeIs('mobile.profile') ? 'no-header' : '' }}">
                @yield('content')
            </main>

            <!-- Bottom Navigation -->
            <nav class="mobile-nav">
                <div class="flex justify-around items-center">
                    <a href="{{ route('mobile.dashboard') }}" 
                       class="flex flex-col items-center {{ request()->routeIs('mobile.dashboard') ? 'text-blue-900' : 'text-gray-500' }}">
                        <i class="fas fa-home {{ request()->routeIs('mobile.dashboard') ? 'text-blue-900' : 'text-gray-400' }}"></i>
                        <span class="text-xs mt-1 {{ request()->routeIs('mobile.dashboard') ? 'text-blue-900' : 'text-gray-500' }}">Beranda</span>
                    </a>
                    <a href="{{ route('mobile.schedule') }}"
                       class="flex flex-col items-center {{ request()->routeIs('mobile.schedule') ? 'text-blue-900' : 'text-gray-500' }}">
                        <i class="fas fa-calendar {{ request()->routeIs('mobile.schedule') ? 'text-blue-900' : 'text-gray-400' }}"></i>
                        <span class="text-xs mt-1 {{ request()->routeIs('mobile.schedule') ? 'text-blue-900' : 'text-gray-500' }}">Jadwal</span>
                    </a>
                    <a href="{{ route('mobile.profile') }}"
                       class="flex flex-col items-center {{ request()->routeIs('mobile.profile') ? 'text-blue-900' : 'text-gray-500' }}">
                        <i class="fas fa-user {{ request()->routeIs('mobile.profile') ? 'text-blue-900' : 'text-gray-400' }}"></i>
                        <span class="text-xs mt-1 {{ request()->routeIs('mobile.profile') ? 'text-blue-900' : 'text-gray-500' }}">Profil</span>
                    </a>
                </div>
            </nav>
        @else
            @yield('content')
        @endauth
    </div>

    <!-- PWA Install Check -->
    <script>
        // Check if running as standalone PWA
        if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
            document.documentElement.classList.add('standalone');
        }

        // Register Service Worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('ServiceWorker registration successful');
                    })
                    .catch(err => {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }

        // Handle standalone mode navigation
        document.addEventListener('DOMContentLoaded', function() {
            if (window.matchMedia('(display-mode: standalone)').matches) {
                // Handle all navigation to stay within the app
                document.addEventListener('click', function(e) {
                    let target = e.target;
                    while (target && target.tagName !== 'A') {
                        target = target.parentNode;
                    }
                    if (target && target.tagName === 'A') {
                        const href = target.getAttribute('href');
                        if (href && href.startsWith('/')) {
                            e.preventDefault();
                            window.location.href = href;
                        }
                    }
                });
            }
        });

        // Deteksi jika aplikasi dibuka dari home screen
        const isInStandaloneMode = () => 
            (window.navigator.standalone) || 
            (window.matchMedia('(display-mode: standalone)').matches);

        // Hanya redirect ke install jika:
        // 1. Bukan dalam mode standalone
        // 2. Belum pernah install
        // 3. Bukan sedang di halaman install
        if (!isInStandaloneMode() && 
            !window.location.pathname.includes('/mobile/install') && 
            !localStorage.getItem('installPromptShown')) {
            
            // Set flag bahwa prompt install sudah ditampilkan
            localStorage.setItem('installPromptShown', 'true');
            
            // Redirect ke halaman install
            window.location.href = "{{ route('mobile.install') }}";
        }
    </script>

    @stack('scripts')
</body>
</html>
