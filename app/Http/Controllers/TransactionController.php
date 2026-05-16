<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class TransactionController extends Controller
{
    public function index()
    {
        // Logika Laporan: Admin bisa melihat semua data, sedangkan User biasa hanya melihat riwayat miliknya sendiri
        if (Auth::user()->role === 'admin') {
            $transactions = Transaction::with(['car', 'user'])->latest()->get();
            $cars = Car::all();
            $users = User::where('role', 'user')->get();
            return view('transactions.index', compact('transactions', 'cars', 'users'));
        } else {
            $transactions = Transaction::with(['car', 'user'])
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
            return view('transactions.user_index', compact('transactions'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'tanggal_sewa' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_sewa',
        ]);

        // Jika penginput adalah admin, user_id diambil dari form select. Jika pelanggan, diambil dari Auth::id()
        $userId = Auth::user()->role === 'admin' ? $request->user_id : Auth::id();
        
        if (Auth::user()->role === 'admin' && !$userId) {
            return redirect()->back()->withErrors(['user_id' => 'Penyewa wajib dipilih oleh admin.'])->withInput();
        }

        // Jalankan Logika Anti Overbooking: Periksa jadwal sewa yang bertabrakan
        $isBooked = Transaction::where('car_id', $request->car_id)
            ->whereIn('status', ['pending', 'aktif'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_sewa', [$request->tanggal_sewa, $request->tanggal_kembali])
                      ->orWhereBetween('tanggal_kembali', [$request->tanggal_sewa, $request->tanggal_kembali])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('tanggal_sewa', '<=', $request->tanggal_sewa)
                            ->where('tanggal_kembali', '>=', $request->tanggal_kembali);
                      });
            })->exists();

        if ($isBooked) {
            return redirect()->back()->withErrors(['car_id' => 'Mobil ini tidak tersedia pada tanggal yang Anda pilih karena sudah dipesan/aktif.'])->withInput();
        }

        // Menentukan status awal berdasarkan siapa yang melakukan pemesanan
        $statusAwal = Auth::user()->role === 'admin' ? 'aktif' : 'pending';

        Transaction::create([
            'user_id' => $userId,
            'car_id' => $request->car_id,
            'tanggal_sewa' => $request->tanggal_sewa,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => $statusAwal,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan ke dalam sistem.');
    }

    // Mengubah status dari 'pending' menjadi 'aktif' ketika admin menyerahkan kunci mobil fisik
    public function approve(Transaction $transaction)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Aksi ini hanya dapat dilakukan oleh Admin.');
        }

        $transaction->update(['status' => 'aktif']);
        return redirect()->route('transactions.index')->with('success', 'Pemesanan disetujui. Status kendaraan sekarang aktif disewa.');
    }

    // Mengubah status dari 'aktif' menjadi 'selesai' dan menghitung biaya otomatis saat pengembalian mobil
    public function complete(Transaction $transaction)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Aksi ini hanya dapat dilakukan oleh Admin.');
        }

        $tglSewa = Carbon::parse($transaction->tanggal_sewa);
        $tglKembali = Carbon::parse($transaction->tanggal_kembali);
        
        $durasiHari = $tglSewa->diffInDays($tglKembali);
        if ($durasiHari == 0) {
            $durasiHari = 1;
        }

        $totalHarga = $durasiHari * $transaction->car->harga;

        $transaction->update([
            'status' => 'selesai',
            'total_harga' => $totalHarga
        ]);

        return redirect()->route('transactions.index')->with('success', 'Mobil berhasil dikembalikan. Biaya sewa tercatat otomatis.');
    }

    public function destroy(Transaction $transaction)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Aksi ini hanya dapat dilakukan oleh Admin.');
        }

        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Data transaksi berhasil dihapus dari sistem.');
    }
}