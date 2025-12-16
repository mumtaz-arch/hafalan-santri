<?php

// File: app/Models/Hafalan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hafalan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_surah',
        'nomor_surah',
        'jumlah_ayat',
        'keterangan',
    ];

    // Relasi dengan voice submissions
    public function voiceSubmissions()
    {
        return $this->hasMany(VoiceSubmission::class);
    }

    // Method untuk mendapatkan nama surah dengan nomor
    public function getFullNameAttribute()
    {
        return "({$this->nomor_surah}) {$this->nama_surah}";
    }

    // Method untuk menghitung berapa santri yang sudah menghafal surah ini
    public function getApprovedSubmissionsCountAttribute()
    {
        return $this->voiceSubmissions()->where('status', 'approved')->count();
    }
}