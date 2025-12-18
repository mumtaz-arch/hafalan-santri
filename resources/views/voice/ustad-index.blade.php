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
        <h1 class="text-3xl font-bold text-gray-900">
            <i class="fas fa-tasks text-islamic-green mr-3"></i>
            Review Hafalan Santri
        </h1>
        <p class="text-gray-600 mt-2">Kelola dan review submission hafalan Al-Qur'an santri</p>
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

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center">
                    <span class="text-sm font-medium text-gray-700 mr-3">Filter Status:</span>
                    <select id="statusFilter" class="border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-islamic-green focus:border-islamic-green">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Disetujui</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
                <div class="flex items-center">
                    <span class="text-sm font-medium text-gray-700 mr-3">Filter Santri:</span>
                    <input type="text" id="santriFilter" placeholder="Nama santri..." class="border border-gray-300 rounded-md px-3 py-1 text-sm focus:outline-none focus:ring-islamic-green focus:border-islamic-green">
                </div>
                <button onclick="applyFilters()" class="px-4 py-1 bg-islamic-green text-white text-sm rounded-md hover:bg-green-700 transition duration-150">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                <button onclick="resetFilters()" class="px-4 py-1 bg-gray-300 text-gray-700 text-sm rounded-md hover:bg-gray-400 transition duration-150">
                    <i class="fas fa-undo mr-1"></i> Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Submissions Table -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-list text-islamic-green mr-2"></i>
                Daftar Submission Hafalan
            </h3>
        </div>
        <div class="p-6">
            @if($submissions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Santri</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hafalan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Submit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="submissionsTable">
                            @foreach($submissions as $submission)
                                <tr class="hover:bg-gray-50 submission-row" 
                                    data-status="{{ $submission->status }}" 
                                    data-santri="{{ strtolower($submission->user->name) }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($submission->user->profile_photo)
                                                    <img src="{{ asset('storage/' . $submission->user->profile_photo) }}"
                                                         alt="{{ $submission->user->name }}"
                                                         class="h-10 w-10 rounded-full object-cover border border-islamic-green">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-islamic-green flex items-center justify-center">
                                                        <span class="text-white font-medium text-sm">{{ substr($submission->user->name, 0, 2) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $submission->user->name }}</div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $submission->user->kelas ?? 'Kelas tidak diset' }}
                                                    @if($submission->user->nisn)
                                                        • NISN: {{ $submission->user->nisn }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $submission->hafalan->nama_surah }}</div>
                                        <div class="text-sm text-gray-500">Surah {{ $submission->hafalan->nomor_surah }} • {{ $submission->hafalan->jumlah_ayat }} ayat</div>
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <!-- Play Audio -->
                                        <button
                                            onclick="playAudio({{ json_encode($submission->voice_url) }}, {{ json_encode($submission->user->name) }}, {{ json_encode($submission->hafalan->nama_surah) }})"
                                            class="text-blue-600 hover:text-blue-900 inline-flex items-center"
                                            title="Putar Audio"
                                        >
                                            <i class="fas fa-play mr-1"></i>
                                        </button>

                                        <!-- Review (only for pending) -->
                                        @if($submission->status === 'pending')
                                            <button
                                                onclick="openReviewModal({{ $submission->id }}, {{ json_encode($submission->user->name) }}, {{ json_encode($submission->hafalan->nama_surah) }})"
                                                class="text-islamic-green hover:text-green-700 inline-flex items-center"
                                                title="Review"
                                            >
                                                <i class="fas fa-clipboard-check mr-1"></i>
                                            </button>
                                        @else
                                            <!-- View Review -->
                                            <button
                                                onclick="viewReview({{ $submission->id }})"
                                                class="text-gray-600 hover:text-gray-900 inline-flex items-center"
                                                title="Lihat Review"
                                            >
                                                <i class="fas fa-eye mr-1"></i>
                                            </button>
                                        @endif
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
                    <i class="fas fa-clipboard-list text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Submission</h3>
                    <p class="text-gray-600">Belum ada submission hafalan dari santri</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Audio Player Modal -->
<div id="audioModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-volume-up mr-2"></i>
                    Audio Hafalan
                </h3>
                <button onclick="closeAudioModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-4">
                <p class="text-sm text-gray-600" id="audioInfo"></p>
            </div>
            <div class="text-center">
                <audio id="audioPlayer" controls class="w-full mb-4">
                    <source src="" type="audio/mpeg">
                    Browser Anda tidak mendukung audio element.
                </audio>
                <button onclick="closeAudioModal()" class="px-4 py-2 bg-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-400 transition duration-150">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Review Modal -->
<div id="reviewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-10 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-clipboard-check mr-2"></i>
                    Review Hafalan
                </h3>
                <button onclick="closeReviewModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="mb-4">
                <p class="text-sm text-gray-600" id="reviewInfo"></p>
            </div>

            <form id="reviewForm" method="POST" action="">
                @csrf
                @method('PATCH')
                
                <!-- Status -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-check-circle mr-1"></i>
                        Status Review
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="status" value="approved" class="h-4 w-4 text-islamic-green focus:ring-islamic-green border-gray-300" required>
                            <span class="ml-2 text-sm text-gray-700">Disetujui</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="status" value="rejected" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300" required>
                            <span class="ml-2 text-sm text-gray-700">Ditolak</span>
                        </label>
                    </div>
                </div>

                <!-- Score -->
                <div class="mb-4">
                    <label for="score" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-star mr-1"></i>
                        Nilai (0-100)
                    </label>
                    <input 
                        type="number" 
                        id="score" 
                        name="score" 
                        min="0" 
                        max="100" 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-islamic-green focus:border-islamic-green sm:text-sm"
                        placeholder="Masukkan nilai"
                    >
                </div>

                <!-- Feedback -->
                <div class="mb-6">
                    <label for="feedback" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-comment mr-1"></i>
                        Feedback
                    </label>
                    <textarea 
                        id="feedback" 
                        name="feedback" 
                        rows="4" 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-islamic-green focus:border-islamic-green sm:text-sm"
                        placeholder="Berikan feedback untuk santri..."
                    ></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3">
                    <button 
                        type="button" 
                        onclick="closeReviewModal()" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-400 transition duration-150"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-islamic-green text-white text-sm font-medium rounded-md hover:bg-green-700 transition duration-150"
                    >
                        <i class="fas fa-save mr-1"></i>
                        Simpan Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Audio player functions
    window.playAudio = function(audioUrl, santriName, surahName) {
        try {
            const audioPlayer = document.getElementById('audioPlayer');
            const audioSource = audioPlayer.querySelector('source');
            const audioInfo = document.getElementById('audioInfo');

            if (!audioPlayer || !audioSource || !audioInfo) {
                console.error('Audio elements not found');
                return;
            }

            audioSource.src = audioUrl;
            audioPlayer.load();
            audioInfo.textContent = `Hafalan ${surahName} oleh ${santriName}`;

            document.getElementById('audioModal').classList.remove('hidden');
        } catch (error) {
            console.error('Error in playAudio function:', error);
        }
    }

    window.closeAudioModal = function() {
        try {
            const audioPlayer = document.getElementById('audioPlayer');
            if (audioPlayer) {
                audioPlayer.pause();
                audioPlayer.currentTime = 0;
            }
            document.getElementById('audioModal').classList.add('hidden');
        } catch (error) {
            console.error('Error in closeAudioModal function:', error);
        }
    }

    // Review modal functions
    window.openReviewModal = function(submissionId, santriName, surahName) {
        try {
            const reviewInfo = document.getElementById('reviewInfo');
            const reviewForm = document.getElementById('reviewForm');

            if (!reviewInfo || !reviewForm) {
                console.error('Review modal elements not found');
                return;
            }

            reviewInfo.textContent = `Review hafalan ${surahName} oleh ${santriName}`;
            reviewForm.action = `/voice-submission/${submissionId}/review`;

            // Reset form
            reviewForm.reset();

            document.getElementById('reviewModal').classList.remove('hidden');
        } catch (error) {
            console.error('Error in openReviewModal function:', error);
        }
    }

    window.closeReviewModal = function() {
        try {
            document.getElementById('reviewModal').classList.add('hidden');
        } catch (error) {
            console.error('Error in closeReviewModal function:', error);
        }
    }

    window.viewReview = function(submissionId) {
        try {
            // Redirect to the submission detail page
            window.location.href = '/voice-submission/' + submissionId;
        } catch (error) {
            console.error('Error in viewReview function:', error);
        }
    }

    // Handle review form submission with AJAX
    const reviewForm = document.getElementById('reviewForm');

    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Add the _method hidden field to make it a PATCH request
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PATCH';
            reviewForm.appendChild(methodField);

            const formData = new FormData(reviewForm);
            const actionUrl = reviewForm.action;

            // Remove the temporary method field after creating FormData
            reviewForm.removeChild(methodField);

            // Show loading state
            const submitButton = reviewForm.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Memproses...';
            submitButton.disabled = true;

            fetch(actionUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showMessage(data.message, 'success');

                    // Close modal and refresh the page
                    closeReviewModal();
                    location.reload();
                } else {
                    // Show error message
                    showMessage(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('Terjadi kesalahan saat menyimpan review. Silakan coba lagi.', 'error');
            })
            .finally(() => {
                // Restore button state
                submitButton.innerHTML = originalButtonText;
                submitButton.disabled = false;
            });
        });
    }

    // Other functions that should be available globally
    window.showMessage = function(message, type) {
        try {
            // Remove existing messages
            const existingAlert = document.querySelector('.alert-auto-hide');
            if (existingAlert) {
                existingAlert.remove();
            }

            // Create message element
            const alertDiv = document.createElement('div');
            alertDiv.className = `bg-${type === 'error' ? 'red' : 'green'}-100 border border-${type === 'error' ? 'red' : 'green'}-400 text-${type === 'error' ? 'red' : 'green'}-700 px-4 py-3 rounded mb-6 alert-auto-hide`;
            alertDiv.innerHTML = `
                <div class="flex">
                    <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'} mr-2 mt-0.5"></i>
                    <p class="text-sm">${message}</p>
                </div>
            `;

            // Insert message at the top of the content
            const contentDiv = document.querySelector('.max-w-7xl');
            if (contentDiv) {
                contentDiv.insertBefore(alertDiv, contentDiv.firstChild);
            }

            // Auto hide after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        } catch (error) {
            console.error('Error in showMessage function:', error);
        }
    }

    // Filter functions
    window.applyFilters = function() {
        try {
            const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
            const santriFilter = document.getElementById('santriFilter').value.toLowerCase();
            const rows = document.querySelectorAll('.submission-row');

            rows.forEach(row => {
                const status = row.dataset.status;
                const santri = row.dataset.santri;

                let showRow = true;

                if (statusFilter && status !== statusFilter) {
                    showRow = false;
                }

                if (santriFilter && !santri.includes(santriFilter)) {
                    showRow = false;
                }

                row.style.display = showRow ? '' : 'none';
            });
        } catch (error) {
            console.error('Error in applyFilters function:', error);
        }
    }

    window.resetFilters = function() {
        try {
            document.getElementById('statusFilter').value = '';
            document.getElementById('santriFilter').value = '';
            applyFilters();
        } catch (error) {
            console.error('Error in resetFilters function:', error);
        }
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
        try {
            const audioModal = document.getElementById('audioModal');
            const reviewModal = document.getElementById('reviewModal');

            if (audioModal && event.target === audioModal) {
                closeAudioModal();
            }
            if (reviewModal && event.target === reviewModal) {
                closeReviewModal();
            }
        } catch (error) {
            console.error('Error in window click handler:', error);
        }
    }

    // Auto-refresh pending count every 30 seconds
    setInterval(function() {
        // You can implement auto-refresh functionality here if needed
    }, 30000);
});
</script>
@endsection