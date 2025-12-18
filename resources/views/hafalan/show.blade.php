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
                    {{ $hafalan->nama_surah }}
                </h1>
                <p class="text-gray-600 mt-2">Detail hafalan surah ke-{{ $hafalan->nomor_surah }} dengan {{ $hafalan->jumlah_ayat }} ayat</p>
            </div>
            <a href="{{ route('hafalan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-400 transition duration-150">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Hafalan Info -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-info-circle text-islamic-green mr-2"></i>
                Informasi Surah
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm font-medium text-gray-500 mb-1">Nomor Surah</div>
                    <div class="text-2xl font-bold text-islamic-green">{{ $hafalan->nomor_surah }}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm font-medium text-gray-500 mb-1">Jumlah Ayat</div>
                    <div class="text-2xl font-bold text-islamic-green">{{ $hafalan->jumlah_ayat }}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm font-medium text-gray-500 mb-1">Santri Hafal</div>
                    <div class="text-2xl font-bold text-islamic-green">{{ $hafalan->approved_submissions_count }}</div>
                </div>
            </div>
            
            @if($hafalan->keterangan)
                <div class="mt-6">
                    <div class="text-sm font-medium text-gray-500 mb-2">Keterangan</div>
                    <div class="text-gray-900 bg-gray-50 rounded-lg p-4">
                        {{ $hafalan->keterangan }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Submissions -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-users text-islamic-green mr-2"></i>
                Santri yang Telah Menghafal
            </h3>
        </div>
        <div class="p-6">
            @if($submissions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Santri</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Submit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($submissions as $submission)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full bg-islamic-green flex items-center justify-center mr-3">
                                                @if($submission->user->profile_photo)
                                                    <img src="{{ asset('storage/' . $submission->user->profile_photo) }}"
                                                         alt="{{ $submission->user->name }}"
                                                         class="h-10 w-10 rounded-full object-cover border-2 border-islamic-green">
                                                @else
                                                    <span class="text-white font-medium">{{ substr($submission->user->name, 0, 2) }}</span>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $submission->user->name }}</div>
                                                @if($submission->user->kelas)
                                                    <div class="text-sm text-gray-500">Kelas {{ $submission->user->kelas }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $submission->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $submission->status_badge['color'] }}">
                                            {{ $submission->status_badge['text'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($submission->score)
                                            <span class="font-medium text-gray-900">{{ $submission->score }}</span>/100
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('voice.show', $submission->id) }}" class="text-islamic-green hover:text-green-700 inline-flex items-center">
                                            <i class="fas fa-eye mr-1"></i>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $submissions->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-user-graduate text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Santri yang Menghafal</h3>
                    <p class="text-gray-600">Belum ada santri yang menyelesaikan hafalan surah ini</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection