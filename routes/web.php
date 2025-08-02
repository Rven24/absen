<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Langsung arahkan ke halaman login Filament
Route::get('/', function () {
    return redirect()->route('filament.absen.auth.login'); // Ganti 'admin' jika nama panel Anda berbeda
});

require __DIR__.'/auth.php';

// Override Filament login routes
Route::get('absen/login', [AuthenticatedSessionController::class, 'create'])->name('filament.absen.auth.login');
Route::post('absen/login', [AuthenticatedSessionController::class, 'store'])->name('filament.absen.auth.login.post');

Route::middleware(['auth'])->group(function () {
    // Route untuk karyawan
    Route::get('/absensi', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/absensi/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/absensi/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');

    // Redirect setelah login
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('filament.absen.pages.dashboard'); // Arahkan ke dashboard Filament
        }
        return redirect()->route('attendance.index'); // Arahkan karyawan ke halaman absensi
    })->name('dashboard');
});
