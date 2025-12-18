@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 to-green-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="mx-auto h-20 w-20 bg-islamic-green rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-mosque text-white text-3xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">
                Hafalan Santri
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Madrasah Aliyah Kejuruan Negeri Ende
            </p>
            <p class="text-lg font-semibold text-islamic-green mt-1">Daftar Akun</p>
        </div>

        <!-- Register Form -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <!-- Alert Messages -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 alert-auto-hide">
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

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                
                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-user mr-1"></i>
                        Nama Lengkap
                    </label>
                    <input 
                        id="name" 
                        name="name" 
                        type="text" 
                        required 
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-islamic-green focus:border-islamic-green focus:z-10 sm:text-sm @error('name') border-red-300 @enderror" 
                        placeholder="Masukkan nama lengkap"
                        value="{{ old('name') }}"
                    >
                </div>

                <!-- Email -->
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
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-islamic-green focus:border-islamic-green focus:z-10 sm:text-sm @error('email') border-red-300 @enderror" 
                        placeholder="Masukkan email"
                        value="{{ old('email') }}"
                    >
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-user-tag mr-1"></i>
                        Sebagai
                    </label>
                    <select 
                        id="role" 
                        name="role" 
                        required 
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-islamic-green focus:border-islamic-green focus:z-10 sm:text-sm @error('role') border-red-300 @enderror"
                        onchange="toggleSantriFields()"
                    >
                        <option value="">Pilih Role</option>
                        <option value="santri" {{ old('role') == 'santri' ? 'selected' : '' }}>Santri</option>
                        <option value="ustad" {{ old('role') == 'ustad' ? 'selected' : '' }}>Ustad</option>
                    </select>
                </div>

                <!-- NISN (untuk santri) -->
                <div id="nisn-field" class="hidden">
                    <label for="nisn" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-id-card mr-1"></i>
                        NISN
                    </label>
                    <input 
                        id="nisn" 
                        name="nisn" 
                        type="text" 
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-islamic-green focus:border-islamic-green focus:z-10 sm:text-sm @error('nisn') border-red-300 @enderror" 
                        placeholder="Masukkan NISN"
                        value="{{ old('nisn') }}"
                    >
                </div>

                <!-- Kelas (untuk santri) -->
                <div id="kelas-field" class="hidden">
                    <label for="kelas" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-school mr-1"></i>
                        Kelas
                    </label>
                    <select 
                        id="kelas" 
                        name="kelas" 
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-islamic-green focus:border-islamic-green focus:z-10 sm:text-sm @error('kelas') border-red-300 @enderror"
                    >
                        <option value="">Pilih Kelas</option>
                        <option value="X" {{ old('kelas') == 'X' ? 'selected' : '' }}>X</option>
                        <option value="XI" {{ old('kelas') == 'XI' ? 'selected' : '' }}>XI</option>
                        <option value="XII" {{ old('kelas') == 'XII' ? 'selected' : '' }}>XII</option>
                    </select>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-lock mr-1"></i>
                        Password
                    </label>
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        required 
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-islamic-green focus:border-islamic-green focus:z-10 sm:text-sm @error('password') border-red-300 @enderror" 
                        placeholder="Masukkan password (min. 6 karakter)"
                    >
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-lock mr-1"></i>
                        Konfirmasi Password
                    </label>
                    <input 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        type="password" 
                        required 
                        class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-islamic-green focus:border-islamic-green focus:z-10 sm:text-sm" 
                        placeholder="Ulangi password"
                    >
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button
                        type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-islamic-green hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-islamic-green transition duration-150 ease-in-out"
                    >
                        <i class="fas fa-user-plus mr-2"></i>
                        Daftar
                    </button>
                </div>

                <!-- Verification Information -->
                <div id="verification-info" class="hidden bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded text-sm text-yellow-700 mt-4">
                    <p><i class="fas fa-exclamation-circle mr-1"></i> <strong>Catatan:</strong> Jika Anda mendaftar sebagai Ustad, akun Anda akan menunggu verifikasi oleh admin sebelum dapat digunakan secara penuh.</p>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <span class="text-sm text-gray-600">Sudah punya akun?</span>
                    <a href="{{ route('login') }}" class="font-medium text-islamic-green hover:text-green-700 ml-1">
                        Login di sini
                    </a>
                </div>
            </form>
        </div>

        <!-- Islamic Quote -->
        <div class="text-center">
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-islamic-green">
                <p class="text-sm text-gray-600 italic">
                    "طَلَبُ الْعِلْمِ فَرِيضَةٌ عَلَى كُلِّ مُسْلِمٍ"
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    "Menuntut ilmu adalah kewajiban atas setiap muslim." (HR. Ibnu Majah)
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function toggleSantriFields() {
    const role = document.getElementById('role').value;
    const nisnField = document.getElementById('nisn-field');
    const kelasField = document.getElementById('kelas-field');
    const verificationInfo = document.getElementById('verification-info');

    if (role === 'santri') {
        nisnField.classList.remove('hidden');
        kelasField.classList.remove('hidden');
        verificationInfo.classList.add('hidden');
    } else if (role === 'ustad') {
        nisnField.classList.add('hidden');
        kelasField.classList.add('hidden');
        verificationInfo.classList.remove('hidden');
        // Clear values when hidden
        document.getElementById('nisn').value = '';
        document.getElementById('kelas').value = '';
    } else {
        nisnField.classList.add('hidden');
        kelasField.classList.add('hidden');
        verificationInfo.classList.add('hidden');
        // Clear values when hidden
        document.getElementById('nisn').value = '';
        document.getElementById('kelas').value = '';
    }
}

// Check on page load if role is already selected
document.addEventListener('DOMContentLoaded', function() {
    toggleSantriFields();
});
</script>
@endsection