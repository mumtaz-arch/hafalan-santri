@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto sm:px-6 lg:px-8 px-4">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-user-circle text-islamic-green mr-3"></i>
                    Detail Santri
                </h1>
                <p class="text-gray-600 mt-2">Informasi dan progres hafalan {{ $santri->name }}</p>
            </div>
            <a href="{{ route('santri.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-400 transition duration-150">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <div class="flex">
                <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <div class="flex">
                <i class="fas fa-times-circle mr-2 mt-0.5"></i>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Santri Info -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-info-circle text-islamic-green mr-2"></i>
                Informasi Santri
            </h3>
        </div>
        <div class="p-6">
            <div class="flex flex-col md:flex-row items-center">
                @if($santri->profile_photo)
                    <img src="{{ asset('storage/' . $santri->profile_photo) }}"
                         alt="{{ $santri->name }}"
                         class="h-20 w-20 rounded-full object-cover mr-6 mb-4 md:mb-0 border-2 border-islamic-green">
                @else
                    <div class="h-20 w-20 rounded-full bg-islamic-green flex items-center justify-center mr-6 mb-4 md:mb-0">
                        <span class="text-white font-medium text-2xl">{{ substr($santri->name, 0, 2) }}</span>
                    </div>
                @endif
                <div class="flex-1 text-center md:text-left">
                    <h4 class="text-xl font-bold text-gray-900">{{ $santri->name }}</h4>
                    <p class="text-gray-600">{{ $santri->email }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2">NISN</h4>
                    <p class="text-gray-900">{{ $santri->nisn ?? '-' }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Kelas</h4>
                    <p class="text-gray-900">{{ $santri->kelas ?? 'Tidak diset' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-chart-bar text-islamic-green mr-2"></i>
                Statistik Hafalan
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <div class="text-sm font-medium text-gray-500 mb-1">Total Submit</div>
                    <div class="text-2xl font-bold text-islamic-green">{{ $stats['total_submissions'] }}</div>
                </div>
                <div class="bg-green-50 rounded-lg p-4 text-center">
                    <div class="text-sm font-medium text-green-500 mb-1">Disetujui</div>
                    <div class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</div>
                </div>
                <div class="bg-yellow-50 rounded-lg p-4 text-center">
                    <div class="text-sm font-medium text-yellow-500 mb-1">Pending</div>
                    <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
                </div>
                <div class="bg-red-50 rounded-lg p-4 text-center">
                    <div class="text-sm font-medium text-red-500 mb-1">Ditolak</div>
                    <div class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</div>
                </div>
            </div>

            <!-- Progress Bar -->
            @php
                $totalHafalan = 114; // jumlah surah dalam Al-Qur'an
                $progress = $stats['total_submissions'] > 0 ? round(($stats['approved'] / $totalHafalan) * 100, 1) : 0;
            @endphp
            <div class="mt-6">
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Progres Hafalan</span>
                    <span>{{ $progress }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="bg-islamic-green h-4 rounded-full" style="width: {{ min(100, max(0, $progress)) }}%"></div>
                </div>
                <div class="text-center text-xs text-gray-500 mt-2">
                    {{ $stats['approved'] }} dari {{ $totalHafalan }} surah selesai
                </div>
            </div>
        </div>
    </div>

    <!-- Submission History -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-history text-islamic-green mr-2"></i>
                Riwayat Submission
            </h3>
        </div>
        <div class="p-6">
            @if($submissions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hafalan</th>
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
                                            <i class="fas fa-book-quran text-islamic-green mr-3"></i>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $submission->hafalan->nama_surah }}</div>
                                                <div class="text-sm text-gray-500">Surah ke-{{ $submission->hafalan->nomor_surah }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $submission->formatted_created_at }}
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
                                        <button 
                                            onclick="playAudio('{{ $submission->voice_url }}')"
                                            class="text-blue-600 hover:text-blue-900 inline-flex items-center mr-3"
                                            title="Putar Audio"
                                        >
                                            <i class="fas fa-play mr-1"></i>
                                            Putar
                                        </button>
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
                    <i class="fas fa-book-quran text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Submission</h3>
                    <p class="text-gray-600">Santri ini belum melakukan submission hafalan</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    @if(auth()->user()->isUstad() || auth()->user()->isAdmin())
    <div class="mt-8 flex space-x-4">
        <a href="{{ route('santri.edit', $santri->id) }}" class="inline-flex items-center px-4 py-2 bg-islamic-green text-white text-sm font-medium rounded-md hover:bg-green-700 transition duration-150">
            <i class="fas fa-edit mr-2"></i>
            Edit Santri
        </a>
        <button onclick="resetPassword({{ $santri->id }}, '{{ $santri->name }}')" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded-md hover:bg-yellow-600 transition duration-150">
            <i class="fas fa-key mr-2"></i>
            Reset Password
        </button>
        <button onclick="deleteSantri({{ $santri->id }}, '{{ $santri->name }}')" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition duration-150">
            <i class="fas fa-trash mr-2"></i>
            Hapus Santri
        </button>
    </div>
    @endif
</div>

<!-- Audio Modal -->
<div id="audioModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-volume-up mr-2"></i>
                    Audio Hafalan
                </h3>
                <button onclick="closeAudioModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mt-2">
                <audio id="audioPlayer" controls class="w-full">
                    <source src="" type="audio/mpeg">
                    Browser Anda tidak mendukung audio element.
                </audio>
            </div>
        </div>
    </div>
</div>

<!-- Reset Password Modal -->
<div id="resetPasswordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-key mr-2"></i>
                    Reset Password
                </h3>
                <button onclick="closeResetPasswordModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-4">
                <p class="text-sm text-gray-600" id="resetPasswordInfo"></p>
            </div>
            <div class="flex justify-end space-x-3">
                <button onclick="closeResetPasswordModal()" class="px-4 py-2 bg-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-400 transition duration-150">
                    Batal
                </button>
                <form id="resetPasswordForm" method="POST" action="" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded-md hover:bg-yellow-600 transition duration-150">
                        <i class="fas fa-key mr-1"></i>
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-trash mr-2"></i>
                    Hapus Santri
                </h3>
                <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-4">
                <p class="text-sm text-gray-600" id="deleteInfo"></p>
            </div>
            <div class="flex justify-end space-x-3">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-400 transition duration-150">
                    Batal
                </button>
                <form id="deleteForm" method="POST" action="" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition duration-150">
                        <i class="fas fa-trash mr-1"></i>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Audio player functions
function playAudio(audioUrl) {
    const audioPlayer = document.getElementById('audioPlayer');
    const audioSource = audioPlayer.querySelector('source');
    audioSource.src = audioUrl;
    audioPlayer.load();
    document.getElementById('audioModal').classList.remove('hidden');
}

function closeAudioModal() {
    const audioPlayer = document.getElementById('audioPlayer');
    audioPlayer.pause();
    audioPlayer.currentTime = 0;
    document.getElementById('audioModal').classList.add('hidden');
}

// Reset password functions
function resetPassword(santriId, santriName) {
    const resetPasswordInfo = document.getElementById('resetPasswordInfo');
    const resetPasswordForm = document.getElementById('resetPasswordForm');
    
    resetPasswordInfo.textContent = `Yakin ingin mereset password santri "${santriName}"? Password akan direset ke "santri123".`;
    resetPasswordForm.action = `/santri/${santriId}/reset-password`;
    
    document.getElementById('resetPasswordModal').classList.remove('hidden');
}

function closeResetPasswordModal() {
    document.getElementById('resetPasswordModal').classList.add('hidden');
}

// Delete functions
function deleteSantri(santriId, santriName) {
    const deleteInfo = document.getElementById('deleteInfo');
    const deleteForm = document.getElementById('deleteForm');
    
    deleteInfo.textContent = `Yakin ingin menghapus santri "${santriName}"? Tindakan ini tidak dapat dibatalkan.`;
    deleteForm.action = `/santri/${santriId}`;
    
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modals when clicking outside
window.onclick = function(event) {
    const audioModal = document.getElementById('audioModal');
    const resetPasswordModal = document.getElementById('resetPasswordModal');
    const deleteModal = document.getElementById('deleteModal');
    
    if (event.target === audioModal) {
        closeAudioModal();
    }
    if (event.target === resetPasswordModal) {
        closeResetPasswordModal();
    }
    if (event.target === deleteModal) {
        closeDeleteModal();
    }
}
</script>
@endsection