<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;

class LaporanBahanBakuController extends Controller
{
    public function index()
    {
        // Mengambil seluruh data rekap bahan baku dari database
        $bahanBakus = BahanBaku::all();

        // Mengarahkan ke file view laporan
        return view('laporan.bahan-baku', compact('bahanBakus'));
    }

    public function store()
    {
        // Aksi ketika tombol simpan laporan diklik
        return redirect()->route('laporan.bahan-baku')->with('success', 'Laporan rekap bahan baku berhasil disimpan.');
    }
}