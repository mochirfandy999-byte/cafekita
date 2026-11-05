<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Reservasi - CafeKita</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f7f9f7;
        color: #2b2f32;
    }

    :root {
        --cafe-primary: #2d503f;
        --cafe-primary-hover: #223e31;
        --cafe-border: #e3e8e5;
    }

    .btn-cafe-primary {
        background-color: var(--cafe-primary);
        color: #ffffff;
        border: none;
        padding: 9px 22px;
        font-weight: 500;
        border-radius: 10px;
        transition: all 0.2s ease-in-out;
    }

    .btn-cafe-primary:hover {
        background-color: var(--cafe-primary-hover);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-cafe-outline {
        border: 1.5px solid var(--cafe-primary);
        color: var(--cafe-primary);
        background: transparent;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .btn-cafe-outline:hover {
        background-color: var(--cafe-primary);
        color: #ffffff;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        border: 1.5px solid var(--cafe-border);
        padding: 9px 14px;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--cafe-primary);
        box-shadow: 0 0 0 3px rgba(45, 80, 63, 0.15);
    }

    .form-label {
        font-size: 0.88rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 6px;
    }

    .card-custom {
        border-radius: 16px;
        border: 1px solid rgba(0, 0, 0, 0.04);
        background: #ffffff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    .section-box {
        background-color: #fbfcfb;
        border: 1px solid var(--cafe-border);
        border-radius: 12px;
        padding: 18px;
    }

    .profile-pill {
        background: #ffffff;
        border: 1px solid var(--cafe-border);
        border-radius: 12px;
        padding: 6px 14px;
    }
    </style>
</head>

<body class="app-with-sidebar">
    @include('layouts.sidebar')

    <div class="container-fluid px-4 py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1" style="color: #1e2922;">Tambah Reservasi</h4>
                <p class="text-muted small mb-0">Kelola dan jadwalkan reservasi meja pelanggan CafeKita</p>
            </div>

            <div class="profile-pill d-flex align-items-center gap-2 shadow-sm">
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-light"
                    style="width: 36px; height: 36px;">
                    <i class="bi bi-person text-secondary"></i>
                </div>
                <div class="lh-1">
                    <span class="d-block fw-semibold"
                        style="font-size: 0.85rem;">{{ auth()->user()->nama ?? auth()->user()->name ?? 'Kasir CafeKita' }}</span>
                    <span class="text-muted"
                        style="font-size: 0.75rem;">{{ ucfirst(auth()->user()->role ?? 'Kasir') }}</span>
                </div>
            </div>
        </div>

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
            <div class="fw-bold mb-1"><i class="bi bi-exclamation-circle-fill me-2"></i> Terdapat kesalahan pengisian:
            </div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card card-custom">
            <div class="card-body p-4 p-md-5">

                <form action="{{ route('reservasis.store') }}" method="POST">
                    @csrf

                    <h6 class="fw-bold mb-3" style="color: var(--cafe-primary);">
                        <i class="bi bi-person-lines-fill me-1"></i> Data Pemesan & Meja
                    </h6>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pelanggan" class="form-control"
                                value="{{ old('nama_pelanggan') }}" placeholder="Masukkan nama pelanggan" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No. HP / WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}"
                                placeholder="08xxxxxxxxxx" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Meja <span class="text-danger">*</span></label>
                            <select name="meja_id" class="form-select" required>
                                <option value="">-- Pilih Meja --</option>
                                @forelse ($mejas as $m)
                                <option value="{{ $m->id }}" {{ old('meja_id') == $m->id ? 'selected' : '' }}>
                                    Meja {{ $m->nomor_meja }} (Kapasitas {{$m->kapasitas }} orang)
                                </option>
                                @empty
                                <option value="" disabled>Tidak ada meja tersedia</option>
                                @endforelse
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jumlah Orang <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_orang" class="form-control"
                                value="{{ old('jumlah_orang', 1) }}" min="1" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Tanggal Reservasi <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_reservasi" class="form-control"
                                value="{{ old('tanggal_reservasi') }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Jam Reservasi <span class="text-danger">*</span></label>
                            <input type="time" name="jam_reservasi" class="form-control"
                                value="{{ old('jam_reservasi') }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="dikonfirmasi" {{ old('status') == 'dikonfirmasi' ? 'selected' : '' }}>
                                    Dikonfirmasi</option>
                                <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai
                                </option>
                                <option value="dibatalkan" {{ old('status') == 'dibatalkan' ? 'selected' : '' }}>
                                    Dibatalkan</option>
                            </select>
                        </div>
                    </div>

                    <div class="section-box mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <label class="form-label mb-0 fw-bold" style="color: var(--cafe-primary);">
                                    <i class="bi bi-cup-hot me-1"></i> Pesanan Menu (Opsional)
                                </label>
                                <p class="text-muted small mb-0">Menu pesanan yang ingin disiapkan sebelum pelanggan
                                    datang</p>
                            </div>
                            <button type="button" class="btn btn-sm btn-cafe-outline" id="btn-tambah-menu">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Menu
                            </button>
                        </div>

                        <div id="container-menu">
                            <div class="baris-menu row mb-2 align-items-center">
                                <div class="col-md-8">
                                    <select name="menus[0][id]" class="form-select select-menu">
                                        <option value="" data-harga="0">-- Pilih Menu Makanan / Minuman --</option>
                                        @if(isset($menus))
                                        @forelse ($menus as $item)
                                        {{-- ATRIBUT data-harga WAJIB ADA DI SINI --}}
                                        <option value="{{ $item->id }}" data-harga="{{ $item->harga }}">
                                            {{ $item->nama_menu ?? $item->nama }} - Rp
                                            {{ number_format($item->harga, 0, ',', '.') }}
                                        </option>
                                        @empty
                                        @endforelse
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="menus[0][jumlah]" class="form-control input-qty"
                                        value="1" min="1">
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-sm btn-hapus-menu" disabled>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="total-box mt-2">
                            <span class="total-title">Total Pembayaran:</span>
                            <div>
                                <span class="total-amount" id="total-bayar-text">Rp 0</span>
                                <input type="hidden" name="total_bayar" id="total-bayar-hidden" value="0">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label"><i class="bi bi-card-text me-1"></i> Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"
                            placeholder="Keterangan tambahan atau catatan khusus meja...">{{ old('keterangan') }}</textarea>
                    </div>

                    <hr class="my-4" style="border-color: var(--cafe-border);">

                    <!-- Pilihan Jenis Pembayaran (DP 50% atau Lunas) -->
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Jenis Pembayaran *</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name=" jenis_pembayaran_tipe"
                                    id="tipe_lunas" value="lunas" checked>
                                <label class="form-check-label" for="tipe_lunas">Langsung Lunas</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_pembayaran_tipe" id="tipe_dp"
                                    value="dp_50">
                                <label class="form-check-label" for="tipe_dp">Bayar 50% (DP)</label>
                            </div>
                        </div>
                    </div>


                    <!-- Info Nominal yang Harus Dibayar (Berubah otomatis jika pilih DP 50%) -->
                    <div class="alert alert-info py-2 mb-3">
                        <strong>Jumlah yang Harus Dibayar: </strong>
                        <span id="label-tagihan-teritory" class="font-weight-bold text-dark">Rp 95.000</span>
                        <!-- Input hidden untuk total yang benar-benar ditagih ke kasir -->
                        <input type="hidden" name="total_bayar" id="total-bayar-hidden" value="0">
                        <input type="hidden" id="total-bayar-murni" value="0">
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Metode Pembayaran *</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metode_pembayaran" id="tunai"
                                    value="Tunai" checked>
                                <label class="form-check-label" for="tunai">Tunai (Cash)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metode_pembayaran" id="qris"
                                    value="QRIS">
                                <label class="form-check-label" for="qris">QRIS (Non-Tunai)</label>
                            </div>
                        </div>
                    </div>

                    <!-- Uang Diterima & Kembalian (Akan otomatis diatur lewat JS) -->
                    <div class="row mb-3" id="wrapper-uang-pembayaran">
                        <div class="col-md-6">
                            <label for="uang_dibayar" class="form-label" id="label-uang-diterima">Uang Dibayar
                                (Rp)</label>
                            <input type="number" class="form-control" id="uang_dibayar" name="uang_dibayar"
                                placeholder="Contoh: 50000" value="0">
                        </div>
                        <div class="col-md-6" id="wrapper-kembalian">
                            <label for="kembalian" class="form-label">Kembalian (Rp)</label>
                            <input type="text" class="form-control" id="kembalian_text" value="Rp 0" readonly>
                            <input type="hidden" name="kembalian" id="kembalian" value="0">
                        </div>
                    </div>

                    <!-- Area Pembayaran QRIS -->
                    <div id="section-qris" class="d-none alert alert-info mb-0">
                        <div class="d-flex align-items-center">
                            <div class="me-3 fs-3">📲</div>
                            <div>
                                <strong>Pembayaran QRIS:</strong> Silakan scan QR code kasir sebesar nominal pas:
                                <span class="badge bg-primary fs-6" id="qris-nominal">Rp 0</span>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('reservasis.index') }}" class="btn btn-light border px-4 py-2"
                    style="border-radius: 10px; font-weight: 500;">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-cafe-primary px-4 py-2">
                    <i class="bi bi-floppy me-1"></i> Simpan Reservasi
                </button>
            </div>

            </form>

        </div>
    </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let menuIndex = 1;

        const inputUangDibayar = document.getElementById('uang_diterima'); // ID input form kamu
        const inputTotalBayarHidden = document.getElementById('total-bayar-hidden');
        const inputTotalMurni = document.getElementById('total-bayar-murni'); // Pastikan input hidden ini ada

        const textTotalAtas = document.getElementById('total-bayar-text');
        const labelTagihanBawah = document.getElementById('label-tagihan-teritory');

        const inputKembalian = document.getElementById('kembalian');
        const textKembalian = document.getElementById('kembalian_text');
        const wrapperKembalian = document.getElementById('wrapper-kembalian');
        const labelUangDibayar = document.getElementById('label-uang-diterima');

        const radioLunas = document.getElementById('tipe_lunas');
        const radioDp = document.getElementById('tipe_dp');

        // Fungsi Hitung Total Harga Menu
        function hitungTotalPembayaran() {
            let totalSemua = 0;
            const barisMenus = document.querySelectorAll('#container-menu .baris-menu');

            barisMenus.forEach(function(baris) {
                const selectMenu = baris.querySelector('.select-menu');
                const inputQty = baris.querySelector('.input-qty');

                if (selectMenu && inputQty) {
                    const selectedOption = selectMenu.options[selectMenu.selectedIndex];
                    const hargaSatuan = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
                    const qty = parseInt(inputQty.value) || 0;

                    totalSemua += (hargaSatuan * qty);
                }
            });

            // Simpan ke input murni
            if (inputTotalMurni) inputTotalMurni.value = totalSemua;

            sesuaikanJenisPembayaran();
        }

        // Fungsi Atur Lunas atau DP 50%
        function sesuaikanJenisPembayaran() {
            let totalMurni = parseFloat(inputTotalMurni ? inputTotalMurni.value : 0) || 0;
            let tagihanAkhir = totalMurni;

            if (radioDp && radioDp.checked) {
                tagihanAkhir = totalMurni / 2; // Bagi dua untuk DP 50%
                if (labelUangDibayar) labelUangDibayar.textContent = "Uang DP Dibayar (Rp)";
                if (wrapperKembalian) wrapperKembalian.style.display = 'none'; // Sembunyikan kembalian
            } else {
                if (labelUangDibayar) labelUangDibayar.textContent = "Uang Dibayar (Rp)";
                if (wrapperKembalian) wrapperKembalian.style.display = 'block'; // Tampilkan kembalian
            }

            // Update Teks Total di Atas
            if (textTotalAtas) {
                textTotalAtas.textContent = 'Rp ' + totalMurni.toLocaleString('id-ID');
            }

            // Update Teks & Hidden di Kotak Biru Bawah
            if (labelTagihanBawah) {
                labelTagihanBawah.textContent = 'Rp ' + tagihanAkhir.toLocaleString('id-ID');
            }
            if (inputTotalBayarHidden) {
                inputTotalBayarHidden.value = tagihanAkhir;
            }

            hitungKembalian();
        }

        // Fungsi Hitung Kembalian
        function hitungKembalian() {
            if (radioDp && radioDp.checked) return; // DP tidak ada kembalian

            let totalBayar = parseFloat(inputTotalBayarHidden ? inputTotalBayarHidden.value : 0) || 0;
            let uangDibayar = parseFloat(inputUangDibayar ? inputUangDibayar.value : 0) || 0;

            let kembalian = uangDibayar - totalBayar;
            if (kembalian < 0) kembalian = 0;

            if (inputKembalian) inputKembalian.value = kembalian;
            if (textKembalian) {
                if (textKembalian.tagName === 'INPUT') {
                    textKembalian.value = 'Rp ' + kembalian.toLocaleString('id-ID');
                } else {
                    textKembalian.textContent = 'Rp ' + kembalian.toLocaleString('id-ID');
                }
            }
        }

        // Event Listeners
        if (radioLunas) radioLunas.addEventListener('change', sesuaikanJenisPembayaran);
        if (radioDp) radioDp.addEventListener('change', sesuaikanJenisPembayaran);
        if (inputUangDibayar) inputUangDibayar.addEventListener('input', hitungKembalian);

        // Tombol Tambah Menu
        const btnTambahMenu = document.getElementById('btn-tambah-menu');
        if (btnTambahMenu) {
            btnTambahMenu.addEventListener('click', function() {
                const container = document.getElementById('container-menu');
                const barisPertama = container.querySelector('.baris-menu');
                const barisBaru = barisPertama.cloneNode(true);

                const selectMenu = barisBaru.querySelector('.select-menu');
                selectMenu.name = `menus[${menuIndex}][id]`;
                selectMenu.selectedIndex = 0;

                const inputQty = barisBaru.querySelector('.input-qty');
                inputQty.name = `menus[${menuIndex}][jumlah]`;
                inputQty.value = 1;

                const tombolHapus = barisBaru.querySelector('.btn-hapus-menu');
                if (tombolHapus) {
                    tombolHapus.disabled = false;
                    tombolHapus.addEventListener('click', function() {
                        barisBaru.remove();
                        hitungTotalPembayaran();
                    });
                }

                selectMenu.addEventListener('change', hitungTotalPembayaran);
                inputQty.addEventListener('input', hitungTotalPembayaran);

                container.appendChild(barisBaru);
                menuIndex++;
                hitungTotalPembayaran();
            });
        }

        // Inisialisasi baris menu awal
        document.querySelectorAll('#container-menu .baris-menu').forEach(function(baris) {
            const selectMenu = baris.querySelector('.select-menu');
            const inputQty = baris.querySelector('.input-qty');
            const tombolHapus = baris.querySelector('.btn-hapus-menu');

            if (selectMenu) selectMenu.addEventListener('change', hitungTotalPembayaran);
            if (inputQty) inputQty.addEventListener('input', hitungTotalPembayaran);
            if (tombolHapus) {
                tombolHapus.addEventListener('click', function() {
                    if (document.querySelectorAll('#container-menu .baris-menu').length > 1) {
                        baris.remove();
                        hitungTotalPembayaran();
                    }
                });
            }
        });

        // Jalankan saat pertama load
        hitungTotalPembayaran();
    });
    </script>
</body>

</html>