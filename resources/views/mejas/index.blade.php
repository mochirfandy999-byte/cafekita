@extends('layouts.app')

@section('title', 'Data Meja')

@section('content')
<div class="page-content">

    {{-- HEADER HALAMAN --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title text-success-emphasis fw-bold mb-1 fs-3">Data Meja</h2>
            <p class="page-subtitle text-muted mb-0">Kelola data dan status meja CafeKita</p>
        </div>

        <a href="{{ route('mejas.create') }}" class="btn btn-success" style="background-color: #304e3a; border:none; border-radius:11px; padding: 10px 16px;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Meja
        </a>
    </div>

    {{-- ALERT NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 rounded-4" style="font-size: 13px;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 rounded-4" style="font-size: 13px;">
            <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- PERHITUNGAN STATUS MEJA SECARA AMAN (TIDAK DIUBAH SAMA SEKALI) --}}
    @php
        $jmlTotalMeja = $mejas->count();
        $jmlTersedia = 0;
        $jmlTerisi = 0;
        $jmlReservasi = 0;

        foreach ($mejas as $m) {
            if ($m->status === 'tersedia') {
                $jmlTersedia++;
            } elseif ($m->status === 'terisi') {
                $jmlTerisi++;
            } elseif ($m->status === 'reservasi') {
                $jmlReservasi++;
            }
        }
    @endphp

    {{-- CARD KETERANGAN STATUS --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                <div class="card-body p-4">
                    <div class="stat-icon mb-3 d-flex align-items-center justify-content-center rounded-3" style="width: 45px; height: 45px; background: #eef4f0; color: #304e3a; font-size:20px;">
                        <i class="bi bi-grid-3x3-gap-fill"></i>
                    </div>
                    <div class="fs-4 fw-bold mb-1 text-dark">{{ $jmlTotalMeja }}</div>
                    <div class="text-muted fw-semibold" style="font-size: 13px;">Jumlah Meja</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                <div class="card-body p-4">
                    <div class="stat-icon mb-3 d-flex align-items-center justify-content-center rounded-3" style="width: 45px; height: 45px; background: #e9f5ed; color: #287044; font-size:20px;">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="fs-4 fw-bold mb-1 text-success">{{ $jmlTersedia }}</div>
                    <div class="text-muted fw-semibold" style="font-size: 13px;">Status Tersedia</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                <div class="card-body p-4">
                    <div class="stat-icon mb-3 d-flex align-items-center justify-content-center rounded-3" style="width: 45px; height: 45px; background: #fff4ea; color: #c9711e; font-size:20px;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="fs-4 fw-bold mb-1 text-warning">{{ $jmlTerisi }}</div>
                    <div class="text-muted fw-semibold" style="font-size: 13px;">Status Terisi</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                <div class="card-body p-4">
                    <div class="stat-icon mb-3 d-flex align-items-center justify-content-center rounded-3" style="width: 45px; height: 45px; background: #fdf5e7; color: #a37c32; font-size:20px;">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="fs-4 fw-bold mb-1 text-secondary">{{ $jmlReservasi }}</div>
                    <div class="text-muted fw-semibold" style="font-size: 13px;">Status Reservasi</div>
                </div>
            </div>
        </div>
    </div>

    {{-- DAFTAR TABEL MEJA --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1 fw-bold" style="color: #304e3a;">
                    <i class="bi bi-grid-3x3-gap-fill me-2"></i> Daftar Meja
                </h5>
                <div class="text-muted" style="font-size: 12px;">Daftar meja yang tersedia di CafeKita</div>
            </div>
            <span class="badge rounded-pill" style="background:#edf3ee; color:#304e3a;">
                {{ $jmlTotalMeja }} Data
            </span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                @if($mejas->count() > 0)
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: #fafbfa;">
                            <tr>
                                <th class="text-muted fw-semibold text-uppercase px-4 py-3" style="font-size: 12px;">No</th>
                                <th class="text-muted fw-semibold text-uppercase px-4 py-3" style="font-size: 12px;">Nomor Meja</th>
                                <th class="text-muted fw-semibold text-uppercase px-4 py-3" style="font-size: 12px;">Kapasitas</th>
                                <th class="text-muted fw-semibold text-uppercase px-4 py-3" style="font-size: 12px;">Status</th>
                                <th class="text-muted fw-semibold text-uppercase px-4 py-3" style="font-size: 12px;">Keterangan</th>
                                <th class="text-muted fw-semibold text-uppercase px-4 py-3 text-center" style="font-size: 12px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mejas as $meja)
                                <tr>
                                    <td class="px-4 py-3" style="font-size:13px; color:#4f5952;">{{ $loop->iteration }}</td>
                                    
                                    <td class="px-4 py-3">
                                        <span class="d-inline-flex align-items-center justify-content-center fw-bold" style="min-width: 42px; height: 34px; padding: 0 10px; border-radius: 9px; background: #edf3ee; color: #304e3a; font-size:13px;">
                                            {{ $meja->nomor_meja }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3" style="font-size:13px; color:#4f5952;">
                                        <i class="bi bi-people-fill me-1 text-muted"></i>
                                        {{ $meja->kapasitas }} orang
                                    </td>

                                    <td class="px-4 py-3">
                                        @if($meja->status === 'tersedia')
                                            <span class="badge rounded-pill px-3 py-2" style="background: #e9f5ed; color: #287044; font-size: 11px;">
                                                <i class="bi bi-check-circle-fill me-1"></i> Tersedia
                                            </span>
                                        @elseif($meja->status === 'terisi')
                                            <span class="badge rounded-pill px-3 py-2" style="background: #fff1e5; color: #a86424; font-size: 11px;">
                                                <i class="bi bi-person-fill me-1"></i> Terisi
                                            </span>
                                        @else
                                            <span class="badge rounded-pill px-3 py-2" style="background: #f8f0dc; color: #9a742e; font-size: 11px;">
                                                <i class="bi bi-calendar-check-fill me-1"></i> Reservasi
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3" style="font-size:13px; color:#4f5952;">
                                        {{ $meja->keterangan ?: '-' }}
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('mejas.edit', $meja->id) }}" class="btn btn-sm d-inline-flex align-items-center justify-content-center rounded-3" style="width: 34px; height: 34px; background: #edf3ee; color: #466b52;" title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('mejas.destroy', $meja->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus meja ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm d-inline-flex align-items-center justify-content-center rounded-3" style="width: 34px; height: 34px; background: #fff0f0; color: #b24b4b;" title="Hapus">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-5">
                        <div class="d-flex justify-content-center align-items-center rounded-circle mx-auto mb-3" style="width: 60px; height: 60px; background: #edf3ee; color: #304e3a; font-size: 25px;">
                            <i class="bi bi-grid-3x3-gap"></i>
                        </div>
                        <h6 class="fw-bold" style="color: #68736c;">Belum Ada Data Meja</h6>
                        <p class="text-muted small mb-3">Silakan tambahkan data meja terlebih dahulu.</p>
                        <a href="{{ route('mejas.create') }}" class="btn btn-success btn-sm" style="background-color: #304e3a; border:none;">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Meja
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="text-center mt-4 mb-3">
        <small class="text-muted">
            Sistem Informasi <strong>CafeKita</strong> &nbsp;•&nbsp; © {{ date('Y') }}
        </small>
    </div>

</div>
@endsection