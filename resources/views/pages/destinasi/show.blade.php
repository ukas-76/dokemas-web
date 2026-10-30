@extends('layouts.app')

@section('content')
<div class="py-4" style="background-color: #f8fafc; min-height: 90vh;">
    <div class="container">

        <!-- BREADCRUMB & TOP ACTIONS -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-secondary text-decoration-none"><i class="bi bi-house-door"></i> Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('destinasi.index') }}" class="text-secondary text-decoration-none">Destinasi Wisata</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('destinasi.index', ['kategori' => $destination->category->slug ?? 'wisata-alam-curug']) }}" class="text-secondary text-decoration-none">{{ $destination->category->name ?? 'Wisata Alam & Air Terjun' }}</a></li>
                    <li class="breadcrumb-item active text-navy fw-bold" aria-current="page">{{ $destination->name }}</li>
                </ol>
            </nav>

            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-white bg-white border border-slate-200 px-3 py-2 rounded-3 text-secondary small d-flex align-items-center gap-2 shadow-2xs hover-green" onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan destinasi berhasil disalin!');">
                    <i class="bi bi-share"></i> Bagikan
                </button>
                <button type="button" class="btn btn-white bg-white border border-slate-200 px-3 py-2 rounded-3 text-secondary small d-flex align-items-center gap-2 shadow-2xs hover-green" onclick="window.print()">
                    <i class="bi bi-download"></i> Unduh Brosur PDF
                </button>
            </div>
        </div>

        <!-- TOP HEADER: BADGES, TITLE, LOCATION & METRICS -->
        <div class="mb-4">
            <!-- Badges Row -->
            <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                <span class="badge rounded-pill px-3 py-2 text-white fw-semibold small d-inline-flex align-items-center gap-1" style="background-color: #0d233a; font-size: 0.75rem;">
                    <i class="bi bi-compass text-info"></i> {{ $destination->category->name ?? 'Wisata Alam' }}
                </span>
                <span class="badge rounded-pill px-3 py-2 fw-semibold small d-inline-flex align-items-center gap-1" style="background-color: #dcfce7; color: #15803d; font-size: 0.75rem;">
                    <i class="bi bi-check-circle-fill"></i> Terverifikasi Resmi Dinporabudpar Banyumas
                </span>
                <span class="badge rounded-pill px-3 py-2 text-secondary fw-semibold small d-inline-flex align-items-center gap-1" style="background-color: #f1f5f9; font-size: 0.75rem;">
                    <i class="bi bi-ticket-perforated"></i> {{ $destination->type === 'ticket' ? 'Bebas Antre Loket' : 'Bebas Biaya Reservasi' }}
                </span>
            </div>

            <!-- Title -->
            <h1 class="display-6 fw-bold text-navy mb-2" style="font-weight: 800; letter-spacing: -0.5px;">
                {{ $destination->name }}
            </h1>

            <!-- Location Line -->
            <div class="d-flex align-items-center gap-1 text-muted small mb-2">
                <i class="bi bi-geo-alt-fill text-success"></i>
                <span>{{ $destination->address_full ?? $destination->location }}</span>
            </div>

            <!-- Metrics Line -->
            <div class="d-flex align-items-center gap-3 text-muted small flex-wrap">
                <div class="d-flex align-items-center gap-1">
                    <i class="bi bi-star-fill text-warning"></i>
                    <span class="fw-bold text-navy">{{ number_format($destination->rating, 1) }}</span>
                    <span>({{ $destination->reviews_count }}+ Ulasan Terverifikasi)</span>
                </div>
                <span>•</span>
                <div class="d-flex align-items-center gap-1">
                    <span class="d-inline-block rounded-circle bg-success me-1" style="width: 8px; height: 8px;"></span>
                    <span class="text-success fw-semibold">Buka Hari Ini: {{ $destination->open_hours ?? '07.30 - 17.00 WIB' }}</span>
                </div>
                <span>•</span>
                <div class="d-flex align-items-center gap-1">
                    <i class="bi bi-thermometer-half text-info"></i>
                    <span>{{ $destination->temperature ?? '20° - 23° C' }} Sejuk Pegunungan</span>
                </div>
            </div>
        </div>

        <!-- PHOTO GALLERY: ASYMMETRICAL MODERN 5-GRID -->
        @php
            $gallery = is_array($destination->gallery) ? $destination->gallery : [];
            $mainImg = $destination->image ?: ($gallery[0] ?? 'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?auto=format&fit=crop&w=1200&q=80');
            $thumb1 = $gallery[0] ?? $mainImg;
            $thumb2 = $gallery[1] ?? ($gallery[0] ?? $mainImg);
            $thumb3 = $gallery[2] ?? ($gallery[0] ?? $mainImg);
            $thumb4 = $gallery[3] ?? ($gallery[1] ?? $mainImg);
        @endphp

        <div class="row g-2 g-md-3 mb-4">
            <!-- Left Large Main Photo -->
            <div class="col-lg-7">
                <div class="rounded-4 overflow-hidden position-relative shadow-sm h-100" style="min-height: 420px; background-color: #0b1b2a;">
                    <img src="{{ $mainImg }}" alt="{{ $destination->name }}" class="w-100 h-100 object-fit-cover" id="mainGalleryImg">
                    
                    <!-- Dark Gradient Overlay with Text -->
                    <div class="position-absolute bottom-0 start-0 w-100 p-3 p-md-4 text-white d-flex justify-content-between align-items-end" style="background: linear-gradient(180deg, transparent 0%, rgba(11,27,42,0.88) 100%);">
                        <div>
                            <small class="text-uppercase tracking-wider fw-bold text-success d-block mb-1" style="font-size: 0.68rem; letter-spacing: 1px;">
                                {{ $destination->badge_label ?? 'PESONA ALAM BANYUMAS' }}
                            </small>
                            <h4 class="h5 fw-bold mb-0 text-white">{{ $destination->name }}</h4>
                        </div>
                        <span class="badge bg-white bg-opacity-20 backdrop-blur px-3 py-1 rounded-pill small">
                            <i class="bi bi-camera me-1"></i> Foto Utama
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right 4 Small Photos (2x2 Grid) -->
            <div class="col-lg-5">
                <div class="row g-2 g-md-3 h-100">
                    <!-- Top Left Thumb -->
                    <div class="col-6">
                        <div class="rounded-4 overflow-hidden position-relative shadow-sm cursor-pointer" style="height: 200px;" onclick="changeMainImg('{{ $thumb1 }}')">
                            <img src="{{ $thumb1 }}" alt="{{ $destination->name }} 1" class="w-100 h-100 object-fit-cover">
                            <span class="badge bg-dark bg-opacity-70 text-white position-absolute top-0 start-0 m-2 px-2 py-1 rounded-pill" style="font-size: 0.65rem;">{{ $destination->subdistrict ?? 'Banyumas' }}</span>
                            <span class="badge bg-dark bg-opacity-75 text-white position-absolute bottom-0 start-0 m-2 px-2 py-1 rounded-3 text-truncate" style="font-size: 0.68rem; max-width: 90%;">Spot Panorama</span>
                        </div>
                    </div>

                    <!-- Top Right Thumb -->
                    <div class="col-6">
                        <div class="rounded-4 overflow-hidden position-relative shadow-sm cursor-pointer" style="height: 200px;" onclick="changeMainImg('{{ $thumb2 }}')">
                            <img src="{{ $thumb2 }}" alt="{{ $destination->name }} 2" class="w-100 h-100 object-fit-cover">
                            <span class="badge bg-dark bg-opacity-75 text-white position-absolute bottom-0 start-0 m-2 px-2 py-1 rounded-3 text-truncate" style="font-size: 0.68rem; max-width: 90%;">Suasana Alami</span>
                        </div>
                    </div>

                    <!-- Bottom Left Thumb -->
                    <div class="col-6">
                        <div class="rounded-4 overflow-hidden position-relative shadow-sm cursor-pointer" style="height: 200px;" onclick="changeMainImg('{{ $thumb3 }}')">
                            <img src="{{ $thumb3 }}" alt="{{ $destination->name }} 3" class="w-100 h-100 object-fit-cover">
                            <span class="badge bg-dark bg-opacity-75 text-white position-absolute bottom-0 start-0 m-2 px-2 py-1 rounded-3 text-truncate" style="font-size: 0.68rem; max-width: 90%;">Spot Fotogenik</span>
                        </div>
                    </div>

                    <!-- Bottom Right Thumb -->
                    <div class="col-6">
                        <div class="rounded-4 overflow-hidden position-relative shadow-sm cursor-pointer" style="height: 200px;" onclick="alert('Membuka Galeri Foto & Video {{ addslashes($destination->name) }}')">
                            <img src="{{ $thumb4 }}" alt="{{ $destination->name }} 4" class="w-100 h-100 object-fit-cover">
                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-60 d-flex flex-column align-items-center justify-content-center text-white text-center p-2">
                                <i class="bi bi-grid-3x3-gap fs-4 mb-1"></i>
                                <span class="fw-bold small" style="font-size: 0.82rem;">Lihat Semua Foto ↗</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- NAVIGATION TABS BAR -->
        <div class="d-flex align-items-center gap-2 overflow-x-auto pb-2 mb-4 scrollbar-none" style="white-space: nowrap;">
            <a href="#tentang" class="btn btn-navy-main text-white rounded-pill px-4 py-2 small fw-bold shadow-2xs" style="background-color: #0f172a;">Tentang Destinasi</a>
            <a href="#fasilitas" class="btn btn-white bg-white border border-slate-200 text-secondary rounded-pill px-4 py-2 small fw-semibold">Fasilitas & Layanan</a>
            <a href="#rute" class="btn btn-white bg-white border border-slate-200 text-secondary rounded-pill px-4 py-2 small fw-semibold">Rute & Lokasi</a>
            <a href="#ulasan" class="btn btn-white bg-white border border-slate-200 text-secondary rounded-pill px-4 py-2 small fw-semibold">Ulasan Wisatawan ({{ $destination->reviews_count }})</a>
            <a href="#faq" class="btn btn-white bg-white border border-slate-200 text-secondary rounded-pill px-4 py-2 small fw-semibold">FAQ / Info Penting</a>
        </div>

        <!-- MAIN TWO-COLUMN SECTION -->
        <div class="row g-4">
            
            <!-- LEFT COLUMN: CONTENT CARDS -->
            <div class="col-lg-8">
                
                <!-- CARD 1: PESONA DESTINASI -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4" id="tentang">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h5 fw-bold text-navy mb-0" style="font-weight: 800;">
                            Pesona {{ $destination->name }}
                        </h2>
                        <span class="text-success fw-bold small text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                            {{ $destination->badge_label ?? 'BANYUMAS INDAH' }}
                        </span>
                    </div>

                    <p class="text-secondary small leading-relaxed mb-3" style="line-height: 1.8; font-size: 0.92rem;">
                        {{ $destination->description }}
                    </p>

                    @if(!empty($destination->highlights) && is_array($destination->highlights))
                        <div class="row g-2 my-3">
                            @foreach($destination->highlights as $hl)
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start gap-2 p-2 rounded-3 bg-light border border-slate-100 h-100">
                                        <i class="bi bi-check-circle-fill text-success mt-1"></i>
                                        <span class="small text-secondary">{{ $hl }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Feature Badges List -->
                    <div class="d-flex flex-wrap gap-2 pt-2">
                        <span class="badge rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-1" style="background-color: #f0fdf4; color: #166534; font-size: 0.75rem;">
                            <i class="bi bi-people-fill text-success"></i> Cocok untuk Keluarga & Wisatawan
                        </span>
                        <span class="badge rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-1" style="background-color: #f0fdf4; color: #166534; font-size: 0.75rem;">
                            <i class="bi bi-camera-fill text-success"></i> Spot Foto Instagramable
                        </span>
                        <span class="badge rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-1" style="background-color: #f0fdf4; color: #166534; font-size: 0.75rem;">
                            <i class="bi bi-geo-alt-fill text-success"></i> Akses Jalan Mudah
                        </span>
                        <span class="badge rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-1" style="background-color: #f0fdf4; color: #166534; font-size: 0.75rem;">
                            <i class="bi bi-droplet-fill text-success"></i> Udara Sejuk Pegunungan
                        </span>
                    </div>
                </div>

                <!-- CARD 2: FASILITAS & SARANA PENGUNJUNG -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4" id="fasilitas">
                    <h3 class="h5 fw-bold text-navy mb-1" style="font-weight: 800;">
                        Fasilitas & Sarana Pengunjung
                    </h3>
                    <p class="text-muted small mb-4">Tersertifikasi standar Sapta Pesona Pariwisata untuk kenyamanan kunjungan Anda.</p>

                    @php
                        $facList = is_array($destination->facilities) ? $destination->facilities : ['Air Alami', 'Parkir Luas', 'Gazebo Teduh', 'Mushola Bersih'];
                        $iconHelper = [
                            'parkir' => ['icon' => 'P', 'is_p' => true, 'desc' => 'Kapasitas kendaraan roda dua, mobil pribadi, hingga bus pariwisata.'],
                            'mushola' => ['icon' => 'bi-moon-stars', 'is_p' => false, 'desc' => 'Tersedia tempat ibadah dan tempat wudhu bersih mengalir.'],
                            'toilet' => ['icon' => 'bi-droplet', 'is_p' => false, 'desc' => 'Bilik toilet dan kamar ganti bilas terawat dan higienis.'],
                            'kamar' => ['icon' => 'bi-door-closed', 'is_p' => false, 'desc' => 'Kamar tidur nyaman dengan fasilitas lengkap.'],
                            'gazebo' => ['icon' => 'bi-house', 'is_p' => false, 'desc' => 'Pondok teduh santai untuk beristirahat bersama keluarga.'],
                            'kolam' => ['icon' => 'bi-water', 'is_p' => false, 'desc' => 'Area kolam alami jernih menyegarkan untuk bermain air.'],
                            'pool' => ['icon' => 'bi-water', 'is_p' => false, 'desc' => 'Kolam renang air bersih yang terawat setiap hari.'],
                            'wifi' => ['icon' => 'bi-wifi', 'is_p' => false, 'desc' => 'Akses internet nirkabel berkecepatan tinggi.'],
                            'anak' => ['icon' => 'bi-people', 'is_p' => false, 'desc' => 'Wahana rekreasi aman dan ramah untuk anak-anak.'],
                            'warung' => ['icon' => 'bi-cup-hot', 'is_p' => false, 'desc' => 'Warung kuliner khas mendoan hangat dan aneka minuman.'],
                            'resto' => ['icon' => 'bi-cup-hot', 'is_p' => false, 'desc' => 'Restoran menyajikan hidangan lezat khas lokal dan nusantara.'],
                            'dapur' => ['icon' => 'bi-fire', 'is_p' => false, 'desc' => 'Dapur bersih dengan peralatan memasak lengkap.'],
                        ];
                    @endphp

                    <div class="row g-3">
                        @foreach($facList as $facilityItem)
                            @php
                                $lower = strtolower($facilityItem);
                                $matched = null;
                                foreach ($iconHelper as $key => $conf) {
                                    if (str_contains($lower, $key)) {
                                        $matched = $conf;
                                        break;
                                    }
                                }
                                if (!$matched) {
                                    $matched = ['icon' => 'bi-check2-circle', 'is_p' => false, 'desc' => 'Fasilitas terawat berstandar demi kenyamanan pengunjung.'];
                                }
                            @endphp
                            <div class="col-md-6 col-lg-4">
                                <div class="p-3 rounded-4 bg-light h-100 border border-slate-100">
                                    <div class="rounded-3 bg-navy-main text-white d-flex align-items-center justify-content-center mb-2" style="width: 36px; height: 36px; background-color: #0f172a;">
                                        @if(!empty($matched['is_p']))
                                            <span class="fw-bold">P</span>
                                        @else
                                            <i class="bi {{ $matched['icon'] }}"></i>
                                        @endif
                                    </div>
                                    <h6 class="fw-bold text-navy mb-1">{{ $facilityItem }}</h6>
                                    <p class="text-muted small mb-0" style="font-size: 0.75rem; line-height: 1.5;">
                                        {{ $matched['desc'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- CARD 3: RUTE & PANDUAN AKSES LOKASI -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4" id="rute">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h3 class="h5 fw-bold text-navy mb-0" style="font-weight: 800;">
                            Rute & Panduan Akses Lokasi
                        </h3>
                        <a href="https://maps.google.com/?q={{ urlencode($destination->name . ' ' . $destination->location . ' Banyumas') }}" target="_blank" class="btn btn-sm btn-dark text-white rounded-3 px-3 py-2 fw-semibold d-flex align-items-center gap-2" style="background-color: #0f172a;">
                            <i class="bi bi-compass"></i> Buka di Google Maps ↗
                        </a>
                    </div>
                    <p class="text-muted small mb-3">Berlokasi di kawasan strategis {{ $destination->location }}, Kabupaten Banyumas.</p>

                    <!-- Stylized Map Card Preview -->
                    <div class="rounded-4 overflow-hidden position-relative p-4 mb-3 text-dark d-flex align-items-center justify-content-center" style="height: 240px; background: linear-gradient(135deg, #cbe3ca 0%, #b8dcb5 100%); border: 1px solid #a8d5a4;">
                        <!-- Map Route SVG Art -->
                        <div class="position-absolute w-100 h-100 top-0 start-0 opacity-40" style="background-image: radial-gradient(#2e7d32 1px, transparent 1px); background-size: 16px 16px;"></div>

                        <div class="card border-0 shadow-lg p-3 rounded-4 bg-white text-start z-1" style="max-width: 340px;">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <div class="rounded-circle bg-success text-white p-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-navy mb-0 text-truncate" style="font-size: 0.9rem; max-width: 250px;">{{ $destination->name }}</h6>
                                    <small class="text-muted" style="font-size: 0.72rem;">{{ $destination->location }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2 Transport Cards -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 rounded-4 bg-light border border-slate-100 h-100">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-car-front-fill text-navy fs-5"></i>
                                    <h6 class="fw-bold text-navy mb-0">Kendaraan Pribadi</h6>
                                </div>
                                <p class="text-muted small mb-0" style="line-height: 1.6; font-size: 0.8rem;">
                                    Akses jalan aspal mulus dan tertata. Tersedia penunjuk arah resmi di setiap simpang utama Banyumas.
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 rounded-4 bg-light border border-slate-100 h-100">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-bus-front-fill text-navy fs-5"></i>
                                    <h6 class="fw-bold text-navy mb-0">Transportasi Umum</h6>
                                </div>
                                <p class="text-muted small mb-0" style="line-height: 1.6; font-size: 0.8rem;">
                                    Dapat diakses menggunakan Trans Banyumas koridor terdekat atau angkutan wisata dari terminal Purwokerto.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 4: ULASAN & PENILAIAN PENGUNJUNG -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4" id="ulasan">
                    <h3 class="h5 fw-bold text-navy mb-1" style="font-weight: 800;">
                        Ulasan & Penilaian Pengunjung
                    </h3>
                    <p class="text-muted small mb-4">Pengalaman autentik wisatawan yang telah berkunjung.</p>

                    <!-- Score Header Block -->
                    <div class="row g-3 align-items-center p-3 rounded-4 bg-light border border-slate-100 mb-4">
                        <div class="col-sm-4 text-center border-end-sm">
                            <div class="display-4 fw-bold text-navy lh-1 mb-1" style="font-weight: 800;">
                                {{ number_format($destination->rating, 1) }}
                            </div>
                            <div class="text-warning small mb-1">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <small class="text-muted d-block fw-semibold" style="font-size: 0.75rem;">
                                Berdasarkan {{ $destination->reviews_count }} Ulasan
                            </small>
                        </div>

                        <div class="col-sm-8">
                            <!-- Progress 5 Bintang -->
                            <div class="d-flex align-items-center gap-2 small mb-1">
                                <span class="text-muted" style="width: 55px; font-size: 0.72rem;">5 Bintang</span>
                                <div class="progress flex-grow-1" style="height: 6px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 88%"></div>
                                </div>
                                <span class="text-muted fw-semibold" style="width: 32px; font-size: 0.72rem;">88%</span>
                            </div>

                            <!-- Progress 4 Bintang -->
                            <div class="d-flex align-items-center gap-2 small mb-1">
                                <span class="text-muted" style="width: 55px; font-size: 0.72rem;">4 Bintang</span>
                                <div class="progress flex-grow-1" style="height: 6px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 9%"></div>
                                </div>
                                <span class="text-muted fw-semibold" style="width: 32px; font-size: 0.72rem;">9%</span>
                            </div>

                            <!-- Progress 3 Bintang -->
                            <div class="d-flex align-items-center gap-2 small">
                                <span class="text-muted" style="width: 55px; font-size: 0.72rem;">3 Bintang</span>
                                <div class="progress flex-grow-1" style="height: 6px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 3%"></div>
                                </div>
                                <span class="text-muted fw-semibold" style="width: 32px; font-size: 0.72rem;">3%</span>
                            </div>
                        </div>
                    </div>

                    <!-- 3 Verified Reviews -->
                    <div class="d-flex flex-column gap-3">
                        <!-- Review 1 -->
                        <div class="p-3 rounded-4 bg-light border border-slate-100">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-navy-main text-white d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px; background-color: #0f172a; font-size: 0.85rem;">
                                        BP
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-navy mb-0" style="font-size: 0.85rem;">Bambang Pamungkas</h6>
                                        <small class="text-muted" style="font-size: 0.7rem;">Kunjungan Keluarga • Minggu Lalu</small>
                                    </div>
                                </div>
                                <div class="text-warning small">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                            </div>
                            <p class="text-secondary small mb-0" style="line-height: 1.6;">
                                "Tempatnya sangat asri dan sejuk. Pelayanannya ramah serta aksesnya sangat tertata. Anak-anak dan keluarga sangat senang berlibur ke sini. Sangat direkomendasikan!"
                            </p>
                        </div>

                        <!-- Review 2 -->
                        <div class="p-3 rounded-4 bg-light border border-slate-100">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-navy-main text-white d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px; background-color: #0f172a; font-size: 0.85rem;">
                                        SN
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-navy mb-0" style="font-size: 0.85rem;">Siti Nurhaliza</h6>
                                        <small class="text-muted" style="font-size: 0.7rem;">Solo Traveler • 2 Minggu Lalu</small>
                                    </div>
                                </div>
                                <div class="text-warning small">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                            </div>
                            <p class="text-secondary small mb-0" style="line-height: 1.6;">
                                "Suasana alam Banyumas memang juara! Pembelian e-tiket di website DOKEMAS praktis banget, tinggal tunjukkan barcode di ponsel langsung masuk tanpa antre."
                            </p>
                        </div>
                    </div>
                </div>

                <!-- CARD 5: FAQ & INFORMASI PENTING -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4" id="faq">
                    <h3 class="h5 fw-bold text-navy mb-1" style="font-weight: 800;">
                        FAQ & Pertanyaan Sering Diajukan
                    </h3>
                    <p class="text-muted small mb-4">Informasi penting seputar tiket, jam buka, dan aturan kunjungan.</p>

                    <div class="d-flex flex-column gap-3">
                        <div class="p-3 rounded-4 bg-light border border-slate-100">
                            <h6 class="fw-bold text-navy mb-2" style="font-size: 0.9rem;">
                                Apakah perlu mencetak tiket fisik?
                            </h6>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">
                                Tidak perlu dicetak. Anda cukup memperlihatkan QR Code E-Tiket dari smartphone Anda kepada petugas loket untuk diverifikasi instan.
                            </p>
                        </div>

                        <div class="p-3 rounded-4 bg-light border border-slate-100">
                            <h6 class="fw-bold text-navy mb-2" style="font-size: 0.9rem;">
                                Bagaimana proses refund / reschedule jika cuaca buruk?
                            </h6>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">
                                Tiket online yang dipesan melalui portal DOKEMAS memiliki jaminan ganti tanggal kunjungan hingga H-1 melalui Customer Service tanpa biaya administrasi.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: STICKY SIDEBAR (BOOKING, WEATHER & NEARBY) -->
            <div class="col-lg-4">
                
                <!-- 1. STICKY BOOKING CARD -->
                <div class="card border-0 shadow-lg rounded-4 p-4 bg-white mb-4 sticky-top-card" style="border: 1px solid #e2e8f0 !important;">
                    
                    <!-- Top Alert Badge -->
                    <div class="p-2 rounded-3 bg-light text-secondary small d-flex align-items-center gap-2 mb-3" style="font-size: 0.72rem; border: 1px solid #e2e8f0;">
                        <i class="bi bi-shield-check text-success fs-6"></i>
                        <span>Harga Resmi Pemkab Banyumas • Tanpa Biaya Tersembunyi</span>
                    </div>

                    <!-- Price Header -->
                    <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                        <div>
                            <small class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                                {{ $destination->price_type_title ?? 'HARGA TIKET MASUK' }}
                            </small>
                            <div class="d-flex align-items-baseline gap-1">
                                <span class="display-6 fw-bold text-navy" style="font-weight: 800;">
                                    Rp {{ number_format($destination->price, 0, ',', '.') }}
                                </span>
                                <small class="text-muted">{{ $destination->price_label ?? '/ orang' }}</small>
                            </div>
                        </div>
                        <span class="badge rounded-pill fw-semibold px-2 py-1" style="background-color: #dcfce7; color: #15803d; font-size: 0.7rem;">
                            {{ $destination->type === 'ticket' ? 'E-Tiket Terusan' : 'Konfirmasi Instan' }}
                        </span>
                    </div>

                    <!-- Booking Form -->
                    <form id="ticketBookingForm" onsubmit="event.preventDefault(); showTicketModal();">
                        <!-- Date Picker -->
                        <div class="mb-3">
                            <label class="form-label text-navy fw-bold small mb-1">Pilih Tanggal Kunjungan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-slate-200 text-muted"><i class="bi bi-calendar3"></i></span>
                                <input type="date" class="form-control bg-light border-slate-200 small" id="visitDateInput" required value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <!-- Quantity Selector Stepper -->
                        <div class="mb-3">
                            <label class="form-label text-navy fw-bold small mb-1">Jumlah Pengunjung</label>
                            <div class="d-flex align-items-center justify-content-between p-2 rounded-3 border border-slate-200 bg-light">
                                <div class="d-flex align-items-center gap-2 text-secondary small">
                                    <i class="bi bi-people-fill text-muted"></i>
                                    <span id="labelPengunjung">2 Pengunjung</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-sm btn-white bg-white shadow-2xs rounded-circle border" style="width: 30px; height: 30px; line-height: 1;" onclick="updateVisitorQty(-1)">-</button>
                                    <span class="fw-bold text-navy" id="displayQty">2</span>
                                    <input type="hidden" id="visitorQty" value="2">
                                    <button type="button" class="btn btn-sm btn-white bg-white shadow-2xs rounded-circle border" style="width: 30px; height: 30px; line-height: 1;" onclick="updateVisitorQty(1)">+</button>
                                </div>
                            </div>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="bg-light p-3 rounded-3 mb-3 border border-slate-100 small">
                            <div class="d-flex justify-content-between text-secondary mb-1">
                                <span><span id="ticketCountLabel">2</span>x {{ $destination->type === 'ticket' ? 'Tiket Masuk' : 'Reservasi' }}</span>
                                <span class="text-navy fw-semibold" id="ticketSubtotal">Rp {{ number_format($destination->price * 2, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between text-secondary mb-2">
                                <span>Asuransi Jasa Raharja Wisata</span>
                                <span class="text-navy fw-semibold" id="insuranceFee">Rp 2.000</span>
                            </div>
                            <hr class="my-2 opacity-25">
                            <div class="d-flex justify-content-between align-items-center fw-bold">
                                <span class="text-navy">Total Pembayaran</span>
                                <span class="text-success fs-5" id="totalPaymentDisplay">Rp {{ number_format($destination->price * 2 + 2000, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <button type="submit" class="btn btn-green w-100 rounded-3 py-3 fw-bold d-flex align-items-center justify-content-center gap-2 shadow-sm mb-2" style="background-color: #2e7d32;">
                            <i class="bi bi-ticket-perforated-fill"></i> {{ $destination->type === 'ticket' ? 'Beli E-Tiket Bebas Antre' : ($destination->type === 'hotel' || $destination->type === 'villa' ? 'Pesan Kamar / Villa' : 'Pesan Tempat / Menu') }}
                        </button>

                        <a href="https://wa.me/6281234567890?text={{ urlencode('Halo DOKEMAS, saya ingin bertanya tentang reservasi ' . $destination->name . '.') }}" target="_blank" class="btn btn-white bg-white border border-slate-200 text-secondary w-100 rounded-3 py-2 fw-semibold small d-flex align-items-center justify-content-center gap-2 mb-2 hover-green">
                            <i class="bi bi-whatsapp text-success"></i> Hubungi Pengelola via WhatsApp
                        </a>

                        <div class="text-center">
                            <a href="https://maps.google.com/?q={{ urlencode($destination->name . ' ' . $destination->location) }}" target="_blank" class="text-muted text-decoration-none small" style="font-size: 0.75rem;">
                                <i class="bi bi-signpost-2"></i> Petunjuk Arah Google Maps
                            </a>
                        </div>
                    </form>

                    <!-- Trust Notes -->
                    <div class="mt-4 pt-3 border-top d-flex flex-column gap-2 text-muted" style="font-size: 0.72rem;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-check2 text-success"></i>
                            <span>E-Tiket QR Code langsung dikirim via WhatsApp & Email</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-check2 text-success"></i>
                            <span>Garansi Bebas Ganti Tanggal (Reschedule) hingga H-1</span>
                        </div>
                    </div>

                </div>

                <!-- 2. KONDISI CUACA & ANTREAN (LIVE UPDATE) -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2 text-navy fw-bold small">
                            <i class="bi bi-brightness-high text-warning"></i>
                            <span>Kondisi Cuaca & Antrean</span>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success fw-bold text-uppercase" style="font-size: 0.65rem;">
                            LIVE UPDATE
                        </span>
                    </div>

                    <!-- Weather Info -->
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-4 bg-light mb-3 border border-slate-100">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-cloud-sun text-warning fs-3"></i>
                            <div>
                                <h6 class="fw-bold text-navy mb-0" style="font-size: 0.95rem;">Cerah Berawan</h6>
                                <small class="text-muted" style="font-size: 0.7rem;">Kelembapan 78% • Hawa Sejuk Pegunungan</small>
                            </div>
                        </div>
                        <div class="display-6 fw-bold text-navy" style="font-size: 1.5rem;">22°C</div>
                    </div>

                    <!-- Crowd Level -->
                    <div class="p-3 rounded-4 bg-light border border-slate-100">
                        <div class="d-flex justify-content-between align-items-center small mb-1">
                            <span class="text-muted" style="font-size: 0.72rem;">Tingkat Kepadatan Hari Ini:</span>
                            <span class="fw-bold text-success" style="font-size: 0.75rem;">Normal / Nyaman</span>
                        </div>
                        <div class="progress mb-2" style="height: 6px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 28%"></div>
                        </div>
                        <p class="text-muted small mb-0" style="font-size: 0.72rem; line-height: 1.4;">
                            Kapasitas pengunjung tersedia 75% (Sangat ideal untuk kunjungan hari ini).
                        </p>
                    </div>
                </div>

                <!-- 3. DESTINASI TERDEKAT (DARI DATABASE) -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="h6 fw-bold text-navy mb-0" style="font-size: 0.95rem;">Destinasi Terdekat</h4>
                        <a href="{{ route('destinasi.index') }}" class="text-success text-decoration-none small fw-bold" style="font-size: 0.75rem;">
                            Lihat Semua
                        </a>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        @forelse($related as $rel)
                            <a href="{{ route('destinasi.show', $rel->slug) }}" class="text-decoration-none">
                                <div class="p-2 rounded-3 bg-light d-flex align-items-center justify-content-between card-hover border border-slate-100">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $rel->image }}" alt="{{ $rel->name }}" class="rounded-2 object-fit-cover" style="width: 44px; height: 44px;">
                                        <div>
                                            <h6 class="fw-bold text-navy mb-0 text-truncate" style="font-size: 0.82rem; max-width: 170px;">{{ $rel->name }}</h6>
                                            <small class="text-muted" style="font-size: 0.68rem;">{{ $rel->location }} • {{ $rel->category_name ?? 'Wisata' }}</small>
                                        </div>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted small"></i>
                                </div>
                            </a>
                        @empty
                            <p class="text-muted small mb-0">Belum ada destinasi terkait lainnya.</p>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

<!-- MODAL SIMULASI E-TIKET RESMI DOKEMAS -->
<div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="ticketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-header bg-navy-main text-white py-3 border-0" style="background-color: #0f172a;">
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset('images/logo-dokemas.png') }}" alt="Logo" style="height: 28px;">
                    <div>
                        <h6 class="modal-title fw-bold text-white lh-1 mb-0" id="ticketModalLabel">E-Tiket Resmi DOKEMAS</h6>
                        <small class="text-white-50" style="font-size: 0.65rem;">Dolan Keliling Banyumas</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 text-center">
                <div class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-1 rounded-pill mb-3">
                    <i class="bi bi-check-circle-fill me-1"></i> E-TIKET SIAP DIGUNAKAN
                </div>

                <h5 class="fw-bold text-navy mb-1">{{ $destination->name }}</h5>
                <p class="text-muted small mb-3">{{ $destination->address_full ?? $destination->location }}</p>

                <!-- QR Code Simulation -->
                <div class="bg-white p-3 rounded-4 shadow-sm border border-slate-200 d-inline-block mb-3">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=DOKEMAS-{{ strtoupper(str_replace('-', '', $destination->slug)) }}-{{ time() }}" alt="QR Code Tiket" class="img-fluid" style="width: 160px; height: 160px;">
                    <small class="d-block text-muted mt-2 fw-bold font-monospace" style="letter-spacing: 1px;">DKM-{{ strtoupper(substr(str_replace('-', '', $destination->slug), 0, 4)) }}-{{ rand(1000, 9999) }}</small>
                </div>

                <div class="bg-light p-3 rounded-3 text-start small border border-slate-100 mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Tanggal Kunjungan:</span>
                        <strong class="text-navy" id="modalDate">-</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Jumlah Pengunjung:</span>
                        <strong class="text-navy" id="modalVisitors">-</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Total Tagihan (Termasuk Asuransi):</span>
                        <strong class="text-success fs-6" id="modalFinalPrice">-</strong>
                    </div>
                </div>

                <p class="text-muted small" style="font-size: 0.75rem;">
                    Tunjukkan QR Code ini kepada petugas loket di pintu masuk {{ $destination->name }} untuk scan instan tanpa antre.
                </p>

                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-green rounded-3 py-2 fw-bold" onclick="alert('E-Tiket PDF berhasil diunduh!');" style="background-color: #2e7d32;">
                        <i class="bi bi-download me-1"></i> Unduh E-Tiket PDF
                    </button>
                    <button type="button" class="btn btn-outline-secondary rounded-3 py-2 small" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const ticketPrice = {{ (int) $destination->price }};
    const insurancePerPerson = {{ $destination->price > 0 ? 1000 : 0 }};

    function changeMainImg(src) {
        document.getElementById('mainGalleryImg').src = src;
    }

    function updateVisitorQty(delta) {
        let qty = parseInt(document.getElementById('visitorQty').value) + delta;
        if (qty < 1) qty = 1;
        if (qty > 30) qty = 30;

        document.getElementById('visitorQty').value = qty;
        document.getElementById('displayQty').innerText = qty;
        document.getElementById('labelPengunjung').innerText = qty + ' Pengunjung';
        document.getElementById('ticketCountLabel').innerText = qty;

        const subtotal = qty * ticketPrice;
        const insurance = qty * insurancePerPerson;
        const total = subtotal + insurance;

        document.getElementById('ticketSubtotal').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
        document.getElementById('insuranceFee').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(insurance);
        document.getElementById('totalPaymentDisplay').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }

    function showTicketModal() {
        const date = document.getElementById('visitDateInput').value;
        const qty = document.getElementById('visitorQty').value;
        const total = document.getElementById('totalPaymentDisplay').innerText;

        document.getElementById('modalDate').innerText = date;
        document.getElementById('modalVisitors').innerText = qty + ' Pengunjung';
        document.getElementById('modalFinalPrice').innerText = total;

        const modal = new bootstrap.Modal(document.getElementById('ticketModal'));
        modal.show();
    }
</script>
@endsection
