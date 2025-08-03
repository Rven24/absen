<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\DailyIncome; // Import model DailyIncome
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today(); // Dapatkan tanggal hari ini

        $todayAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('check_in_time', $today) // Gunakan $today
            ->first();

        // Ambil data pendapatan harian untuk user yang login hari ini
        $todayDailyIncome = DailyIncome::where('user_id', $user->id)
                                        ->whereDate('date', $today) // Gunakan $today
                                        ->first();

        $attendances = Attendance::where('user_id', $user->id)
            ->latest()
            ->paginate(5);

        // Teruskan $todayDailyIncome ke view
        return view('attendance.index', compact('todayAttendance', 'attendances', 'todayDailyIncome'));
    }

    public function checkIn(Request $request)
    {
        $user = Auth::user();

        $currentTime = Carbon::now();

        if ($user->shift === 'pagi') {
            // Check-in allowed between 7 and 9 AM
            if ($currentTime->hour < 7 || $currentTime->hour >= 9) {
                return redirect()->back()->with('error', 'Check-in hanya bisa dilakukan pada jam 7 sampai jam 9 pagi untuk shift pagi.');
            }
        } elseif ($user->shift === 'malam') {
            // Check-in allowed between 3 and 5 PM
            // Perbaikan: jam 5 pagi seharusnya 17 (5 sore)
            if ($currentTime->hour < 15 || $currentTime->hour >= 17) {
                return redirect()->back()->with('error', 'Check-in hanya bisa dilakukan pada jam 3 sampai jam 5 sore untuk shift malam.');
            }
        } else {
            return redirect()->back()->with('error', 'Shift karyawan tidak valid.');
        }

        // Check if already checked in today
        $existingAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('check_in_time', Carbon::now())
            ->first();

        if ($existingAttendance) {
            return redirect()->back()->with('error', 'Anda sudah melakukan Check-in hari ini.');
        }

        $isLate = false;
        if ($user->shift === 'pagi') {
            $isLate = $currentTime->hour >= 8;
        } elseif ($user->shift === 'malam') {
            $isLate = $currentTime->hour >= 16;
        }

        $attendance = Attendance::create([
            'user_id' => $user->id,
            'date_check_in' => $currentTime->toDateString(), // Gunakan toDateString() jika hanya tanggal
            'check_in_time' => $currentTime->toDateTimeString(),
            'is_late' => $isLate,
        ]);

        return redirect()->back()->with('success', 'Check-in berhasil! Kamu ' . ($attendance->is_late ? 'Terlambat' : 'Tidak Terlambat'));
    }

    public function checkOut(Request $request)
    {
        $user = Auth::user();

        $currentTime = Carbon::now();

        if (!in_array($user->shift, ['pagi', 'malam'])) {
            return redirect()->back()->with('error', 'Shift karyawan tidak valid.');
        }

        // Find today's attendance without check-out
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('check_in_time', Carbon::today())
            ->whereNull('check_out_time')
            ->first();

        if (! $todayAttendance) {
            return redirect()->back()->with('error', 'Anda belum melakukan Check-in hari ini atau sudah Check-out.');
        }

        $isOvertime = false;
        if ($user->shift === 'pagi') {
            $isOvertime = $currentTime->hour >= 15; // Setelah jam 3 sore
        } elseif ($user->shift === 'malam') {
            $isOvertime = $currentTime->hour >= 21; // Setelah jam 9 malam
        }

        $todayAttendance->update([
            'check_out_time' => $currentTime->toDateTimeString(),
            'is_overtime' => $isOvertime,
        ]);

        return redirect()->back()->with('success', 'Check-out berhasil!');
    }
}
