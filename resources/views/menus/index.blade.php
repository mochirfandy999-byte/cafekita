@extends('layouts.app')

@section('title', 'Data Menu')

@section('content')
<div class="page-content">

    {{-- HEADER HALAMAN --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title text-success-emphasis fw-bold mb-1 fs-3">Data Menu</h2>
            <p class="page-subtitle text-muted mb-0">Kelola daftar menu makanan dan minuman CafeKita</p>
        </div>

        <a href="{{ route('menus.create') }}" class="btn btn-success" style="background-color: #304e3a; border:none; border-radius:11px; padding: 10px 16px;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Menu
        </a>
    </div>

    {{-- ALERT --}}
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

    {{-- STATISTIK RINGKASAN --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                <div class="card-body p-4">
                    <div class="stat-icon mb-3 d-flex align-items-center justify-content-center rounded-3" style="width: 45px; height: 45px; background: #edf3ee; color: #304e3a; font-size:20px;">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <div class="fs-4 fw-bold mb-1" style="color: #304e3a;">{{ $totalMenu ?? 0 }}</div>
                    <div class="text-muted" style="font-size: 13px;">Total Menu</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                <div class="card-body p-4">
                    <div class="stat-icon mb-3 d-flex align-items-center justify-content-center rounded-3" style="width: 45px; height: 45px; background: #edf3ee; color: #304e3a; font-size:20px;">
                        <i class="bi bi-egg-fried"></i>
                    </div>
                    <div class="fs-4 fw-bold mb-1 text-success">{{ $totalMakanan ?? 0 }}</div>
                    <div class="text-muted" style="font-size: 13px;">Makanan</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                <div class="card-body p-4">
                    <div class="stat-icon mb-3 d-flex align-items-center justify-content-center rounded-3" style="width: 45px; height: 45px; background: #edf3ee; color: #304e3a; font-size:20px;">
                        <i class="bi bi-cup-straw"></i>
                    </div>
                    <div class="fs-4 fw-bold mb-1 text-primary">{{ $totalMinuman ?? 0 }}</div>
                    <div class="text-muted" style="font-size: 13px;">Minuman</div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL DAFTAR MENU --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1 fw-bold" style="color: #304e3a;">
                    <i class="bi bi-list-ul me-2"></i> Daftar Menu
                </h5>
                <div class="text-muted" style="font-size: 12px;">Kelola daftar menu makanan dan minuman CafeKita</div>
            </div>
            <span class="badge rounded-pill" style="background:#edf3ee; color:#304e3a;">
                {{ isset($menus) ? count($menus) : ($totalMenu ?? 0) }} Data
            </span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: #fafbfa;">
                        <tr>
                            <th class="text-muted fw-semibold text-uppercase px-4 py-3" style="font-size: 12px;">NO</th>
                            <th class="text-muted fw-semibold text-uppercase px-4 py-3" style="font-size: 12px;">KODE MENU</th>
                            <th class="text-muted fw-semibold text-uppercase px-4 py-3" style="font-size: 12px;">NAMA MENU</th>
                            <th class="text-muted fw-semibold text-uppercase px-4 py-3" style="font-size: 12px;">KATEGORI</th>
                            <th class="text-muted fw-semibold text-uppercase px-4 py-3" style="font-size: 12px;">VARIAN</th>
                            <th class="text-muted fw-semibold text-uppercase px-4 py-3" style="font-size: 12px;">HARGA</th>
                            <th class="text-muted fw-semibold text-uppercase px-4 py-3 text-center" style="font-size: 12px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menus as $menu)
                            <tr>
                                <td class="px-4 py-3"><span class="text-muted" style="font-size:13px;">{{ $loop->iteration }}</span></td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 12px;">{{ $menu->kode_menu }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="fw-semibold text-dark" style="font-size:13px;">{{ $menu->nama_menu }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge rounded-pill px-3 py-2" style="font-size: 11px; {{ $menu->kategori == 'makanan' ? 'background: #e8f5e9; color: #2e7d32;' : 'background: #e3f2fd; color: #1565c0;' }}">
                                        {{ ucfirst($menu->kategori) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3"> @if($menu->kategori == 'minuman')
                                    <span class="badge rounded-pill px-3 py-2" style="background: #e3f2fd; color: #1565c0;">
                                        {{ strtoupper($menu->varian) }}
                                    </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="fw-bold" style="color: #304e3a; font-size:13px;">
                                        Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-sm d-inline-flex align-items-center justify-content-center rounded-3" style="width: 34px; height: 34px; background: #fff4d9; color: #9a751e;" title="Edit Menu">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm d-inline-flex align-items-center justify-content-center rounded-3" style="width: 34px; height: 34px; background: #fdeaea; color: #dc3545;" title="Hapus Menu">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="text-center py-5">
                                        <div class="d-flex justify-content-center align-items-center rounded-circle mx-auto mb-3" style="width: 60px; height: 60px; background: #edf3ee; color: #304e3a; font-size: 25px;">
                                            <i class="bi bi-journal-text"></i>
                                        </div>
                                        <h6 class="fw-bold">Belum Ada Menu</h6>
                                        <p class="text-muted small mb-3">Belum terdapat data menu di CafeKita.</p>
                                        <a href="{{ route('menus.create') }}" class="btn btn-success btn-sm" style="background-color: #304e3a; border:none;">
                                            <i class="bi bi-plus-lg me-1"></i> Tambah Menu
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
