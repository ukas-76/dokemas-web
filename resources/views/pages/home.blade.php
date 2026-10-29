@extends('layouts.app')

@section('content')

<!-- HERO & SEARCH BAR -->
<section class="hero-section text-white pt-5 pb-5 hero-pattern">
    <div class="container pt-4 pb-5 text-center position-relative z-1">
        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white bg-opacity-10 border border-white border-opacity-10 text-white-50 small mb-4">
            <i class="bi bi-compass text-success"></i> GERBANG RESMI WISATA LERENG SLAMET
        </div>

        <h1 class="display-4 fw-bold mb-3 text-white col-lg-10 mx-auto lh-sm" style="font-weight: 800;">
            Eksplorasi Wisata & Penginapan<br>Terbaik di Banyumas
        </h1>

        <p class="lead text-white-50 mb-4 col-lg-8 mx-auto fs-6">
            Temukan air terjun tersembunyi, resort lereng Gunung Slamet, homestay ramah keluarga, dan kuliner otentik dalam satu platform terpercaya.
        </p>

        <div class="d-flex flex-wrap justify-content-center align-items-center gap-4 text-white-50 small mb-5">
            <div><i class="bi bi-check-circle-fill text-success me-1"></i> 150+ Mitra Terverifikasi</div>
            <span class="opacity-25 d-none d-md-inline">•</span>
            <div><i class="bi bi-qr-code text-success me-1"></i> Tiket QR Code Instan</div>
            <span class="opacity-25 d-none d-md-inline">•</span>
            <div><i class="bi bi-shield-check text-success me-1"></i> Rekomendasi Resmi Banyumas</div>
        </div>

        <!-- Search Bar Floating Card -->
        <!-- Search Box Floating Card (Sederhana & Fungsional) -->
<div class="card border-0 shadow-lg p-3 p-md-4 mx-auto text-start rounded-4 text-dark" style="max-width: 850px; margin-bottom: -80px; background-color: #ffffff;">
    <form action="#" method="GET" class="row g-2 align-items-center">
        <!-- Input Kata Kunci / Lokasi -->
        <div class="col-md-5">
            <label class="form-label text-uppercase text-muted fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                <i class="bi bi-geo-alt text-secondary"></i> Cari Lokasi / Tempat
            </label>
            <input type="text" name="q" class="form-control form-control-lg border-0 bg-light fs-6 fw-semibold text-navy" placeholder="Misal: Baturraden, Curug...">
        </div>

        <!-- Select Kategori -->
        <div class="col-md-4">
            <label class="form-label text-uppercase text-muted fw-bold mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                <i class="bi bi-bounding-box text-secondary"></i> Kategori
            </label>
            <select name="kategori" class="form-select form-select-lg border-0 bg-light fs-6 fw-semibold text-navy">
                <option value="">Semua Kategori</option>
                <option value="wisata">Wisata Alam</option>
                <option value="hotel">Hotel & Resort</option>
                <option value="homestay">Homestay</option>
                <option value="kuliner">Kuliner</option>
            </select>
        </div>

        <!-- Tombol Submit Cari -->
        <div class="col-md-3 pt-md-3">
            <button type="submit" class="btn btn-green w-100 rounded-3 py-2 fw-bold d-flex align-items-center justify-content-center gap-2" style="background-color: #3a821d;">
                <i class="bi bi-search"></i> Cari
            </button>
        </div>
    </form>

    <!-- Tag Populer -->
    <div class="pt-3 mt-3 border-top d-flex align-items-center gap-2 flex-wrap" style="font-size: 0.75rem;">
        <span class="text-muted font-monospace">POPULER:</span>
        <a href="?q=Curug+Cipendok" class="badge bg-light text-dark fw-normal text-decoration-none px-2 py-1">Curug Cipendok</a>
        <a href="?q=Baturraden" class="badge bg-light text-dark fw-normal text-decoration-none px-2 py-1">Baturraden</a>
        <a href="?q=Mendoan" class="badge bg-light text-dark fw-normal text-decoration-none px-2 py-1">Mendoan Sokaraja</a>
    </div>
</div>
    </div>
</section>

<div style="height: 100px;"></div>

<!-- KATEGORI & DESTINASI UNGGULAN -->
<section class="py-5">
    <div class="container">
        
        <!-- Header Kategori -->
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="text-uppercase text-success fw-bold small" style="letter-spacing: 1px;">• RAGAM REKREASI</span>
                <h3 class="fw-bold text-navy mt-1 mb-1">Kategori Pilihan Wisatawan</h3>
                <p class="text-muted small mb-0">Jelajahi Banyumas sesuai preferensi gaya liburan dan petualangan Anda.</p>
            </div>
            <span class="text-muted small fw-bold">{{ count($categories) }} KATEGORI INTI</span>
        </div>

        <!-- LOOPING CARD KATEGORI -->
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3 mb-5">
            @foreach($categories as $category)
            <div class="col">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-2 card-hover bg-white">
                    <div class="rounded-3 overflow-hidden mb-2" style="height: 110px;">
                        <img src="{{ $category['image'] }}" class="w-100 h-100 object-fit-cover" alt="{{ $category['name'] }}">
                    </div>
                    <div class="px-1">
                        <h6 class="fw-bold text-navy mb-0">{{ $category['name'] }}</h6>
                        <small class="text-muted" style="font-size: 0.75rem;">{{ $category['count'] }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Header Destinasi -->
        <div class="pt-4 mb-4">
            <span class="badge badge-green-soft px-3 py-2 rounded-pill small mb-2">• PILIHAN TERPOPULER MINGGU INI</span>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2">
                <div>
                    <h3 class="fw-bold text-navy mb-1">Destinasi & Penginapan Unggulan</h3>
                    <p class="text-muted small mb-0">Rekomendasi terbaik dengan ulasan tertinggi dan fasilitas terverifikasi tim DOKEMAS.</p>
                </div>
                <a href="#" class="text-success text-decoration-none fw-bold small">Lihat Semua Katalog (120+) <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>

        <!-- LOOPING CARD DESTINASI -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach($destinations as $item)
            <div class="col">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden card-hover bg-white">
                    <div class="position-relative" style="height: 180px;">
                        <img src="{{ $item['image'] }}" class="w-100 h-100 object-fit-cover" alt="{{ $item['title'] }}">
                        <span class="badge bg-navy-main text-white position-absolute top-0 start-0 m-3 px-2 py-1 rounded-pill small" style="font-size: 0.65rem;">{{ $item['category'] }}</span>
                        <button class="btn btn-light rounded-circle position-absolute top-0 end-0 m-3 p-1 d-flex align-items-center justify-content-center shadow-sm" style="width: 28px; height: 28px;">
                            <i class="bi bi-heart text-secondary" style="font-size: 0.8rem;"></i>
                        </button>
                    </div>
                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center gap-1 mb-1" style="font-size: 0.75rem;">
                                <i class="bi bi-star-fill text-warning"></i>
                                <span class="fw-bold">{{ $item['rating'] }}</span>
                                <span class="text-muted">({{ $item['reviews_count'] }} ulasan)</span>
                            </div>
                            <h6 class="fw-bold text-navy mb-1">{{ $item['title'] }}</h6>
                            <p class="text-muted mb-2" style="font-size: 0.7rem;"><i class="bi bi-geo-alt"></i> {{ $item['location'] }}</p>
                            
                            <div class="d-flex flex-wrap gap-1 mb-3">
                                @foreach($item['tags'] as $tag)
                                <span class="badge bg-light text-secondary fw-normal" style="font-size: 0.65rem;">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-end pt-2 border-top">
                            <div>
                                <small class="text-muted d-block" style="font-size: 0.6rem;">{{ $item['price_label'] }}</small>
                                <span class="fw-bold text-success" style="font-size: 0.9rem;">{{ $item['price'] }} <small class="text-muted fw-normal">{{ $item['price_unit'] }}</small></span>
                            </div>
                            <a href="#" class="btn btn-light rounded-circle p-1 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="bi bi-arrow-up-right text-dark"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

<!-- APP PROMO BANNER -->
<section class="py-5">
    <div class="container">
        <div class="card border-0 rounded-5 p-4 p-lg-5 text-white overflow-hidden position-relative hero-pattern" style="background: linear-gradient(135deg, #0d233a 0%, #06121e 100%);">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0 z-1">
                    <span class="badge bg-white bg-opacity-10 text-white border border-white border-opacity-10 rounded-pill px-3 py-2 small mb-3">
                        <i class="bi bi-phone text-success me-1"></i> KEMUDAHAN DALAM GENGGAMAN
                    </span>

                    <h2 class="display-6 fw-bold text-white mb-3 lh-sm">
                        Dolan Lebih Praktis dengan Aplikasi DOKEMAS
                    </h2>

                    <p class="text-white-50 mb-4 small" style="line-height: 1.7;">
                        Pesan tiket wisata tanpa antre, nikmati check-in instan dengan e-tiket QR Code, dan dapatkan notifikasi cuaca lereng Gunung Slamet secara langsung.
                    </p>

                    <div class="d-flex flex-wrap gap-2 mb-4 small">
                        <span class="bg-white bg-opacity-10 text-white px-3 py-2 rounded-3"><i class="bi bi-qr-code-scan text-success me-1"></i> Scan QR di Loket</span>
                        <span class="bg-white bg-opacity-10 text-white px-3 py-2 rounded-3"><i class="bi bi-map text-success me-1"></i> Peta Offline Curug</span>
                        <span class="bg-white bg-opacity-10 text-white px-3 py-2 rounded-3"><i class="bi bi-tag text-success me-1"></i> Promo Weekend</span>
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <a href="#" class="btn btn-white bg-white text-dark rounded-3 px-3 py-2 d-flex align-items-center gap-2 shadow-sm text-decoration-none">
                            <i class="bi bi-apple fs-4"></i>
                            <div class="text-start lh-1">
                                <small class="d-block text-muted" style="font-size: 0.55rem;">DOWNLOAD ON THE</small>
                                <span class="fw-bold small">App Store</span>
                            </div>
                        </a>

                        <a href="#" class="btn btn-white bg-white text-dark rounded-3 px-3 py-2 d-flex align-items-center gap-2 shadow-sm text-decoration-none">
                            <i class="bi bi-google-play fs-4 text-primary"></i>
                            <div class="text-start lh-1">
                                <small class="d-block text-muted" style="font-size: 0.55rem;">GET IT ON</small>
                                <span class="fw-bold small">Google Play</span>
                            </div>
                        </a>

                        <div class="bg-white bg-opacity-10 p-2 rounded-3 d-flex align-items-center gap-2 border border-white border-opacity-10">
                            <i class="bi bi-qr-code fs-3 text-white"></i>
                            <div class="text-start lh-1">
                                <small class="d-block text-success fw-bold" style="font-size: 0.6rem;">SCAN CEPAT</small>
                                <span class="fw-bold text-white small">Install Sekarang</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 ms-auto text-center z-1">
                    <div class="bg-white p-2 rounded-5 shadow-lg mx-auto" style="max-width: 300px; border: 8px solid #1a2f43;">
                        <div class="bg-light rounded-4 p-3 text-start text-dark small" style="font-size: 0.75rem;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold text-success d-flex align-items-center gap-1">
                                    <i class="bi bi-geo-alt-fill"></i> DOKEMAS
                                </span>
                                <div class="d-flex gap-1">
                                    <i class="bi bi-bell"></i>
                                    <span class="badge bg-success rounded-circle p-1">A</span>
                                </div>
                            </div>

                            <div class="bg-dark text-white p-2 rounded-3 mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="badge bg-secondary" style="font-size: 0.5rem;">TIKET MASUK AKTIF</span>
                                    <span class="badge bg-success" style="font-size: 0.5rem;">TERVERIFIKASI</span>
                                </div>
                                <div class="fw-bold" style="font-size: 0.7rem;">Curug Jaten Baturraden</div>
                                <small class="text-white-50 d-block" style="font-size: 0.55rem;">1 Tiket Dewasa • Hari Ini</small>
                                <div class="d-flex justify-content-between align-items-center mt-2 bg-white bg-opacity-10 p-1 rounded">
                                    <code class="text-white" style="font-size: 0.6rem;">#DKM-88219</code>
                                    <span class="badge bg-success" style="font-size: 0.5rem;">Siap Scan</span>
                                </div>
                            </div>

                            <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.65rem;">Rekomendasi Sekitar Anda</small>
                            <div class="card border-0 bg-white p-1 rounded-2 shadow-sm d-flex flex-row align-items-center gap-2 mb-2">
                                <div class="bg-secondary rounded" style="width: 35px; height: 35px;"></div>
                                <div>
                                    <div class="fw-bold" style="font-size: 0.65rem;">Taman Langit Baturraden</div>
                                    <small class="text-muted" style="font-size: 0.55rem;"><i class="bi bi-geo"></i> 1.2 km dari lokasi Anda</small>
                                </div>
                            </div>

                            <div class="bg-success bg-opacity-10 p-2 rounded-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="d-block text-muted" style="font-size: 0.55rem;">Cuaca Lereng Slamet</small>
                                    <span class="fw-bold text-success" style="font-size: 0.65rem;">Cerah Berawan • 22°C</span>
                                </div>
                                <span class="badge bg-success" style="font-size: 0.55rem;">Kondisi Ideal</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection