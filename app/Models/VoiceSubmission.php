<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoiceSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hafalan_id',
        'voice_file_path',
        'status',
        'feedback',
        'score',
        'reviewed_by',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
        ];
    }

    // Relasi dengan user (santri yang submit)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan hafalan
    public function hafalan()
    {
        return $this->belongsTo(Hafalan::class);
    }

    // Relasi dengan reviewer (ustad yang me-review)
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Method untuk mendapatkan URL file audio
    public function getVoiceUrlAttribute()
    {
        return asset('storage/' . $this->voice_file_path);
    }

    // Method untuk mendapatkan status dengan warna
    public function getStatusBadgeAttribute()
    {
        $statusColors = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
        ];

        $statusTexts = [
            'pending' => 'Menunggu Review',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
        ];

        return [
            'color' => $statusColors[$this->status] ?? 'bg-gray-100 text-gray-800',
            'text' => $statusTexts[$this->status] ?? 'Unknown',
        ];
    }

    // Method untuk format tanggal Indonesia
    public function getFormattedCreatedAtAttribute()
    {
        if (!$this->created_at) {
            return '-';
        }
        
        // Ensure it's a Carbon instance before formatting
        $date = $this->created_at instanceof \Carbon\Carbon ? $this->created_at : \Carbon\Carbon::parse($this->created_at);
        return $date->format('d M Y H:i');
    }

    public function getFormattedReviewedAtAttribute()
    {
        if (!$this->reviewed_at) {
            return '-';
        }
        
        // Ensure it's a Carbon instance before formatting
        $date = $this->reviewed_at instanceof \Carbon\Carbon ? $this->reviewed_at : \Carbon\Carbon::parse($this->reviewed_at);
        return $date->format('d M Y H:i');
    }
}
    
