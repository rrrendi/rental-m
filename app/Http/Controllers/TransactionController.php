<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['car', 'user'])->latest()->get();
        $cars = Car::all();
        $users = User::all();
        
        return view('transactions.index', compact('transactions', 'cars', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'tanggal_sewa' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_sewa',
        ]);

        // Cek Ketersediaan Mobil (Mencegah Overbooking)
        $isBooked = Transaction::where('car_id', $request->car_id)
            ->where('status', 'aktif')
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_sewa', [$request->tanggal_sewa, $request->tanggal_kembali])
                      ->orWhereBetween('tanggal_kembali', [$request->tanggal_sewa, $request->tanggal_kembali])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('tanggal_sewa', '<=', $request->tanggal_sewa)
                            ->where('tanggal_kembali', '>=', $request->tanggal_kembali);
                      });
            })->exists();

        if ($isBooked) {
            return redirect()->back()->withErrors(['car_id' => 'Gagal! Mobil tersebut sudah disewa pada rentang tanggal yang dipilih.'])->withInput();
        }

        Transaction::create([
            'user_id' => $request->user_id,
            'car_id' => $request->car_id,
            'tanggal_sewa' => $request->tanggal_sewa,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'aktif',
        ]);

        return redirect()->route('transactions.index')->with('success', 'Data transaksi berhasil dicatat.');
    }

    public function complete(Transaction $transaction)
    {
        $tglSewa = Carbon::parse($transaction->tanggal_sewa);
        $tglKembali = Carbon::parse($transaction->tanggal_kembali);
        
        $hari = $tglSewa->diffInDays($tglKembali);
        if ($hari == 0) $hari = 1; 

        $totalHarga = $hari * $transaction->car->harga;

        $transaction->update([
            'status' => 'selesai',
            'total_harga' => $totalHarga
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaksi diselesaikan. Total harga telah dihitung.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Data transaksi berhasil dihapus.');
    }
}