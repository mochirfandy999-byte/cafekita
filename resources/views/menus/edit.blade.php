<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Menu - CafeKita</title>

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
                <h4 class="fw-bold mb-1 text-dark">Ubah Data Menu</h4>
                <p class="text-secondary small mb-0">Kelola dan perbarui rincian menu hidangan CafeKita</p>
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

        {{-- Alert Error --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <ul class="mb-0 small">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Form Card --}}
        <div class="card border border-light-subtle shadow-sm rounded-3 bg-white p-4">
            <form action="{{ route('menus.update', $menu->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Detail Menu --}}
                <div class="section-title">
                    <i class="bi bi-cup-hot text-secondary"></i> Informasi Menu
                </div>

                <div class="row g-3 mb-4">
                    {{-- Kode Menu --}}
                    <div class="col-md-6">
                        <label class="form-label">Kode Menu / ID Menu <span class="text-danger">*</span></label>
                        <input type="text"
                               name="kode_menu"
                               class="form-control"
                               placeholder="Contoh: MN01"
                               value="{{ old('kode_menu', $menu->kode_menu) }}"
                               required>
                    </div>

                    {{-- Nama Menu --}}
                    <div class="col-md-6">
                        <label class="form-label">Nama Menu <span class="text-danger">*</span></label>
                        <input type="text"
                               name="nama_menu"
                               class="form-control"
                               placeholder="Masukkan nama menu hidangan"
                               value="{{ old('nama_menu', $menu->nama_menu) }}"
                               required>
                    </div>

                    {{-- Kategori Menu --}}
                    <div class="col-md-6">
                        <label class="form-label">Kategori Menu <span class="text-danger">*</span></label>
                        <select name="kategori" class="form-select" required>
                            <option value="makanan" {{ old('kategori', $menu->kategori) == 'makanan' ? 'selected' : '' }}>
                                Makanan
                            </option>
                            <option value="minuman" {{ old('kategori', $menu->kategori) == 'minuman' ? 'selected' : '' }}>
                                Minuman
                            </option>
                        </select>
                    </div>

                    {{-- Harga Menu --}}
                    <div class="col-md-6">
                        <label class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 8px 0 0 8px; font-size: 0.88rem;">Rp</span>
                            <input type="number"
                                   name="harga"
                                   class="form-control"
                                   style="border-radius: 0 8px 8px 0;"
                                   min="0"
                                   placeholder="0"
                                   value="{{ old('harga', $menu->harga) }}"
                                   required>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="{{ route('menus.index') }}" class="btn-back">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>

                    <button type="submit" class="btn-theme-primary">
                        <i class="bi bi-floppy"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>