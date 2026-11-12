@extends('layouts.app')

@section('title', 'Dashboard Pengelola Mitra - ' . ($activeDestination->name ?? 'DOKEMAS Banyumas'))

@section('content')
<div class="container py-4 py-lg-5">

    <!-- Notifikasi Sukses Pembaruan Data -->
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center justify-content-between rounded-4 p-3 mb-4 border-0 shadow-sm bg-success bg-opacity-10 text-success fade show" role="alert">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-check-circle-fill fs-4 flex-shrink-0"></i>
                <div>
                    <strong class="d-block" style="font-size: 0.95rem;">Perubahan Berhasil Disimpan!</strong>
                    <span class="small text-secondary">{{ session('success') }}</span>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- ============================================================== -->
    <!-- 1. TOP PARTNER HEADER CARD & DESTINATION SWITCHER              -->
    <!-- ============================================================== -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            
            <!-- Left Info: Partner Avatar & Destination Identity -->
            <div class="d-flex align-items-center gap-3">
                <div class="position-relative flex-shrink-0">
                    <img src="{{ $activeDestination->image ?? asset('images/gunung-selamet.jpg') }}" 
                         alt="{{ $activeDestination->name ?? 'Destinasi Mitra' }}" 
                         class="rounded-4 object-fit-cover shadow-sm border border-2 border-white" 
                         style="width: 76px; height: 76px;" id="topHeaderThumb">
                    <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-2 border-white" 
                          style="width: 14px; height: 14px;" 
                          title="Status Destinasi Aktif"></span>
                </div>
                <div>
                    <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                        <h4 class="fw-bold text-navy mb-0" style="letter-spacing: -0.3px;">
                            {{ $activeDestination->name ?? 'Lokawisata Baturraden' }}
                        </h4>
                        <span class="badge bg-success bg-opacity-10 text-success fw-bold border border-success-subtle rounded-pill px-2 py-1 small">
                            <i class="bi bi-patch-check-fill me-1"></i> Terverifikasi Dinporabudpar
                        </span>
                    </div>
                    <div class="d-flex align-items-center gap-3 text-muted small flex-wrap">
                        <span><i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $activeDestination->location ?? 'Kec. Baturraden, Banyumas' }}</span>
                        <span>&bull;</span>
                        <span class="text-success fw-bold"><i class="bi bi-tag-fill me-1"></i> Rp {{ number_format($activeDestination->price ?? 20000, 0, ',', '.') }} {{ $activeDestination->price_label ?? '/ orang' }}</span>
                        <span>&bull;</span>
                        <span><i class="bi bi-clock-history me-1"></i> {{ $activeDestination->open_hours ?? '08:00 - 17:00 WIB' }}</span>
                    </div>
                </div>
            </div>

            <!-- Right Controls: Action Buttons -->
            <div class="d-flex flex-wrap align-items-center gap-2 justify-content-lg-end">

                <!-- Badge Penanda Destinasi Pengelola -->
                <div class="d-inline-flex align-items-center gap-2 bg-light border border-light-subtle rounded-pill px-3 py-2 small text-navy fw-semibold">
                    <i class="bi bi-person-check-fill text-success"></i>
                    <span>Destinasi Terdaftar Anda</span>
                </div>

                <!-- Tombol Pratinjau Halaman Publik -->
                <a href="{{ route('destinasi.show', $activeDestination->slug ?? 'lokawisata-baturraden') }}" target="_blank" 
                   class="btn btn-light border rounded-pill px-3 py-2 fw-semibold text-secondary small d-flex align-items-center gap-1 shadow-xs" title="Lihat Tampilan Publik Destinasi Ini">
                    <i class="bi bi-box-arrow-up-right me-1 text-success"></i> Lihat Halaman Publik
                </a>

                <!-- Quick Button Simpan -->
                <button type="button" class="btn btn-green rounded-pill px-4 py-2 fw-bold text-white small shadow-sm d-flex align-items-center gap-1" 
                         onclick="document.getElementById('formUpdateDestinasi').submit();">
                    <i class="bi bi-check2-circle me-1"></i> Simpan Perubahan
                </button>

            </div>

        </div>
    </div>

    <!-- ============================================================== -->
    <!-- 2. NAV TABS PENGELOLAAN DESTINASI                              -->
    <!-- ============================================================== -->
    <div class="card border-0 shadow-sm rounded-4 p-2 mb-4 bg-white">
        <ul class="nav nav-pills nav-fill gap-2" id="mitraDashboardTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill py-2 px-3 fw-semibold small active d-flex align-items-center justify-content-center gap-2" 
                        id="tab-edit-photos" data-bs-toggle="pill" data-bs-target="#content-edit-photos" type="button" role="tab">
                    <i class="bi bi-images"></i>
                    <span>Foto Utama & Galeri</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill py-2 px-3 fw-semibold small d-flex align-items-center justify-content-center gap-2" 
                        id="tab-edit-price" data-bs-toggle="pill" data-bs-target="#content-edit-price" type="button" role="tab">
                    <i class="bi bi-tag"></i>
                    <span>Harga Tiket & Tarif</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill py-2 px-3 fw-semibold small d-flex align-items-center justify-content-center gap-2" 
                        id="tab-edit-info" data-bs-toggle="pill" data-bs-target="#content-edit-info" type="button" role="tab">
                    <i class="bi bi-pencil-square"></i>
                    <span>Informasi & Fasilitas</span>
                </button>
            </li>
        </ul>
    </div>

    <!-- ============================================================== -->
    <!-- 3. FORM UTAMA PENGELOLAAN DESTINASI                            -->
    <!-- ============================================================== -->
    <form action="{{ route('mitra.destination.update') }}" method="POST" enctype="multipart/form-data" id="formUpdateDestinasi">
        @csrf
        <input type="hidden" name="destination_id" value="{{ $activeDestination->id }}">

        <div class="tab-content" id="mitraDashboardTabsContent">

            <!-- ========================================================== -->
            <!-- TAB 1: KELOLA FOTO UTAMA & GALERI DESTINASI                -->
            <!-- ========================================================== -->
            <div class="tab-pane fade show active" id="content-edit-photos" role="tabpanel">
                <div class="row g-4">
                    
                    <!-- Left: Foto Utama (Cover) -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                            <div class="mb-3 border-bottom border-light-subtle pb-3">
                                <h6 class="fw-bold text-navy mb-1 d-flex align-items-center gap-2">
                                    <i class="bi bi-image text-success"></i> Foto Utama (Cover Depan)
                                </h6>
                                <p class="text-muted small mb-0">Foto utama yang tampil di kartu katalog, hasil pencarian, dan header halaman detail.</p>
                            </div>

                            <!-- Pratinjau Foto Utama Saat Ini -->
                            <div class="position-relative rounded-4 overflow-hidden mb-3 border border-light-subtle bg-light shadow-xs" style="height: 250px;">
                                <img src="{{ $activeDestination->image ?? asset('images/gunung-selamet.jpg') }}" 
                                     alt="Cover Destinasi" 
                                     id="previewCoverImage" 
                                     class="w-100 h-100 object-fit-cover">
                                <span class="position-absolute top-0 start-0 bg-navy-main text-white px-3 py-1 rounded-bottom-end small fw-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                                    FOTO UTAMA SAAT INI
                                </span>
                            </div>

                            <!-- Upload Berkas Foto Baru -->
                            <div class="mb-3">
                                <label class="form-label fw-bold text-navy small mb-1">Unggah Foto Baru dari Komputer / HP</label>
                                <input type="file" name="image_file" class="form-control rounded-3 fs-6" id="inputCoverFile" accept="image/jpeg,image/png,image/webp" onchange="previewSelectedCover(this)">
                                <small class="text-muted d-block mt-1" style="font-size: 0.73rem;">Format JPG, PNG, atau WebP (Maksimal 5MB). Rekomendasi lanskap rasio 16:9.</small>
                            </div>

                            <!-- Opsi Tambahan: Input URL Gambar Langsung -->
                            <div class="mb-2">
                                <label class="form-label fw-bold text-navy small mb-1">Atau Gunakan Tautan URL Gambar</label>
                                <div class="input-group rounded-3">
                                    <span class="input-group-text bg-light text-muted border-end-0 fs-6"><i class="bi bi-link-45deg"></i></span>
                                    <input type="url" name="image_url" class="form-control fs-6 border-start-0" id="inputCoverUrl" placeholder="https://..." value="{{ $activeDestination->image ?? '' }}" oninput="previewUrlCover(this.value)">
                                </div>
                                <small class="text-muted d-block mt-1" style="font-size: 0.73rem;">Tautan gambar publik beresolusi tinggi.</small>
                            </div>

                        </div>
                    </div>

                    <!-- Right: Galeri Foto Tambahan -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom border-light-subtle pb-3">
                                <div>
                                    <h6 class="fw-bold text-navy mb-1 d-flex align-items-center gap-2">
                                        <i class="bi bi-images text-success"></i> Galeri Foto Tambahan
                                    </h6>
                                    <p class="text-muted small mb-0">Foto-foto sudut menarik, fasilitas, dan suasana tempat wisata.</p>
                                </div>
                                <span class="badge bg-light text-secondary border px-3 py-1 rounded-pill small">
                                    {{ count($activeDestination->gallery ?? []) }} Foto Galeri
                                </span>
                            </div>

                            <!-- List Thumbnail Galeri Saat Ini -->
                            <div class="mb-4">
                                <label class="form-label fw-bold text-navy small mb-2">Foto Galeri Aktif (Centang untuk Hapus Foto):</label>
                                <div class="row g-2" id="galleryListContainer">
                                    @if(isset($activeDestination->gallery) && is_array($activeDestination->gallery) && count($activeDestination->gallery) > 0)
                                        @foreach($activeDestination->gallery as $index => $gImg)
                                            <div class="col-4 col-sm-3 position-relative" id="galBox_{{ $index }}">
                                                <div class="rounded-3 overflow-hidden border border-light-subtle position-relative shadow-2xs" style="height: 80px;">
                                                    <img src="{{ $gImg }}" alt="Galeri {{ $index + 1 }}" class="w-100 h-100 object-fit-cover">
                                                </div>
                                                <div class="form-check position-absolute top-0 end-0 mt-1 me-2 bg-white rounded-circle p-1 shadow-xs" title="Centang untuk menghapus foto ini saat disimpan">
                                                    <input class="form-check-input ms-0" type="checkbox" name="delete_gallery_images[]" value="{{ $gImg }}" id="delGal_{{ $index }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12">
                                            <p class="text-muted small mb-0 p-3 bg-light rounded-3 text-center">Belum ada foto galeri tambahan. Unggah di bawah ini.</p>
                                        </div>
                                    @endif
                                </div>
                                <small class="text-muted d-block mt-2" style="font-size: 0.72rem;">Tip: Centang kotak merah pada foto untuk menghapusnya saat disimpan.</small>
                            </div>

                            <!-- Upload Berkas Galeri Baru (Multiple) -->
                            <div class="mb-3">
                                <label class="form-label fw-bold text-navy small mb-1">Tambah Foto Galeri Baru (Pilih beberapa foto)</label>
                                <input type="file" name="gallery_files[]" class="form-control rounded-3 fs-6" multiple accept="image/jpeg,image/png,image/webp">
                                <small class="text-muted d-block mt-1" style="font-size: 0.73rem;">Bisa memilih lebih dari 1 foto sekaligus (Maksimal 5MB per berkas).</small>
                            </div>

                            <!-- Atau Tambah via URL Baru -->
                            <div class="mb-3">
                                <label class="form-label fw-bold text-navy small mb-1">Atau Tambah 1 Tautan URL Galeri Baru</label>
                                <input type="url" name="new_gallery_url" class="form-control fs-6 rounded-3" placeholder="https://example.com/foto-wahana.jpg">
                            </div>

                        </div>
                    </div>

                </div>

                <!-- Bottom Save Button Bar -->
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top border-light-subtle">
                    <button type="submit" class="btn btn-green rounded-pill px-5 py-2 fw-bold text-white shadow-sm">
                        <i class="bi bi-save me-1"></i> Simpan & Perbarui Foto
                    </button>
                </div>
            </div>

            <!-- ========================================================== -->
            <!-- TAB 2: KELOLA HARGA TIKET & TARIF                          -->
            <!-- ========================================================== -->
            <div class="tab-pane fade" id="content-edit-price" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <div class="mb-4 border-bottom border-light-subtle pb-3">
                        <h6 class="fw-bold text-navy mb-1 d-flex align-items-center gap-2">
                            <i class="bi bi-cash-coin text-success"></i> Pengaturan Harga Tiket & Tarif Pengunjung
                        </h6>
                        <p class="text-muted small mb-0">Ubah besaran harga tiket masuk, satuan tarif, dan label pemesanan yang dilihat oleh wisatawan.</p>
                    </div>

                    <div class="row g-4">
                        
                        <!-- Nominal Harga Utama -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-navy small mb-2">Harga Tiket / Tarif Utama (Nominal Angka) <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg rounded-3 mb-1">
                                <span class="input-group-text bg-light text-muted border-end-0 fs-6 fw-semibold">Rp</span>
                                <input type="number" name="price" class="form-control fs-6 border-start-0 fw-bold text-navy" 
                                       id="inputPriceVal" value="{{ $activeDestination->price ?? 20000 }}" min="0" step="1000" required oninput="updateLivePricePreview(this.value)">
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <small class="text-muted" style="font-size: 0.73rem;">Contoh: 15000, 20000, 50000 (Gunakan 0 jika Gratis).</small>
                                <span class="badge bg-success bg-opacity-10 text-success fw-bold" id="livePriceBadge">Rp {{ number_format($activeDestination->price ?? 20000, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Satuan Tarif -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-navy small mb-2">Satuan Tarif / Keterangan Durasi <span class="text-danger">*</span></label>
                            <input type="text" name="price_label" class="form-control form-control-lg rounded-3 fs-6" 
                                   value="{{ $activeDestination->price_label ?? '/ orang' }}" placeholder="Misal: / orang, / kamar / malam, / kelompok" required>
                            <small class="text-muted d-block mt-1" style="font-size: 0.73rem;">Ditampilkan di sebelah nominal harga (misal: "Rp 20.000 / orang").</small>
                        </div>

                        <!-- Judul Tipe Tarif -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-navy small mb-2">Judul Tipe Tiket / Retribusi</label>
                            <input type="text" name="price_type_title" class="form-control rounded-3 fs-6" 
                                   value="{{ $activeDestination->price_type_title ?? 'TIKET MASUK' }}" placeholder="Contoh: TIKET MASUK, SEWA KAMAR, TIKET TERUSAN">
                            <small class="text-muted d-block mt-1" style="font-size: 0.73rem;">Label kecil di atas harga (misal: "TIKET MASUK").</small>
                        </div>

                        <!-- Label Tombol Aksi -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-navy small mb-2">Teks Tombol Aksi Wisatawan</label>
                            <input type="text" name="button_label" class="form-control rounded-3 fs-6" 
                                   value="{{ $activeDestination->button_label ?? 'Lihat Detail >' }}" placeholder="Contoh: Lihat Detail >, Info Rute >, Cek Lokasi >">
                            <small class="text-muted d-block mt-1" style="font-size: 0.73rem;">Teks pada tombol kartu katalog publik.</small>
                        </div>

                    </div>

                    <!-- Kotak Simulasi Pratinjau Tampilan Harga -->
                    <div class="mt-4 p-3 rounded-4 bg-light border border-light-subtle">
                        <span class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">PRATINJAU KARTU HARGA DI HALAMAN PUBLIK:</span>
                        <div class="card border-0 shadow-xs rounded-3 p-3 bg-white" style="max-width: 320px;">
                            <span class="text-muted small text-uppercase" style="font-size: 0.68rem;" id="previewPriceTypeTitle">{{ $activeDestination->price_type_title ?? 'TIKET MASUK' }}</span>
                            <div class="d-flex align-items-baseline gap-1">
                                <h4 class="fw-bold text-navy mb-0" id="previewPriceDisplay">Rp {{ number_format($activeDestination->price ?? 20000, 0, ',', '.') }}</h4>
                                <small class="text-muted" id="previewPriceLabel">{{ $activeDestination->price_label ?? '/ orang' }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top border-light-subtle">
                        <button type="submit" class="btn btn-green rounded-pill px-5 py-2 fw-bold text-white shadow-sm">
                            <i class="bi bi-save me-1"></i> Simpan & Perbarui Harga
                        </button>
                    </div>
                </div>
            </div>

            <!-- ========================================================== -->
            <!-- TAB 3: KELOLA INFORMASI TEMPAT & FASILITAS                 -->
            <!-- ========================================================== -->
            <div class="tab-pane fade" id="content-edit-info" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <div class="mb-4 border-bottom border-light-subtle pb-3">
                        <h6 class="fw-bold text-navy mb-1 d-flex align-items-center gap-2">
                            <i class="bi bi-info-circle text-success"></i> Informasi Destinasi, Jam Buka & Fasilitas
                        </h6>
                        <p class="text-muted small mb-0">Perbarui deskripsi, kategori wisata, jam operasional, dan daftar fasilitas yang tersedia.</p>
                    </div>

                    <div class="row g-3 mb-4">
                        <!-- Nama Destinasi -->
                        <div class="col-md-7">
                            <label class="form-label fw-bold text-navy small mb-1">Nama Destinasi / Tempat Usaha <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-lg rounded-3 fs-6" value="{{ $activeDestination->name ?? '' }}" required>
                        </div>

                        <!-- Kategori Utama -->
                        <div class="col-md-5">
                            <label class="form-label fw-bold text-navy small mb-1">Kategori Destinasi <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select form-select-lg rounded-3 fs-6" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ ($activeDestination->category_id ?? null) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jam Operasional -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-navy small mb-1">Jam Operasional Kunjungan</label>
                            <div class="input-group rounded-3">
                                <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-clock"></i></span>
                                <input type="text" name="open_hours" class="form-control border-start-0" value="{{ $activeDestination->open_hours ?? '08:00 - 17:00 WIB' }}" placeholder="Contoh: 08:00 - 17:00 WIB (Setiap Hari)">
                            </div>
                        </div>

                        <!-- Suhu / Cuaca -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-navy small mb-1">Suhu Rata-rata Lingkungan</label>
                            <div class="input-group rounded-3">
                                <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-thermometer-half"></i></span>
                                <input type="text" name="temperature" class="form-control border-start-0" value="{{ $activeDestination->temperature ?? '20° - 23° C' }}" placeholder="Contoh: 20° - 23° C Sejuk Pegunungan">
                            </div>
                        </div>

                        <!-- Lokasi Ringkas & Alamat Lengkap -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-navy small mb-1">Wilayah / Kecamatan</label>
                            <input type="text" name="location" class="form-control rounded-3" value="{{ $activeDestination->location ?? 'Karangmangu, Kec. Baturraden' }}" placeholder="Misal: Karangmangu, Kec. Baturraden">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-navy small mb-1">Alamat Lengkap & Petunjuk Akses</label>
                            <input type="text" name="address_full" class="form-control rounded-3" value="{{ $activeDestination->address_full ?? '' }}" placeholder="Alamat lengkap, patokan jalan, atau kapasitas bus">
                        </div>

                        <!-- Deskripsi Destinasi -->
                        <div class="col-12 mt-3">
                            <label class="form-label fw-bold text-navy small mb-1">Deskripsi & Narasi Wisata <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control rounded-3" rows="4" required placeholder="Ceritakan keindahan, daya tarik, dan fasilitas tempat wisata Anda...">{{ $activeDestination->description ?? '' }}</textarea>
                        </div>
                    </div>

                    <!-- Checklist Fasilitas Populer -->
                    <div class="pt-3 border-top border-light-subtle">
                        <label class="form-label fw-bold text-navy small mb-2 d-block">
                            Fasilitas yang Tersedia (Centang untuk Mengaktifkan):
                        </label>
                        @php
                            $availableFacilities = [
                                'Toilet Bersih', 'Musholla', 'Wifi Cepat', 'Parkir Luas', 'Warung Makan', 
                                'Spot Foto Estetik', 'Area Bermain Anak', 'Gazebo Teduh', 'Penginapan / Homestay',
                                'Akses Ramah Difabel', 'Pembayaran QRIS', 'Pemandian Air Panas', 'Kolam Renang'
                            ];
                            $currentFacilities = $activeDestination->facilities ?? [];
                            if (!is_array($currentFacilities)) $currentFacilities = [];
                        @endphp

                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach($availableFacilities as $fac)
                                <div class="form-check form-check-inline m-0">
                                    <input class="form-check-input d-none facility-checkbox" type="checkbox" name="facilities[]" value="{{ $fac }}" id="fac_{{ $loop->index }}" {{ in_array($fac, $currentFacilities) ? 'checked' : '' }}>
                                    <label class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 facility-label {{ in_array($fac, $currentFacilities) ? 'active bg-success text-white border-success' : '' }}" for="fac_{{ $loop->index }}">
                                        <i class="bi bi-check2 {{ in_array($fac, $currentFacilities) ? '' : 'd-none' }}"></i> {{ $fac }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top border-light-subtle">
                        <button type="submit" class="btn btn-green rounded-pill px-5 py-2 fw-bold text-white shadow-sm">
                            <i class="bi bi-save me-1"></i> Simpan Semua Perubahan
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </form>

</div>

<!-- ============================================================== -->
<!-- SCRIPT PRATINJAU LANGSUNG GAMBAR & HARGA                       -->
<!-- ============================================================== -->
<script>
    // 1. Pratinjau saat memilih file cover dari komputer
    function previewSelectedCover(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('previewCoverImage');
                const topThumb = document.getElementById('topHeaderThumb');
                if (img) img.src = e.target.result;
                if (topThumb) topThumb.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // 2. Pratinjau saat mengetik URL foto cover
    function previewUrlCover(url) {
        if (url && (url.startsWith('http://') || url.startsWith('https://'))) {
            const img = document.getElementById('previewCoverImage');
            const topThumb = document.getElementById('topHeaderThumb');
            if (img) img.src = url;
            if (topThumb) topThumb.src = url;
        }
    }

    // 3. Pratinjau nominal harga real-time
    function updateLivePricePreview(val) {
        const num = Number(val) || 0;
        const formatted = 'Rp ' + num.toLocaleString('id-ID');
        
        const badge = document.getElementById('livePriceBadge');
        const display = document.getElementById('previewPriceDisplay');
        if (badge) badge.innerText = formatted;
        if (display) display.innerText = formatted;
    }

    // 4. Toggle visual aktif pada tombol fasilitas
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.facility-checkbox');
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const label = document.querySelector('label[for="' + this.id + '"]');
                const icon = label ? label.querySelector('i') : null;
                if (this.checked) {
                    if (label) label.className = 'btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 facility-label active bg-success text-white border-success';
                    if (icon) icon.className = 'bi bi-check2';
                } else {
                    if (label) label.className = 'btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 facility-label';
                    if (icon) icon.className = 'bi bi-check2 d-none';
                }
            });
        });
    });
</script>
@endsection
