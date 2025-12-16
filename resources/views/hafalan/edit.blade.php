@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-edit text-islamic-green mr-3"></i>
                    Edit Surah
                </h1>
                <p class="text-gray-600 mt-2">Edit informasi surah {{ $hafalan->nama_surah }}</p>
            </div>
            <a href="{{ route('hafalan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-400 transition duration-150">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <div class="flex">
                <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                <div>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="list-disc pl-5 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-book-quran text-islamic-green mr-2"></i>
                Informasi Surah
            </h3>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('hafalan.update', $hafalan->id) }}" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nomor Surah -->
                    <div>
                        <label for="nomor_surah" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-list-ol mr-1"></i>
                            Nomor Surah
                        </label>
                        <input 
                            type="number" 
                            id="nomor_surah" 
                            name="nomor_surah" 
                            value="{{ old('nomor_surah', $hafalan->nomor_surah) }}" 
                            min="1" 
                            max="114"
                            required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-islamic-green focus:border-islamic-green sm:text-sm"
                        >
                        <p class="mt-1 text-xs text-gray-500">Nomor surah dalam Al-Qur'an (1-114)</p>
                    </div>

                    <!-- Jumlah Ayat -->
                    <div>
                        <label for="jumlah_ayat" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-sort-numeric-up mr-1"></i>
                            Jumlah Ayat
                        </label>
                        <input 
                            type="number" 
                            id="jumlah_ayat" 
                            name="jumlah_ayat" 
                            value="{{ old('jumlah_ayat', $hafalan->jumlah_ayat) }}" 
                            min="1" 
                            required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-islamic-green focus:border-islamic-green sm:text-sm"
                        >
                    </div>
                </div>

                <!-- Nama Surah -->
                <div>
                    <label for="nama_surah" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-heading mr-1"></i>
                        Nama Surah
                    </label>
                        <input 
                        type="text" 
                        id="nama_surah" 
                        name="nama_surah" 
                        value="{{ old('nama_surah', $hafalan->nama_surah) }}" 
                        required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-islamic-green focus:border-islamic-green sm:text-sm"
                        placeholder="Contoh: Al-Fatihah, Al-Baqarah, dll."
                    >
                </div>

                <!-- Keterangan -->
                <div>
                    <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-comment mr-1"></i>
                        Keterangan (Opsional)
                    </label>
                    <textarea 
                        id="keterangan" 
                        name="keterangan" 
                        rows="4"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-islamic-green focus:border-islamic-green sm:text-sm"
                        placeholder="Tambahkan keterangan atau catatan khusus tentang surah ini..."
                    >{{ old('keterangan', $hafalan->keterangan) }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button 
                        type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-islamic-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-islamic-green focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <i class="fas fa-save mr-2"></i>
                        Update Surah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection