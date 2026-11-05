@extends('layouts.app')

@section('title', 'Data Pemesanan')

@section('content')
<div class="page-content">

    {{-- HEADER HALAMAN --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title text-success-emphasis fw-bold mb-1 fs-3">Data Pemesanan</h2>
            <p class="page-subtitle text-muted mb-0">Kelola seluruh pemesanan pelanggan CafeKita</p>
        </div>

        <a href="{{ route('pemesanans.create') }}" class="btn btn-success" style="background-color: #304e3a; border:none; border-radius:11px; padding: 10px 16px;">
            <i class="bi bi-plus-lg me-1"></i> Pemesanan Baru
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 rounded-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 rounded-4">
            <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- STATISTIK (Bisa diganti dengan Blade Component jika sudah dibuat) --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                <div class="card-body p-4">
                    <div class="stat-icon mb-3 d-flex align-items-center justify-content-center rounded-3" style="width: 45px; height: 45px; background: #edf3ee; color: #304e3a; font-size:20px;">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div class="fs-4 fw-bold mb-1" style="color: #304e3a;">{{ $totalPemesanan ?? 0 }}</div>
                    <div class="text-muted" style="font-size: 13px;">Total Pemesanan</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                <div class="card-body p-4">
                    <div class="stat-icon mb-3 d-flex align-items-center justify-content-center rounded-3" style="width: 45px; height: 45px; background: #edf3ee; color: #304e3a; font-size:20px;">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="fs-4 fw-bold mb-1 text-warning">{{ $totalReservasi ?? 0 }}</div>
                    <div class="text-muted" style="font-size: 13px;">Total Reservasi</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                <div class="card-body p-4">
                    <div class="stat-icon mb-3 d-flex align-items-center justify-content-center rounded-3" style="width: 45px; height: 45px; background: #edf3ee; color: #304e3a; font-size:20px;">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="fs-4 fw-bold mb-1 text-success">{{ $pemesananSelesai ?? 0 }}</div>
                    <div class="text-muted" style="font-size: 13px;">Pemesanan Selesai</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                <div class="card-body p-4">
                    <div class="stat-icon mb-3 d-flex align-items-center justify-content-center rounded-3" style="width: 45px; height: 45px; background: #edf3ee; color: #304e3a; font-size:20px;">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div class="fw-bold mb-1" style="font-size:20px; color: #304e3a;">
                        Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="text-muted" style="font-size: 13px;">Total Pendapatan</div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL PEMESANAN --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1 fw-bold" style="color: #304e3a;">
                    <i class="bi bi-list-ul me-2"></i> Daftar Pemesanan
                </h5>
                <div class="text-muted" style="font-size: 12px;">Data pemesanan pelanggan CafeKita</div>
            </div>
            <span class="badge rounded-pill" style="background:#edf3ee; color:#304e3a;">
                {{ isset($semuaPesanan) ? count($semuaPesanan) : ($totalPemesanan ?? 0) }} Data
            </span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: #fafbfa;">
                        <tr>
                            <th class="text-muted fw-semibold text-uppercase px-4 py-3" style="font-size: 12px;">No</th>
                            <th class="text-muted fw-semibold text-uppercase px-4 py-3" style="font-size: 12px;">No. Pemesanan</th>
                            <th class="text-muted fw-semibold text-uppercase px-4 py-3" style="font-size: 12px;">Pelanggan</th>
                            <th class="text-muted fw-semibold text-uppercase px-4 py-3" style="font-size: 12px;">Meja</th>
                            <th class="text-muted fw-semibold text-uppercase px-4 py-3" style="font-size: 12px;">Kasir</th>
                            <th class="text-muted fw-semibold text-uppercase px-4 py-3" style="font-size: 12px;">Total</th>
                            <th class="text-muted fw-semibold text-uppercase px-4 py-3" style="font-size: 12px;">Status</th>
                            <th class="text-muted fw-semibold text-uppercase text-center px-4 py-3" style="font-size: 12px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($semuaPesanan as $index => $item)
                            <tr>
                                <td class="px-4 py-3"><span class="text-muted" style="font-size:13px;">{{ $loop->iteration }}</span></td>
                                <td class="px-4 py-3">
                                    <div class="fw-bold" style="color: #304e3a; font-size:13px;">
                                        {{ $item->nomor_transaksi ?? $item->kode_pemesanan }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="fw-semibold text-dark" style="font-size:13px;">
                                        {{ $item->nama_pelanggan }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if($item->meja)
                                        <span class="badge rounded-pill" style="background:#edf3ee; color:#304e3a;">
                                            <i class="bi bi-grid-3x3-gap me-1"></i> {{ $item->meja->nomor_meja }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($item->user)
                                        <div class="d-flex align-items-center gap-2" style="font-size:13px;">
                                            <div style="width:28px; height:28px; border-radius:50%; background:#edf3ee; color:#304e3a; display:flex; align-items:center; justify-content:center;">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            <span>{{ $item->user->nama }}</span>
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="fw-bold" style="color: #304e3a; font-size:13px;">
                                        Rp {{ number_format($item->total_bayar, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if($item->status === 'selesai')
                                        <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1"><i class="bi bi-check-circle me-1"></i> Selesai</span>
                                    @elseif($item->status === 'batal')
                                        <span class="badge bg-danger-subtle text-danger rounded-pill px-2 py-1"><i class="bi bi-x-circle me-1"></i> Batal</span>
                                    @elseif($item->status === 'diproses')
                                        <span class="badge bg-primary-subtle text-primary rounded-pill px-2 py-1"><i class="bi bi-arrow-repeat me-1"></i> Diproses</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-2 py-1"><i class="bi bi-clock me-1"></i> Pending</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        @if(!empty($item->is_reservasi))
                                            <a href="{{ route('pemesanans.create', ['reservasi_id' => $item->id]) }}" class="btn btn-sm" style="background: #fff4d9; color: #9a751e;" title="Proses Reservasi">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('pemesanans.edit', $item->id) }}" class="btn btn-sm" style="background: #fff4d9; color: #9a751e;" title="Edit Pemesanan">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        @endif
                                        <form action="{{ route('pemesanans.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pemesanan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm" style="background: #fdeaea; color: #dc3545;" title="Hapus Pemesanan">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="text-center py-5">
                                        <div class="d-flex justify-content-center align-items-center rounded-circle mx-auto mb-3" style="width: 60px; height: 60px; background: #edf3ee; color: #304e3a; font-size: 25px;">
                                            <i class="bi bi-receipt"></i>
                                        </div>
                                        <h6 class="fw-bold">Belum Ada Pemesanan</h6>
                                        <p class="text-muted small mb-3">Belum terdapat data pemesanan CafeKita.</p>
                                        <a href="{{ route('pemesanans.create') }}" class="btn btn-success btn-sm" style="background-color: #304e3a; border:none;">
                                            <i class="bi bi-plus-lg me-1"></i> Tambah Pemesanan
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

   
    {{-- FOOTER --}}
    <div class="text-center mt-4 mb-3">
        <small class="text-muted">
            © {{ date('Y') }} CafeKita Management System
        </small>
    </div>

</div>
@endsection