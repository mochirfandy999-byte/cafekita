<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;

class LaporanBahanBakuController extends Controller
{
    /**
     * Menampilkan daftar stok bahan baku untuk diperiksa & dikelola Staff Dapur.
     */
    public function index(Request $request)
    {
        $bahanBakus = BahanBaku::orderBy('id')->get();
        $isKelolaMode = $request->boolean('mode') || session()->has('success') || session()->has('errors');

        return view('laporan.bahan-baku', compact('bahanBakus', 'isKelolaMode'));
    }

    /**
     * Memvalidasi perubahan jumlah stok dan menyimpan ke database,
     * lalu menampilkan pesan sukses untuk verifikasi ketersediaan stok.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'added_item_name' => ['nullable', 'string', 'max:255'],
            'items' => ['required', 'array'],
            'items.*.id' => ['nullable'],
            'items.*.nama_bahan' => ['required', 'string', 'max:255'],
            'items.*.jumlah' => ['required', 'numeric', 'min:0'],
            'items.*.satuan' => ['required', 'string', 'max:50'],
        ], [
            'items.*.jumlah.required' => 'Perubahan jumlah stok wajib diisi.',
            'items.*.jumlah.numeric' => 'Perubahan jumlah stok harus berupa angka.',
            'items.*.jumlah.min' => 'Perubahan jumlah stok tidak boleh kurang dari 0.',
        ]);

        foreach ($validated['items'] as $row) {
            BahanBaku::updateOrCreate(
                ['nama_bahan' => $row['nama_bahan']],
                [
                    'jumlah' => $row['jumlah'],
                    'satuan' => $row['satuan'],
                ]
            );
        }

        $addedItem = $validated['added_item_name'] ?? null;
        $pesanSukses = $addedItem
            ? "Stok {$addedItem} berhasil ditambah +1, divalidasi, dan disimpan. Silakan lihat dan verifikasi ketersediaan stok bahan baku."
            : 'Perubahan stok bahan baku berhasil divalidasi dan disimpan. Silakan lihat dan verifikasi ketersediaan stok bahan baku.';

        return redirect()
            ->route('laporan.bahan-baku.index', ['mode' => 1])
            ->with('success', $pesanSukses);
    }
}