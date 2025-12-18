@extends('layouts.app')

@section('content')
@if(isset($seoData))
    @section('seoTitle', $seoData['title'])
    @section('seoDescription', $seoData['description'])
@endif
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-user-graduate text-islamic-green mr-3"></i>
            Dashboard Ustad
        </h1>
        <p class="text-gray-600 mt-2">Assalamu'alaikum, {{ auth()->user()->name }}!</p>
        <p class="text-sm text-gray-500">Akun Anda sedang menunggu verifikasi oleh admin</p>
    </div>

    <!-- Alert Notification -->
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8 rounded">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-yellow-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    <strong>Akun Anda sedang menunggu verifikasi oleh admin.</strong>
                    <br>
                    Silakan menunggu konfirmasi dari admin sebelum dapat menggunakan fitur-fitur untuk ustad.
                    Anda tetap dapat melihat informasi akun Anda di bawah ini.
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Submission -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 mr-4">
                    <i class="fas fa-microphone text-blue-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Submission</p>
                    <p class="text-2xl font-bold text-gray-900">-</p>
                </div>
            </div>
        </div>

        <!-- Verified Submission -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 mr-4">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Disetujui</p>
                    <p class="text-2xl font-bold text-gray-900">-</p>
                </div>
            </div>
        </div>

        <!-- Pending Review -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 mr-4">
                    <i class="fas fa-clock text-yellow-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Pending Review</p>
                    <p class="text-2xl font-bold text-gray-900">-</p>
                </div>
            </div>
        </div>
    </div>

    <!-- User Information -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-user-circle text-islamic-green mr-2"></i>
                Informasi Akun
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Nama Lengkap</h4>
                    <p class="text-lg font-medium text-gray-900">{{ $user->name }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Email</h4>
                    <p class="text-lg font-medium text-gray-900">{{ $user->email }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Role</h4>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ ucfirst($user->role) }} (Menunggu Verifikasi)
                    </span>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Status Verifikasi</h4>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        {{ ucfirst($user->verification_status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- What happens next? -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                Apa yang terjadi selanjutnya?
            </h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center mr-3 mt-1">
                        <span class="text-blue-800 text-xs font-bold">1</span>
                    </div>
                    <p class="text-gray-700">Admin akan meninjau permintaan Anda untuk menjadi ustad</p>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center mr-3 mt-1">
                        <span class="text-blue-800 text-xs font-bold">2</span>
                    </div>
                    <p class="text-gray-700">Jika permintaan Anda disetujui, Anda akan menerima notifikasi dan dapat mengakses fitur ustad secara penuh</p>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center mr-3 mt-1">
                        <span class="text-blue-800 text-xs font-bold">3</span>
                    </div>
                    <p class="text-gray-700">Jika permintaan Anda ditolak, Anda akan menerima notifikasi penjelasan</p>
                </div>
            </div>
            
            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                <p class="text-sm text-blue-700">
                    <i class="fas fa-clock mr-2"></i>
                    Proses verifikasi biasanya memakan waktu 1-2 hari kerja. Jika Anda memiliki pertanyaan, silakan hubungi admin.
                </p>
            </div>
        </div>
    </div>

    <!-- Islamic Quote -->
    <div class="mt-8 bg-gradient-to-r from-islamic-green to-green-600 rounded-lg shadow p-6 text-white">
        <div class="text-center">
            <i class="fas fa-quote-left text-2xl mb-4 opacity-75"></i>
            <p class="text-lg mb-2 font-medium">
                "تَعَلَّمُوا الْعِلْمَ وَلُقِّنُوهُ النَّاسَ وَعَلِّمُوهُ الصِّبْيَانَ"
            </p>
            <p class="text-sm opacity-90">
                "Pelajarilah ilmu dan ajarkanlah kepada orang-orang, serta ajarkanlah kepada anak-anak." (HR. Baihaqi)
            </p>
            <div class="mt-4 pt-4 border-t border-green-500">
                <p class="text-sm">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection