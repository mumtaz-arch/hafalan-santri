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
        <p class="text-sm text-gray-500">Kelola dan review hafalan santri MAKN Ende</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Santri -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-islamic-green">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 mr-4">
                    <i class="fas fa-users text-islamic-green text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Santri</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalSantri }}</p>
                </div>
            </div>
        </div>

        <!-- Total Submission -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 mr-4">
                    <i class="fas fa-microphone text-blue-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Submission</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalSubmissions }}</p>
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
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingReviews }}</p>
                </div>
            </div>
        </div>

        <!-- Reviewed Hari Ini -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 mr-4">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Reviewed Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $reviewedToday }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Submission Pending Review -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-exclamation-circle text-yellow-500 mr-2"></i>
                    Submission Perlu Review ({{ $pendingReviews }})
                </h3>
                <a href="{{ route('voice.index') }}" class="text-islamic-green hover:text-green-700 text-sm font-medium">
                    Lihat Semua →
                </a>
            </div>
        </div>
        <div class="p-6">
            @if($pendingSubmissions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Santri</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hafalan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Submit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pendingSubmissions as $submission)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-islamic-green flex items-center justify-center">
                                                    <span class="text-white font-medium">{{ substr($submission->user->name, 0, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $submission->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $submission->user->kelas ?? 'Kelas tidak diset' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $submission->hafalan->nama_surah }}</div>
                                        <div class="text-sm text-gray-500">{{ $submission->hafalan->jumlah_ayat }} ayat</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $submission->formatted_created_at }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('voice.index') }}" class="text-islamic-green hover:text-green-700">
                                            <i class="fas fa-eye mr-1"></i>Review
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-check-circle text-green-400 text-4xl mb-4"></i>
                    <p class="text-gray-500">Tidak ada submission yang perlu direview</p>
                    <p class="text-sm text-gray-400">Semua submission sudah direview</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Aktivitas Terbaru -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-history text-islamic-green mr-2"></i>
                    Aktivitas Terbaru
                </h3>
            </div>
            <div class="p-6">
                @if($recentActivities->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentActivities as $activity)
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="h-8 w-8 rounded-full bg-{{ $activity->status === 'approved' ? 'green' : ($activity->status === 'rejected' ? 'red' : 'yellow') }}-100 flex items-center justify-center">
                                        <i class="fas fa-{{ $activity->status === 'approved' ? 'check' : ($activity->status === 'rejected' ? 'times' : 'clock') }} text-{{ $activity->status === 'approved' ? 'green' : ($activity->status === 'rejected' ? 'red' : 'yellow') }}-600 text-xs"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900">
                                        <span class="font-medium">{{ $activity->user->name }}</span>
                                        {{ $activity->status === 'pending' ? 'mengirim' : 'submission' }}
                                        hafalan <span class="font-medium">{{ $activity->hafalan->nama_surah }}</span>
                                        @if($activity->status !== 'pending')
                                            {{ $activity->status === 'approved' ? 'disetujui' : 'ditolak' }}
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $activity->formatted_created_at }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-history text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500">Belum ada aktivitas</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Statistik Bulanan -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-chart-bar text-islamic-green mr-2"></i>
                    Statistik {{ date('Y') }}
                </h3>
            </div>
            <div class="p-6">
                @if($monthlyStats->count() > 0)
                    <div class="space-y-4">
                        @foreach($monthlyStats as $stat)
                            <div class="border-b border-gray-100 pb-4 last:border-b-0">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ \Carbon\Carbon::create()->month($stat->month)->locale('id')->translatedFormat('F') }}
                                    </span>
                                    <span class="text-sm text-gray-500">{{ $stat->total }} submission</span>
                                </div>
                                <div class="flex space-x-4 text-xs">
                                    <span class="text-green-600">
                                        <i class="fas fa-check mr-1"></i>{{ $stat->approved }} disetujui
                                    </span>
                                    <span class="text-red-600">
                                        <i class="fas fa-times mr-1"></i>{{ $stat->rejected }} ditolak
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-chart-bar text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500">Belum ada data statistik</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
            <i class="fas fa-bolt text-islamic-green mr-2"></i>
            Aksi Cepat
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('voice.index') }}" class="flex items-center p-4 bg-islamic-light rounded-lg hover:bg-green-100 transition duration-150">
                <div class="p-2 bg-islamic-green rounded-lg mr-4">
                    <i class="fas fa-tasks text-white"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Review Submission</p>
                    <p class="text-sm text-gray-600">Review hafalan santri</p>
                </div>
            </a>
            
            <a href="{{ route('santri.index') }}" class="flex items-center p-4 bg-islamic-light rounded-lg hover:bg-green-100 transition duration-150">
                <div class="p-2 bg-blue-500 rounded-lg mr-4">
                    <i class="fas fa-users text-white"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Data Santri</p>
                    <p class="text-sm text-gray-600">Kelola data santri</p>
                </div>
            </a>
            
            <a href="{{ route('export.index') }}" class="flex items-center p-4 bg-islamic-light rounded-lg hover:bg-green-100 transition duration-150">
                <div class="p-2 bg-purple-500 rounded-lg mr-4">
                    <i class="fas fa-download text-white"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Export Data</p>
                    <p class="text-sm text-gray-600">Download laporan</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Islamic Quote -->
    <div class="mt-8 bg-gradient-to-r from-islamic-green to-green-600 rounded-lg shadow p-6 text-white">
        <div class="text-center">
            <i class="fas fa-quote-left text-2xl mb-4 opacity-75"></i>
            <p class="text-lg mb-2 font-medium">
                "خَيْرُكُمْ مَنْ تَعَلَّمَ الْقُرْآنَ وَعَلَّمَهُ"
            </p>
            <p class="text-sm opacity-90">
                "Sebaik-baik kalian adalah yang belajar Al-Qur'an dan mengajarkannya." (HR. Bukhari)
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