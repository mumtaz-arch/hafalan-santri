@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto sm:px-6 lg:px-8 px-4">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-user-edit text-islamic-green mr-3"></i>
            Edit Data Santri
        </h1>
        <p class="text-gray-600 mt-2">Edit data santri {{ $santri->name }}</p>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <form method="POST" action="{{ route('santri.update', $santri->id) }}" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" id="name" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-islamic-green focus:border-islamic-green" value="{{ old('name', $santri->name) }}">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-islamic-green focus:border-islamic-green" value="{{ old('email', $santri->email) }}">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="nisn" class="block text-sm font-medium text-gray-700 mb-1">NISN</label>
                    <input type="text" id="nisn" name="nisn" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-islamic-green focus:border-islamic-green" value="{{ old('nisn', $santri->nisn) }}">
                    @error('nisn')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="kelas" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                    <select id="kelas" name="kelas" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-islamic-green focus:border-islamic-green">
                        <option value="">Pilih Kelas</option>
                        <option value="X" {{ old('kelas', $santri->kelas) == 'X' ? 'selected' : '' }}>X</option>
                        <option value="XI" {{ old('kelas', $santri->kelas) == 'XI' ? 'selected' : '' }}>XI</option>
                        <option value="XII" {{ old('kelas', $santri->kelas) == 'XII' ? 'selected' : '' }}>XII</option>
                    </select>
                    @error('kelas')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru (Kosongkan jika tidak ingin ubah)</label>
                    <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-islamic-green focus:border-islamic-green">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('santri.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-400 transition duration-150">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 bg-islamic-green text-white text-sm font-medium rounded-md hover:bg-green-700 transition duration-150">
                        <i class="fas fa-save mr-1"></i>
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection