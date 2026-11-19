@extends('layouts.app')

@section('content')
@php
$now = now()->format('Y-m-d H:i:s');

$fallbackBahanBakus = collect([
(object) ['id' => null, 'nama_bahan' => 'Sirup Strawberry', 'jumlah' => 0, 'satuan' => 'Botol', 'updated_at' => $now],
(object) ['id' => null, 'nama_bahan' => 'Air Soda', 'jumlah' => 0, 'satuan' => 'Kaleng', 'updated_at' => $now],
(object) ['id' => null, 'nama_bahan' => 'Bubuk Coklat', 'jumlah' => 0, 'satuan' => 'kg', 'updated_at' => $now],
(object) ['id' => null, 'nama_bahan' => 'Bubuk Matcha', 'jumlah' => 0, 'satuan' => 'kg', 'updated_at' => $now],
(object) ['id' => null, 'nama_bahan' => 'Susu Cair Full Cream (Coklat & Matcha)', 'jumlah' => 0, 'satuan' => 'Liter',
'updated_at' => $now],
(object) ['id' => null, 'nama_bahan' => 'Gula Pasir / Cair (Coklat & Matcha)', 'jumlah' => 0, 'satuan' => 'kg',
'updated_at' => $now],
(object) ['id' => null, 'nama_bahan' => 'Sosis', 'jumlah' => 0, 'satuan' => 'Pcs', 'updated_at' => $now],
(object) ['id' => null, 'nama_bahan' => 'Nugget Ayam', 'jumlah' => 0, 'satuan' => 'Pcs', 'updated_at' => $now],
(object) ['id' => null, 'nama_bahan' => 'Dimsum Ayam', 'jumlah' => 0, 'satuan' => 'Pcs', 'updated_at' => $now],
(object) ['id' => null, 'nama_bahan' => 'Siomay', 'jumlah' => 0, 'satuan' => 'Pcs', 'updated_at' => $now],
(object) ['id' => null, 'nama_bahan' => 'Kentang Goreng Beku (Kentang goreng & Mix platter)', 'jumlah' => 0, 'satuan' =>
'kg', 'updated_at' => $now],
(object) ['id' => null, 'nama_bahan' => 'Tahu Walik', 'jumlah' => 0, 'satuan' => 'Pcs', 'updated_at' => $now],
(object) ['id' => null, 'nama_bahan' => 'Minyak Goreng (Makanan)', 'jumlah' => 0, 'satuan' => 'Liter', 'updated_at' =>
$now],
(object) ['id' => null, 'nama_bahan' => 'Saus Sambal & Mayones (Makanan)', 'jumlah' => 0, 'satuan' => 'Botol',
'updated_at' => $now],
]);

$dataRekap = (isset($bahanBakus) && count($bahanBakus) > 0) ? $bahanBakus : $fallbackBahanBakus;
$modeKelola = $isKelolaMode ?? request()->boolean('mode');
@endphp

<div class="container-fluid px-4 py-4">
    <form action="{{ route('laporan.bahan-baku.store') }}" method="POST" id="formRekapBahanBaku">
        @csrf
        <input type="hidden" name="added_item_name" id="added_item_name" value="">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark">Laporan Rekap Bahan Baku</h2>
                <p class="text-muted mb-0">
                    @if($modeKelola)
                    Mode Kelola Stok Aktif: periksa detail, input perubahan stok (ya/tidak), simpan untuk validasi, lalu
                    verifikasi ketersediaan stok.
                    @else
                    Daftar stok bahan baku CafeKita. Klik <strong>Kelola Stok Bahan Baku</strong> untuk memperbarui atau
                    menambah stok.
                    @endif
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('laporan.bahan-baku.index', ['mode' => 1]) }}"
                    class="btn {{ $modeKelola ? 'btn-primary' : 'btn-outline-success' }}">
                    <i class="fas fa-boxes-stacked me-1"></i> Kelola Stok Bahan Baku
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Simpan Laporan
                </button>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="fw-semibold">Pesan Sukses &amp; Verifikasi Ketersediaan Stok</div>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <div class="fw-semibold mb-1">Validasi perubahan stok gagal:</div>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nama Bahan Baku</th>
                            <th style="width: 210px;">Stok Tersedia</th>
                            <th style="width: 110px;">Satuan</th>
                            <th style="width: 190px;">Terakhir Diperbarui</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataRekap as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                {{ $item->nama_bahan }}
                                <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id ?? '' }}">
                                <input type="hidden" name="items[{{ $index }}][nama_bahan]"
                                    value="{{ $item->nama_bahan }}">
                                <input type="hidden" name="items[{{ $index }}][satuan]" value="{{ $item->satuan }}">
                            </td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <input type="number" step="0.01" min="0" id="stok-input-{{ $index }}"
                                        name="items[{{ $index }}][jumlah]"
                                        value="{{ old("items.$index.jumlah", $item->jumlah) }}" class="form-control"
                                        {{ $modeKelola ? '' : 'readonly' }} required>
                                    @if($modeKelola)
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="tambahStokCepat({{ $index }}, 1, @js($item->nama_bahan))"
                                        title="Tambah +1 dan simpan">+1</button>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $item->satuan }}</td>
                            <td>{{ $item->updated_at }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data bahan baku.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>

<script>
function tambahStokCepat(index, delta, namaBahan) {
    const input = document.getElementById('stok-input-' + index);
    const form = document.getElementById('formRekapBahanBaku');
    const addedNameInput = document.getElementById('added_item_name');
    if (!input || !form) return;

    const current = parseFloat(input.value) || 0;
    input.value = Math.max(0, +(current + delta).toFixed(2));

    if (addedNameInput) {
        addedNameInput.value = namaBahan || '';
    }

    form.submit();
}
</script>
@endsection