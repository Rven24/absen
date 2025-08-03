<?php

namespace App\Http\Controllers;

use App\Models\DailyIncome; // Pastikan model DailyIncome diimpor
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EmployeeDailyIncomeController extends Controller
{
    /**
     * Menyimpan data pendapatan harian yang dikirim oleh karyawan.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'amount' => 'required|numeric|min:0', // Jumlah tunai harus angka dan tidak negatif
            'transfer_income' => 'required|numeric|min:0', // Jumlah transfer harus angka dan tidak negatif
        ]);

        $user = Auth::user(); // Dapatkan user yang sedang login
        $today = Carbon::today(); // Dapatkan tanggal hari ini

        // Periksa apakah pendapatan harian sudah dikirim untuk hari ini oleh user ini
        $existingDailyIncome = DailyIncome::where('user_id', $user->id)
                                        ->whereDate('date', $today)
                                        ->first();

        if ($existingDailyIncome) {
            // Jika sudah ada, kembalikan dengan pesan error
            return redirect()->back()->with('error', 'Anda sudah mengirim pendapatan harian untuk hari ini.');
        }

        // Buat record DailyIncome baru di database
        DailyIncome::create([
            'user_id' => $user->id,
            'date' => $today,
            'amount' => $request->amount,
            'transfer_income' => $request->transfer_income,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Pendapatan harian berhasil dikirim!');
    }
}
