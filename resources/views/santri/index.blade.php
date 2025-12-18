@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-users text-islamic-green mr-3"></i>
                    Kelola Data Santri
                </h1>
                <p class="text-gray-600 mt-2">Manajemen data santri MAKN Ende</p>
            </div>
            <a href="{{ route('santri.create') }}" class="inline-flex items-center px-4 py-2 bg-islamic-green text-white text-sm font-medium rounded-md hover:bg-green-700 transition duration-150">
                <i class="fas fa-plus mr-2"></i>
                Tambah Santri
            </a>
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

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center">
                    <input type="text" id="searchSantri" placeholder="Cari nama santri..." class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-islamic-green focus:border-islamic-green">
                </div>
                <div class="flex items-center">
                    <select id="filterKelas" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-islamic-green focus:border-islamic-green">
                        <option value="">Semua Kelas</option>
                        <option value="X">Kelas X</option>
                        <option value="XI">Kelas XI</option>
                        <option value="XII">Kelas XII</option>
                    </select>
                </div>
                <button onclick="filterSantri()" class="px-4 py-2 bg-islamic-green text-white text-sm rounded-md hover:bg-green-700 transition duration-150">
                    <i class="fas fa-search mr-1"></i> Filter
                </button>
                <button onclick="resetFilter()" class="px-4 py-2 bg-gray-300 text-gray-700 text-sm rounded-md hover:bg-gray-400 transition duration-150">
                    <i class="fas fa-undo mr-1"></i> Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-table text-islamic-green mr-2"></i>
                Daftar Santri ({{ $santris->total() }})
            </h3>
        </div>
        <div class="p-6">
            @if($santris->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Santri</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submission</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="santriTable">
                            @foreach($santris as $santri)
                                <tr class="hover:bg-gray-50 santri-row" 
                                    data-name="{{ strtolower($santri->name) }}" 
                                    data-kelas="{{ $santri->kelas }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                @if($santri->profile_photo)
                                                    <img src="{{ asset('storage/' . $santri->profile_photo) }}"
                                                         alt="{{ $santri->name }}"
                                                         class="h-12 w-12 rounded-full object-cover border-2 border-islamic-green">
                                                @else
                                                    <div class="h-12 w-12 rounded-full bg-islamic-green flex items-center justify-center">
                                                        <span class="text-white font-medium">{{ substr($santri->name, 0, 2) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $santri->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $santri->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $santri->nisn ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $santri->kelas ?? 'Tidak diset' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex items-center space-x-4">
                                            <span class="text-gray-900 font-medium">{{ $santri->voice_submissions_count }}</span>
                                            <span class="text-green-600">{{ $santri->approved_count }} selesai</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $totalHafalan = 114; // atau sesuai jumlah hafalan di database
                                            $progress = $santri->approved_count > 0 ? round(($santri->approved_count / $totalHafalan) * 100, 1) : 0;
                                        @endphp
                                        <div class="flex items-center">
                                            <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                                <div class="bg-islamic-green h-2 rounded-full" style="width: {{ $progress }}%"></div>
                                            </div>
                                            <span class="text-sm text-gray-600">{{ $progress }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('santri.show', $santri->id) }}" class="text-blue-600 hover:text-blue-900" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('santri.edit', $santri->id) }}" class="text-islamic-green hover:text-green-700" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="resetPassword({{ $santri->id }}, '{{ $santri->name }}')" class="text-yellow-600 hover:text-yellow-900" title="Reset Password">
                                            <i class="fas fa-key"></i>
                                        </button>
                                        <button onclick="deleteSantri({{ $santri->id }}, '{{ $santri->name }}')" class="text-red-600 hover:text-red-900" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $santris->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-users text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Data Santri</h3>
                    <p class="text-gray-600 mb-4">Tambahkan data santri untuk memulai</p>
                    <a href="{{ route('santri.create') }}" class="inline-flex items-center px-4 py-2 bg-islamic-green text-white text-sm font-medium rounded-md hover:bg-green-700 transition duration-150">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Santri Pertama
                    </a>
                </div>
            @endif
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
// Filter functions
function filterSantri() {
    const searchTerm = document.getElementById('searchSantri').value.toLowerCase();
    const kelasFilter = document.getElementById('filterKelas').value;
    const rows = document.querySelectorAll('.santri-row');
    
    rows.forEach(row => {
        const name = row.dataset.name;
        const kelas = row.dataset.kelas;
        
        let showRow = true;
        
        if (searchTerm && !name.includes(searchTerm)) {
            showRow = false;
        }
        
        if (kelasFilter && kelas !== kelasFilter) {
            showRow = false;
        }
        
        row.style.display = showRow ? '' : 'none';
    });
}

function resetFilter() {
    document.getElementById('searchSantri').value = '';
    document.getElementById('filterKelas').value = '';
    filterSantri();
}

// Real-time search
document.getElementById('searchSantri').addEventListener('input', filterSantri);
document.getElementById('filterKelas').addEventListener('change', filterSantri);

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
    const resetPasswordModal = document.getElementById('resetPasswordModal');
    const deleteModal = document.getElementById('deleteModal');
    
    if (event.target === resetPasswordModal) {
        closeResetPasswordModal();
    }
    if (event.target === deleteModal) {
        closeDeleteModal();
    }
}
</script>
@endsection