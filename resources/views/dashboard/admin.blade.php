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
            <i class="fas fa-shield-alt text-green-600 mr-3"></i>
            Dashboard Admin
        </h1>
        <p class="text-gray-600 mt-2">Assalamu'alaikum, {{ auth()->user()->name }}!</p>
        <p class="text-sm text-gray-500">Sistem manajemen pengguna dan hafalan MAKN Ende</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 mr-4">
                    <i class="fas fa-users text-blue-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Pengguna</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>

        <!-- Total Santri -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-islamic-green">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 mr-4">
                    <i class="fas fa-user-graduate text-islamic-green text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Santri</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalSantri }}</p>
                </div>
            </div>
        </div>

        <!-- Total Ustad -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 mr-4">
                    <i class="fas fa-chalkboard-teacher text-orange-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Ustad</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalUstad }}</p>
                </div>
            </div>
        </div>

        <!-- Ustad Menunggu Verifikasi -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 mr-4">
                    <i class="fas fa-crown text-purple-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Ustad Menunggu Verifikasi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingVerifications }}</p>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Unverified Ustad Accounts -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-exclamation-circle text-yellow-500 mr-2"></i>
                    Ustad Menunggu Verifikasi ({{ $pendingVerifications }})
                </h3>
                <a href="{{ route('admin.users.index') }}" class="text-islamic-green hover:text-green-700 text-sm font-medium">
                    Lihat Semua →
                </a>
            </div>
        </div>
        <div class="p-6">
            @if($unverifiedUsers->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Registrasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($unverifiedUsers as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-islamic-green flex items-center justify-center">
                                                    <span class="text-white font-medium">{{ substr($user->name, 0, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ ucfirst($user->role) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <form method="POST" action="{{ route('admin.users.verify', $user->id) }}" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-600 hover:text-green-900" onclick="return confirm('Apakah Anda yakin ingin memverifikasi akun {{ $user->name }}?')">
                                                    <i class="fas fa-check mr-1"></i>Verifikasi
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.users.reject', $user->id) }}" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menolak akun {{ $user->name }}?')">
                                                    <i class="fas fa-times mr-1"></i>Tolak
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-check-circle text-green-400 text-4xl mb-4"></i>
                    <p class="text-gray-500">Tidak ada ustad yang menunggu verifikasi</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-history text-blue-500 mr-2"></i>
                    Aktivitas Terbaru Pengguna
                </h3>
            </div>
            <div class="p-6">
                @if($recentActivities->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentActivities as $activity)
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="h-8 w-8 rounded-full bg-{{ $activity->verification_status === 'verified' ? 'green' : ($activity->verification_status === 'rejected' ? 'red' : 'yellow') }}-100 flex items-center justify-center">
                                        <i class="fas fa-{{ $activity->verification_status === 'verified' ? 'check' : ($activity->verification_status === 'rejected' ? 'times' : 'clock') }} text-{{ $activity->verification_status === 'verified' ? 'green' : ($activity->verification_status === 'rejected' ? 'red' : 'yellow') }}-600 text-xs"></i>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900">
                                        @if($activity->verification_status !== null && $activity->verification_status !== 'verified')
                                            <span class="font-medium">{{ $activity->name }}</span> 
                                            ({{ ucfirst($activity->role) }}) menunggu verifikasi
                                        @else
                                            <span class="font-medium">{{ $activity->name }}</span> 
                                            ({{ ucfirst($activity->role) }}) terverifikasi 
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $activity->updated_at->format('d M Y H:i') }}</p>
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

    <!-- Islamic Quote -->
    <div class="mt-8 bg-gradient-to-r from-islamic-green to-green-600 rounded-lg shadow p-6">
        <div class="text-center text-white">
            <i class="fas fa-quote-left text-2xl mb-4 opacity-75"></i>
            <p class="text-lg mb-2 font-medium text-islamic-green">
                "إِنَّمَا الْأَعْمَالُ بِالنِّيَّاتِ"
            </p>
            <p class="text-sm opacity-90 text-islamic-green">
                "Sesungguhnya amal itu bergantung pada niat." (HR. Bukhari & Muslim)
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