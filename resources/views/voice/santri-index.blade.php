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
            <i class="fas fa-microphone text-islamic-green mr-3"></i>
            Hafalan Saya
        </h1>
        <p class="text-gray-600 mt-2">Upload dan kelola submission hafalan Al-Qur'an Anda</p>
    </div>

    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 alert-auto-hide">
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

    <!-- Submit Form -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-plus-circle text-islamic-green mr-2"></i>
                Submit Hafalan Baru
            </h3>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('voice.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Pilih Hafalan -->
                <div>
                    <label for="hafalan_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-book-quran mr-1"></i>
                        Pilih Surah
                    </label>
                    <select 
                        id="hafalan_id" 
                        name="hafalan_id" 
                        required 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-islamic-green focus:border-islamic-green sm:text-sm @error('hafalan_id') border-red-300 @enderror"
                    >
                        <option value="">Pilih Surah yang akan dihafal</option>
                        @foreach($hafalans as $hafalan)
                            <option value="{{ $hafalan->id }}" {{ old('hafalan_id') == $hafalan->id ? 'selected' : '' }}>
                                ({{ $hafalan->nomor_surah }}) {{ $hafalan->nama_surah }} - {{ $hafalan->jumlah_ayat }} ayat
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Upload Audio -->
                <div>
                    <label for="voice_file" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-file-audio mr-1"></i>
                        File Audio Hafalan
                    </label>
                    
                    <!-- Record Button -->
                    <div class="mb-4">
                        <button 
                            type="button" 
                            onclick="openRecordModal()"
                            class="inline-flex items-center px-4 py-2 bg-islamic-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-islamic-green focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <i class="fas fa-microphone mr-2"></i>
                            Rekam Langsung
                        </button>
                    </div>
                    
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-islamic-green transition-colors">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="voice_file" class="relative cursor-pointer bg-white rounded-md font-medium text-islamic-green hover:text-green-700 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-islamic-green">
                                    <span>Upload file audio</span>
                                    <input 
                                        id="voice_file" 
                                        name="voice_file" 
                                        type="file" 
                                        class="sr-only" 
                                        accept=".mp3,.wav,.m4a,.ogg"
                                        onchange="displayFileName(this)"
                                    >
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                MP3, WAV, M4A, OGG up to 35MB
                            </p>
                            <div id="file-name" class="text-sm text-gray-900 font-medium hidden"></div>
                            
                            <!-- Status indicator when using recorded audio -->
                            <div id="recording-status" class="text-sm text-green-600 font-medium hidden mt-2">
                                <i class="fas fa-check-circle mr-1"></i>
                                Menggunakan rekaman langsung
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                    <div class="flex">
                        <i class="fas fa-info-circle text-blue-400 mr-2 mt-0.5"></i>
                        <div>
                            <h4 class="text-sm font-medium text-blue-800">Panduan Upload Hafalan:</h4>
                            <ul class="text-sm text-blue-700 mt-2 space-y-1">
                                <li>• Bacakan hafalan dengan tartil dan jelas</li>
                                <li>• Pastikan suara jernih dan tidak ada gangguan</li>
                                <li>• Ukuran file maksimal 35MB</li>
                                <li>• Format yang didukung: MP3, WAV, M4A, OGG</li>
                                <li>• Anda hanya bisa submit ulang jika submission sebelumnya ditolak</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button 
                        type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-islamic-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-islamic-green focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        <i class="fas fa-upload mr-2"></i>
                        Submit Hafalan
                    </button>
                </div>
                
                <!-- Hidden form field to indicate if we're using recorded audio -->
                <input type="hidden" id="using_recorded_audio" name="using_recorded_audio" value="0">
            </form>
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Surah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Submit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($submissions as $submission)
                                <tr class="hover:bg-gray-50" 
                                    data-submission-id="{{ $submission->id }}" 
                                    data-status="{{ $submission->status }}" 
                                    data-feedback="{{ addslashes($submission->feedback ?? '') }}" 
                                    data-score="{{ $submission->score ?? '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $submission->hafalan->nama_surah }}</div>
                                        <div class="text-sm text-gray-500">{{ $submission->hafalan->jumlah_ayat }} ayat</div>
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
                                            onclick="playAudio('{{ $submission->voice_url }}')"
                                            class="text-blue-600 hover:text-blue-900 inline-flex items-center"
                                            title="Putar Audio"
                                        >
                                            <i class="fas fa-play mr-1"></i>
                                            Putar
                                        </button>
                                        
                                        <!-- View Details -->
                                        <button 
                                            onclick="showDetail('{{ $submission->id }}')"
                                            class="text-islamic-green hover:text-green-700 inline-flex items-center"
                                            title="Lihat Detail"
                                        >
                                            <i class="fas fa-eye mr-1"></i>
                                            Detail
                                        </button>

                                        <!-- Delete button for all status, not just pending -->
                                        <form method="POST" action="{{ route('voice.destroy', $submission->id) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus submission ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 inline-flex items-center" title="Hapus">
                                                <i class="fas fa-trash mr-1"></i>
                                                Hapus
                                            </button>
                                        </form>
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
                    <i class="fas fa-microphone text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Submission</h3>
                    <p class="text-gray-600 mb-4">Mulai submit hafalan Al-Qur'an Anda sekarang</p>
                    <p class="text-sm text-gray-500">Pilih surah di form di atas dan upload file audio hafalan Anda</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Audio Player Modal -->
<div id="audioModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white z-60">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-volume-up mr-2"></i>
                    Putar Audio Hafalan
                </h3>
                <button onclick="closeAudioModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
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

<!-- Detail Modal -->
<div id="detailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-10 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white z-60">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-info-circle mr-2"></i>
                    Detail Submission
                </h3>
                <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="detailContent">
                <!-- Content will be loaded here -->
            </div>
            <div class="text-center mt-4">
                <button onclick="closeDetailModal()" class="px-4 py-2 bg-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-400 transition duration-150">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Record Audio Modal -->
<div id="recordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white z-60">
        <div class="mt-3 text-center">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-microphone mr-2"></i>
                    Rekam Hafalan
                </h3>
                <button onclick="closeRecordModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mt-2">
                <div id="recordControls">
                    <button id="startRecordBtn" class="px-4 py-2 bg-green-600 text-white rounded-md mr-2">
                        <i class="fas fa-microphone mr-1"></i> Rekam
                    </button>
                    <button id="stopRecordBtn" class="px-4 py-2 bg-red-600 text-white rounded-md" disabled>
                        <i class="fas fa-stop mr-1"></i> Berhenti
                    </button>
                </div>
                <div id="recordStatus" class="mt-3 text-gray-600">
                    Siap untuk merekam...
                </div>
                <div id="recordedAudio" class="mt-4 hidden">
                    <audio id="recordedPlayer" controls class="w-full"></audio>
                    <button id="playRecordedBtn" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-md mr-2">
                        <i class="fas fa-play mr-1"></i> Putar
                    </button>
                    <button id="useRecordingBtn" class="mt-2 px-4 py-2 bg-islamic-green text-white rounded-md">
                        <i class="fas fa-check mr-1"></i> Gunakan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src='{{ asset('js/voice-recorder.js') }}'></script>
@endsection
