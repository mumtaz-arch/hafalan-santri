@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 to-green-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto h-20 w-20 bg-islamic-green rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-unlock text-white text-3xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">
                Hafalan Santri
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Madrasah Aliyah Kejuruan Negeri Ende
            </p>
            <p class="text-lg font-semibold text-islamic-green mt-1">Reset Kata Sandi</p>
        </div>

        <!-- Reset Password Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <!-- Alert Messages -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                <p class="text-sm">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <div class="flex">
                        <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-envelope mr-1"></i>
                        Email
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        required
                        value="{{ old('email') }}"
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-islamic-green focus:border-islamic-green focus:z-10 sm:text-sm @error('email') border-red-300 @enderror"
                        placeholder="Masukkan email"
                    >
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-lock mr-1"></i>
                        Kata Sandi Baru
                    </label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-islamic-green focus:border-islamic-green focus:z-10 sm:text-sm @error('password') border-red-300 @enderror"
                        placeholder="Masukkan kata sandi baru"
                    >
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-lock mr-1"></i>
                        Konfirmasi Kata Sandi Baru
                    </label>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        required
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-islamic-green focus:border-islamic-green focus:z-10 sm:text-sm @error('password_confirmation') border-red-300 @enderror"
                        placeholder="Konfirmasi kata sandi baru"
                    >
                </div>

                <!-- Submit Button -->
                <div>
                    <button
                        type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-islamic-green hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-islamic-green transition duration-150 ease-in-out"
                    >
                        <i class="fas fa-sync-alt mr-2"></i>
                        Reset Kata Sandi
                    </button>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <span class="text-sm text-gray-600">Ingin kembali ke login?</span>
                    <a href="{{ route('login') }}" class="font-medium text-islamic-green hover:text-green-700 ml-1">
                        Kembali ke login
                    </a>
                </div>
            </form>
        </div>

        <!-- Islamic Quote -->
        <div class="text-center">
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-islamic-green">
                <p class="text-sm text-gray-600 italic">
                    "وَقُلْ رَبِّ زِدْنِي عِلْمًا"
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    "Dan katakanlah: Ya Tuhanku, tambahkanlah kepadaku ilmu pengetahuan." (QS. Taha: 114)
                </p>
            </div>
        </div>
    </div>
</div>
@endsection