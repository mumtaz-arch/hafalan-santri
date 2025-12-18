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
            <i class="fas fa-tachometer-alt text-islamic-green mr-3"></i>
            Dashboard Santri
        </h1>
        <p class="text-gray-600 mt-2">Assalamu'alaikum, {{ auth()->user()->name }}!</p>
        <p class="text-sm text-gray-500">Selamat datang di sistem hafalan MAKN Ende</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Hafalan -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-islamic-green">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 mr-4">
                    <i class="fas fa-book-quran text-islamic-green text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Hafalan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalHafalan }}</p>
                </div>
            </div>
        </div>

        <!-- Hafalan Selesai -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 mr-4">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Hafalan Selesai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $approvedSubmissions }}</p>
                </div>
            </div>
        </div>

        <!-- Menunggu Review -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 mr-4">
                    <i class="fas fa-clock text-yellow-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Menunggu Review</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingSubmissions }}</p>
                </div>
            </div>
        </div>

        <!-- Progres -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 mr-4">
                    <i class="fas fa-chart-pie text-blue-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Progres</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $progressPercentage }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
            <i class="fas fa-chart-line text-islamic-green mr-2"></i>
            Progress Hafalan Anda
        </h3>
        <div class="mb-2 flex justify-between text-sm">
            <span class="text-gray-600">{{ $approvedSubmissions }} dari {{ $totalHafalan }} surah</span>
            <span class="font-medium text-islamic-green">{{ $progressPercentage }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-gradient-to-r from-islamic-green to-green-400 h-3 rounded-full transition-all duration-500" 
                 style="width: {{ $progressPercentage }}%"></div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Submission Terbaru -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-history text-islamic-green mr-2"></i>
                    Submission Terbaru
                </h3>
            </div>
            <div class="p-6">
                @if($recentSubmissions->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentSubmissions as $submission)
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{ $submission->hafalan->nama_surah }}</h4>
                                        <p class="text-sm text-gray-600">{{ $submission->formatted_created_at }}</p>
                                    </div>
                                    <div class="ml-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $submission->status_badge['color'] }}">
                                            {{ $submission->status_badge['text'] }}
                                        </span>
                                    </div>
                                </div>
                                @if($submission->status !== 'pending' && $submission->reviewer)
                                    <div class="mt-2 flex items-center text-sm text-gray-500">
                                        <i class="fas fa-user-check mr-2"></i>
                                        <span>Direview oleh: {{ $submission->reviewer->name }}</span>
                                        @if($submission->reviewed_at)
                                            <span class="ml-3">• {{ $submission->formatted_reviewed_at }}</span>
                                        @endif
                                    </div>
                                @elseif($submission->status !== 'pending' && !$submission->reviewer)
                                    <div class="mt-2 flex items-center text-sm text-gray-500">
                                        <i class="fas fa-user-slash mr-2"></i>
                                        <span>Reviewer: Tidak diketahui</span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-microphone text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500">Belum ada submission hafalan</p>
                        <a href="{{ route('voice.index') }}" class="text-islamic-green hover:text-green-700 text-sm font-medium">
                            Mulai submit hafalan →
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Hafalan Selanjutnya -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-list text-islamic-green mr-2"></i>
                    Hafalan Selanjutnya
                </h3>
            </div>
            <div class="p-6">
                @if($remainingHafalan->count() > 0)
                    <div class="space-y-4">
                        @foreach($remainingHafalan as $hafalan)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $hafalan->nama_surah }}</h4>
                                    <p class="text-sm text-gray-600">{{ $hafalan->jumlah_ayat }} ayat</p>
                                </div>
                                <div class="ml-4">
                                    <span class="text-xs text-gray-500">Surah {{ $hafalan->nomor_surah }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 text-center">
                        <a href="{{ route('voice.index') }}" class="inline-flex items-center px-4 py-2 bg-islamic-green text-white text-sm font-medium rounded-md hover:bg-green-700 transition duration-150">
                            <i class="fas fa-microphone mr-2"></i>
                            Submit Hafalan
                        </a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-trophy text-gold text-4xl mb-4"></i>
                        <p class="text-gray-900 font-medium">Selamat!</p>
                        <p class="text-gray-500 text-sm">Anda telah menyelesaikan semua hafalan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <!-- <div class="mt-8 bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
            <i class="fas fa-bolt text-islamic-green mr-2"></i>
            Aksi Cepat
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('voice.index') }}" class="flex items-center p-4 bg-islamic-light rounded-lg hover:bg-green-100 transition duration-150">
                <div class="p-2 bg-islamic-green rounded-lg mr-4">
                    <i class="fas fa-microphone text-white"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Submit Hafalan</p>
                    <p class="text-sm text-gray-600">Upload rekaman hafalan baru</p>
                </div>
            </a>
            
            <a href="{{ route('voice.index') }}" class="flex items-center p-4 bg-islamic-light rounded-lg hover:bg-green-100 transition duration-150">
                <div class="p-2 bg-blue-500 rounded-lg mr-4">
                    <i class="fas fa-list text-white"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Lihat Hafalan</p>
                    <p class="text-sm text-gray-600">Cek status submission</p>
                </div>
            </a>
            
            <div class="flex items-center p-4 bg-gray-100 rounded-lg">
                <div class="p-2 bg-yellow-500 rounded-lg mr-4">
                    <i class="fas fa-chart-bar text-white"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Statistik</p>
                    <p class="text-sm text-gray-600">Lihat progress detail</p>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Islamic Quote -->
    <div class="mt-8 bg-gradient-to-r from-islamic-green to-green-600 rounded-lg shadow p-6">
        <div class="text-center text-white">
            <i class="fas fa-quote-left text-2xl mb-4 opacity-75"></i>
            <p class="text-lg mb-2 font-medium text-islamic-green">
                "وَرَتِّلِ الْقُرْآنَ تَرْتِيلًا"
            </p>
            <p class="text-sm opacity-90 text-islamic-green">
                "Dan bacalah Al-Qur'an itu dengan perlahan-lahan." (QS. Al-Muzzammil: 4)
            </p>
            <div class="mt-4 pt-4 border-t border-green-500">
                <p class="text-sm text-islamic-green">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection