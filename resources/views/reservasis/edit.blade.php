<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservasi - CafeKita</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .main-content {
            margin-left: 260px; /* Sesuaikan dengan lebar sidebar CafeKita */
            padding: 2rem 2.5rem;
            min-height: 100vh;
        }
        .form-label {
            font-size: 0.82rem;
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.35rem;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border-color: #dee2e6;
            font-size: 0.88rem;
            padding: 0.6rem 0.85rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #2d6a4f;
            box-shadow: 0 0 0 0.2rem rgba(45, 106, 79, 0.15);
        }
        .btn-theme-primary {
            background-color: #234d3b;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 0.55rem 1.4rem;
            font-weight: 500;
            font-size: 0.88rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }
        .btn-theme-primary:hover {
            background-color: #1b3d2f;
            color: #ffffff;
        }
        .btn-back {
            border-radius: 8px;
            font-size: 0.88rem;
            padding: 0.55rem 1.4rem;
            color: #495057;
            border: 1px solid #ced4da;
            background-color: #ffffff;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }
        .btn-back:hover {
            background-color: #f1f3f5;
            color: #212529;
        }
        .section-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #2b2f32;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
        }
    </style>
</head>

<body class="app-with-sidebar">

    @include('layouts.sidebar')

    <div class="main-content">
        {{-- Header Atas --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1 text-dark">Edit Reservasi</h4>
                <p class="text-secondary small mb-0">Kelola dan perbarui jadwal reservasi meja pelanggan CafeKita</p>
            </div>

            {{-- Info Profil User --}}
            <div class="d-flex align-items-center bg-white border rounded-3 px-3 py-2 shadow-sm gap-2">
                <i class="bi bi-person text-secondary fs-5"></i>
                <div class="text-end" style="line-height: 1.2;">
                    <div class="fw-semibold small text-dark">{{ auth()->user()->name ?? 'Kasir CafeKita' }}</div>
                    <small class="text-muted" style="font-size: 0.75rem;">{{ auth()->user()->role ?? 'Kasir' }}</small>
                </div>
            </div>
        </div>

        {{-- Session Error & Alert --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <ul class="mb-0 small">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Form Card --}}
        <div class="card border border-light-subtle shadow-sm rounded-3 bg-white p-4">
            <form action="{{ route('reservasis.update', $reservasi) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Informasi Pemesan & Meja --}}
                <div class="section-title">
                    <i class="bi bi-calendar-check text-secondary"></i> Data Pemesan & Jadwal Meja
                </div>

                <div class="row g-3 mb-3">
                    {{-- Nomor Reservasi --}}
                    <div class="col-md-6">
                        <label class="form-label">Nomor Reservasi</label>
                        <input type="text"
                               class="form-control bg-light text-muted"
                               value="{{ $reservasi->nomor_reservasi }}"
                               readonly>
                    </div>

                    {{-- Nama Pelanggan --}}
                    <div class="col-md-6">
                        <label class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                        <input type="text"
                               name="nama_pelanggan"
                               class="form-control"
                               placeholder="Masukkan nama pelanggan"
                               value="{{ old('nama_pelanggan', $reservasi->nama_pelanggan) }}"
                               required>
                    </div>

                    {{-- No. HP --}}
                    <div class="col-md-6">
                        <label class="form-label">No. HP / WhatsApp <span class="text-danger">*</span></label>
                        <input type="text"
                               name="no_hp"
                               class="form-control"
                               placeholder="Contoh: 08123456789"
                               value="{{ old('no_hp', $reservasi->no_hp) }}"
                               required>
                    </div>

                    {{-- Meja --}}
                    <div class="col-md-6">
                        <label class="form-label">Pilih Meja <span class="text-danger">*</span></label>
                        <select name="meja_id" class="form-select" required>
                            @foreach($mejas as $meja)
                                <option value="{{ $meja->id }}"
                                    {{ old('meja_id', $reservasi->meja_id) == $meja->id ? 'selected' : '' }}>
                                    Meja {{ $meja->nomor_meja }} (Kapasitas {{ $meja->kapasitas }} orang)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Jumlah Orang --}}
                    <div class="col-md-4">
                        <label class="form-label">Jumlah Orang <span class="text-danger">*</span></label>
                        <input type="number"
                               name="jumlah_orang"
                               class="form-control"
                               value="{{ old('jumlah_orang', $reservasi->jumlah_orang) }}"
                               min="1"
                               required>
                    </div>

                    {{-- Tanggal Reservasi --}}
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Reservasi <span class="text-danger">*</span></label>
                        <input type="date"
                               name="tanggal_reservasi"
                               class="form-control"
                               value="{{ old('tanggal_reservasi', $reservasi->tanggal_reservasi->format('Y-m-d')) }}"
                               required>
                    </div>

                    {{-- Jam Reservasi --}}
                    <div class="col-md-4">
                        <label class="form-label">Jam Reservasi <span class="text-danger">*</span></label>
                        <input type="time"
                               name="jam_reservasi"
                               class="form-control"
                               value="{{ old('jam_reservasi', $reservasi->jam_reservasi) }}"
                               required>
                    </div>

                    {{-- Status Reservasi --}}
                    <div class="col-md-12">
                        <label class="form-label">Status Reservasi <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ old('status', $reservasi->status) === 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="dikonfirmasi" {{ old('status', $reservasi->status) === 'dikonfirmasi' ? 'selected' : '' }}>
                                Dikonfirmasi
                            </option>
                            <option value="selesai" {{ old('status', $reservasi->status) === 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                            <option value="dibatalkan" {{ old('status', $reservasi->status) === 'dibatalkan' ? 'selected' : '' }}>
                                Dibatalkan
                            </option>
                        </select>
                    </div>
                </div>

                {{-- Keterangan Tambahan --}}
                <div class="section-title mt-4">
                    <i class="bi bi-card-text text-secondary"></i> Catatan Khusus
                </div>

                <div class="mb-4">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan"
                              class="form-control"
                              rows="3"
                              placeholder="Keterangan tambahan atau catatan khusus reservasi...">{{ old('keterangan', $reservasi->keterangan) }}</textarea>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="{{ route('reservasis.index') }}" class="btn-back">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>

                    <button type="submit" class="btn-theme-primary">
                        <i class="bi bi-floppy"></i> Update Reservasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>