@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto sm:px-6 lg:px-8 px-4">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-download text-islamic-green mr-3"></i>
            Export Data
        </h1>
        <p class="text-gray-600 mt-2">Download data hafalan santri dalam format CSV</p>
    </div>

    <!-- Export Options -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Export Data Santri -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-users text-blue-500 mr-2"></i>
                    Data Santri
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-600 mb-4">Export data lengkap santri beserta progress hafalan mereka.</p>
                <div class="space-y-2 text-sm text-gray-500 mb-6">
                    <p>• Nama lengkap dan informasi kontak</p>
                    <p>• NISN dan kelas</p>
                    <p>• Total submission dan hafalan selesai</p>
                    <p>• Persentase progress hafalan</p>
                </div>
                <a href="{{ route('export.santri') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition duration-150 w-full justify-center">
                    <i class="fas fa-download mr-2"></i>
                    Download Data Santri
                </a>
            </div>
        </div>

        <!-- Export Data Submissions -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-microphone text-green-500 mr-2"></i>
                    Data Submissions
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-600 mb-4">Export data submission hafalan dengan filter tanggal dan status.</p>
                
                <form action="{{ route('export.submissions') }}" method="GET" class="space-y-4">
                    <!-- Filter Tanggal -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Dari Tanggal</label>
                            <input type="date" name="start_date" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-islamic-green focus:border-islamic-green">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                            <input type="date" name="end_date" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-islamic-green focus:border-islamic-green">
                        </div>
                    </div>

                    <!-- Filter Status -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-islamic-green focus:border-islamic-green">
                            <option value="all">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Disetujui</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>

                    <!-- Filter Kelas -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Kelas</label>
                        <select name="kelas" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-islamic-green focus:border-islamic-green">
                            <option value="all">Semua Kelas</option>
                            <option value="X">Kelas X</option>
                            <option value="XI">Kelas XI</option>
                            <option value="XII">Kelas XII</option>
                        </select>
                    </div>

                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition duration-150 w-full justify-center">
                        <i class="fas fa-download mr-2"></i>
                        Download Data Submissions
                    </button>
                </form>
            </div>
        </div>

        <!-- Export Progress Hafalan -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-chart-line text-purple-500 mr-2"></i>
                    Progress Hafalan
                </h3>
            </div>
            <div class="p-6">
                <p class="text-gray-600 mb-4">Export detail progress hafalan setiap santri per surah.</p>
                <div class="space-y-2 text-sm text-gray-500 mb-6">
                    <p>• Status hafalan per surah (Selesai/Belum)</p>
                    <p>• Total hafalan yang sudah selesai</p>
                    <p>• Persentase progress keseluruhan</p>
                    <p>• Data terstruktur untuk analisis</p>
                </div>
                <a href="{{ route('export.progress') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-md hover:bg-purple-700 transition duration-150 w-full justify-center">
                    <i class="fas fa-download mr-2"></i>
                    Download Progress Hafalan
                </a>
            </div>
        </div>

       
    </div>

    <!-- Info Export -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-md p-6">
        <div class="flex">
            <i class="fas fa-info-circle text-blue-400 mr-3 mt-0.5"></i>
            <div>
                <h4 class="text-sm font-medium text-blue-800 mb-2">Informasi Export</h4>
                <div class="text-sm text-blue-700 space-y-1">
                    <p>• File akan didownload dalam format CSV yang dapat dibuka dengan Excel</p>
                    <p>• Encoding UTF-8 mendukung karakter Arab dan Indonesia</p>
                    <p>• Nama file otomatis menyertakan tanggal dan waktu export</p>
                    <p>• Data yang diexport adalah data real-time saat ini</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl font-bold text-blue-600">{{ \App\Models\User::where('role', 'santri')->count() }}</div>
            <div class="text-sm text-gray-600">Total Santri</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl font-bold text-green-600">{{ \App\Models\VoiceSubmission::count() }}</div>
            <div class="text-sm text-gray-600">Total Submission</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl font-bold text-yellow-600">{{ \App\Models\VoiceSubmission::where('status', 'pending')->count() }}</div>
            <div class="text-sm text-gray-600">Pending Review</div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <div class="text-2xl font-bold text-islamic-green">{{ \App\Models\VoiceSubmission::where('status', 'approved')->count() }}</div>
            <div class="text-sm text-gray-600">Hafalan Selesai</div>
        </div>
    </div>
</div>
@endsection