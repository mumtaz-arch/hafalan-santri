<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\VoiceSubmission;
use App\Models\Hafalan;
use App\Http\Controllers\SeoController;

class VoiceSubmissionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'santri') {
            // Untuk santri, tampilkan submission mereka sendiri
            $submissions = VoiceSubmission::where('user_id', $user->id)
                ->with(['hafalan', 'reviewer'])  // Already optimized with eager loading
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            
            // Daftar hafalan untuk form submission baru
            $hafalans = Hafalan::orderBy('nomor_surah')->get();
            
            // Generate SEO data
            $seoData = SeoController::getDashboardSeoData($user);
            
            return view('voice.santri-index', compact('submissions', 'hafalans', 'seoData'));
        } else {
            // Untuk ustad/admin, tampilkan semua submission yang perlu direview
            // Using eager loading to prevent N+1 queries
            $submissions = VoiceSubmission::with(['user', 'hafalan'])
                ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            
            // Generate SEO data
            $seoData = SeoController::getDashboardSeoData($user);
            
            return view('voice.ustad-index', compact('submissions', 'seoData'));
        }
    }

    public function store(Request $request)
    {
        try {
            
            // Manual validation to provide better debugging
            $hafalanId = $request->input('hafalan_id');
            if (!$hafalanId) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['message' => 'Pilih hafalan terlebih dahulu', 'success' => false], 422);
                }
                return back()->with('error', 'Pilih hafalan terlebih dahulu');
            }
            
            // Check if hafalan exists
            $hafalan = \App\Models\Hafalan::find($hafalanId);
            if (!$hafalan) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['message' => 'Hafalan tidak valid', 'success' => false], 422);
                }
                return back()->with('error', 'Hafalan tidak valid');
            }
            
            $file = $request->file('voice_file');
            if (!$file) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['message' => 'File audio wajib diupload', 'success' => false], 422);
                }
                return back()->with('error', 'File audio wajib diupload');
            }
            
            // Validate file size (max 35MB)
            if ($file->getSize() > 35 * 1024 * 1024) { // 35MB in bytes
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['message' => 'Ukuran file maksimal 35MB', 'success' => false], 422);
                }
                return back()->with('error', 'Ukuran file maksimal 35MB');
            }
            
            // Check file extension (more permissive approach than mimes)
            $allowedExtensions = ['mp3', 'wav', 'm4a', 'ogg'];
            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, $allowedExtensions)) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['message' => 'Format file harus mp3, wav, m4a, atau ogg', 'success' => false], 422);
                }
                return back()->with('error', 'Format file harus mp3, wav, m4a, atau ogg');
            }
            
            // If we reached here, validation passed
            $validatedData = [
                'hafalan_id' => $hafalanId,
                'voice_file' => $file
            ];

            $user = Auth::user();

            // Cek apakah sudah pernah submit hafalan ini dan statusnya approved
            $existingApproved = VoiceSubmission::where('user_id', $user->id)
                ->where('hafalan_id', $request->hafalan_id)
                ->where('status', 'approved')
                ->exists();

            if ($existingApproved) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['message' => 'Anda sudah menyelesaikan hafalan ini dengan status disetujui.', 'success' => false], 422);
                }
                return back()->with('error', 'Anda sudah menyelesaikan hafalan ini dengan status disetujui.');
            }

            // Cek apakah ada submission pending untuk hafalan ini
            $existingPending = VoiceSubmission::where('user_id', $user->id)
                ->where('hafalan_id', $request->hafalan_id)
                ->where('status', 'pending')
                ->exists();

            if ($existingPending) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['message' => 'Anda masih memiliki submission pending untuk hafalan ini. Tunggu review ustad terlebih dahulu.', 'success' => false], 422);
                }
                return back()->with('error', 'Anda masih memiliki submission pending untuk hafalan ini. Tunggu review ustad terlebih dahulu.');
            }

            // Upload file audio
            $uploadedFile = $request->file('voice_file');
            if (!$uploadedFile) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['message' => 'File audio tidak ditemukan.', 'success' => false], 422);
                }
                return back()->with('error', 'File audio tidak ditemukan.');
            }
            
            $filename = time() . '_' . $user->id . '_' . $request->hafalan_id . '.' . $uploadedFile->getClientOriginalExtension();
            $filePath = $uploadedFile->storeAs('voice_recordings', $filename, 'public');

            // Simpan submission
            $submission = VoiceSubmission::create([
                'user_id' => $user->id,
                'hafalan_id' => $request->hafalan_id,
                'voice_file_path' => $filePath,
                'status' => 'pending',
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => 'Hafalan berhasil disubmit! Tunggu review dari ustad.',
                    'success' => true,
                    'data' => $submission
                ], 200);
            }


        } catch (\Exception $e) {
            // Log the actual error for debugging
            \Log::error('Voice submission error: ' . $e->getMessage() . ' in file: ' . $e->getFile() . ' at line: ' . $e->getLine());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => 'Terjadi kesalahan saat menyimpan hafalan. Silakan coba lagi.',
                    'success' => false
                ], 500);
            }
            
            return back()->with('error', 'Terjadi kesalahan saat menyimpan hafalan. Silakan coba lagi.');
        }
    }

    public function review(Request $request, $id)
    {
        try {
            $user = Auth::user();
            
            // Pastikan hanya ustad yang bisa review
            if ($user->role !== 'ustad') {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['message' => 'Anda tidak memiliki akses untuk melakukan review.', 'success' => false], 403);
                }
                return back()->with('error', 'Anda tidak memiliki akses untuk melakukan review.');
            }

            $request->validate([
                'status' => 'required|in:approved,rejected',
                'feedback' => 'nullable|string|max:1000',
                'score' => 'nullable|integer|min:0|max:100',
            ], [
                'status.required' => 'Status wajib dipilih',
                'status.in' => 'Status tidak valid',
                'score.integer' => 'Nilai harus berupa angka',
                'score.min' => 'Nilai minimal 0',
                'score.max' => 'Nilai maksimal 100',
            ]);

            $submission = VoiceSubmission::findOrFail($id);

            $submission->update([
                'status' => $request->status,
                'feedback' => $request->feedback,
                'score' => $request->score,
                'reviewed_by' => $user->id,
                'reviewed_at' => now(),
            ]);

            $statusText = $request->status === 'approved' ? 'disetujui' : 'ditolak';
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => "Submission berhasil {$statusText}!",
                    'success' => true,
                    'data' => $submission
                ], 200);
            }
            
            return back()->with('success', "Submission berhasil {$statusText}!");
        } catch (\Exception $e) {
            // Log the actual error for debugging
            \Log::error('Voice submission review error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => 'Terjadi kesalahan saat mereview submission. Silakan coba lagi.',
                    'success' => false
                ], 500);
            }
            
            return back()->with('error', 'Terjadi kesalahan saat mereview submission. Silakan coba lagi.');
        }
    }

    public function show($id)
    {
        $submission = VoiceSubmission::with(['user', 'hafalan', 'reviewer'])->findOrFail($id);

        $user = Auth::user();

        // Pastikan santri hanya bisa melihat submission mereka sendiri
        if ($user->role === 'santri' && $submission->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke submission ini.');
        }

        // Return JSON response if AJAX request, otherwise return view
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'id' => $submission->id,
                'user_id' => $submission->user_id,
                'hafalan' => $submission->hafalan,
                'voice_file_path' => $submission->voice_file_path,
                'voice_url' => $submission->voice_url,
                'status' => $submission->status,
                'feedback' => $submission->feedback,
                'score' => $submission->score,
                'reviewer' => $submission->reviewer,
                'reviewed_at' => $submission->reviewed_at,
                'formatted_reviewed_at' => $submission->formatted_reviewed_at,
                'created_at' => $submission->created_at,
                'formatted_created_at' => $submission->formatted_created_at,
                'status_badge' => $submission->status_badge,
            ]);
        }

        // Generate SEO data
        $seoData = SeoController::getVoiceSubmissionSeoData($submission);

        return view('voice.show', compact('submission', 'seoData'));
    }

    public function destroy($id)
    {
        try {
            $user = Auth::user();
            $submission = VoiceSubmission::findOrFail($id);

            // Pastikan santri hanya bisa menghapus submission mereka sendiri yang masih pending
            if ($user->role === 'santri') {
                if ($submission->user_id !== $user->id) {
                    if (request()->ajax() || request()->wantsJson()) {
                        return response()->json(['message' => 'Anda tidak memiliki akses untuk menghapus submission ini.', 'success' => false], 403);
                    }
                    return back()->with('error', 'Anda tidak memiliki akses untuk menghapus submission ini.');
                }
                
                if ($submission->status !== 'pending') {
                    if (request()->ajax() || request()->wantsJson()) {
                        return response()->json(['message' => 'Submission yang sudah direview tidak dapat dihapus.', 'success' => false], 422);
                    }
                    return back()->with('error', 'Submission yang sudah direview tidak dapat dihapus.');
                }
            }

            // Hapus file audio
            if (Storage::disk('public')->exists($submission->voice_file_path)) {
                Storage::disk('public')->delete($submission->voice_file_path);
            }

            $submission->delete();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => 'Submission berhasil dihapus.',
                    'success' => true
                ], 200);
            }

            return back()->with('success', 'Submission berhasil dihapus.');
        } catch (\Exception $e) {
            // Log the actual error for debugging
            \Log::error('Voice submission delete error: ' . $e->getMessage());
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => 'Terjadi kesalahan saat menghapus submission. Silakan coba lagi.',
                    'success' => false
                ], 500);
            }
            
            return back()->with('error', 'Terjadi kesalahan saat menghapus submission. Silakan coba lagi.');
        }
    }
}