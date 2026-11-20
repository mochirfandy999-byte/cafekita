<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    // Menampilkan daftar menu
    public function index()
    {
        $menus = Menu::orderBy('created_at', 'desc')->get();

        $totalMenu = $menus->count();
        $totalMakanan = $menus->where('kategori', 'makanan')->count();
        $totalMinuman = $menus->where('kategori', 'minuman')->count();

        return view('menus.index', compact(
            'menus',
            'totalMenu',
            'totalMakanan',
            'totalMinuman'
        ));
    }

    // Form tambah menu
    public function create()
    {
        $kodeMenu = $this->generateKodeMenu();

        return view('menus.create', compact('kodeMenu'));
    }

    // Membuat kode menu otomatis
    private function generateKodeMenu()
    {
        $nomorTerbesar = Menu::pluck('kode_menu')
            ->map(function ($kode) {
                if (preg_match('/^MNU-(\d+)$/', $kode, $hasil)) {
                    return (int) $hasil[1];
                }

                return 0;
            })
            ->max();

        $nomorBerikutnya = $nomorTerbesar + 1;

        return 'MNU-' . str_pad(
            $nomorBerikutnya,
            3,
            '0',
            STR_PAD_LEFT
        );
    }

    // Simpan menu baru
    public function store(Request $request)
    {
        // Menghilangkan titik pada harga
        $request->merge([
            'harga' => str_replace('.', '', $request->harga ?? '')
        ]);

        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'kategori'  => 'required|in:makanan,minuman',
            'varian'    => 'nullable|required_if:kategori,minuman|in:ice,hot',
            'harga'     => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {

            $kodeMenu = $this->generateKodeMenu();

            Menu::create([
                'kode_menu' => $kodeMenu,
                'nama_menu' => $request->nama_menu,
                'kategori'  => $request->kategori,
                'varian'    => $request->kategori == 'minuman'
                                ? $request->varian
                                : null,
                'harga'     => $request->harga,
            ]);
        });

        return redirect()->route('menus.index')
            ->with('success', 'Data menu berhasil ditambahkan.');
    }

    // Form ubah menu
    public function edit(Menu $menu)
    {
        return view('menus.edit', compact('menu'));
    }

    // Simpan perubahan menu
    public function update(Request $request, Menu $menu)
    {
        $request->merge([
            'harga' => str_replace('.', '', $request->harga ?? '')
        ]);

        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'kategori'  => 'required|in:makanan,minuman',
            'varian'    => 'nullable|required_if:kategori,minuman|in:ice,hot',
            'harga'     => 'required|numeric|min:0',
        ]);

        $menu->update([
            'nama_menu' => $request->nama_menu,
            'kategori'  => $request->kategori,
            'varian'    => $request->kategori == 'minuman'
                            ? $request->varian
                            : null,
            'harga'     => $request->harga,
        ]);

        return redirect()->route('menus.index')
            ->with('success', 'Data menu berhasil diperbarui.');
    }

    // Hapus menu
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('menus.index')
            ->with('success', 'Data menu berhasil dihapus.');
    }
}
