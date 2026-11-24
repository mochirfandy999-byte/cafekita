<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter tanggal dan metode pembayaran
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;
        $metodePembayaran = $request->query('metode_pembayaran');

        // Validasi pilihan metode pembayaran
        if (!in_array($metodePembayaran, ['tunai', 'qris'])) {
            $metodePembayaran = null;
        }


        $pemesananQuery = Pemesanan::with(['user', 'meja'])
            ->orderBy('created_at', 'desc');

        if ($tanggalMulai) {
            $pemesananQuery->whereDate('created_at', '>=', $tanggalMulai);
        }

        if ($tanggalSelesai) {
            $pemesananQuery->whereDate('created_at', '<=', $tanggalSelesai);
        }

        $pemesanans = $pemesananQuery->get();
        $jumlahPemesanan = $pemesanans->count();

        // =========================
        // LAPORAN RESERVASI
        // =========================
        $reservasiQuery = Reservasi::with('meja')
            ->orderBy('tanggal_reservasi', 'desc')
            ->orderBy('jam_reservasi', 'desc');

        if ($tanggalMulai) {
            $reservasiQuery->whereDate('tanggal_reservasi', '>=', $tanggalMulai);
        }

        if ($tanggalSelesai) {
            $reservasiQuery->whereDate('tanggal_reservasi', '<=', $tanggalSelesai);
        }

        $reservasis = $reservasiQuery->get();

        $jumlahReservasi = $reservasis->count();

        $reservasiSelesai = $reservasis
            ->where('status', 'selesai')
            ->count();


        $pembayaranQuery = Pembayaran::with(['pemesanan', 'reservasi'])
            ->latest();

        // Filter tanggal
        if ($tanggalMulai) {
            $pembayaranQuery->whereDate('created_at', '>=', $tanggalMulai);
        }

        if ($tanggalSelesai) {
            $pembayaranQuery->whereDate('created_at', '<=', $tanggalSelesai);
        }

        // Filter metode pembayaran: tunai atau qris
        if ($metodePembayaran) {
            $pembayaranQuery->where(
                'metode_pembayaran',
                $metodePembayaran
            );
        }

        $pembayarans = $pembayaranQuery->get();

        $totalPendapatan = (clone $pembayaranQuery)
            ->where('status', 'lunas')
            ->sum('total_bayar');

        return view('laporan.index', compact(
            'pemesanans',
            'reservasis',
            'pembayarans',
            'jumlahPemesanan',
            'totalPendapatan',
            'jumlahReservasi',
            'reservasiSelesai',
            'tanggalMulai',
            'tanggalSelesai',
            'metodePembayaran'
        ));
    }
}
