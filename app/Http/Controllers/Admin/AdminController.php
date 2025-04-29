<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'nrp' => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();
            if ($user->role === 'admin') {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            }
            Auth::guard('admin')->logout();
        }

        return back()->withErrors([
            'nrp' => 'NRP atau password salah.',
        ]);
    }

    public function dashboard()
    {
        // Basic Stats
        $totalUsers = User::count();
        $todayAttendance = Attendance::whereDate('created_at', today())->count();
        
        // Statistik Ketepatan Waktu
        $totalAttendances = Attendance::count();
        $onTimeAttendances = Attendance::where('status', 'Tepat Waktu')->count();
        $onTimePercentage = $totalAttendances > 0 
            ? round(($onTimeAttendances / $totalAttendances) * 100) 
            : 0;

        // Data Kehadiran Mingguan
        $weeklyLabels = [];
        $weeklyOnTime = [];
        $weeklyLate = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $weeklyLabels[] = $date->format('D');
            
            $weeklyOnTime[] = Attendance::whereDate('created_at', $date)
                ->where('status', 'Tepat Waktu')
                ->count();
                
            $weeklyLate[] = Attendance::whereDate('created_at', $date)
                ->where('status', 'Terlambat')
                ->count();
        }

        // Distribusi per Divisi
        $divisions = User::select('divisi')
            ->selectRaw('count(*) as count')
            ->groupBy('divisi')
            ->get();
        
        $divisionLabels = $divisions->pluck('divisi');
        $divisionCounts = $divisions->pluck('count');

        return view('admin.dashboard', compact(
            'totalUsers',
            'todayAttendance',
            'onTimePercentage',
            'weeklyLabels',
            'weeklyOnTime',
            'weeklyLate',
            'divisionLabels',
            'divisionCounts'
        ));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function attendance()
    {
        $attendances = \App\Models\Attendance::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.attendance.index', compact('attendances'));
    }
}
