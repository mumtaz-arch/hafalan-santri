<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Traits\PasswordValidationRules;

class AuthController extends Controller
{
    use PasswordValidationRules;

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->except('password'));
    }

    public function register(Request $request)
    {
        $request->validate(array_merge([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:santri,ustad',
            'nisn' => 'nullable|string|max:20|unique:users',
            'kelas' => 'nullable|string|max:50',
        ], $this->passwordValidationRules()), array_merge([
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'role.required' => 'Role wajib dipilih',
            'role.in' => 'Role harus santri atau ustad',
            'nisn.unique' => 'NISN sudah terdaftar',
        ], $this->passwordValidationMessages()));

        // Determine verification status based on role
        $verificationStatus = 'verified'; // Default is verified
        if ($request->role === 'ustad') {
            $verificationStatus = 'pending'; // Ustad accounts need admin verification
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Gunakan role dari request
            'nisn' => $request->nisn,
            'kelas' => $request->kelas,
            'verification_status' => $verificationStatus,
        ]);

        // Login user, but show different message for ustad pending verification
        Auth::login($user);

        if ($request->role === 'ustad' && !$user->isVerified()) {
            return redirect('/dashboard')->with('warning', 'Akun Anda telah terdaftar dan menunggu verifikasi oleh admin. Silakan menunggu konfirmasi dari admin sebelum dapat menggunakan fitur-fitur untuk ustad.');
        }

        return redirect('/dashboard')->with('success', 'Registrasi berhasil!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logout berhasil!');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendPasswordResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak ditemukan dalam sistem'
        ]);

        // Create password reset token
        $token = Str::random(60);

        // Delete any existing tokens for this email
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Insert new token
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        // Send password reset email
        $user = User::where('email', $request->email)->first();

        Mail::to($user->email)->send(new \App\Mail\ResetPasswordMail($user, $token));

        return back()->with('success', 'Link reset password telah dikirim ke email Anda. Silakan cek kotak masuk Anda.');
    }

    public function showResetPassword(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate(array_merge([
            'token' => 'required',
            'email' => 'required|email',
        ], $this->passwordValidationRules()), array_merge([
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'token.required' => 'Token tidak valid'
        ], $this->passwordValidationMessages()));

        // Check if the token exists and is not expired (valid for 60 minutes)
        $resetData = DB::table('password_reset_tokens')
                      ->where('email', $request->email)
                      ->where('token', $request->token)
                      ->first();

        if (!$resetData) {
            return back()->withErrors(['email' => 'Token reset password tidak valid atau sudah kadaluarsa.']);
        }

        // Check if token is expired (older than 60 minutes)
        $createdAt = \Carbon\Carbon::parse($resetData->created_at);
        if ($createdAt->addMinutes(60)->isPast()) {
            // Delete expired token
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Token reset password sudah kadaluarsa. Silakan minta ulang.']);
        }

        // Update user password
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Alamat email tidak ditemukan.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Delete the used token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/login')->with('success', 'Password berhasil direset. Silakan login menggunakan password baru Anda.');
    }
}