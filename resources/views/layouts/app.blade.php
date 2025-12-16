<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Primary Meta Tags -->
    <title>
        @if(isset($seoTitle))
            {{ $seoTitle }}
        @elseif(isset($title))
            {{ $title }} - Kontrol Hafalan Santri MAKN Ende
        @else
            Kontrol Hafalan Santri MAKN Ende
        @endif
    </title>
    
    <meta name="title" content="@if(isset($seoTitle)){{ $seoTitle }}@elseif(isset($title)){{ $title }} - Kontrol Hafalan Santri MAKN Ende @else Kontrol Hafalan Santri MAKN Ende @endif">
    
    <meta name="description" content="@if(isset($seoDescription)){{ $seoDescription }}@else Aplikasi web untuk mencatat, menilai, dan memantau hafalan Al-Qur'an para santri di MAKN Ende. Sistem kontrol hafalan digital untuk pondok pesantren. @endif">
    
    <meta name="keywords" content="@if(isset($seoKeywords)){{ $seoKeywords }}@else hafalan santri, Makn Ende, aplikasi Quran, kontrol hafalan, pondok pesantren digital, madrasah aliyyah, hafalan Al-Quran, monitoring hafalan @endif">
    
    <meta name="author" content="MAKN Ende">
    <meta name="robots" content="index, follow">
    <meta name="language" content="Indonesian">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@if(isset($seoTitle)){{ $seoTitle }}@elseif(isset($title)){{ $title }} - Kontrol Hafalan Santri MAKN Ende @else Kontrol Hafalan Santri MAKN Ende @endif">
    <meta property="og:description" content="@if(isset($seoDescription)){{ $seoDescription }}@else Aplikasi web untuk mencatat, menilai, dan memantau hafalan Al-Qur'an para santri di MAKN Ende. Sistem kontrol hafalan digital untuk pondok pesantren. @endif">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
    <meta property="og:image:alt" content="@if(isset($seoTitle)){{ $seoTitle }}@else Kontrol Hafalan Santri MAKN Ende @endif">
    <meta property="og:site_name" content="MAKN Ende">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@if(isset($seoTitle)){{ $seoTitle }}@elseif(isset($title)){{ $title }} - Kontrol Hafalan Santri MAKN Ende @else Kontrol Hafalan Santri MAKN Ende @endif">
    <meta property="twitter:description" content="@if(isset($seoDescription)){{ $seoDescription }}@else Aplikasi web untuk mencatat, menilai, dan memantau hafalan Al-Qur'an para santri di MAKN Ende. Sistem kontrol hafalan digital untuk pondok pesantren. @endif">
    <meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        .bg-islamic-green { background-color: #0d5f3c; }
        .text-islamic-green { color: #0d5f3c; }
        .border-islamic-green { border-color: #0d5f3c; }
        .hover\:bg-islamic-green:hover { background-color: #0d5f3c; }
        .bg-islamic-light { background-color: #e8f5e8; }
        .gradient-islamic { background: linear-gradient(135deg, #0d5f3c 0%, #4ade80 100%); }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    @auth
    <!-- Navbar -->
    <nav class="bg-islamic-green shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-white text-xl font-bold">
                            <i class="fas fa-mosque mr-2"></i>
                            MAKN ENDE
                        </h1>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="{{ route('dashboard') }}" class="text-white hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-green-700' : '' }}">
                                <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                            </a>
                            <a href="{{ route('voice.index') }}" class="text-white hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('voice.*') ? 'bg-green-700' : '' }}">
                                <i class="fas fa-microphone mr-1"></i> 
                                @if(auth()->user()->role === 'santri') 
                                    Hafalan Saya 
                                @else 
                                    Review Hafalan 
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="hidden md:flex md:items-center">
                    <div class="ml-4 flex items-center md:ml-6">
                        <div class="relative">
                            <div class="flex items-center text-white">
                                <i class="fas fa-user-circle text-2xl mr-2"></i>
                                <div class="text-sm">
                                    <div class="font-medium">{{ auth()->user()->name }}</div>
                                    <div class="text-green-200">{{ ucfirst(auth()->user()->role) }}</div>
                                </div>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="ml-4">
                            @csrf
                            <button type="submit" class="text-white hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium">
                                <i class="fas fa-sign-out-alt mr-1"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-white hover:bg-green-700 px-2 py-1 rounded-md">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-green-800">
                <a href="{{ route('dashboard') }}" class="text-white block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('dashboard') ? 'bg-green-700' : '' }}">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                </a>
                <a href="{{ route('voice.index') }}" class="text-white block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('voice.*') ? 'bg-green-700' : '' }}">
                    <i class="fas fa-microphone mr-2"></i> 
                    @if(auth()->user()->role === 'santri') 
                        Hafalan Saya 
                    @else 
                        Review Hafalan 
                    @endif
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-white block px-3 py-2 rounded-md text-base font-medium w-full text-left">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>
    @endauth

    <!-- Main Content -->
    <main class="@auth py-6 @endauth">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-islamic-green text-white mt-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-sm">
                    &copy; {{ date('Y') }} Madrasah Aliyah Kejuruan Negeri Ende. 
                    <span class="block mt-1">Sistem Kontroling Hafalan Al-Qur'an By Team Magangers KKI</span>
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Flash message auto hide
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-auto-hide');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);

        // Audio player custom controls
        document.addEventListener('DOMContentLoaded', function() {
            const audioPlayers = document.querySelectorAll('audio');
            audioPlayers.forEach(function(audio) {
                audio.addEventListener('loadstart', function() {
                    const playBtn = audio.nextElementSibling;
                    if (playBtn && playBtn.classList.contains('audio-controls')) {
                        playBtn.style.display = 'inline-block';
                    }
                });
            });
        });
    </script>

    @yield('scripts')
</body>
</html>