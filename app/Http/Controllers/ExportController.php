<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VoiceSubmission;
use App\Models\Hafalan;
use Carbon\Carbon;

class ExportController extends Controller
{
    public function index()
    {
        return view('export.index');
    }

    public function exportSantri()
    {
        $santris = User::where('role', 'santri')
            ->withCount([
                'voiceSubmissions',
                'voiceSubmissions as approved_count' => function ($query) {
                    $query->where('status', 'approved');
                }
            ])
            ->orderBy('kelas')
            ->orderBy('name')
            ->get();

        $filename = 'data_santri_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($santris) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header CSV
            fputcsv($file, [
                'No',
                'Nama Lengkap',
                'Email',
                'NISN',
                'Kelas',
                'Total Submission',
                'Hafalan Selesai',
                'Progress (%)',
                'Tanggal Daftar'
            ]);

            $no = 1;
            $totalHafalan = Hafalan::count();
            
            foreach ($santris as $santri) {
                $progress = $totalHafalan > 0 ? round(($santri->approved_count / $totalHafalan) * 100, 2) : 0;
                
                fputcsv($file, [
                    $no++,
                    $santri->name,
                    $santri->email,
                    $santri->nisn,
                    $santri->kelas,
                    $santri->voice_submissions_count,
                    $santri->approved_count,
                    $progress . '%',
                    $santri->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportSubmissions(Request $request)
    {
        $query = VoiceSubmission::with(['user', 'hafalan', 'reviewer']);

        // Filter berdasarkan tanggal jika ada
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter berdasarkan status jika ada
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan kelas jika ada
        if ($request->filled('kelas') && $request->kelas !== 'all') {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }

        $submissions = $query->orderBy('created_at', 'desc')->get();

        $filename = 'data_submissions_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($submissions) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header CSV
            fputcsv($file, [
                'No',
                'Nama Santri',
                'Kelas',
                'NISN',
                'Surah',
                'Nomor Surah',
                'Jumlah Ayat',
                'Status',
                'Nilai',
                'Feedback',
                'Reviewer',
                'Tanggal Submit',
                'Tanggal Review'
            ]);

            $no = 1;
            
            foreach ($submissions as $submission) {
                fputcsv($file, [
                    $no++,
                    $submission->user->name,
                    $submission->user->kelas ?? '-',
                    $submission->user->nisn ?? '-',
                    $submission->hafalan->nama_surah,
                    $submission->hafalan->nomor_surah,
                    $submission->hafalan->jumlah_ayat,
                    ucfirst($submission->status),
                    $submission->score ?? '-',
                    $submission->feedback ?? '-',
                    $submission->reviewer->name ?? '-',
                    $submission->created_at->format('d/m/Y H:i'),
                    $submission->reviewed_at ? $submission->reviewed_at->format('d/m/Y H:i') : '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportProgress()
    {
        $totalHafalan = Hafalan::count();
        
        $santris = User::where('role', 'santri')
            ->with(['voiceSubmissions' => function($query) {
                $query->where('status', 'approved')->with('hafalan');
            }])
            ->orderBy('kelas')
            ->orderBy('name')
            ->get();

        $filename = 'progress_hafalan_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($santris, $totalHafalan) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header CSV
            $headers = ['No', 'Nama Santri', 'Kelas', 'NISN'];
            
            // Tambahkan header surah (1-114)
            for ($i = 1; $i <= $totalHafalan; $i++) {
                $headers[] = "Surah $i";
            }
            
            $headers[] = 'Total Selesai';
            $headers[] = 'Progress (%)';
            
            fputcsv($file, $headers);

            $no = 1;
            
            foreach ($santris as $santri) {
                $row = [
                    $no++,
                    $santri->name,
                    $santri->kelas ?? '-',
                    $santri->nisn ?? '-'
                ];
                
                // Get surah yang sudah disetujui
                $approvedSurah = $santri->voiceSubmissions->pluck('hafalan.nomor_surah')->toArray();
                
                // Tambahkan status untuk setiap surah
                for ($i = 1; $i <= $totalHafalan; $i++) {
                    $row[] = in_array($i, $approvedSurah) ? 'Selesai' : 'Belum';
                }
                
                $totalSelesai = count($approvedSurah);
                $progress = $totalHafalan > 0 ? round(($totalSelesai / $totalHafalan) * 100, 2) : 0;
                
                $row[] = $totalSelesai;
                $row[] = $progress . '%';
                
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportStatistik()
    {
        // Data statistik umum
        $totalSantri = User::where('role', 'santri')->count();
        $totalSubmissions = VoiceSubmission::count();
        $approvedSubmissions = VoiceSubmission::where('status', 'approved')->count();
        $pendingSubmissions = VoiceSubmission::where('status', 'pending')->count();
        $rejectedSubmissions = VoiceSubmission::where('status', 'rejected')->count();

        // Statistik per kelas
        $statPerKelas = User::where('role', 'santri')
            ->selectRaw('kelas, COUNT(*) as total_santri')
            ->withCount([
                'voiceSubmissions',
                'voiceSubmissions as approved_count' => function ($query) {
                    $query->where('status', 'approved');
                }
            ])
            ->groupBy('kelas')
            ->orderBy('kelas')
            ->get();

        $filename = 'statistik_hafalan_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($totalSantri, $totalSubmissions, $approvedSubmissions, $pendingSubmissions, $rejectedSubmissions, $statPerKelas) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Statistik Umum
            fputcsv($file, ['STATISTIK UMUM HAFALAN SANTRI MAKN ENDE']);
            fputcsv($file, ['Tanggal Export', date('d/m/Y H:i:s')]);
            fputcsv($file, []);
            
            fputcsv($file, ['Total Santri', $totalSantri]);
            fputcsv($file, ['Total Submission', $totalSubmissions]);
            fputcsv($file, ['Submission Disetujui', $approvedSubmissions]);
            fputcsv($file, ['Submission Pending', $pendingSubmissions]);
            fputcsv($file, ['Submission Ditolak', $rejectedSubmissions]);
            fputcsv($file, []);
            
            // Statistik per kelas
            fputcsv($file, ['STATISTIK PER KELAS']);
            fputcsv($file, ['Kelas', 'Total Santri', 'Total Submission', 'Hafalan Selesai', 'Rata-rata Progress']);
            
            foreach ($statPerKelas as $stat) {
                $avgProgress = $stat->total_santri > 0 ? round(($stat->approved_count / $stat->total_santri), 2) : 0;
                
                fputcsv($file, [
                    $stat->kelas ?? 'Tidak Diset',
                    $stat->total_santri,
                    $stat->voice_submissions_count,
                    $stat->approved_count,
                    $avgProgress
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}