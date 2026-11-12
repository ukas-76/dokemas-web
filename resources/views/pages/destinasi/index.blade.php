@extends('layouts.app')

@section('content')
<div class="py-4" style="background-color: #f6f8fa; min-height: 85vh;">
    <div class="container">

        <!-- HEADER -->
        <div class="mb-4">
            <h1 class="h2 fw-bold text-navy mb-0" style="font-weight: 800; letter-spacing: -0.5px;">
                Eksplorasi Destinasi & Penginapan Banyumas
            </h1>
        </div>

        <!-- SUBHEADER / QUICK STATS & SORTING -->
        <div class="card border-0 shadow-sm rounded-4 p-3 mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #f0f7ff 100%); border: 1px solid #e1effe !important;">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <!-- Info Stat -->
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-primary shadow-sm" style="width: 44px; height: 44px; background-color: #e0f2fe;">
                        <i class="bi bi-search fs-5"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-navy" style="font-size: 1.05rem;">
                            Menampilkan {{ $totalFound ?? $totalRegistered }} Destinasi & Penginapan
                        </div>
                        <small class="text-muted">Kecamatan Baturraden, Purwokerto, Sumbang, Cilongok & Sekitarnya</small>
                    </div>
                </div>

                <!-- Sort & Display Options -->
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <form action="{{ route('destinasi.index') }}" method="GET" id="sortForm" class="d-flex align-items-center gap-2">
                        @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
                        @if(request('wilayah')) <input type="hidden" name="wilayah" value="{{ request('wilayah') }}"> @endif
                        <input type="hidden" name="view" id="sortFormView" value="{{ $viewMode ?? 'grid' }}">
                        <input type="hidden" name="per_page" id="sortFormPerPage" value="{{ $perPage ?? 6 }}">

                        <div class="d-flex align-items-center bg-white px-3 py-2 rounded-3 border border-slate-200 shadow-2xs">
                            <span class="text-uppercase text-muted fw-bold me-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">URUTKAN:</span>
                            <select name="sort" class="form-select form-select-sm border-0 bg-transparent fw-semibold text-navy p-0 pe-4" style="box-shadow: none; cursor: pointer;" onchange="document.getElementById('sortForm').submit();">
                                <option value="rating_desc" {{ request('sort') == 'rating_desc' ? 'selected' : '' }}>Rating Tertinggi (4.8+)</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Paling Populer & Banyak Ulasan</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                            </select>
                        </div>
                    </form>

                    <!-- Dropdown Opsi Tampilan -->
                    <div class="position-relative" style="position: relative;">
                        <button type="button" class="btn btn-white bg-white border border-slate-200 px-3 py-2 rounded-3 text-navy fw-semibold small d-flex align-items-center gap-2 shadow-2xs" id="viewOptionsDropdown" onclick="toggleViewDropdown(event)" style="font-size: 0.82rem; cursor: pointer;">
                            <i class="bi bi-sliders"></i> Opsi Tampilan
                            <i class="bi bi-chevron-down text-muted ms-1" style="font-size: 0.7rem;"></i>
                        </button>
                        <div class="shadow-lg p-3 rounded-4" id="viewOptionsMenu" style="display: none; position: absolute; top: calc(100% + 8px); right: 0; min-width: 270px; z-index: 9999; background: #ffffff; border: 1px solid #e2e8f0;">
                            <span class="text-uppercase text-muted fw-bold d-block mb-2" style="font-size: 0.68rem; letter-spacing: 0.5px;">Tata Letak Kartu</span>
                            <div class="d-flex gap-2 mb-3">
                                <button type="button" class="btn btn-sm flex-fill d-flex align-items-center justify-content-center gap-1 {{ ($viewMode ?? 'grid') === 'grid' ? 'btn-green text-white fw-bold' : 'btn-outline-secondary' }}" id="menuBtnGrid" onclick="setViewMode('grid')">
                                    <i class="bi bi-grid-fill"></i> Grid (3 Kolom)
                                </button>
                                <button type="button" class="btn btn-sm flex-fill d-flex align-items-center justify-content-center gap-1 {{ ($viewMode ?? 'grid') === 'list' ? 'btn-green text-white fw-bold' : 'btn-outline-secondary' }}" id="menuBtnList" onclick="setViewMode('list')">
                                    <i class="bi bi-view-list"></i> List (Baris)
                                </button>
                            </div>

                            <hr class="my-2 opacity-25">

                            <span class="text-uppercase text-muted fw-bold d-block mb-2" style="font-size: 0.68rem; letter-spacing: 0.5px;">Destinasi Per Halaman</span>
                            <div class="d-flex gap-2 mb-3">
                                @foreach([6, 9, 12] as $num)
                                    <a href="{{ route('destinasi.index', array_merge(request()->query(), ['per_page' => $num, 'page' => 1])) }}" class="btn btn-sm flex-fill {{ ($perPage ?? 6) == $num ? 'btn-green text-white fw-bold' : 'btn-light border' }}">
                                        {{ $num }}
                                    </a>
                                @endforeach
                            </div>

                            <hr class="my-2 opacity-25">

                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" id="toggleFilterSidebar" checked onchange="toggleSidebarFilter(this.checked)" style="cursor: pointer;">
                                <label class="form-check-label small fw-semibold text-navy" for="toggleFilterSidebar" style="cursor: pointer;">Panel Filter Samping</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAIN LAYOUT: SIDEBAR FILTER + DESTINATION GRID -->
        <div class="row g-4">
            
            <!-- LEFT COLUMN: SIDEBAR FILTER -->
            <div class="col-lg-3" id="sidebarFilterCol">
                <div class="card border-0 shadow-sm rounded-4 p-3 p-xl-4 bg-white sticky-top-card">
                    <form action="{{ route('destinasi.index') }}" method="GET" id="filterForm">
                        @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
                        @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                        <input type="hidden" name="view" value="{{ $viewMode ?? 'grid' }}">
                        <input type="hidden" name="per_page" value="{{ $perPage ?? 6 }}">
                        <input type="hidden" name="wilayah" id="filterWilayahInput" value="{{ request('wilayah', '') }}">
                        
                        <!-- Filter Header -->
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                            <div class="d-flex align-items-center gap-2 fw-bold text-navy">
                                <i class="bi bi-funnel text-success fs-5"></i>
                                <span>Filter Pencarian</span>
                            </div>
                            <a href="{{ route('destinasi.index') }}" class="text-decoration-none text-success fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                                RESET FILTER
                            </a>
                        </div>

                        <!-- 1. Rentang Harga -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="fw-bold text-navy small mb-0">Rentang Harga</label>
                                <span class="text-muted" style="font-size: 0.72rem;">IDR</span>
                            </div>
                            <!-- Price Range Slider -->
                            <input type="range" class="form-range" min="10000" max="1500000" step="25000" id="priceRange" name="max_price" value="{{ request('max_price', 1500000) }}" oninput="updatePriceLabel(this.value)">
                            
                            <!-- Min & Max Input Boxes -->
                            <div class="row g-2 mt-1">
                                <div class="col-6">
                                    <div class="bg-light p-2 rounded-3 border border-slate-100">
                                        <small class="text-muted d-block" style="font-size: 0.65rem;">Min (Rp)</small>
                                        <span class="fw-bold small text-navy">10.000</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light p-2 rounded-3 border border-slate-100">
                                        <small class="text-muted d-block" style="font-size: 0.65rem;">Maks (Rp)</small>
                                        <span class="fw-bold small text-navy" id="maxPriceDisplay">{{ number_format(request('max_price', 1500000), 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="text-muted opacity-25 my-3">

                        <!-- 2. Kategori Destinasi -->
                        <div class="mb-4">
                            <label class="fw-bold text-navy small mb-2 d-block">Kategori Destinasi</label>
                            
                            @php
                                $activeCats = (array) request('kategori', []);
                                $activeCats = array_filter($activeCats, function($v) { return !empty($v); });
                            @endphp

                            <div class="d-flex flex-column gap-2">
                                @foreach($categories as $cat)
                                    @php
                                        $catSlug = $cat['slug'] ?? $cat->slug;
                                        $catName = $cat['name'] ?? $cat->name;
                                        $catCount = $cat['destinations_count'] ?? ($cat->destinations_count ?? 0);
                                    @endphp
                                    <label class="form-check d-flex justify-content-between align-items-center mb-0 cursor-pointer" style="cursor: pointer;">
                                        <div class="d-flex align-items-center gap-2">
                                            <input class="form-check-input mt-0 category-filter-checkbox" type="checkbox" name="kategori[]" value="{{ $catSlug }}" {{ in_array($catSlug, $activeCats) ? 'checked' : '' }}>
                                            <span class="small {{ in_array($catSlug, $activeCats) ? 'fw-bold text-success' : 'text-secondary' }}">{{ $catName }}</span>
                                        </div>
                                        <span class="badge bg-light text-muted small" style="font-size: 0.72rem;">{{ $catCount }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <hr class="text-muted opacity-25 my-3">

                        <!-- 3. Rating Pengunjung -->
                        <div class="mb-4">
                            <label class="fw-bold text-navy small mb-2 d-block">Rating Pengunjung</label>
                            
                            @php
                                $selectedRatings = (array) request('rating', []);
                            @endphp

                            <div class="d-flex flex-column gap-2">
                                <label class="form-check d-flex align-items-center gap-2 mb-0" style="cursor: pointer;">
                                    <input class="form-check-input mt-0" type="checkbox" name="rating[]" value="5" {{ in_array('5', $selectedRatings) ? 'checked' : '' }}>
                                    <span class="small {{ in_array('5', $selectedRatings) ? 'fw-bold text-success' : 'text-secondary' }} d-flex align-items-center gap-1">
                                        <i class="bi bi-star-fill text-warning" style="font-size: 0.8rem;"></i>
                                        <strong>5.0</strong> Sempurna
                                    </span>
                                </label>
                                <label class="form-check d-flex align-items-center gap-2 mb-0" style="cursor: pointer;">
                                    <input class="form-check-input mt-0" type="checkbox" name="rating[]" value="4" {{ in_array('4', $selectedRatings) ? 'checked' : '' }}>
                                    <span class="small {{ in_array('4', $selectedRatings) ? 'fw-bold text-success' : 'text-secondary' }} d-flex align-items-center gap-1">
                                        <i class="bi bi-star-fill text-warning" style="font-size: 0.8rem;"></i>
                                        <strong>4.0+</strong> Sangat Baik
                                    </span>
                                </label>
                                <label class="form-check d-flex align-items-center gap-2 mb-0" style="cursor: pointer;">
                                    <input class="form-check-input mt-0" type="checkbox" name="rating[]" value="3" {{ in_array('3', $selectedRatings) ? 'checked' : '' }}>
                                    <span class="small {{ in_array('3', $selectedRatings) ? 'fw-bold text-success' : 'text-secondary' }} d-flex align-items-center gap-1">
                                        <i class="bi bi-star-fill text-warning" style="font-size: 0.8rem;"></i>
                                        <strong>3.0+</strong> Cukup Baik
                                    </span>
                                </label>
                            </div>
                        </div>

                        <hr class="text-muted opacity-25 my-3">

                        <!-- 4. Fasilitas Pendukung -->
                        <div class="mb-4">
                            <label class="fw-bold text-navy small mb-2 d-block">Fasilitas Pendukung</label>
                            
                            @php
                                $selectedFacilities = (array) request('fasilitas', []);
                                $facilityList = [
                                    ['val' => 'parkir', 'name' => 'Parkir Luas (Bus & Mobil)'],
                                    ['val' => 'toilet', 'name' => 'Toilet Bersih'],
                                    ['val' => 'musholla', 'name' => 'Musholla Bersih'],
                                    ['val' => 'wifi', 'name' => 'WIFI Publik Cepat'],
                                    ['val' => 'anak', 'name' => 'Area Bermain Anak'],
                                    ['val' => 'warung', 'name' => 'Warung Makan / Kuliner'],
                                    ['val' => 'penginapan', 'name' => 'Penginapan / Villa'],
                                    ['val' => 'spot_foto', 'name' => 'Spot Foto Estetik'],
                                ];
                            @endphp

                            <div class="d-flex flex-column gap-2">
                                @foreach($facilityList as $fac)
                                    <label class="form-check d-flex align-items-center gap-2 mb-0" style="cursor: pointer;">
                                        <input class="form-check-input mt-0" type="checkbox" name="fasilitas[]" value="{{ $fac['val'] }}" {{ in_array($fac['val'], $selectedFacilities) ? 'checked' : '' }}>
                                        <span class="small {{ in_array($fac['val'], $selectedFacilities) ? 'fw-bold text-success' : 'text-secondary' }}">{{ $fac['name'] }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <hr class="text-muted opacity-25 my-3">

                        <!-- 5. Wilayah / Kawasan -->
                        <div class="mb-4">
                            <label class="fw-bold text-navy small mb-2 d-block">Wilayah / Kawasan</label>
                            
                            @php
                                $areas = ['Baturraden', 'Purwokerto', 'Cilongok', 'Banyumas'];
                                $curArea = request('wilayah', '');
                            @endphp

                            <div class="d-flex flex-wrap gap-2">
                                @foreach($areas as $area)
                                    <button type="button" 
                                            class="area-pill {{ $curArea == $area ? 'active' : '' }}" 
                                            onclick="toggleAreaFilter('{{ $area }}', this)">
                                        {{ $area }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Tombol Terapkan Filter -->
                        <button type="submit" class="btn btn-green w-100 rounded-3 py-2 fw-bold d-flex align-items-center justify-content-center gap-2 shadow-sm">
                            <i class="bi bi-funnel-fill"></i> Terapkan Filter
                        </button>
                    </form>
                </div>
            </div>

            <!-- RIGHT COLUMN: DESTINATION CARDS GRID -->
            <div class="col-lg-9" id="destinationListColumn">
                <div class="row g-4 {{ ($viewMode ?? 'grid') === 'list' ? 'view-mode-list' : '' }}" id="destinationCardsRow">
                    @forelse($destinations as $dest)
                        <div class="col-md-6 col-xl-4 destination-card-col" data-category="{{ $dest['category_slug'] ?? ($dest['category']['slug'] ?? '') }}" data-price="{{ $dest['price'] }}">
                            <div class="destination-card">
                                <!-- Card Image & Badges -->
                                <div class="card-img-wrapper">
                                    <img src="{{ $dest['image'] }}" alt="{{ $dest['name'] }}" loading="lazy">
                                    
                                    <!-- Category Badge Top-Left -->
                                    <div class="card-img-badge">
                                        {{ $dest['badge_label'] ?? ($dest['category']['name'] ?? 'Destinasi') }}
                                    </div>

                                    <!-- Rating Badge Bottom-Left -->
                                    <div class="card-rating-badge">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <span>{{ number_format($dest['rating'], 1) }}</span>
                                        <span class="opacity-75" style="font-size: 0.68rem;">({{ $dest['reviews_count'] }} ulasan)</span>
                                    </div>
                                </div>

                                <!-- Card Content -->
                                <div class="card-content">
                                    <div class="card-info-main">
                                        <!-- Location -->
                                        <div class="d-flex align-items-center gap-1 text-muted mb-1" style="font-size: 0.78rem;">
                                            <i class="bi bi-geo-alt text-success"></i>
                                            <span>{{ $dest['location'] }}</span>
                                        </div>

                                        <!-- Title -->
                                        <h2 class="h6 fw-bold text-navy mb-2" style="font-size: 1.05rem;">
                                            <a href="{{ route('destinasi.show', $dest['slug']) }}" class="text-navy text-decoration-none hover-green">
                                                {{ $dest['name'] }}
                                            </a>
                                        </h2>

                                        <!-- Facilities Tags -->
                                        <div class="d-flex flex-wrap gap-1 mb-3">
                                            @if(isset($dest['facilities']) && is_array($dest['facilities']))
                                                @foreach(array_slice($dest['facilities'], 0, 3) as $fac)
                                                    <span class="tag-pill">{{ $fac }}</span>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Bottom Row: Price & Action Button -->
                                    <div class="card-action-side pt-3 border-top d-flex justify-content-between align-items-center mt-auto">
                                        <div>
                                            <small class="text-muted text-uppercase d-block fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                                                {{ $dest['price_type_title'] ?? 'TIKET MASUK' }}
                                            </small>
                                            <div class="lh-1">
                                                <span class="fw-bold text-navy" style="font-size: 1.15rem;">
                                                    Rp {{ number_format($dest['price'], 0, ',', '.') }}
                                                </span>
                                                <small class="text-muted" style="font-size: 0.72rem;">{{ $dest['price_label'] ?? '/ orang' }}</small>
                                            </div>
                                        </div>

                                        <div>
                                            <a href="{{ route('destinasi.show', $dest['slug']) }}" class="{{ $dest['button_class'] ?? 'btn-slate-soft' }}">
                                                {{ $dest['button_label'] ?? 'Lihat Detail >' }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <div class="bg-white p-5 rounded-4 shadow-sm border border-slate-200">
                                <i class="bi bi-search text-muted fs-1 mb-3 d-block"></i>
                                <h5 class="fw-bold text-navy">Tidak Ada Destinasi yang Sesuai</h5>
                                <p class="text-muted small">Coba sesuaikan kata kunci pencarian atau bersihkan filter yang dipilih.</p>
                                <a href="{{ route('destinasi.index') }}" class="btn btn-green rounded-pill px-4 py-2 mt-2">
                                    Reset Semua Filter
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- PAGINATION BAR -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-5 pt-3 gap-3">
                    <small class="text-muted fw-semibold">
                        @if($destinations->total() > 0)
                            Menampilkan {{ $destinations->firstItem() }} - {{ $destinations->lastItem() }} dari {{ $destinations->total() }} Destinasi Terdaftar
                        @else
                            Menampilkan 0 Destinasi Terdaftar
                        @endif
                    </small>

                    @if($totalPages > 1)
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0 gap-1">
                                {{-- Tombol Sebelumnya (<) --}}
                                <li class="page-item {{ $destinations->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link rounded-3 border-0 bg-white shadow-2xs text-secondary px-3 py-2" 
                                       href="{{ $destinations->previousPageUrl() ?? '#' }}" 
                                       aria-label="Sebelumnya">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>

                                {{-- Loop Nomor Halaman Real Sesuai Data di Database --}}
                                @php
                                    $start = max(1, $currentPage - 2);
                                    $end = min($totalPages, $currentPage + 2);
                                @endphp

                                @if($start > 1)
                                    <li class="page-item">
                                        <a class="page-link rounded-3 border-0 bg-white shadow-2xs text-secondary px-3 py-2" href="{{ $destinations->url(1) }}">1</a>
                                    </li>
                                    @if($start > 2)
                                        <li class="page-item disabled">
                                            <span class="page-link rounded-3 border-0 bg-transparent text-secondary px-2 py-2">...</span>
                                        </li>
                                    @endif
                                @endif

                                @for ($page = $start; $page <= $end; $page++)
                                    <li class="page-item {{ $page == $currentPage ? 'active' : '' }}">
                                        <a class="page-link rounded-3 border-0 px-3 py-2 fw-bold {{ $page == $currentPage ? 'text-white' : 'bg-white shadow-2xs text-secondary' }}" 
                                           style="{{ $page == $currentPage ? 'background-color: #1967d2;' : '' }}" 
                                           href="{{ $destinations->url($page) }}">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endfor

                                @if($end < $totalPages)
                                    @if($end < $totalPages - 1)
                                        <li class="page-item disabled">
                                            <span class="page-link rounded-3 border-0 bg-transparent text-secondary px-2 py-2">...</span>
                                        </li>
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link rounded-3 border-0 bg-white shadow-2xs text-secondary px-3 py-2" href="{{ $destinations->url($totalPages) }}">{{ $totalPages }}</a>
                                    </li>
                                @endif

                                {{-- Tombol Selanjutnya (>) --}}
                                <li class="page-item {{ !$destinations->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link rounded-3 border-0 bg-white shadow-2xs text-secondary px-3 py-2" 
                                       href="{{ $destinations->nextPageUrl() ?? '#' }}" 
                                       aria-label="Selanjutnya">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>

        </div>

    </div>
</div>

<script>
    function updatePriceLabel(val) {
        document.getElementById('maxPriceDisplay').innerText = new Intl.NumberFormat('id-ID').format(val);
    }

    function toggleAreaFilter(areaName, btn) {
        const input = document.getElementById('filterWilayahInput');
        if (!input) return;

        if (input.value === areaName) {
            input.value = '';
            btn.classList.remove('active');
        } else {
            input.value = areaName;
            document.querySelectorAll('.area-pill').forEach(el => el.classList.remove('active'));
            btn.classList.add('active');
        }
    }

    // Dropdown Opsi Tampilan Toggle (Klik Buka/Tutup Langsung)
    function toggleViewDropdown(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        const menu = document.getElementById('viewOptionsMenu');
        const btn = document.getElementById('viewOptionsDropdown');
        if (!menu) return;

        const isVisible = menu.style.display === 'block';
        if (isVisible) {
            menu.style.display = 'none';
            if (btn) btn.classList.remove('border-success');
        } else {
            menu.style.display = 'block';
            if (btn) btn.classList.add('border-success');
        }
    }

    // Tutup dropdown otomatis saat klik di luar area menu
    document.addEventListener('click', function(e) {
        const menu = document.getElementById('viewOptionsMenu');
        const btn = document.getElementById('viewOptionsDropdown');
        if (menu && menu.style.display === 'block') {
            if (!menu.contains(e.target) && (!btn || !btn.contains(e.target))) {
                menu.style.display = 'none';
                if (btn) btn.classList.remove('border-success');
            }
        }
    });

    // Auto-restore pilihan tampilan pengguna
    document.addEventListener('DOMContentLoaded', function() {
        const savedView = localStorage.getItem('dokemas_destinasi_view');
        const urlParams = new URLSearchParams(window.location.search);
        const viewInUrl = urlParams.get('view');
        const activeView = viewInUrl || savedView || '{{ $viewMode ?? 'grid' }}';
        if (activeView === 'list') {
            setViewMode('list');
        }
    });

    // Fungsi Pengatur Opsi Tampilan (Grid / List)
    function setViewMode(mode) {
        const row = document.getElementById('destinationCardsRow');
        const menuBtnGrid = document.getElementById('menuBtnGrid');
        const menuBtnList = document.getElementById('menuBtnList');

        if (mode === 'list') {
            row.classList.add('view-mode-list');
            if (menuBtnGrid) { menuBtnGrid.className = 'btn btn-sm flex-fill d-flex align-items-center justify-content-center gap-1 btn-outline-secondary'; }
            if (menuBtnList) { menuBtnList.className = 'btn btn-sm flex-fill d-flex align-items-center justify-content-center gap-1 btn-green text-white fw-bold'; }
        } else {
            row.classList.remove('view-mode-list');
            if (menuBtnGrid) { menuBtnGrid.className = 'btn btn-sm flex-fill d-flex align-items-center justify-content-center gap-1 btn-green text-white fw-bold'; }
            if (menuBtnList) { menuBtnList.className = 'btn btn-sm flex-fill d-flex align-items-center justify-content-center gap-1 btn-outline-secondary'; }
        }

        const sortFormView = document.getElementById('sortFormView');
        if (sortFormView) sortFormView.value = mode;

        localStorage.setItem('dokemas_destinasi_view', mode);
        const url = new URL(window.location);
        url.searchParams.set('view', mode);
        window.history.replaceState({}, '', url);
    }

    // Fungsi Toggle Panel Filter Samping
    function toggleSidebarFilter(show) {
        const sidebar = document.getElementById('sidebarFilterCol');
        const mainCol = document.getElementById('destinationListColumn');
        if (!sidebar || !mainCol) return;

        if (show) {
            sidebar.classList.remove('d-none');
            mainCol.className = 'col-lg-9';
        } else {
            sidebar.classList.add('d-none');
            mainCol.className = 'col-lg-12';
        }
    }
</script>
@endsection
