@extends('layouts.app')

@section('content')
    @php
        $now = now()->format('Y-m-d H:i:s');

        $fallbackBahanBakus = collect([
            // MNU-008: Soda strawberry
            (object) [
                'nama_bahan' => 'Sirup Strawberry',
                'jumlah' => 0,
                'satuan' => 'Botol',
                'updated_at' => $now
            ],
            (object) [
                'nama_bahan' => 'Air Soda',
                'jumlah' => 0,
                'satuan' => 'Kaleng',
                'updated_at' =>
                    $now
            ],

            // MNU-007: Coklat
            (object) ['nama_bahan' => 'Bubuk Coklat', 'jumlah' => 0, 'satuan' => 'kg', 'updated_at' => $now],

            // MNU-006: Matcha
            (object) ['nama_bahan' => 'Bubuk Matcha', 'jumlah' => 0, 'satuan' => 'kg', 'updated_at' => $now],

            // Bahan bersama minuman (Coklat & Matcha)
            (object) [
                'nama_bahan' => 'Susu Cair Full Cream (Coklat & Matcha)',
                'jumlah' => 0,
                'satuan' => 'Liter',
                'updated_at' =>
                    $now
            ],
            (object) ['nama_bahan' => 'Gula Pasir / Cair (Coklat & Matcha)', 'jumlah' => 0, 'satuan' => 'kg', 'updated_at' => $now],

            // MNU-005: Mix platter
            (object) ['nama_bahan' => 'Sosis', 'jumlah' => 0, 'satuan' => 'Pcs', 'updated_at' => $now],
            (object) [
                'nama_bahan' => 'Nugget Ayam',
                'jumlah' => 0,
                'satuan' => 'Pcs',
                'updated_at' =>
                    $now
            ],

            // MNU-004: Dimsum
            (object) ['nama_bahan' => 'Dimsum Ayam', 'jumlah' => 0, 'satuan' => 'Pcs', 'updated_at' => $now],

            // MNU-003: Siomay
            (object) ['nama_bahan' => 'Siomay', 'jumlah' => 0, 'satuan' => 'Pcs', 'updated_at' => $now],

            // MNU-002: Kentang goreng (& ikut dipakai di Mix platter)
            (object) [
                'nama_bahan' => 'Kentang Goreng Beku (Kentang goreng & Mix platter)',
                'jumlah' => 0,
                'satuan' => 'kg',
                'updated_at' => $now
            ],

            // MNU-001: Tahu walik
            (object) ['nama_bahan' => 'Tahu Walik', 'jumlah' => 0, 'satuan' => 'Pcs', 'updated_at' => $now],

            // Bahan gorengan & pelengkap umum
            (object) ['nama_bahan' => 'Minyak Goreng (Makanan)', 'jumlah' => 0, 'satuan' => 'Liter', 'updated_at' => $now],
            (object) ['nama_bahan' => 'Saus Sambal & Mayones (Makanan)', 'jumlah' => 0, 'satuan' => 'Botol', 'updated_at' => $now],
        ]);

        $dataRekap = (isset($bahanBakus) && count($bahanBakus) > 0) ? $bahanBakus : $fallbackBahanBakus;
    @endphp

    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark">Laporan Rekap Bahan Baku</h2>
                <p class="text-muted mb-0">Kelola dan lihat rekap data stok bahan baku CafeKita (8 Menu Tersedia).</p>
            </div>
            <a href="{{ route('laporan.bahan-baku.store') }}" class="btn btn-success">
                <i class="fas fa-save me-1"></i> Simpan Laporan
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Bahan Baku</th>
                            <th>Stok Tersedia</th>
                            <th>Satuan</th>
                            <th>Terakhir Diperbarui</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataRekap as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama_bahan }}</td>
                                <td>{{ $item->jumlah }}</td>
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
    </div>
@endsection