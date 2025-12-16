<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hafalan;
use App\Models\VoiceSubmission;

class SeoController extends Controller
{
    /**
     * Generate SEO data for voice submission detail page
     */
    public static function getVoiceSubmissionSeoData($submission)
    {
        $surahName = $submission->hafalan->nama_surah;
        $santriName = $submission->user->name;
        
        return [
            'title' => "Hafalan {$surahName} oleh {$santriName} - Kontrol Hafalan Santri MAKN Ende",
            'description' => "Dengarkan hafalan {$surahName} yang dibacakan oleh santri {$santriName} di MAKN Ende. Sistem kontrol hafalan digital untuk pondok pesantren.",
            'keywords' => "hafalan {$surahName}, hafalan santri {$santriName}, Makn Ende, aplikasi Quran, kontrol hafalan"
        ];
    }

    /**
     * Generate SEO data for dashboard pages
     */
    public static function getDashboardSeoData($user)
    {
        $role = ucfirst($user->role);
        
        return [
            'title' => "Dashboard {$role} - Kontrol Hafalan Santri MAKN Ende",
            'description' => "Dashboard {$role} untuk mengelola hafalan santri di MAKN Ende. Sistem kontrol hafalan digital untuk pondok pesantren.",
            'keywords' => "dashboard {$user->role}, kontrol hafalan, Makn Ende, aplikasi Quran"
        ];
    }

    /**
     * Generate SEO data for hafalan list
     */
    public static function getHafalanListSeoData()
    {
        return [
            'title' => "Daftar Surah Al-Qur'an - Kontrol Hafalan Santri MAKN Ende",
            'description' => "Daftar lengkap surah Al-Qur'an yang tersedia untuk hafalan santri di MAKN Ende. Sistem kontrol hafalan digital untuk pondok pesantren.",
            'keywords' => "daftar surah quran, hafalan santri, Makn Ende, aplikasi Quran"
        ];
    }

    /**
     * Generate SEO data for hafalan detail
     */
    public static function getHafalanDetailSeoData($hafalan)
    {
        return [
            'title' => "Hafalan {$hafalan->nama_surah} - Kontrol Hafalan Santri MAKN Ende",
            'description' => "Detail hafalan surah {$hafalan->nama_surah} di MAKN Ende. Surah ke-{$hafalan->nomor_surah} dengan {$hafalan->jumlah_ayat} ayat.",
            'keywords' => "hafalan {$hafalan->nama_surah}, surah {$hafalan->nomor_surah}, Makn Ende, aplikasi Quran"
        ];
    }
}