@extends('layouts.app')

@section('content')
@if(isset($seoData))
    @section('seoTitle', $seoData['title'])
    @section('seoDescription', $seoData['description'])
    @section('seoKeywords', $seoData['keywords'])
@endif

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-book-quran text-islamic-green mr-3"></i>
                    Daftar Surah Al-Qur'an
                </h1>
                <p class="text-gray-600 mt-2">Daftar lengkap surah Al-Qur'an yang tersedia untuk hafalan santri</p>
            </div>
            @if(auth()->user()->isUstad())
                <a href="{{ route('hafalan.create') }}" class="inline-flex items-center px-4 py-2 bg-islamic-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-islamic-green focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Surah
                </a>
            @endif
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 alert-auto-hide">
            <div class="flex">
                <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 alert-auto-hide">
            <div class="flex">
                <i class="fas fa-times-circle mr-2 mt-0.5"></i>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Hafalan Table -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-list mr-2"></i>
                Surah Al-Qur'an
            </h3>
        </div>
        <div class="p-6">
            @if($hafalans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Surah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Ayat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Santri Hafal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($hafalans as $hafalan)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $hafalan->nomor_surah }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $hafalan->nama_surah }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $hafalan->jumlah_ayat }} ayat
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $hafalan->approved_submissions_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('hafalan.show', $hafalan->id) }}" class="text-islamic-green hover:text-green-700 inline-flex items-center">
                                            <i class="fas fa-eye mr-1"></i>
                                            Detail
                                        </a>
                                        @if(auth()->user()->isUstad())
                                            <a href="{{ route('hafalan.edit', $hafalan->id) }}" class="text-blue-600 hover:text-blue-900 inline-flex items-center">
                                                <i class="fas fa-edit mr-1"></i>
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('hafalan.destroy', $hafalan->id) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus surah ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 inline-flex items-center">
                                                    <i class="fas fa-trash mr-1"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $hafalans->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-book-quran text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Surah</h3>
                    <p class="text-gray-600 mb-4">Belum ada surah Al-Qur'an yang ditambahkan ke sistem</p>
                    @if(auth()->user()->isUstad())
                        <a href="{{ route('hafalan.create') }}" class="inline-flex items-center px-4 py-2 bg-islamic-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-islamic-green focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Surah Pertama
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection