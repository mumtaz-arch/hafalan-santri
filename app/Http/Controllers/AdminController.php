<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Anda tidak memiliki akses ke halaman ini.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        return redirect()->route('dashboard');
    }

    public function users()
    {
        $users = User::orderBy('role')->orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    public function verifyUser($id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->role !== 'ustad') {
                return redirect()->back()->with('error', 'Hanya akun ustad yang dapat diverifikasi.');
            }

            $user->update([
                'verification_status' => 'verified',
                'verified_at' => now(),
                'verified_by' => Auth::id()
            ]);

            return redirect()->back()->with('success', "Akun {$user->name} berhasil diverifikasi.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memverifikasi akun.');
        }
    }

    public function rejectUser($id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->role !== 'ustad') {
                return redirect()->back()->with('error', 'Hanya akun ustad yang dapat ditolak.');
            }

            $user->update([
                'verification_status' => 'rejected',
                'verified_at' => now(),
                'verified_by' => Auth::id()
            ]);

            return redirect()->back()->with('success', "Akun {$user->name} berhasil ditolak.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menolak akun.');
        }
    }

    public function resetVerification($id)
    {
        try {
            $user = User::findOrFail($id);

            $user->update([
                'verification_status' => 'pending',
                'verified_at' => null,
                'verified_by' => null
            ]);

            return redirect()->back()->with('success', "Status verifikasi {$user->name} diatur ulang.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mereset verifikasi.');
        }
    }
}