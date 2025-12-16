<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Primary Meta Tags -->
    <title>Kontrol Hafalan Santri MAKN Ende - Aplikasi Monitoring Hafalan Al-Qur'an</title>
    <meta name="title" content="Kontrol Hafalan Santri MAKN Ende - Aplikasi Monitoring Hafalan Al-Qur'an">
    <meta name="description" content="Sistem digital untuk mencatat, menilai, dan memantau hafalan Al-Qur'an para santri di Madrasah Aliyah Kejuruan Negeri Ende. Solusi modern untuk pondok pesantren.">
    <meta name="keywords" content="hafalan santri, Makn Ende, aplikasi Quran, kontrol hafalan, pondok pesantren digital, madrasah aliyyah, hafalan Al-Quran, monitoring hafalan">
    <meta name="author" content="MAKN Ende">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://hafalansantri.maknende.ac.id/">
    <meta property="og:title" content="Kontrol Hafalan Santri MAKN Ende - Aplikasi Monitoring Hafalan Al-Qur'an">
    <meta property="og:description" content="Sistem digital untuk mencatat, menilai, dan memantau hafalan Al-Qur'an para santri di Madrasah Aliyah Kejuruan Negeri Ende. Solusi modern untuk pondok pesantren.">
    <meta property="og:image" content="https://hafalansantri.maknende.ac.id/images/og-image.jpg">
    <meta property="og:site_name" content="MAKN Ende">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://hafalansantri.maknende.ac.id/">
    <meta property="twitter:title" content="Kontrol Hafalan Santri MAKN Ende - Aplikasi Monitoring Hafalan Al-Qur'an">
    <meta property="twitter:description" content="Sistem digital untuk mencatat, menilai, dan memantau hafalan Al-Qur'an para santri di Madrasah Aliyah Kejuruan Negeri Ende. Solusi modern untuk pondok pesantren.">
    <meta property="twitter:image" content="https://hafalansantri.maknende.ac.id/images/og-image.jpg">
    
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
                </div>
                
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6 space-x-4">
                        <a href="{{ route('login') }}" class="text-white hover:bg-green-700 px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-sign-in-alt mr-1"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-white text-islamic-green hover:bg-gray-100 px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-user-plus mr-1"></i> Register
                        </a>
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
                <a href="{{ route('login') }}" class="text-white block px-3 py-2 rounded-md text-base font-medium">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </a>
                <a href="{{ route('register') }}" class="text-white block px-3 py-2 rounded-md text-base font-medium">
                    <i class="fas fa-user-plus mr-2"></i> Register
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="gradient-islamic text-white">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
                    Kontrol Hafalan Santri
                </h1>
                <p class="mt-6 max-w-lg mx-auto text-xl sm:max-w-3xl">
                    Sistem digital untuk mencatat, menilai, dan memantau hafalan Al-Qur'an para santri di Madrasah Aliyah Kejuruan Negeri Ende
                </p>
                <div class="mt-10 flex justify-center">
                    <div class="inline-flex rounded-md shadow">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-islamic-green bg-white hover:bg-gray-50">
                            <i class="fas fa-rocket mr-2"></i> Mulai Sekarang
                        </a>
                    </div>
                    <div class="ml-3 inline-flex">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-800 hover:bg-green-700">
                            <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base font-semibold text-islamic-green tracking-wide uppercase">Fitur</h2>
                <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Solusi Komprehensif untuk Hafalan Santri
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Platform digital yang dirancang khusus untuk memudahkan pengelolaan hafalan Al-Qur'an di lingkungan pendidikan pesantren
                </p>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-islamic-green text-white">
                            <i class="fas fa-microphone-alt"></i>
                        </div>
                        <div class="mt-5">
                            <h3 class="text-lg font-medium text-gray-900">Perekaman Hafalan</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Santri dapat mengupload rekaman hafalan mereka untuk direview oleh ustadz/ah dengan mudah dan efisien.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-islamic-green text-white">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="mt-5">
                            <h3 class="text-lg font-medium text-gray-900">Monitoring Progress</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Ustadz/ah dapat memantau perkembangan hafalan santri secara real-time dengan sistem penilaian yang terstruktur.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-islamic-green text-white">
                            <i class="fas fa-file-export"></i>
                        </div>
                        <div class="mt-5">
                            <h3 class="text-lg font-medium text-gray-900">Laporan & Export</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Hasilkan laporan kemajuan hafalan santri dalam format yang dapat diexport untuk dokumentasi dan evaluasi.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Benefits Section -->
    <div class="py-12 bg-islamic-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base font-semibold text-islamic-green tracking-wide uppercase">Manfaat</h2>
                <p class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Mengapa Memilih Sistem Kami?
                </p>
            </div>

            <div class="mt-10">
                <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-white text-islamic-green">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Efisiensi Waktu</p>
                        <p class="mt-2 ml-16 text-base text-gray-600">
                            Menghemat waktu dalam proses pemeriksaan dan pendataan hafalan santri dengan sistem digital terintegrasi.
                        </p>
                    </div>

                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-white text-islamic-green">
                            <i class="fas fa-database"></i>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Arsip Digital</p>
                        <p class="mt-2 ml-16 text-base text-gray-600">
                            Menyimpan semua data hafalan santri secara aman dan terorganisir dalam format digital yang mudah diakses.
                        </p>
                    </div>

                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-white text-islamic-green">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Analisis Data</p>
                        <p class="mt-2 ml-16 text-base text-gray-600">
                            Mendapatkan insight berharga tentang kemajuan hafalan santri melalui laporan statistik dan visualisasi data.
                        </p>
                    </div>

                    <div class="relative">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-white text-islamic-green">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Akses Mudah</p>
                        <p class="mt-2 ml-16 text-base text-gray-600">
                            Akses sistem dari berbagai perangkat (desktop, tablet, mobile) kapan saja dan di mana saja.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-islamic-green">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Siap meningkatkan kualitas</span>
                <span class="block text-white">pengelolaan hafalan santri?</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-islamic-green bg-white hover:bg-gray-50">
                        <i class="fas fa-rocket mr-2"></i> Daftar Sekarang
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-800 hover:bg-green-700">
                        <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-lg font-bold mb-4">
                        <i class="fas fa-mosque mr-2"></i>
                        Kontrol Hafalan Santri MAKN Ende
                    </h3>
                    <p class="text-gray-300 mb-4">
                        Sistem digital inovatif untuk mencatat, menilai, dan memantau hafalan Al-Qur'an para santri di Madrasah Aliyah Kejuruan Negeri Ende.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-sm font-semibold text-gray-400 tracking-wider uppercase mb-4">
                        Navigasi
                    </h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-base text-gray-300 hover:text-white">Beranda</a></li>
                        <li><a href="{{ route('login') }}" class="text-base text-gray-300 hover:text-white">Login</a></li>
                        <li><a href="{{ route('register') }}" class="text-base text-gray-300 hover:text-white">Register</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-sm font-semibold text-gray-400 tracking-wider uppercase mb-4">
                        Kontak
                    </h4>
                    <ul class="space-y-2 text-gray-300">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-2 text-sm"></i>
                            <span>Jl. Raya Ende - Maumere, Ende, Nusa Tenggara Timur</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2"></i>
                            <span>+62 123 4567 890</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2"></i>
                            <span>info@maknende.ac.id</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="mt-8 border-t border-gray-700 pt-8 md:flex md:items-center md:justify-between">
                <div class="flex space-x-6 md:order-2">
                    <!-- Social links would go here -->
                </div>
                <p class="mt-8 text-base text-gray-400 md:mt-0 md:order-1">
                    &copy; 2025 Madrasah Aliyah Kejuruan Negeri Ende. Hak Cipta Dilindungi.
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
    </script>
</body>
</html>