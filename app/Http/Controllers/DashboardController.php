<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Hafalan;
use App\Models\VoiceSubmission;
use App\Http\Controllers\SeoController;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $seoData = SeoController::getDashboardSeoData($user);

        if ($user->role === 'santri') {
            return $this->santriDashboard($seoData);
        } elseif ($user->role === 'admin') {
            return $this->adminDashboard($seoData);
        } else {
            // For ustad, check verification status
            if (!$user->isVerified()) {
                // Show pending verification dashboard with notification
                return $this->pendingUstadDashboard($seoData);
            }
            return $this->ustadDashboard($seoData);
        }
    }

    private function santriDashboard($seoData)
    {
        $user = Auth::user();
        
        // Statistik untuk santri
        $totalHafalan = Hafalan::count();
        $totalSubmissions = VoiceSubmission::where('user_id', $user->id)->count();
        $approvedSubmissions = VoiceSubmission::where('user_id', $user->id)
            ->where('status', 'approved')->count();
        $pendingSubmissions = VoiceSubmission::where('user_id', $user->id)
            ->where('status', 'pending')->count();

        // Progres hafalan
        $progressPercentage = $totalHafalan > 0 ? round(($approvedSubmissions / $totalHafalan) * 100, 2) : 0;

        // Submission terbaru
        $recentSubmissions = VoiceSubmission::where('user_id', $user->id)
            ->with(['hafalan', 'reviewer'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Hafalan yang belum dikerjakan
        $completedHafalanIds = VoiceSubmission::where('user_id', $user->id)
            ->where('status', 'approved')
            ->pluck('hafalan_id');
        
        $remainingHafalan = Hafalan::whereNotIn('id', $completedHafalanIds)->limit(5)->get();

        return view('dashboard.santri', compact(
            'totalHafalan',
            'totalSubmissions',
            'approvedSubmissions',
            'pendingSubmissions',
            'progressPercentage',
            'recentSubmissions',
            'remainingHafalan',
            'seoData'
        ));
    }

    private function ustadDashboard($seoData)
    {
        // Statistik untuk ustad
        $totalSantri = User::where('role', 'santri')->count();
        $totalSubmissions = VoiceSubmission::count();
        $pendingReviews = VoiceSubmission::where('status', 'pending')->count();
        $reviewedToday = VoiceSubmission::whereDate('reviewed_at', today())->count();

        // Submission yang perlu direview
        $pendingSubmissions = VoiceSubmission::where('status', 'pending')
            ->with(['user', 'hafalan'])
            ->orderBy('created_at', 'asc')
            ->limit(10)
            ->get();

        // Aktivitas terbaru
        $recentActivities = VoiceSubmission::with(['user', 'hafalan'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Statistik per bulan
        $monthlyStats = VoiceSubmission::selectRaw('
                MONTH(created_at) as month,
                COUNT(*) as total,
                SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected
            ')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('dashboard.ustad', compact(
            'totalSantri',
            'totalSubmissions',
            'pendingReviews',
            'reviewedToday',
            'pendingSubmissions',
            'recentActivities',
            'monthlyStats',
            'seoData'
        ));
    }

    private function pendingUstadDashboard($seoData)
    {
        $user = Auth::user();

        // Show a message that account is pending verification
        // Display limited information
        return view('dashboard.pending-ustad', compact('seoData', 'user'));
    }

    private function adminDashboard($seoData)
    {
        $user = Auth::user();

        // Statistics for admin
        $totalUsers = User::count();
        $totalSantri = User::where('role', 'santri')->count();
        $totalUstad = User::where('role', 'ustad')->count();
        $totalAdmin = User::where('role', 'admin')->count();

        $pendingVerifications = User::where('role', 'ustad')
            ->where('verification_status', 'pending')
            ->count();

        // Users that need verification
        $unverifiedUsers = User::where('role', 'ustad')
            ->where('verification_status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        // Recent activities - users that have verification status changes
        $recentActivities = User::with('verifier')
            ->where('role', 'ustad')
            ->whereNotNull('verified_at')
            ->orderBy('verified_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.admin', compact(
            'totalUsers',
            'totalSantri',
            'totalUstad',
            'totalAdmin',
            'pendingVerifications',
            'unverifiedUsers',
            'recentActivities',
            'seoData'
        ));
    }
}