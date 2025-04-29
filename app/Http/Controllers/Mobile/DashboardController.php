<?php
// app/Http/Controllers/Mobile/DashboardController.php
namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $today = now()->toDateString();
        
        // Ambil data attendance hari ini
        $attendance = Attendance::where('user_id', auth()->id())
                              ->whereDate('date', $today)
                              ->first();

        // Ambil riwayat attendance
        $recentAttendances = Attendance::where('user_id', auth()->id())
                                     ->orderBy('date', 'desc')
                                     ->take(5)
                                     ->get();

        // Debug untuk memeriksa data
        // \Log::info('Attendance data:', ['attendance' => $attendance]);

        return view('mobile.user.dashboard', compact('attendance', 'recentAttendances'));
    }
}
