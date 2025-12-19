@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto sm:px-6 lg:px-8 px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-user-circle text-islamic-green mr-3"></i>
            Profil Saya
        </h1>
        <p class="text-gray-600 mt-2">Kelola informasi profil dan foto profil Anda</p>
    </div>

    <!-- Alert Messages -->
    @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Terjadi Kesalahan</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 rounded-lg p-4 alert-auto-hide">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 rounded-lg p-4 alert-auto-hide">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-times-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="bg-white rounded-lg shadow">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Profile Photo Section -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">
                    <i class="fas fa-image text-islamic-green mr-2"></i>
                    Foto Profil
                </h3>

                <div class="flex items-center space-x-6">
                    <!-- Current Photo -->
                    <div class="flex-shrink-0">
                        @if($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                 alt="{{ $user->name }}" 
                                 class="h-32 w-32 rounded-full object-cover border border-islamic-green">
                        @else
                            <div class="h-32 w-32 rounded-full bg-gray-200 flex items-center justify-center border-4 border-gray-300">
                                <x-user-avatar :user="$user" size="xl" />
                            </div>
                        @endif
                    </div>

                    <!-- Upload Section -->
                    <div class="flex-1">
                        <div class="mb-4">
                            <label for="profile_photo" class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih Foto Profil
                            </label>
                            <div class="relative">
                                <input type="file" 
                                       name="profile_photo" 
                                       id="profile_photo" 
                                       accept="image/*"
                                       class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 focus:outline-none focus:border-islamic-green"
                                       onchange="previewImage(this)">
                                <p class="text-xs text-gray-500 mt-2">
                                    Format: JPG, PNG, GIF (Maksimal 2MB)
                                </p>
                            </div>
                        </div>

                        <!-- Image Preview -->
                        <div id="imagePreview" class="hidden mt-4">
                            <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                            <img id="previewImg" src="" alt="Preview" class="h-32 w-32 rounded-lg object-cover border-2 border-islamic-green">
                        </div>

                        <!-- Delete Photo Button -->
                        @if($user->profile_photo)
                            <form action="{{ route('profile.deletePhoto') }}" method="POST" class="mt-4 inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-2 bg-red-50 text-red-700 text-sm font-medium rounded-md hover:bg-red-100 transition duration-150"
                                        onclick="return confirm('Yakin ingin menghapus foto profil?')">
                                    <i class="fas fa-trash mr-2"></i>
                                    Hapus Foto
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Personal Information Section -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">
                    <i class="fas fa-info-circle text-islamic-green mr-2"></i>
                    Informasi Pribadi
                </h3>

                <div class="space-y-6">
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $user->name) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-islamic-green focus:ring-2 focus:ring-green-100"
                               placeholder="Masukkan nama lengkap"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email', $user->email) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-islamic-green focus:ring-2 focus:ring-green-100"
                               placeholder="Masukkan email"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Additional Information Section -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">
                    <i class="fas fa-details text-islamic-green mr-2"></i>
                    Informasi Tambahan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Role / Peran
                        </label>
                        <div class="px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                            <p class="text-gray-900 font-medium capitalize">
                                @if($user->role === 'santri')
                                    <i class="fas fa-graduation-cap text-islamic-green mr-2"></i>Santri
                                @elseif($user->role === 'ustad')
                                    <i class="fas fa-chalkboard-user text-islamic-green mr-2"></i>Ustad
                                @elseif($user->role === 'admin')
                                    <i class="fas fa-shield-alt text-islamic-green mr-2"></i>Admin
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- NISN (if santri) -->
                    @if($user->role === 'santri')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                NISN
                            </label>
                            <div class="px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                                <p class="text-gray-900">{{ $user->nisn ?? '-' }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Kelas (if santri) -->
                    @if($user->role === 'santri' && $user->kelas)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kelas
                            </label>
                            <div class="px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                                <p class="text-gray-900">{{ $user->kelas }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Member Since -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Bergabung Sejak
                        </label>
                        <div class="px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg">
                            <p class="text-gray-900">{{ $user->created_at->locale('id')->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="p-6 bg-gray-50 rounded-b-lg flex justify-between items-center">
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-900 font-medium rounded-lg hover:bg-gray-400 transition duration-150">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
                <button type="submit"
                        class="inline-flex items-center px-6 py-2 bg-islamic-green text-white font-medium rounded-lg hover:bg-green-700 transition duration-150">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Password Change Section -->
    <div class="mt-8 bg-white rounded-lg shadow">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">
                <i class="fas fa-key text-islamic-green mr-2"></i>
                Ubah Password
            </h3>

            <form action="{{ route('profile.change-password') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Current Password Field -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password Saat Ini
                        </label>
                        <input type="password"
                               name="current_password"
                               id="current_password"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-islamic-green focus:ring-2 focus:ring-green-100"
                               placeholder="Masukkan password saat ini"
                               required>
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password Field -->
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password Baru
                        </label>
                        <input type="password"
                               name="new_password"
                               id="new_password"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-islamic-green focus:ring-2 focus:ring-green-100"
                               placeholder="Masukkan password baru (minimal 8 karakter)"
                               required>
                        @error('new_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm New Password Field -->
                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password Baru
                        </label>
                        <input type="password"
                               name="new_password_confirmation"
                               id="new_password_confirmation"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-islamic-green focus:ring-2 focus:ring-green-100"
                               placeholder="Konfirmasi password baru"
                               required>
                    </div>

                    <!-- Password Strength Indicator -->
                    <div class="pt-2">
                        <small class="text-gray-600">
                            Password harus memiliki setidaknya 8 karakter dan mencakup huruf besar, huruf kecil, angka, dan simbol.
                        </small>
                    </div>
                </div>

                <!-- Password Change Button -->
                <div class="mt-6">
                    <button type="submit"
                            class="inline-flex items-center px-6 py-2 bg-islamic-green text-white font-medium rounded-lg hover:bg-green-700 transition duration-150">
                        <i class="fas fa-key mr-2"></i>
                        Ganti Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Image Preview Script -->
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewDiv = document.getElementById('imagePreview');
                const previewImg = document.getElementById('previewImg');
                previewImg.src = e.target.result;
                previewDiv.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
