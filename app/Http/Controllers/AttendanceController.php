<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('check_in_time', Carbon::today())
            ->first();

        $attendances = Attendance::where('user_id', $user->id)
            ->latest()
            ->paginate(5);

        return view('attendance.index', compact('todayAttendance', 'attendances'));
    }

    public function checkIn(Request $request)
    {
        $user = Auth::user();

        $currentTime = Carbon::now();

        if ($user->shift === 'pagi') {
            if ($currentTime->hour < 7 || $currentTime->hour >= 9) {
                return redirect()->back()->with('error', 'Check-in hanya bisa dilakukan pada jam 7 sampai jam 9 pagi untuk shift pagi.');
            }
        } elseif ($user->shift === 'malam') {
            if ($currentTime->hour < 15 || $currentTime->hour >= 5) {
                return redirect()->back()->with('error', 'Check-in hanya bisa dilakukan pada jam 3 sampai jam 5 sore untuk shift malam.');
            }
        } else {
            return redirect()->back()->with('error', 'Shift karyawan tidak valid.');
        }

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
            'date_check_in' => $currentTime->toDateTimeString(),
            'check_in_time' => $currentTime->toDateTimeString(),
            'is_late' => $isLate,
        ]);

        return redirect()->back()->with('success', 'Check-in berhasil! Kamu ' . ($attendance->is_late ? 'Terlambat' : 'Tidak Terlambat'));
    }

    public function checkOut(Request $request)
    {
        $user = Auth::user();

        $currentTime = Carbon::now();

        if ($user->shift === 'pagi') {
            if ($currentTime->hour >= 24) {
                return redirect()->back()->with('error', 'Check-out hanya bisa dilakukan sampai jam 24.');
            }
        } elseif ($user->shift === 'malam') {
            if ($currentTime->hour >= 24) {
                return redirect()->back()->with('error', 'Check-out hanya bisa dilakukan sampai jam 24.');
            }
        } else {
            return redirect()->back()->with('error', 'Shift karyawan tidak valid.');
        }

        $todayAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('check_in_time', Carbon::today())
            ->whereNull('check_out_time')
            ->first();

        if (! $todayAttendance) {
            return redirect()->back()->with('error', 'Anda belum melakukan Check-in hari ini atau sudah Check-out.');
        }

        $isOvertime = false;
        if ($user->shift === 'pagi') {
            $isOvertime = $currentTime->hour >= 15;
        } elseif ($user->shift === 'malam') {
            $isOvertime = $currentTime->hour >= 21;
        }

        $todayAttendance->update([
            'check_out_time' => $currentTime->toDateTimeString(),
            'is_overtime' => $isOvertime,
        ]);

        return redirect()->back()->with('success', 'Check-out berhasil!');
    }
}
