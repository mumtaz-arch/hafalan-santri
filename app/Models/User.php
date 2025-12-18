<?php
// File: app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'nisn',
        'role',
        'kelas',
        'profile_photo',
        'verification_status',
        'verified_at',
        'verified_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'verified_at' => 'datetime',
        ];
    }

    // Relasi dengan voice submissions
    public function voiceSubmissions()
    {
        return $this->hasMany(VoiceSubmission::class);
    }

    // Relasi dengan reviews yang dilakukan (untuk ustad)
    public function reviewedSubmissions()
    {
        return $this->hasMany(VoiceSubmission::class, 'reviewed_by');
    }

    // Relasi dengan admin yang melakukan verifikasi
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Helper methods untuk verification status
    public function isVerified()
    {
        return $this->verification_status === 'verified';
    }

    public function isPendingVerification()
    {
        return $this->verification_status === 'pending';
    }

    public function isRejected()
    {
        return $this->verification_status === 'rejected';
    }

    // Helper method untuk mengecek role
    public function isSantri()
    {
        return $this->role === 'santri';
    }

    public function isUstad()
    {
        return $this->role === 'ustad';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isRole($role)
    {
        return $this->role === $role;
    }
}