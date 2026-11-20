<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    /**
     * Menampilkan semua data meja
     */
    public function index()
    {
        $mejas = Meja::latest()->get();

        return view('mejas.index', compact('mejas'));
    }

    /**
     * Menampilkan form tambah meja
     */
    public function create()
    {
        // Ambil data meja terakhir berdasarkan ID atau nomor meja
        $lastMeja = Meja::orderBy('id', 'desc')->first();

        if (!$lastMeja) {
            // Jika belum ada data sama sekali, mulai dari M01
            $nomorOtomatis = 'M01';
        } else {
            // Ambil angka dari nomor meja terakhir (misal "M05" -> 5)
            // Asumsi format selalu diawali 1 huruf ("M") diikuti angka
            $lastNumber = (int) substr($lastMeja->nomor_meja, 1);
            $nextNumber = $lastNumber + 1;

            // Format ulang menjadi M01, M02, ... M10
            $nomorOtomatis = 'M' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
        }

        return view('mejas.create', compact('nomorOtomatis'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_meja' => 'required|max:50|unique:mejas,nomor_meja',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:tersedia,terisi,reservasi',
            'keterangan' => 'nullable|string',
        ], [
            'nomor_meja.required' => 'Nomor meja wajib diisi.',
            'nomor_meja.unique' => 'Nomor meja sudah digunakan.',
            'kapasitas.required' => 'Kapasitas wajib diisi.',
            'kapasitas.integer' => 'Kapasitas harus berupa angka.',
            'kapasitas.min' => 'Kapasitas minimal 1.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        Meja::create($validated);

        return redirect()
            ->route('mejas.index')
            ->with('success', 'Data meja berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit meja
     */
    public function edit(Meja $meja)
    {
        return view('mejas.edit', compact('meja'));
    }

    /**
     * Memperbarui data meja
     */
    public function update(Request $request, Meja $meja)
    {
        $validated = $request->validate([
            'nomor_meja' => 'required|string|max:50|unique:mejas,nomor_meja,' . $meja->id,
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:tersedia,terisi,reservasi',
            'keterangan' => 'nullable|string',
        ]);

        $meja->update($validated);

        return redirect()
            ->route('mejas.index')
            ->with('success', 'Data meja berhasil diperbarui.');
    }

    /**
     * Menghapus data meja
     */
    public function destroy(Meja $meja)
    {
        $meja->delete();

        return redirect()
            ->route('mejas.index')
            ->with('success', 'Data meja berhasil dihapus.');
    }
}
