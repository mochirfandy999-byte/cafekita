
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
            background-color: #f4f7f4;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        .main-content {
            margin-left: 260px;
            padding: 2rem 2.5rem;
            min-height: 100vh;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #3b4e3f;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1.5px solid #e1e7e2;
            font-size: 14px;
            padding: 10px 14px;
        }

        .form-control:focus, .form-select:focus {
            border-color: #2d6a4f;
            box-shadow: 0 0 0 0.2rem rgba(45, 106, 79, 0.15);
        }

        .btn-theme-primary {
            background-color: #234d3b;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
        }

        .btn-theme-primary:hover {
            background-color: #1b3d2f;
            color: #fff;
        }

        .btn-back {
            border-radius: 10px;
            padding: 10px 20px;
            color: #495057;
            border: 1px solid #ced4da;
            background-color: #fff;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: #f1f3f5;
            color: #212529;
        }

        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: #2b2f32;
            margin-bottom: 20px;
        }

        .input-group-text {
            background: #f8faf8;
            border: 1.5px solid #e1e7e2;
            color: #6d7f71;
            font-weight: 600;
        }

        .kode-info {
            font-size: 11px;
            color: #6d7f71;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
        }
    </style>
</head>

<body class="app-with-sidebar">

    @include('layouts.sidebar')

    <div class="main-content">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="fw-bold mb-1" style="color: #1f3929;">
                    Ubah Data Menu
                </h4>

                <p class="text-secondary small mb-0">
                    Kelola dan perbarui rincian menu CafeKita
                </p>
            </div>

            <div class="d-flex align-items-center bg-white border rounded-3 px-3 py-2 shadow-sm gap-2">
                <i class="bi bi-person text-secondary fs-5"></i>

                <div class="text-end" style="line-height: 1.2;">
                    <div class="fw-semibold small text-dark">
                        {{ auth()->user()->name ?? 'Kasir CafeKita' }}
                    </div>

                    <small class="text-muted" style="font-size: 0.75rem;">
                        {{ auth()->user()->role ?? 'Kasir' }}
                    </small>
                </div>
            </div>

        </div>

        {{-- ALERT ERROR --}}
        @if($errors->any())
            <div class="alert alert-danger rounded-3 shadow-sm">
                <strong>Periksa kembali data Anda:</strong>

                <ul class="mb-0 small">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM EDIT --}}
        <div class="card border-0 shadow-sm rounded-4 bg-white p-4">

            <form action="{{ route('menus.update', $menu->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="section-title">
                    <i class="bi bi-cup-hot text-success me-2"></i>
                    Informasi Menu
                </div>

                <div class="row g-3 mb-4">

                    {{-- KODE MENU --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Kode Menu
                        </label>

                        <input type="text"
                               class="form-control"
                               value="{{ $menu->kode_menu }}"
                               readonly>

                        <div class="kode-info">
                            Kode menu tidak dapat diubah.
                        </div>

                    </div>

                    {{-- KATEGORI --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Kategori Menu *
                        </label>

                        <select name="kategori"
                                id="kategori"
                                class="form-select"
                                required>

                            <option value="makanan"
                                {{ old('kategori', $menu->kategori) == 'makanan' ? 'selected' : '' }}>
                                Makanan
                            </option>

                            <option value="minuman"
                                {{ old('kategori', $menu->kategori) == 'minuman' ? 'selected' : '' }}>
                                Minuman
                            </option>

                        </select>

                    </div>

                    {{-- NAMA MENU --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Nama Menu *
                        </label>

                        <input type="text"
                               name="nama_menu"
                               class="form-control"
                               placeholder="Masukkan nama menu"
                               value="{{ old('nama_menu', $menu->nama_menu) }}"
                               maxlength="255"
                               required>

                    </div>

                    {{-- VARIAN --}}
                    <div class="col-md-6"
                         id="varian-container"
                         style="display: none;">

                        <label class="form-label">
                            Varian Minuman *
                        </label>

                        <select name="varian"
                                id="varian"
                                class="form-select">

                            <option value="">
                                -- Pilih Varian --
                            </option>

                            <option value="ice"
                                {{ old('varian', $menu->varian) == 'ice' ? 'selected' : '' }}>
                                Ice (Dingin)
                            </option>

                            <option value="hot"
                                {{ old('varian', $menu->varian) == 'hot' ? 'selected' : '' }}>
                                Hot (Panas)
                            </option>

                        </select>

                    </div>

                    {{-- HARGA --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Harga Jual *
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                Rp
                            </span>

                            <input type="text"
                                   name="harga"
                                   id="harga"
                                   class="form-control"
                                   inputmode="numeric"
                                   autocomplete="off"
                                   placeholder="Contoh: 15.000"
                                   value="{{ old('harga', $menu->harga) }}"
                                   required>

                        </div>

                        <div class="kode-info">
                            Format Rupiah akan ditambahkan otomatis.
                        </div>

                    </div>

                </div>

                {{-- TOMBOL --}}
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">

                    <a href="{{ route('menus.index') }}"
                       class="btn-back">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>

                    <button type="submit" class="btn-theme-primary">
                        <i class="bi bi-floppy me-1"></i>
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>

        // Pengaturan varian berdasarkan kategori
        const kategori = document.getElementById('kategori');
        const varianContainer = document.getElementById('varian-container');
        const varian = document.getElementById('varian');

        function aturVarian() {

            if (kategori.value === 'minuman') {

                varianContainer.style.display = 'block';
                varian.required = true;

            } else {

                varianContainer.style.display = 'none';
                varian.required = false;
                varian.value = '';

            }

        }

        kategori.addEventListener('change', aturVarian);

        // Menjalankan saat halaman pertama kali dibuka
        aturVarian();


        // Format harga Rupiah
        const harga = document.getElementById('harga');

        function formatRupiah(angka) {

            const angkaBersih = angka.replace(/\D/g, '');

            if (angkaBersih === '') {
                return '';
            }

            return angkaBersih.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        }

        harga.addEventListener('input', function () {
            this.value = formatRupiah(this.value);
        });

        // Format harga yang sudah tersimpan
        harga.value = formatRupiah(harga.value);

    </script>

</body>
</html>
