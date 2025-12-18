@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-users text-blue-600 mr-3"></i>
            Manajemen Pengguna
        </h1>
        <p class="text-gray-600 mt-2">Kelola semua pengguna dalam sistem MAKN Ende</p>
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
                    <p class="text-2xl font-bold text-gray-900">{{ $users->count() }}</p>
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
                    <p class="text-2xl font-bold text-gray-900">{{ $users->where('role', 'santri')->count() }}</p>
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
                    <p class="text-2xl font-bold text-gray-900">{{ $users->where('role', 'ustad')->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Total Admin -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 mr-4">
                    <i class="fas fa-crown text-purple-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Admin</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $users->where('role', 'admin')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-list text-blue-500 mr-2"></i>
                Daftar Semua Pengguna
            </h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Verifikasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Registrasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($user->profile_photo)
                                                <img src="{{ asset('storage/' . $user->profile_photo) }}"
                                                     alt="{{ $user->name }}"
                                                     class="h-10 w-10 rounded-full object-cover border-2 border-islamic-green">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-islamic-green flex items-center justify-center">
                                                    <span class="text-white font-medium">{{ substr($user->name, 0, 2) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            @if($user->nisn)
                                                <div class="text-sm text-gray-500">NISN: {{ $user->nisn }}</div>
                                            @endif
                                            @if($user->kelas)
                                                <div class="text-sm text-gray-500">Kelas: {{ $user->kelas }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $user->role === 'santri' ? 'bg-green-100 text-green-800' : 
                                           ($user->role === 'ustad' ? 'bg-orange-100 text-orange-800' : 
                                           'bg-purple-100 text-purple-800') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->role === 'ustad')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $user->verification_status === 'verified' ? 'bg-green-100 text-green-800' : 
                                               ($user->verification_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($user->verification_status) }}
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Tidak Perlu
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($user->role === 'ustad' && $user->verification_status === 'pending')
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
                                    @elseif($user->role === 'ustad' && $user->verification_status !== 'pending')
                                        <div class="flex space-x-2">
                                            <form method="POST" action="{{ route('admin.users.reset-verification', $user->id) }}" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-yellow-600 hover:text-yellow-900" onclick="return confirm('Apakah Anda yakin ingin mereset verifikasi akun {{ $user->name }}?')">
                                                    <i class="fas fa-redo mr-1"></i>Reset
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                    <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
                                    <p>Belum ada pengguna dalam sistem</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Islamic Quote -->
    <div class="mt-8 bg-gradient-to-r from-islamic-green to-green-600 rounded-lg shadow p-6 text-white">
        <div class="text-center">
            <i class="fas fa-quote-left text-2xl mb-4 opacity-75"></i>
            <p class="text-lg mb-2 font-medium">
                "إِنَّمَا الْمُؤْمِنُونَ إِخْوَةٌ"
            </p>
            <p class="text-sm opacity-90">
                "Sesungguhnya orang-orang mukmin itu bersaudara." (QS. Al-Hujurat: 10)
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