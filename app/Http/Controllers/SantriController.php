<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VoiceSubmission;
use Illuminate\Support\Facades\Hash;

class SantriController extends Controller
{
    public function index()
    {
        $santris = User::where('role', 'santri')
            ->withCount(['voiceSubmissions', 'voiceSubmissions as approved_count' => function ($query) {
                $query->where('status', 'approved');
            }])
            ->orderBy('name')
            ->paginate(15);

        return view('santri.index', compact('santris'));
    }

    public function create()
    {
        return view('santri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'nisn' => 'required|string|max:20|unique:users',
            'kelas' => 'required|string|max:50',
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'nisn.required' => 'NISN wajib diisi',
            'nisn.unique' => 'NISN sudah terdaftar',
            'kelas.required' => 'Kelas wajib diisi',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'santri',
            'nisn' => $request->nisn,
            'kelas' => $request->kelas,
        ]);

        return redirect()->route('santri.index')->with('success', 'Data santri berhasil ditambahkan!');
    }

    public function show($id)
    {
        $santri = User::where('role', 'santri')->findOrFail($id);
        
        $submissions = VoiceSubmission::where('user_id', $id)
            ->with('hafalan')  // Eager loading to prevent N+1 queries
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Optimize stats query by using a single query with conditional counting
        // This prevents multiple database queries and improves performance
        $statsData = VoiceSubmission::selectRaw("
                COUNT(*) as total_submissions,
                SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected
            ")
            ->where('user_id', $id)
            ->first();

        $stats = [
            'total_submissions' => $statsData->total_submissions,
            'approved' => $statsData->approved,
            'pending' => $statsData->pending,
            'rejected' => $statsData->rejected,
        ];

        return view('santri.show', compact('santri', 'submissions', 'stats'));
    }

    public function edit($id)
    {
        $santri = User::where('role', 'santri')->findOrFail($id);
        return view('santri.edit', compact('santri'));
    }

    public function update(Request $request, $id)
    {
        $santri = User::where('role', 'santri')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'nisn' => 'required|string|max:20|unique:users,nisn,' . $id,
            'kelas' => 'required|string|max:50',
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'nisn.required' => 'NISN wajib diisi',
            'nisn.unique' => 'NISN sudah terdaftar',
            'kelas.required' => 'Kelas wajib diisi',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'nisn' => $request->nisn,
            'kelas' => $request->kelas,
        ];

        // Update password jika diisi
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6',
            ], [
                'password.min' => 'Password minimal 6 karakter',
            ]);
            $updateData['password'] = Hash::make($request->password);
        }

        $santri->update($updateData);

        return redirect()->route('santri.index')->with('success', 'Data santri berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $santri = User::where('role', 'santri')->findOrFail($id);
        
        // Cek apakah ada submission
        if ($santri->voiceSubmissions()->count() > 0) {
            return redirect()->route('santri.index')->with('error', 'Tidak dapat menghapus santri yang memiliki submission hafalan!');
        }

        $santri->delete();

        return redirect()->route('santri.index')->with('success', 'Data santri berhasil dihapus!');
    }

    public function resetPassword($id)
    {
        $santri = User::where('role', 'santri')->findOrFail($id);
        
        // Reset password ke default (bisa disesuaikan)
        $defaultPassword = 'santri123';
        $santri->update([
            'password' => Hash::make($defaultPassword)
        ]);

        return redirect()->route('santri.index')->with('success', "Password santri {$santri->name} berhasil direset ke: {$defaultPassword}");
    }
}