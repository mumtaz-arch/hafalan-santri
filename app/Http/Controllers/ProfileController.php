<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Traits\PasswordValidationRules;

class ProfileController extends Controller
{
    use PasswordValidationRules;

    /**
     * Show the user profile page
     */
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nisn' => 'nullable|string|max:20|unique:users,nisn,' . $user->id,
            'kelas' => 'nullable|string|max:50',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'nisn.unique' => 'NISN sudah terdaftar',
            'profile_photo.image' => 'File harus berupa gambar',
            'profile_photo.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'profile_photo.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Store new photo
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo = $path;
        }

        // Update other fields
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->nisn = $request->input('nisn');
        $user->kelas = $request->input('kelas');
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Change user password
     */
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate($this->changePasswordValidationRules(), $this->passwordValidationMessages());

        // Check if the current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('profile.show')->with('error', 'Password saat ini salah!');
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Password berhasil diperbarui');
    }

    /**
     * Delete profile photo
     */
    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->profile_photo = null;
            $user->save();

            return redirect()->route('profile.show')->with('success', 'Foto profil berhasil dihapus!');
        }

        return redirect()->route('profile.show')->with('error', 'Tidak ada foto untuk dihapus!');
    }
}
