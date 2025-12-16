// Voice Recorder Functions

// Audio recording variables
let mediaRecorder;
let audioChunks = [];
let audioBlob;

// Initialize recording functionality
function initRecording() {
    const startBtn = document.getElementById('startRecordBtn');
    const stopBtn = document.getElementById('stopRecordBtn');
    const statusDiv = document.getElementById('recordStatus');
    const recordedAudioDiv = document.getElementById('recordedAudio');
    
    if (!startBtn || !stopBtn) {
        console.error('Record buttons not found');
        return;
    }

    // Check if browser supports recording
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        statusDiv.textContent = 'Browser tidak mendukung rekaman audio.';
        startBtn.disabled = true;
        return;
    }

    startBtn.addEventListener('click', async () => {
        try {
            statusDiv.textContent = 'Mengakses mikrofon...';
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
            
            mediaRecorder = new MediaRecorder(stream);
            audioChunks = [];

            mediaRecorder.ondataavailable = event => {
                audioChunks.push(event.data);
            };

            mediaRecorder.onstop = () => {
                // Stop all tracks to release the microphone
                stream.getTracks().forEach(track => track.stop());
                
                audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                
                // Create a URL for the recorded audio blob
                const audioUrl = URL.createObjectURL(audioBlob);
                
                // Set the source for the player
                const recordedPlayer = document.getElementById('recordedPlayer');
                if (recordedPlayer) {
                    recordedPlayer.src = audioUrl;
                }
                
                // Show the recorded audio controls
                if (recordedAudioDiv) {
                    recordedAudioDiv.classList.remove('hidden');
                }
                statusDiv.textContent = 'Rekaman selesai. Anda dapat memutar dan menggunakan rekaman ini.';
                
                startBtn.disabled = false;
                stopBtn.disabled = true;
            };

            mediaRecorder.start();
            statusDiv.textContent = 'Sedang merekam...';
            startBtn.disabled = true;
            stopBtn.disabled = false;
        } catch (error) {
            console.error('Error accessing microphone:', error);
            statusDiv.textContent = 'Gagal mengakses mikrofon. Pastikan Anda memberikan izin.';
            startBtn.disabled = false;
            stopBtn.disabled = true;
        }
    });

    stopBtn.addEventListener('click', () => {
        if (mediaRecorder && mediaRecorder.state !== 'inactive') {
            mediaRecorder.stop();
        }
    });

    // Play recorded audio button
    const playRecordedBtn = document.getElementById('playRecordedBtn');
    if (playRecordedBtn) {
        playRecordedBtn.addEventListener('click', () => {
            const recordedPlayer = document.getElementById('recordedPlayer');
            if (recordedPlayer) {
                recordedPlayer.play();
            }
        });
    }

    // Use recording button
    const useRecordingBtn = document.getElementById('useRecordingBtn');
    if (useRecordingBtn) {
        useRecordingBtn.addEventListener('click', () => {
            // Convert the blob to a File object so it can be submitted with the form
            if (audioBlob) {
                const audioFile = new File([audioBlob], `recording_${Date.now()}.wav`, { type: 'audio/wav' });
                
                // Store the file in a variable to use during form submission
                window.recordedAudioFile = audioFile;
                
                // Set a flag to know we're using recorded audio
                window.usingRecordedAudio = true;
                
                // Update the hidden form field
                const formField = document.getElementById('using_recorded_audio');
                if (formField) {
                    formField.value = '1';
                }
                
                // Show the recording status indicator
                const recordingStatus = document.getElementById('recording-status');
                if (recordingStatus) {
                    recordingStatus.classList.remove('hidden');
                }
                
                // Close the modal
                closeRecordModal();
                
                // Show a message to the user
                alert('Rekaman telah disiapkan. Silakan submit hafalan seperti biasa.');
            }
        });
    }
}

// Override the form submission to handle recorded audio
function initFormSubmission() {
    const forms = document.querySelectorAll('form[method="POST"]');
    forms.forEach(function(form) {
        if (form.querySelector('input[name="voice_file"]')) {
            form.addEventListener('submit', function(e) {
                // Check if this form has a voice file input - handle with AJAX regardless of recorded vs uploaded
                const fileInput = form.querySelector('input[name="voice_file"]');
                const hafalanSelect = form.querySelector('select[name="hafalan_id"]');
                
                if (fileInput) { // If form has voice file input, handle via AJAX to support JSON responses
                    e.preventDefault(); // Prevent normal form submission
                    
                    // Validate that required fields are present before submitting
                    const hafalanId = hafalanSelect ? hafalanSelect.value : null;
                    if (!hafalanId) {
                        alert('Silakan pilih surah terlebih dahulu.');
                        // Re-enable button on error
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.innerHTML = 'Submit Hafalan';
                        }
                        return false;
                    }
                    
                    const formData = new FormData(form);
                    
                    // If we have a recorded file, use that instead of the original file upload
                    if (window.usingRecordedAudio && window.recordedAudioFile) {
                        // Client-side validation for recorded audio file
                        if (window.recordedAudioFile.size > 35 * 1024 * 1024) { // 35MB in bytes
                            alert('Ukuran file audio terlalu besar. Maksimal 35MB.');
                            // Re-enable button on error
                            if (submitButton) {
                                submitButton.disabled = false;
                                submitButton.innerHTML = 'Submit Hafalan';
                            }
                            return false;
                        }
                        
                        // Check file extension
                        const allowedExtensions = ['mp3', 'wav', 'm4a', 'ogg'];
                        const fileExtension = window.recordedAudioFile.name.split('.').pop().toLowerCase();
                        if (!allowedExtensions.includes(fileExtension)) {
                            alert('Format file tidak didukung. Gunakan format: mp3, wav, m4a, atau ogg.');
                            // Re-enable button on error
                            if (submitButton) {
                                submitButton.disabled = false;
                                submitButton.innerHTML = 'Submit Hafalan';
                            }
                            return false;
                        }
                        
                        formData.set('voice_file', window.recordedAudioFile);
                        console.log('Using recorded audio file:', window.recordedAudioFile.name, 'Size:', window.recordedAudioFile.size, 'Type:', window.recordedAudioFile.type);
                    } else {
                        // For regular file uploads, ensure the selected file is added and validate
                        const selectedFile = fileInput.files[0];
                        if (selectedFile) {
                            // Client-side validation for uploaded file
                            if (selectedFile.size > 35 * 1024 * 1024) { // 35MB in bytes
                                alert('Ukuran file audio terlalu besar. Maksimal 35MB.');
                                // Re-enable button on error
                                if (submitButton) {
                                    submitButton.disabled = false;
                                    submitButton.innerHTML = 'Submit Hafalan';
                                }
                                return false;
                            }
                            
                            // Check file extension
                            const allowedExtensions = ['mp3', 'wav', 'm4a', 'ogg'];
                            const fileExtension = selectedFile.name.split('.').pop().toLowerCase();
                            if (!allowedExtensions.includes(fileExtension)) {
                                alert('Format file tidak didukung. Gunakan format: mp3, wav, m4a, atau ogg.');
                                // Re-enable button on error
                                if (submitButton) {
                                    submitButton.disabled = false;
                                    submitButton.innerHTML = 'Submit Hafalan';
                                }
                                return false;
                            }
                            
                            formData.set('voice_file', selectedFile);
                            console.log('Using uploaded file:', selectedFile.name, 'Size:', selectedFile.size, 'Type:', selectedFile.type);
                        } else if (form.querySelector('[required]')) {
                            alert('Silakan pilih file audio atau gunakan rekaman langsung terlebih dahulu.');
                            // Re-enable button on error
                            if (submitButton) {
                                submitButton.disabled = false;
                                submitButton.innerHTML = 'Submit Hafalan';
                            }
                            return false;
                        }
                    }
                    
                    // Add hafalan_id explicitly to ensure it's present
                    if (hafalanId) {
                        formData.set('hafalan_id', hafalanId);
                    }
                    
                    // Get CSRF token with better fallback handling
                    let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    if (!csrfToken) {
                        csrfToken = document.querySelector('input[name="_token"]')?.value;
                    }
                    if (!csrfToken) {
                        console.error('CSRF token not found in meta tag or form input');
                        alert('Gagal submit hafalan: Token keamanan tidak ditemukan. Silakan refresh halaman dan coba lagi.');
                        return;
                    }
                    console.log('CSRF Token found:', csrfToken ? 'Yes' : 'No');

                    // Debug: Log form data being submitted
                    console.log('Submitting form data:');
                    for (let pair of formData.entries()) {
                        console.log(pair[0] + ': ', pair[1]);
                    }
                    
                    // Submit the form via fetch API
                    fetch(form.getAttribute('action'), {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'  // This tells Laravel this is an AJAX request
                        }
                    })
                    .then(async response => {
                        // Check if response is ok (status 200-299)
                        if (!response.ok) {
                            // Check if response is HTML (error page) or JSON
                            const contentType = response.headers.get('content-type');
                            if (contentType && contentType.includes('application/json')) {
                                const errorData = await response.json();
                                // Create a more descriptive error message that includes validation errors
                                let errorMessage = errorData.message || `HTTP error! status: ${response.status}`;
                                if (errorData.errors) {
                                    // Include specific field errors in the message
                                    const allErrors = [];
                                    Object.keys(errorData.errors).forEach(field => {
                                        allErrors.push(...errorData.errors[field]);
                                    });
                                    if (allErrors.length > 0) {
                                        errorMessage += ' (' + allErrors.join(', ') + ')';
                                    }
                                }
                                throw new Error(errorMessage);
                            } else {
                                // Response is HTML, likely an error page
                                const errorText = await response.text();
                                console.error('Server returned HTML error page:', errorText);
                                throw new Error(`Server error (status: ${response.status}). Please check the console for more details.`);
                            }
                        }
                        
                        // Check if response is JSON
                        const contentType = response.headers.get('content-type');
                        if (contentType && contentType.includes('application/json')) {
                            return response.json();
                        } else {
                            // Response is not JSON, likely an issue with the server response
                            const responseText = await response.text();
                            console.error('Unexpected server response:', responseText);
                            throw new Error('Server returned unexpected response format.');
                        }
                    })
                    .then(data => {
                        if (data.success || data.message) {
                            alert('Hafalan berhasil disubmit!');
                            // Reset the flags and stored file
                            window.usingRecordedAudio = false;
                            window.recordedAudioFile = null;
                            // Hide recording status
                            document.getElementById('recording-status')?.classList.add('hidden');
                            form.reset();
                            // Optionally reload the page or update the UI
                            location.reload();
                        } else {
                            alert('Gagal submit hafalan: Terjadi kesalahan pada server');
                        }
                    })
                    .catch(error => {
                        console.error('Error submitting recording:', error);
                        // More specific error handling
                        if (error.message.includes('CSRF token')) {
                            alert('Gagal submit hafalan: Token keamanan tidak valid. Silakan refresh halaman dan coba lagi.');
                        } else if (error.message.includes('Server error')) {
                            alert('Gagal submit hafalan: Terjadi kesalahan pada server. Silakan coba lagi nanti atau hubungi administrator.');
                        } else if (error.message.includes('Unexpected server response')) {
                            alert('Gagal submit hafalan: Format respon server tidak valid. Silakan coba lagi nanti.');
                        } else if (error.message.includes('Data tidak valid')) {
                            // Check if the server sent detailed validation errors
                            if (error.message.includes('hafalan_id')) {
                                alert('Gagal submit hafalan: Pastikan Anda telah memilih surah terlebih dahulu.');
                            } else if (error.message.includes('voice_file')) {
                                alert('Gagal submit hafalan: File audio tidak valid. Pastikan file berupa mp3, wav, m4a, atau ogg dengan ukuran maksimal 35MB.');
                            } else {
                                alert('Gagal submit hafalan: Data yang dikirim tidak valid. Pastikan Anda telah memilih surah dan file audio yang valid.');
                            }
                        } else if (error.name === 'TypeError' && error.message.includes('fetch')) {
                            alert('Gagal submit hafalan: Koneksi jaringan gagal. Pastikan Anda terhubung ke internet dan URL server benar.');
                        } else {
                            alert('Gagal submit hafalan: ' + error.message);
                        }
                    })
                    .finally(() => {
                        // Re-enable button after request completes (success or failure)
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.innerHTML = 'Submit Hafalan';
                        }
                    });
                }
            });
        }
    });
}

// Record modal functions
function openRecordModal() {
    const modal = document.getElementById('recordModal');
    if (modal) {
        modal.classList.remove('hidden');
        // Reset the recording state
        resetRecording();
    } else {
        console.error('Record modal not found');
    }
}

function closeRecordModal() {
    const modal = document.getElementById('recordModal');
    if (modal) {
        modal.classList.add('hidden');
        // Stop any active recording
        if (mediaRecorder && mediaRecorder.state !== 'inactive') {
            mediaRecorder.stop();
        }
    }
}

function resetRecording() {
    const startBtn = document.getElementById('startRecordBtn');
    const stopBtn = document.getElementById('stopRecordBtn');
    const statusDiv = document.getElementById('recordStatus');
    const recordedAudioDiv = document.getElementById('recordedAudio');
    
    if (startBtn) startBtn.disabled = false;
    if (stopBtn) stopBtn.disabled = true;
    if (statusDiv) statusDiv.textContent = 'Siap untuk merekam...';
    if (recordedAudioDiv) recordedAudioDiv.classList.add('hidden');
    
    // Also reset the audio blob
    audioBlob = null;
}

// Audio player functions
function playAudio(audioUrl) {
    const audioPlayer = document.getElementById('audioPlayer');
    const audioSource = audioPlayer.querySelector('source');
    if (audioPlayer && audioSource) {
        audioSource.src = audioUrl;
        audioPlayer.load();
        document.getElementById('audioModal').classList.remove('hidden');
    } else {
        console.error('Audio player elements not found');
    }
}

function closeAudioModal() {
    const audioPlayer = document.getElementById('audioPlayer');
    if (audioPlayer) {
        audioPlayer.pause();
        audioPlayer.currentTime = 0;
    }
    document.getElementById('audioModal').classList.add('hidden');
}

// Detail modal functions
function showDetail(submissionId) {
    // Find the table row with the matching submission ID to get the data
    const row = document.querySelector(`[data-submission-id="${submissionId}"]`);
    
    if (!row) {
        console.error('Submission row not found');
        return;
    }
    
    // Extract data attributes from the row
    const status = row.getAttribute('data-status');
    const feedback = row.getAttribute('data-feedback');
    const score = row.getAttribute('data-score');
    
    // Get additional data from the row
    const surahName = row.querySelector('td:first-child .text-sm.font-medium')?.textContent?.trim() || 'Unknown';
    const ayatCount = row.querySelector('td:first-child .text-sm.text-gray-500')?.textContent?.trim() || '';
    const date = row.querySelector('td:nth-child(2)')?.textContent?.trim() || '';
    
    // Format the feedback display
    let feedbackDisplay = 'Feedback akan ditampilkan di sini setelah review oleh ustad.';
    if (feedback && feedback.trim() !== '') {
        feedbackDisplay = feedback;
    }
    
    // Format status text
    let statusText = status.charAt(0).toUpperCase() + status.slice(1);
    switch(status) {
        case 'pending':
            statusText = 'Menunggu Review';
            break;
        case 'approved':
            statusText = 'Disetujui';
            break;
        case 'rejected':
            statusText = 'Ditolak';
            break;
        default:
            statusText = 'Tidak Diketahui';
    }
    
    // Create modal content
    const detailContent = document.getElementById('detailContent');
    if (detailContent) {
        detailContent.innerHTML = `
            <div class="space-y-4">
                <div class="border-b pb-3">
                    <span class="font-medium text-gray-700">Surah:</span>
                    <div class="mt-1 text-gray-900">${surahName} ${ayatCount}</div>
                </div>
                <div class="border-b pb-3">
                    <span class="font-medium text-gray-700">Tanggal Submit:</span>
                    <div class="mt-1 text-gray-900">${date}</div>
                </div>
                <div class="border-b pb-3">
                    <span class="font-medium text-gray-700">Status:</span>
                    <div class="mt-1 text-gray-900">${statusText}</div>
                </div>
                <div class="border-b pb-3">
                    <span class="font-medium text-gray-700">Feedback:</span>
                    <div class="mt-1 text-gray-900 text-sm">
                        ${feedbackDisplay}
                    </div>
                </div>
                ${score ? `
                <div>
                    <span class="font-medium text-gray-700">Nilai:</span>
                    <div class="mt-1 text-gray-900">${score}/100</div>
                </div>
                ` : `
                <div>
                    <span class="font-medium text-gray-700">Nilai:</span>
                    <div class="mt-1 text-gray-900">-</div>
                </div>
                `}
            </div>
        `;
    }
    
    document.getElementById('detailModal').classList.remove('hidden');
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
}

// Close modals when clicking outside
function initModalClickOutside() {
    window.onclick = function(event) {
        const audioModal = document.getElementById('audioModal');
        const detailModal = document.getElementById('detailModal');
        const recordModal = document.getElementById('recordModal');
        
        if (event.target === audioModal) {
            closeAudioModal();
        }
        if (event.target === detailModal) {
            closeDetailModal();
        }
        if (event.target === recordModal) {
            closeRecordModal();
        }
    }
}

// Ensure modals are always on top
function ensureModalZIndex() {
    const modals = ['audioModal', 'detailModal', 'recordModal'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (modal) {
            // Set high z-index to ensure modals are on top
            modal.style.zIndex = '9999';
            const content = modal.querySelector('div');
            if (content) {
                content.style.zIndex = '10000';
            }
        }
    });
}



// Initialize all functions when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initRecording();
    initFormSubmission();
    initModalClickOutside();
    
    // Display file name when selected
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            displayFileName(this);
        });
    });
});

// Display file name when selected
function displayFileName(input) {
    const fileName = input.files[0]?.name;
    const fileNameDiv = document.getElementById('file-name');
    if (fileName) {
        fileNameDiv.textContent = `File dipilih: ${fileName}`;
        fileNameDiv.classList.remove('hidden');
    } else {
        fileNameDiv.classList.add('hidden');
    }
}