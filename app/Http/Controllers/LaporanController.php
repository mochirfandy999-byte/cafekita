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
        // Ambil tanggal filter
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;

        // =========================
        // LAPORAN PEMESANAN
        // =========================
        $pemesananQuery = Pemesanan::with(['user', 'meja'])
            ->orderBy('created_at', 'desc');

        if ($tanggalMulai) {
            $pemesananQuery->whereDate('created_at', '>=', $tanggalMulai);
        }

        if ($tanggalSelesai) {
            $pemesananQuery->whereDate('created_at', '<=', $tanggalSelesai);
        }

        $pemesanans = $pemesananQuery->get();

        // Total pemesanan
        $jumlahPemesanan = $pemesanans->count();

        
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

        // Jumlah reservasi
        $jumlahReservasi = $reservasis->count();

        // Reservasi selesai
        $reservasiSelesai = $reservasis
            ->where('status', 'selesai')
            ->count();


        // =========================
        // LAPORAN PEMBAYARAN / PENDAPATAN
        // =========================
        $pembayaranQuery = Pembayaran::with(['pemesanan', 'reservasi'])
            ->latest();

        if ($tanggalMulai) {
            $pembayaranQuery->whereDate('created_at', '>=', $tanggalMulai);
        }

        if ($tanggalSelesai) {
            $pembayaranQuery->whereDate('created_at', '<=', $tanggalSelesai);
        }

        $pembayarans = $pembayaranQuery->get();

        // Total pendapatan dihitung dari total_bayar pembayaran yang lunas dan terfilter tanggal
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
            'tanggalSelesai'
        ));
    }
}