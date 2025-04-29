<?php
// app/Http/Controllers/Mobile/ScheduleController.php
namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('members')
            ->orderBy('day_order', 'asc')
            ->get();

        return view('mobile.user.schedule', compact('schedules'));
    }
}
