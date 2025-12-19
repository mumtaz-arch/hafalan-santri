@extends('layouts.app')

@section('content')
@if(isset($seoData))
    @section('seoTitle', $seoData['title'])
    @section('seoDescription', $seoData['description'])
@endif
<div class="max-w-4xl mx-auto sm:px-6 lg:px-8 px-4">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-eye text-islamic-green mr-3"></i>
                    Detail Submission
                </h1>
                <p class="text-gray-600 mt-2">{{ $submission->hafalan->nama_surah }} oleh {{ $submission->user->name }}</p>
            </div>
            <a href="{{ route('voice.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-400 transition duration-150">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Submission Details -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-info-circle text-islamic-green mr-2"></i>
                Informasi Submission
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informasi Santri -->
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-3">INFORMASI SANTRI</h4>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            @if($submission->user->profile_photo)
                                <img src="{{ asset('storage/' . $submission->user->profile_photo) }}"
                                     alt="{{ $submission->user->name }}"
                                     class="h-12 w-12 rounded-full object-cover mr-4 border border-islamic-green">
                            @else
                                <div class="h-12 w-12 rounded-full bg-islamic-green flex items-center justify-center mr-4">
                                    <span class="text-white font-medium">{{ substr($submission->user->name, 0, 2) }}</span>
                                </div>
                            @endif
                            <div>
                                <p class="font-medium text-gray-900">{{ $submission->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $submission->user->email }}</p>
                            </div>
                        </div>
                        @if($submission->user->kelas)
                            <div class="flex items-center text-sm">
                                <i class="fas fa-school text-gray-400 mr-2"></i>
                                <span class="text-gray-600">Kelas: {{ $submission->user->kelas }}</span>
                            </div>
                        @endif
                        @if($submission->user->nisn)
                            <div class="flex items-center text-sm">
                                <i class="fas fa-id-card text-gray-400 mr-2"></i>
                                <span class="text-gray-600">NISN: {{ $submission->user->nisn }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Informasi Hafalan -->
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-3">INFORMASI HAFALAN</h4>
                    <div class="space-y-3">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-book-quran text-islamic-green mr-2"></i>
                            <span class="font-medium text-gray-900">{{ $submission->hafalan->nama_surah }}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-list-ol text-gray-400 mr-2"></i>
                            <span class="text-gray-600">Surah ke-{{ $submission->hafalan->nomor_surah }}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-scroll text-gray-400 mr-2"></i>
                            <span class="text-gray-600">{{ $submission->hafalan->jumlah_ayat }} ayat</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-calendar text-gray-400 mr-2"></i>
                            <span class="text-gray-600">{{ $submission->formatted_created_at }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Audio Player -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-volume-up text-islamic-green mr-2"></i>
                Audio Hafalan
            </h3>
        </div>
        <div class="p-6">
            <div class="bg-gray-50 rounded-lg p-6 text-center">
                <i class="fas fa-file-audio text-4xl text-islamic-green mb-4"></i>
                <audio controls class="w-full max-w-md mx-auto">
                    <source src="{{ $submission->voice_url }}" type="audio/mpeg">
                    Browser Anda tidak mendukung audio element.
                </audio>
                <p class="text-sm text-gray-600 mt-3">
                    Klik play untuk mendengar hafalan {{ $submission->hafalan->nama_surah }}
                </p>
            </div>
        </div>
    </div>

    <!-- Status & Review -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-clipboard-check text-islamic-green mr-2"></i>
                Status & Review
            </h3>
        </div>
        <div class="p-6">
            <!-- Status -->
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-500 mb-2">STATUS</h4>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $submission->status_badge['color'] }}">
                    <i class="fas fa-{{ $submission->status === 'approved' ? 'check-circle' : ($submission->status === 'rejected' ? 'times-circle' : 'clock') }} mr-2"></i>
                    {{ $submission->status_badge['text'] }}
                </span>
            </div>

            @if($submission->status !== 'pending')
                <!-- Review Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Reviewer Info -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-3">DIREVIEW OLEH</h4>
                        @if($submission->reviewer)
                            <div class="flex items-center">
                                @if($submission->reviewer->profile_photo)
                                    <img src="{{ asset('storage/' . $submission->reviewer->profile_photo) }}"
                                         alt="{{ $submission->reviewer->name }}"
                                         class="h-10 w-10 rounded-full object-cover mr-3 border-gray-300">
                                @else
                                    <x-user-avatar :user="$submission->reviewer" size="md" class="mr-3" />
                                @endif
                                <div>
                                    <p class="font-medium text-gray-900">{{ $submission->reviewer->prefixed_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $submission->formatted_reviewed_at }}</p>
                                </div>
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">Informasi reviewer tidak tersedia</p>
                        @endif
                    </div>

                    <!-- Score -->
                    @if($submission->score)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-3">NILAI</h4>
                            <div class="flex items-center">
                                <div class="text-3xl font-bold {{ $submission->score >= 80 ? 'text-green-600' : ($submission->score >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $submission->score }}
                                </div>
                                <div class="ml-2">
                                    <div class="text-lg text-gray-500">/100</div>
                                    <div class="text-xs text-gray-400">
                                        @if($submission->score >= 80)
                                            Sangat Baik
                                        @elseif($submission->score >= 60)
                                            Baik
                                        @else
                                            Perlu Perbaikan
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Feedback -->
                @if($submission->feedback)
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-500 mb-3">FEEDBACK</h4>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-900 leading-relaxed">{{ $submission->feedback }}</p>
                        </div>
                    </div>
                @endif
            @else
                <!-- Pending Status -->
                <div class="text-center py-8">
                    <i class="fas fa-clock text-yellow-500 text-4xl mb-4"></i>
                    <h4 class="text-lg font-medium text-gray-900 mb-2">Menunggu Review</h4>
                    <p class="text-gray-600">Submission sedang menunggu review dari ustad</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Actions (for santri) -->
    @if(auth()->user()->role === 'santri' && $submission->user_id === auth()->user()->id && $submission->status === 'pending')
        <div class="mt-8">
            <form method="POST" action="{{ route('voice.destroy', $submission->id) }}" onsubmit="return confirm('Yakin ingin menghapus submission ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition duration-150">
                    <i class="fas fa-trash mr-2"></i>
                    Hapus Submission
                </button>
            </form>
        </div>
    @endif
</div>
@endsection