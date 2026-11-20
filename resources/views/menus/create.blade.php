
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu - CafeKita</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-dark: #1f3929;
            --primary-hover: #264633;
            --primary-gold: #d9b56d;
            --bg-body: #f4f7f4;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', system-ui, sans-serif;
            background-color: var(--bg-body);
            color: #2c3e30;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 15px;
        }

        .main-container {
            width: 100%;
            max-width: 650px;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .brand-badge {
            width: 52px;
            height: 52px;
            background: linear-gradient(145deg, #1f3929, #2b4d38);
            color: var(--primary-gold);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 12px;
        }

        .brand-title {
            font-size: 22px;
            font-weight: 800;
            margin: 0;
            color: #1f3929;
        }

        .brand-title span {
            color: #b08d4b;
        }

        .form-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid #eef2ee;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            padding: 32px 36px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #3b4e3f;
            margin-bottom: 6px;
        }

        .form-control, .form-select {
            border: 1.5px solid #e1e7e2;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 14px;
            color: #2c3e30;
            background-color: #fdfdfd;
        }

        .form-control:focus, .form-select:focus {
            border-color: #2e573d;
            box-shadow: 0 0 0 3.5px rgba(46, 87, 61, 0.12);
        }

        .input-group-text {
            background: #f8faf8;
            border: 1.5px solid #e1e7e2;
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: #6d7f71;
            font-weight: 600;
            font-size: 13px;
        }

        .input-group .form-control {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .btn-cafe-primary {
            background: #1f3929;
            color: #fff;
            border: none;
            padding: 10px 22px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
        }

        .btn-cafe-primary:hover {
            background: #284c36;
            color: #fff;
        }

        .btn-cafe-secondary {
            background: #edf1ed;
            color: #4b6151;
            border: none;
            padding: 10px 20px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
        }

        .btn-cafe-secondary:hover {
            background: #e2e8e3;
            color: #2d3e32;
        }

        .kode-info {
            font-size: 11px;
            color: #6d7f71;
            margin-top: 5px;
        }
    </style>
</head>

<body class="app-with-sidebar">

    @include('layouts.sidebar')

    <div class="main-container">

        <div class="brand-header">
            <div class="brand-badge">
                <i class="bi bi-cup-hot-fill"></i>
            </div>

            <h3 class="brand-title">Cafe<span>Kita</span></h3>
            <p class="text-muted small mb-0">Tambah Data Menu Baru</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">
                <strong>Periksa kembali data Anda:</strong>
                <ul class="mb-0 ps-3 small">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-card">

            <form action="{{ route('menus.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- KODE MENU OTOMATIS --}}
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="bi bi-upc-scan me-1"></i> Kode Menu
                        </label>

                        <input type="text"
                            class="form-control"
                            value="{{ $kodeMenu }}"
                            readonly>

                        <div class="kode-info">
                            Kode dibuat otomatis ketika menu disimpan.
                        </div>
                    </div>

                    {{-- KATEGORI --}}
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="bi bi-tags me-1"></i> Kategori Menu
                        </label>

                        <select name="kategori"
                                id="kategori"
                                class="form-select"
                                required>

                            <option value="">-- Pilih Kategori --</option>

                            <option value="makanan"
                                {{ old('kategori') == 'makanan' ? 'selected' : '' }}>
                                Makanan
                            </option>

                            <option value="minuman"
                                {{ old('kategori') == 'minuman' ? 'selected' : '' }}>
                                Minuman
                            </option>

                        </select>
                    </div>

                    {{-- NAMA MENU MANUAL --}}
                    <div class="col-12">
                        <label class="form-label">
                            <i class="bi bi-card-heading me-1"></i> Nama Menu
                        </label>

                        <input type="text"
                               name="nama_menu"
                               class="form-control"
                               placeholder="Masukkan nama makanan atau minuman"
                               value="{{ old('nama_menu') }}"
                               maxlength="255"
                               required>
                    </div>

                    {{-- VARIAN --}}
                    <div class="col-md-6"
                         id="varian-container"
                         style="display: none;">

                        <label class="form-label">
                            <i class="bi bi-thermometer-half me-1"></i>
                            Varian Minuman
                        </label>

                        <select name="varian"
                                id="varian"
                                class="form-select">

                            <option value="">-- Pilih Varian --</option>

                            <option value="ice"
                                {{ old('varian') == 'ice' ? 'selected' : '' }}>
                                Ice (Dingin)
                            </option>

                            <option value="hot"
                                {{ old('varian') == 'hot' ? 'selected' : '' }}>
                                Hot (Panas)
                            </option>

                        </select>
                    </div>

                    {{-- HARGA --}}
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="bi bi-cash-stack me-1"></i> Harga Jual
                        </label>

                        <div class="input-group">
                            <span class="input-group-text">Rp</span>

                            <input type="text"
                                   name="harga"
                                   id="harga"
                                   class="form-control"
                                   placeholder="Contoh: 15.000"
                                   inputmode="numeric"
                                   autocomplete="off"
                                   value="{{ old('harga') }}"
                                   required>
                        </div>

                        <div class="kode-info">
                            Gunakan angka saja, titik akan ditambahkan otomatis.
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-end align-items-center gap-2 mt-4 pt-3 border-top">

                    <a href="{{ route('menus.index') }}"
                       class="btn-cafe-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>

                    <button type="submit" class="btn-cafe-primary">
                        <i class="bi bi-floppy"></i> Simpan Menu
                    </button>

                </div>

            </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Menampilkan varian berdasarkan kategori
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


        // Format harga Rupiah otomatis
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

        // Format kembali jika ada nilai lama
        harga.value = formatRupiah(harga.value);

    </script>

</body>
</html>
