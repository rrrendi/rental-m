<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index()
    {
        $users = User::all();
        $cars = Car::all();

        if (auth()->user()->role == 'admin') {
            $transactions = Transaction::with(['car', 'user'])->latest()->get();
        } else {
            $transactions = Transaction::with(['car'])->where('user_id', auth()->id())->latest()->get();
        }

        return view('transactions.index', compact('transactions', 'users', 'cars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $car = Car::findOrFail($request->car_id);

        $tglPinjam = Carbon::parse($request->tanggal_pinjam);
        $tglKembali = Carbon::parse($request->tanggal_kembali);
        $jumlahHari = $tglPinjam->diffInDays($tglKembali) ?: 1;
        $totalHarga = $jumlahHari * $car->harga;

        // Proses Unggah Bukti Pembayaran Manual oleh User
        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        Transaction::create([
            'user_id' => auth()->id(),
            'car_id' => $car->id,
            // PENTING: Gunakan 'tanggal_sewa' di sebelah kiri, tapi ambil dari request 'tanggal_pinjam' form HTML
            'tanggal_sewa' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'total_harga' => $totalHarga,
            'bukti_pembayaran' => $buktiPath,
            'status' => 'pending',
        ]);

        return redirect()->route('transactions.index')->with('success', 'Pemesanan sukses diajukan! Harap tunggu verifikasi admin.');
    }

    // Aksi Persetujuan Admin (Setujui)
    public function approve(Transaction $transaction)
    {
        $transaction->update(['status' => 'disetujui']);

        // Setelah disetujui, barulah status mobil berubah menjadi "tidak tersedia"
        $transaction->car->update(['status_mobil' => 'tidak tersedia']);

        return back()->with('success', 'Penyewaan disetujui! Status mobil otomatis terkunci.');
    }

    // Aksi Persetujuan Admin (Tolak)
    public function reject(Transaction $transaction)
    {
        $transaction->update(['status' => 'ditolak']);
        return back()->with('success', 'Pengajuan penyewaan telah ditolak.');
    }

    // Aksi Menyelesaikan Sesi Sewa (Mobil Dikembalikan)
    public function complete(Transaction $transaction)
    {
        $transaction->update(['status' => 'selesai']);

        // Lepas status mobil kembali menjadi "tersedia"
        $transaction->car->update(['status_mobil' => 'tersedia']);

        return redirect()->route('reports.index')->with('success', 'Transaksi selesai dan masuk laporan keuangan.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return back()->with('success', 'Transaksi berhasil dihapus.');
    }
}