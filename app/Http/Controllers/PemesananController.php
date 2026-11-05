<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
use App\Models\Pembayaran;
use App\Models\Menu;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
  public function index()
{
    // Ganti $pemesanans menjadi $semuaPesanan
    $semuaPesanan = Pemesanan::with(['meja', 'user'])->latest()->get();

    $reservasis = Reservasi::with('meja')->latest()->get();

    $totalPemesanan = $semuaPesanan->count();
    $totalReservasi = $reservasis->count();
    $pemesananSelesai = $semuaPesanan->where('status', 'selesai')->count();
    $totalPendapatan = Pembayaran::where('status', 'lunas')->sum('total_bayar');
    $reservasiBatal   = $reservasis->where('status', 'Dibatalkan')->count();

    return view('pemesanans.index', compact(
        'semuaPesanan', 
        'reservasis', 
        'totalPemesanan', 
        'totalReservasi', 
        'pemesananSelesai', 
        'totalPendapatan',
        'reservasiBatal'
    ));
}
    public function detailPemesanans()
{
    return $this->hasMany(DetailPemesanan::class, 'pemesanan_id');
}

     public function create(Request $request)
    {
        $reservasi = null;
        if ($request->filled('reservasi_id')) {
            $reservasi = Reservasi::find($request->reservasi_id);
        }

        // Tampilkan meja tersedia, ATAU meja yang sedang dipesan oleh reservasi ini
        $mejas = Meja::where('status', 'tersedia')
            ->when($reservasi, function ($query) use ($reservasi) {
                return $query->orWhere('id', $reservasi->meja_id);
            })
            ->get();

        $menus = Menu::all();

        return view('pemesanans.create', compact('mejas', 'menus', 'reservasi'));
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'meja_id'           => 'required|exists:mejas,id',
        'nama_pelanggan'    => 'required|string|max:100',
        'catatan'           => 'nullable|string|max:255',
        'menu_id'           => 'required|array|min:1',
        'menu_id.*'         => 'required|exists:menus,id',
        'jumlah'            => 'required|array|min:1',
        'jumlah.*'          => 'required|integer|min:1',
        'total_bayar'       => 'required|numeric|min:0',
        'metode_pembayaran' => 'required|in:tunai,qris',
        'uang_dibayar'      => 'nullable|numeric|min:0',
    ], [
        'meja_id.required'           => 'Meja wajib dipilih.',
        'nama_pelanggan.required'    => 'Nama pelanggan wajib diisi.',
        'menu_id.required'           => 'Pilih minimal satu menu.',
        'jumlah.*.min'               => 'Jumlah item minimal 1.',
        'total_bayar.required'       => 'Total bayar tidak valid.',
        'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih.',
    ]);

    $meja = Meja::findOrFail($validated['meja_id']);

    if (strtolower($meja->status) !== 'tersedia') {
        return back()
            ->withInput()
            ->with('error', 'Meja tersebut sudah tidak tersedia.');
    }

    $nomorPemesanan = 'PMS-' . date('YmdHis') . '-' . random_int(100, 999);

    // Hitung nominal uang dibayar dan kembalian
    $metode = $validated['metode_pembayaran'];
    $totalBayar = (float) $validated['total_bayar'];

    if ($metode === 'tunai') {
        $uangDibayar = (float) ($request->uang_dibayar ?? 0);
        $kembalian = max(0, $uangDibayar - $totalBayar);
    } else {
        $uangDibayar = $totalBayar;
        $kembalian = 0;
    }

    $pemesanan = DB::transaction(function () use ($validated, $meja, $nomorPemesanan, $request, $totalBayar, $uangDibayar, $kembalian) {
        
        // 1. Simpan Header Pemesanan (HANYA DATA PESANAN)
        $pesanan = Pemesanan::create([
            'nomor_transaksi'   => $nomorPemesanan,
            'user_id'           => auth()->id(),
            'meja_id'           => $validated['meja_id'],
            'nama_pelanggan'    => $validated['nama_pelanggan'],
            'catatan'           => $request->catatan,
            'tanggal_transaksi' => now(),
            'total_bayar'       => $totalBayar,
            'status'            => 'selesai',
        ]);
// Tentukan apakah ini dari pemesanan atau reservasi berdasarkan input form atau request
Pembayaran::create([
    'pemesanan_id'      => $pesanan->id ?? null,       // Isi jika dari pemesanan, null jika dari reservasi
    'reservasi_id'      => $reservasi->id ?? null,     // Isi dengan ID reservasi jika transaksinya dari reservasi
    'metode_pembayaran' => $validated['metode_pembayaran'],
    'total_bayar'       => $totalBayar,
    'uang_dibayar'      => $uangDibayar,
    'kembalian'         => $kembalian,
    'status'            => 'lunas',
]);

        // 3. Simpan Rincian Menu Pesanan
        foreach ($validated['menu_id'] as $index => $menuId) {
            $menu = Menu::find($menuId);
            $qty  = $validated['jumlah'][$index];

            DetailPemesanan::create([
                'pemesanan_id' => $pesanan->id,
                'menu_id'      => $menuId,
                'jumlah'       => $qty,
                'harga_satuan' => $menu->harga,
                'subtotal'     => $menu->harga * $qty,
            ]);
        }

        // 4. Ubah status meja menjadi terisi
        $meja->update(['status' => 'terisi']);

        return $pesanan;
    });

    return redirect()
        ->route('pemesanans.nota', $pemesanan->id)
        ->with('success', 'Pemesanan berhasil disimpan! Silakan cetak nota.');

        if ($request->filled('reservasi_id')) {
        $reservasi = Reservasi::find($request->reservasi_id);
        if ($reservasi) {
            $reservasi->update(['status' => 'selesai']); // Sesuaikan nilai status di database
        }
    }

    return redirect()->route('pemesanans.index')->with('success', 'Pemesanan berhasil dibuat!');

}

// Method untuk menampilkan Nota Pemesanan
public function nota($id)
{
    $pemesanan = Pemesanan::with(['meja', 'user', 'detailPemesanans.menu'])->findOrFail($id);
    return view('pemesanans.nota', compact('pemesanan'));
}

    /**
     * Form edit pemesanan.
     */
    public function edit(Pemesanan $pemesanan)
    {
        $mejas = Meja::orderBy('nomor_meja')->get();

        return view('pemesanans.edit', compact(
            'pemesanan',
            'mejas'
        ));
    }

    /**
     * Update pemesanan.
     */
    public function update(Request $request, Pemesanan $pemesanan)
    {
        $validated = $request->validate([
            'meja_id' => 'required|exists:mejas,id',
            'nama_pelanggan' => 'required|string|max:100',
            'total_bayar' => 'required|numeric|min:0',
            'status' => 'required|in:pending,selesai,batal',
        ]);

        $pemesanan->update($validated);

       return redirect()->route('pemesanans.index')->with('success', 'Pemesanan berhasil disimpan!');
    }

    /**
     * Hapus pemesanan.
     */
    public function destroy(Pemesanan $pemesanan)
    {
        $pemesanan->delete();

        return redirect()
            ->route('pemesanans.index')
            ->with('success', 'Pemesanan berhasil dihapus.');
    }
}