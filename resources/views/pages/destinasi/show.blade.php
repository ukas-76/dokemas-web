@extends('layouts.app')

@section('content')
<div class="py-4" style="background-color: #f8fafc; min-height: 90vh;">
    <div class="container">

        <!-- BREADCRUMB -->
        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-secondary text-decoration-none"><i class="bi bi-house-door"></i> Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('destinasi.index') }}" class="text-secondary text-decoration-none">Destinasi Wisata</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('destinasi.index', ['kategori' => $destination->category->slug ?? 'wisata-alam-curug']) }}" class="text-secondary text-decoration-none">{{ $destination->category->name ?? 'Wisata Alam & Air Terjun' }}</a></li>
                    <li class="breadcrumb-item active text-navy fw-bold" aria-current="page">{{ $destination->name }}</li>
                </ol>
            </nav>
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
        <!-- PHOTO GALLERY: ASYMMETRICAL MODERN 5-GRID DENGAN LIGHTBOX POPUP -->
        @php
            $gallery = is_array($destination->gallery) ? $destination->gallery : [];
            $mainImg = $destination->image ?: ($gallery[0] ?? 'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?auto=format&fit=crop&w=1200&q=80');
            $allImages = array_values(array_filter(array_unique(array_merge([$mainImg], $gallery))));
            if (empty($allImages)) {
                $allImages = [$mainImg];
            }
            $thumb1 = $allImages[1] ?? $allImages[0];
            $thumb2 = $allImages[2] ?? ($allImages[1] ?? $allImages[0]);
            $thumb3 = $allImages[3] ?? ($allImages[2] ?? $allImages[0]);
            $thumb4 = $allImages[4] ?? ($allImages[3] ?? $allImages[0]);
        @endphp

        <style>
            .gallery-preview-card {
                cursor: pointer;
                transition: transform 0.25s ease, box-shadow 0.25s ease;
            }
            .gallery-preview-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
            }
            .gallery-preview-card img {
                transition: transform 0.35s ease;
            }
            .gallery-preview-card:hover img {
                transform: scale(1.03);
            }
            .lightbox-arrow-btn {
                background: rgba(15, 23, 42, 0.75) !important;
                border: 2px solid rgba(255, 255, 255, 0.4) !important;
                color: #ffffff !important;
                backdrop-filter: blur(8px);
                transition: all 0.2s ease !important;
            }
            .lightbox-arrow-btn:hover {
                background-color: #1967d2 !important;
                border-color: #1967d2 !important;
                transform: translateY(-50%) scale(1.12) !important;
                box-shadow: 0 0 25px rgba(25, 103, 210, 0.6) !important;
            }
            .lightbox-close-btn {
                background: rgba(255, 255, 255, 0.15) !important;
                border: 2px solid rgba(255, 255, 255, 0.45) !important;
                color: #ffffff !important;
                backdrop-filter: blur(8px);
                transition: all 0.2s ease !important;
            }
            .lightbox-close-btn:hover {
                background-color: #dc3545 !important;
                border-color: #dc3545 !important;
                transform: scale(1.1) rotate(90deg) !important;
                box-shadow: 0 0 20px rgba(220, 53, 69, 0.6) !important;
            }
            /* Hilangkan scrollbar pada strip thumbnail galeri */
            .lightbox-thumb-strip {
                overflow-x: auto !important;
                overflow-y: hidden !important;
                scrollbar-width: none !important;
                -ms-overflow-style: none !important;
            }
            .lightbox-thumb-strip::-webkit-scrollbar {
                display: none !important;
                width: 0 !important;
                height: 0 !important;
            }
        </style>

        <div class="row g-2 g-md-3 mb-4">
            <!-- Left Large Main Photo -->
            <div class="col-lg-7">
                <div class="rounded-4 overflow-hidden position-relative shadow-sm h-100 gallery-preview-card" style="min-height: 420px; background-color: #0b1b2a;" onclick="openLightbox(0)" title="Klik untuk memperbesar foto">
                    <img src="{{ $mainImg }}" alt="{{ $destination->name }}" class="w-100 h-100 object-fit-cover" id="mainGalleryImg">
                    
                    <!-- Dark Gradient Overlay with Text -->
                    <div class="position-absolute bottom-0 start-0 w-100 p-3 p-md-4 text-white d-flex justify-content-between align-items-end" style="background: linear-gradient(180deg, transparent 0%, rgba(11,27,42,0.88) 100%);">
                        <div>
                            <small class="text-uppercase tracking-wider fw-bold text-success d-block mb-1" style="font-size: 0.68rem; letter-spacing: 1px;">
                                {{ $destination->badge_label ?? 'PESONA ALAM BANYUMAS' }}
                            </small>
                            <h4 class="h5 fw-bold mb-0 text-white">{{ $destination->name }}</h4>
                        </div>
                        <span class="badge bg-white bg-opacity-25 backdrop-blur px-3 py-2 rounded-pill small">
                            <i class="bi bi-arrows-fullscreen me-1"></i> Klik untuk Memperbesar
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right 4 Small Photos (2x2 Grid) -->
            <div class="col-lg-5">
                <div class="row g-2 g-md-3 h-100">
                    <!-- Top Left Thumb -->
                    <div class="col-6">
                        <div class="rounded-4 overflow-hidden position-relative shadow-sm gallery-preview-card" style="height: 200px;" onclick="openLightbox(1)" title="Klik untuk melihat foto">
                            <img src="{{ $thumb1 }}" alt="{{ $destination->name }} 1" class="w-100 h-100 object-fit-cover">
                            <span class="badge bg-dark bg-opacity-70 text-white position-absolute top-0 start-0 m-2 px-2 py-1 rounded-pill" style="font-size: 0.65rem;">{{ $destination->subdistrict ?? 'Banyumas' }}</span>
                            <span class="badge bg-dark bg-opacity-75 text-white position-absolute bottom-0 start-0 m-2 px-2 py-1 rounded-3 text-truncate" style="font-size: 0.68rem; max-width: 90%;">Spot Panorama</span>
                        </div>
                    </div>

                    <!-- Top Right Thumb -->
                    <div class="col-6">
                        <div class="rounded-4 overflow-hidden position-relative shadow-sm gallery-preview-card" style="height: 200px;" onclick="openLightbox(2)" title="Klik untuk melihat foto">
                            <img src="{{ $thumb2 }}" alt="{{ $destination->name }} 2" class="w-100 h-100 object-fit-cover">
                            <span class="badge bg-dark bg-opacity-75 text-white position-absolute bottom-0 start-0 m-2 px-2 py-1 rounded-3 text-truncate" style="font-size: 0.68rem; max-width: 90%;">Suasana Alami</span>
                        </div>
                    </div>

                    <!-- Bottom Left Thumb -->
                    <div class="col-6">
                        <div class="rounded-4 overflow-hidden position-relative shadow-sm gallery-preview-card" style="height: 200px;" onclick="openLightbox(3)" title="Klik untuk melihat foto">
                            <img src="{{ $thumb3 }}" alt="{{ $destination->name }} 3" class="w-100 h-100 object-fit-cover">
                            <span class="badge bg-dark bg-opacity-75 text-white position-absolute bottom-0 start-0 m-2 px-2 py-1 rounded-3 text-truncate" style="font-size: 0.68rem; max-width: 90%;">Spot Fotogenik</span>
                        </div>
                    </div>

                    <!-- Bottom Right Thumb -->
                    <div class="col-6">
                        <div class="rounded-4 overflow-hidden position-relative shadow-sm gallery-preview-card" style="height: 200px;" onclick="openLightbox(0)" title="Lihat semua foto destinasi">
                            <img src="{{ $thumb4 }}" alt="{{ $destination->name }} 4" class="w-100 h-100 object-fit-cover">
                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-60 d-flex flex-column align-items-center justify-content-center text-white text-center p-2">
                                <i class="bi bi-grid-3x3-gap fs-4 mb-1"></i>
                                <span class="fw-bold small" style="font-size: 0.82rem;">Lihat Semua Foto ({{ count($allImages) }}) ↗</span>
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
                    @php
                        $mapQuery = !empty($destination->latitude) && !empty($destination->longitude)
                            ? $destination->latitude . ',' . $destination->longitude
                            : urlencode($destination->name . ', ' . ($destination->address_full ?? $destination->location) . ', Banyumas');
                    @endphp

                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3">
                        <div>
                            <h3 class="h5 fw-bold text-navy mb-0" style="font-weight: 800;">
                                Rute & Panduan Akses Lokasi
                            </h3>
                            <p class="text-muted small mb-0 mt-1">Berlokasi di kawasan strategis {{ $destination->location }}, Kabupaten Banyumas.</p>
                        </div>
                        <a href="https://maps.google.com/?q={{ $mapQuery }}" target="_blank" class="btn btn-sm btn-green text-white rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-xs text-nowrap align-self-start align-self-sm-center" title="Buka aplikasi Google Maps untuk navigasi GPS">
                            <i class="bi bi-geo-alt-fill"></i> Buka di Google Maps ↗
                        </a>
                    </div>

                    <!-- Interactive Google Maps Frame (API Maps Embed) -->
                    <div class="rounded-4 overflow-hidden position-relative mb-3 shadow-xs border border-light-subtle bg-light" style="height: 380px;">
                        <iframe 
                            class="w-100 h-100 border-0" 
                            style="border: 0; min-height: 380px;" 
                            loading="lazy" 
                            allowfullscreen 
                            referrerpolicy="no-referrer-when-downgrade" 
                            src="https://maps.google.com/maps?q={{ $mapQuery }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                            title="Peta Lokasi Google Maps {{ $destination->name }}">
                        </iframe>
                    </div>

                    <!-- Detail Alamat & Tombol Petunjuk Arah Langsung -->
                    <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between p-3 rounded-4 bg-light border border-slate-100 mb-3 gap-2">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-geo-alt-fill text-danger fs-5 flex-shrink-0 mt-n1"></i>
                            <div>
                                <strong class="text-navy d-block small">{{ $destination->name }}</strong>
                                <span class="text-secondary" style="font-size: 0.78rem;">{{ $destination->address_full ?? ($destination->location . ', Kabupaten Banyumas, Jawa Tengah') }}</span>
                            </div>
                        </div>
                        <a href="https://maps.google.com/maps/dir/?api=1&destination={{ $mapQuery }}" target="_blank" class="btn btn-sm btn-white bg-white border border-slate-200 text-primary rounded-pill px-3 py-1-5 fw-bold text-nowrap d-inline-flex align-items-center gap-1 shadow-2xs hover-green align-self-start align-self-sm-center">
                            <i class="bi bi-sign-turn-right-fill text-primary"></i> Petunjuk Arah Navigasi
                        </a>
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
                                "Suasana alam Banyumas memang juara! Informasi di website DOKEMAS sangat lengkap dan akurat, mulai dari jam operasional, rute jalan, hingga estimasi harga tiket di loket resmi."
                            </p>
                        </div>
                    </div>
                </div>

                <!-- CARD 5: FAQ & INFORMASI PENTING -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4" id="faq">
                    <h3 class="h5 fw-bold text-navy mb-1" style="font-weight: 800;">
                        FAQ & Pertanyaan Sering Diajukan
                    </h3>
                    <p class="text-muted small mb-4">Informasi penting seputar tiket masuk di loket, jam operasional, dan aturan kunjungan.</p>

                    <div class="d-flex flex-column gap-3">
                        <div class="p-3 rounded-4 bg-light border border-slate-100">
                            <h6 class="fw-bold text-navy mb-2" style="font-size: 0.9rem;">
                                Bagaimana cara membeli tiket masuk {{ $destination->name }}?
                            </h6>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">
                                Tiket masuk dibeli langsung di pintu loket resmi destinasi saat kedatangan (On The Spot / OTS). Pembayaran dapat dilakukan dengan uang tunai maupun scan QRIS resmi pengelola.
                            </p>
                        </div>

                        <div class="p-3 rounded-4 bg-light border border-slate-100">
                            <h6 class="fw-bold text-navy mb-2" style="font-size: 0.9rem;">
                                Apakah perlu melakukan pemesanan / reservasi tiket sebelumnya?
                            </h6>
                            <p class="text-muted small mb-0" style="line-height: 1.6;">
                                Untuk kunjungan wisata harian reguler tidak memerlukan pemesanan di awal. Pengunjung bisa langsung datang sesuai jam operasional. Untuk rombongan besar atau reservasi penginapan/villa, silakan hubungi kontak pengelola via WhatsApp.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: SIDEBAR (INFORMASI KUNJUNGAN, CUACA & DESTINASI SEKITAR) -->
            <div class="col-lg-4">
                
                <!-- 1. INFORMASI TIKET & KUNJUNGAN LOKET RESMI -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4" style="border: 1px solid #e2e8f0 !important;">
                    
                    <!-- Top Alert Badge -->
                    <div class="p-2 rounded-3 bg-light text-secondary small d-flex align-items-center gap-2 mb-3" style="font-size: 0.72rem; border: 1px solid #e2e8f0;">
                        <i class="bi bi-info-circle-fill text-primary fs-6"></i>
                        <span>Informasi Tarif Resmi di Loket Masuk Banyumas</span>
                    </div>

                    <!-- Price Header -->
                    <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                        <div>
                            <small class="text-muted text-uppercase fw-bold d-block" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                                {{ $destination->price_type_title ?? 'HARGA TIKET MASUK' }}
                            </small>
                            <div class="d-flex align-items-baseline gap-1">
                                <span class="display-6 fw-bold text-navy" style="font-weight: 800;">
                                    @if(($destination->price ?? 0) > 0)
                                        Rp {{ number_format($destination->price, 0, ',', '.') }}
                                    @else
                                        Gratis
                                    @endif
                                </span>
                                @if(($destination->price ?? 0) > 0)
                                    <small class="text-muted">{{ $destination->price_label ?? '/ orang' }}</small>
                                @endif
                            </div>
                        </div>
                        <span class="badge rounded-pill fw-semibold px-3 py-2" style="background-color: #e8f0fe; color: #1967d2; font-size: 0.72rem;">
                            <i class="bi bi-ticket-perforated me-1"></i> Beli di Loket (OTS)
                        </span>
                    </div>

                    <!-- Ringkasan Info Operasional & Loket -->
                    <div class="d-flex flex-column gap-2 mb-4">
                        <div class="p-3 bg-light rounded-3 border border-slate-100 small">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted"><i class="bi bi-clock-history me-1 text-primary"></i> Jam Operasional:</span>
                                <strong class="text-navy">{{ $destination->open_hours ?? '08:00 - 17:00 WIB' }}</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted"><i class="bi bi-shop me-1 text-primary"></i> Pembelian Tiket:</span>
                                <strong class="text-navy">Loket Resmi di Lokasi</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted"><i class="bi bi-cash-stack me-1 text-primary"></i> Metode Bayar Lokasi:</span>
                                <span class="fw-semibold text-success">Tunai & QRIS</span>
                            </div>
                        </div>

                        <div class="p-3 rounded-3 border border-slate-100 bg-white" style="font-size: 0.78rem; line-height: 1.5;">
                            <div class="d-flex gap-2 text-secondary">
                                <i class="bi bi-info-circle-fill text-primary fs-6 flex-shrink-0"></i>
                                <span>Tiket masuk dibeli secara langsung di gerbang masuk tempat wisata saat kedatangan (On The Spot). Tidak ada transaksi pembelian tiket via website.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-column gap-2">
                        <a href="https://maps.google.com/?q={{ urlencode($destination->name . ' ' . $destination->location . ' Banyumas') }}" target="_blank" class="btn btn-green w-100 rounded-3 py-3 fw-bold d-flex align-items-center justify-content-center gap-2 shadow-sm text-decoration-none">
                            <i class="bi bi-geo-alt-fill"></i> Petunjuk Arah Google Maps
                        </a>

                        <a href="https://wa.me/6281234567890?text={{ urlencode('Halo pengelola ' . $destination->name . ', saya ingin bertanya mengenai info kunjungan dan jam buka.') }}" target="_blank" class="btn btn-white bg-white border border-slate-200 text-secondary w-100 rounded-3 py-2 fw-semibold small d-flex align-items-center justify-content-center gap-2 hover-green text-decoration-none">
                            <i class="bi bi-whatsapp text-success"></i> Hubungi Pengelola via WhatsApp
                        </a>
                    </div>

                    <!-- Info Catatan Kunjungan -->
                    <div class="mt-4 pt-3 border-top d-flex flex-column gap-2 text-muted" style="font-size: 0.72rem;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-check2 text-success"></i>
                            <span>Informasi lokasi & jam buka diperbarui berkala</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-check2 text-success"></i>
                            <span>Dukung pariwisata lokal Banyumas dengan membeli tiket resmi</span>
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



<!-- ============================================================== -->
<!-- LIGHTBOX MODAL POPUP GALERI FOTO DESTINASI                    -->
<!-- ============================================================== -->
<div class="modal fade" id="modalGalleryLightbox" tabindex="-1" aria-labelledby="modalGalleryLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen p-0 m-0">
        <div class="modal-content border-0 text-white position-relative" style="background-color: rgba(6, 13, 22, 0.98); backdrop-filter: blur(14px);">
            
            <!-- Top Header Bar -->
            <div class="position-absolute top-0 start-0 w-100 px-3 px-md-4 py-3 d-flex justify-content-between align-items-center" style="z-index: 1090; background: linear-gradient(180deg, rgba(0,0,0,0.85) 0%, transparent 100%);">
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-success bg-opacity-25 text-success border border-success-subtle px-3 py-2 rounded-pill fw-semibold small">
                        <i class="bi bi-images me-1"></i> Galeri Foto
                    </span>
                    <div>
                        <h5 class="fw-bold text-white mb-0 text-truncate" style="max-width: 450px;">{{ $destination->name }}</h5>
                        <small class="text-white-50" id="lightboxCounter">Foto 1 dari {{ count($allImages) }}</small>
                    </div>
                </div>
                
                <!-- Close Button (Pojok Kanan Atas) -->
                <button type="button" class="btn lightbox-close-btn rounded-circle d-flex align-items-center justify-content-center p-0" onclick="closeLightbox(event)" aria-label="Tutup Galeri" title="Tutup Galeri (Esc)" style="width: 48px; height: 48px; z-index: 1099; cursor: pointer;">
                    <i class="bi bi-x-lg fs-4 text-white" style="pointer-events: none;"></i>
                </button>
            </div>

            <!-- Center Image Container with Left & Right Navigation Arrows (Row Kiri-Kanan) -->
            <div class="modal-body p-0 d-flex align-items-center justify-content-center position-relative w-100 h-100" style="overflow: hidden;" onclick="if(event.target === this) closeLightbox(event);">
                
                <!-- Left Navigation Arrow (Row Panah Kiri) -->
                <button type="button" class="btn lightbox-arrow-btn rounded-circle shadow-lg d-flex align-items-center justify-content-center position-absolute start-0 top-50 translate-middle-y ms-2 ms-md-4" style="width: 60px; height: 60px; z-index: 1080; cursor: pointer;" onclick="event.stopPropagation(); prevLightboxImage()" title="Foto Sebelumnya (Panah Kiri)">
                    <i class="bi bi-chevron-left fs-2 text-white" style="pointer-events: none;"></i>
                </button>

                <!-- Current Active Image (Large & Responsive) -->
                <div class="d-flex flex-column align-items-center justify-content-center w-100 h-100" style="padding-top: 60px; padding-bottom: 75px; padding-left: 20px; padding-right: 20px;" onclick="if(event.target === this) closeLightbox(event);">
                    <div class="d-flex flex-column align-items-center justify-content-center position-relative w-100 h-100" style="max-width: 1400px; max-height: 82vh;">
                        <img id="lightboxActiveImage" src="{{ $allImages[0] ?? '' }}" alt="{{ $destination->name }}" class="rounded-4" style="width: 100%; height: 100%; max-height: 76vh; object-fit: contain; filter: drop-shadow(0 25px 50px rgba(0,0,0,0.9)); transition: opacity 0.2s ease-in-out;">
                        <div class="mt-3 text-white-50 text-center" id="lightboxCaption" style="font-size: 0.92rem; text-shadow: 0 2px 8px rgba(0,0,0,0.95); font-weight: 500;">
                            {{ $destination->name }} &bull; {{ $destination->address_full ?? ($destination->location ?? 'Kabupaten Banyumas') }}
                        </div>
                    </div>
                </div>

                <!-- Right Navigation Arrow (Row Panah Kanan) -->
                <button type="button" class="btn lightbox-arrow-btn rounded-circle shadow-lg d-flex align-items-center justify-content-center position-absolute end-0 top-50 translate-middle-y me-2 me-md-4" style="width: 60px; height: 60px; z-index: 1080; cursor: pointer;" onclick="event.stopPropagation(); nextLightboxImage()" title="Foto Selanjutnya (Panah Kanan)">
                    <i class="bi bi-chevron-right fs-2 text-white" style="pointer-events: none;"></i>
                </button>

            </div>

            <!-- Bottom Thumbnail Strip -->
            <div class="position-absolute bottom-0 start-0 w-100 p-3 text-center" style="z-index: 1060; background: linear-gradient(0deg, rgba(6,13,22,0.95) 0%, transparent 100%); pointer-events: none;">
                <div class="d-inline-flex align-items-center gap-2 p-1.5 rounded-pill bg-black bg-opacity-70 border border-white border-opacity-20 shadow-lg lightbox-thumb-strip" style="max-width: 90vw; pointer-events: auto; height: 56px;">
                    @foreach($allImages as $idx => $img)
                        <img src="{{ $img }}" alt="Thumbnail {{ $idx + 1 }}" class="rounded-circle object-fit-cover cursor-pointer flex-shrink-0" style="width: 42px; height: 42px; border: 2.5px solid {{ $idx == 0 ? '#22c55e' : 'transparent' }}; opacity: {{ $idx == 0 ? '1' : '0.5' }}; transition: all 0.2s ease; box-sizing: border-box;" onclick="event.stopPropagation(); setLightboxIndex({{ $idx }})" id="lightboxThumb{{ $idx }}">
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Galeri Foto & Lightbox Modal
    const galleryImages = @json($allImages);
    let currentLightboxIndex = 0;
    let lightboxModalInstance = null;

    function openLightbox(index) {
        if (!galleryImages || galleryImages.length === 0) return;
        
        currentLightboxIndex = (index >= 0 && index < galleryImages.length) ? index : 0;
        updateLightboxContent();

        const modalEl = document.getElementById('modalGalleryLightbox');
        if (!modalEl) return;

        if (window.bootstrap && window.bootstrap.Modal) {
            try {
                lightboxModalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                lightboxModalInstance.show();
            } catch(e) {
                modalEl.classList.add('show');
                modalEl.style.display = 'block';
            }
        } else {
            modalEl.classList.add('show');
            modalEl.style.display = 'block';
        }
    }

    function closeLightbox(e) {
        if (e) {
            if (e.preventDefault) e.preventDefault();
            if (e.stopPropagation) e.stopPropagation();
        }

        const modalEl = document.getElementById('modalGalleryLightbox');
        if (!modalEl) return;

        // Tutup via Bootstrap instance jika ada
        if (window.bootstrap && window.bootstrap.Modal) {
            try {
                const inst = bootstrap.Modal.getInstance(modalEl) || bootstrap.Modal.getOrCreateInstance(modalEl);
                if (inst) {
                    inst.hide();
                }
            } catch (err) {
                console.warn('Bootstrap close error:', err);
            }
        }

        // Fallback langsung hapus style dan class show
        modalEl.classList.remove('show');
        modalEl.style.display = 'none';
        modalEl.setAttribute('aria-hidden', 'true');
        modalEl.removeAttribute('aria-modal');

        // Kembalikan overflow scroll pada body
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('overflow');
        document.body.style.removeProperty('padding-right');

        // Hapus backdrop jika tertinggal di DOM
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(b => b.remove());
    }

    function updateLightboxContent() {
        const imgEl = document.getElementById('lightboxActiveImage');
        const counterEl = document.getElementById('lightboxCounter');
        
        if (imgEl && galleryImages[currentLightboxIndex]) {
            imgEl.style.opacity = '0.3';
            setTimeout(() => {
                imgEl.src = galleryImages[currentLightboxIndex];
                imgEl.style.opacity = '1';
            }, 100);
        }

        if (counterEl) {
            counterEl.innerText = `Foto ${currentLightboxIndex + 1} dari ${galleryImages.length}`;
        }

        // Sinkronisasi border thumbnail di bagian bawah modal
        galleryImages.forEach((_, idx) => {
            const thumb = document.getElementById(`lightboxThumb${idx}`);
            if (thumb) {
                if (idx === currentLightboxIndex) {
                    thumb.style.borderColor = '#22c55e';
                    thumb.style.boxShadow = '0 0 12px rgba(34, 197, 94, 0.9)';
                    thumb.style.opacity = '1';
                    thumb.style.transform = 'scale(1.08)';
                } else {
                    thumb.style.borderColor = 'transparent';
                    thumb.style.boxShadow = 'none';
                    thumb.style.opacity = '0.5';
                    thumb.style.transform = 'scale(1)';
                }
            }
        });
    }

    function nextLightboxImage() {
        if (!galleryImages || galleryImages.length <= 1) return;
        currentLightboxIndex = (currentLightboxIndex + 1) % galleryImages.length;
        updateLightboxContent();
    }

    function prevLightboxImage() {
        if (!galleryImages || galleryImages.length <= 1) return;
        currentLightboxIndex = (currentLightboxIndex - 1 + galleryImages.length) % galleryImages.length;
        updateLightboxContent();
    }

    function setLightboxIndex(idx) {
        if (idx >= 0 && idx < galleryImages.length) {
            currentLightboxIndex = idx;
            updateLightboxContent();
        }
    }

    // Navigasi Keyboard (Tombol Panah Kiri, Kanan, & Tombol Escape untuk Menutup)
    document.addEventListener('keydown', function(e) {
        const modalEl = document.getElementById('modalGalleryLightbox');
        if (modalEl && (modalEl.classList.contains('show') || modalEl.style.display === 'block')) {
            if (e.key === 'ArrowRight') {
                nextLightboxImage();
            } else if (e.key === 'ArrowLeft') {
                prevLightboxImage();
            } else if (e.key === 'Escape') {
                closeLightbox(e);
            }
        }
    });

    function changeMainImg(src) {
        document.getElementById('mainGalleryImg').src = src;
    }
</script>
@endsection
