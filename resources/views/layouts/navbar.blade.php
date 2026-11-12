<nav class="navbar navbar-expand-lg bg-white sticky-top py-3 shadow-sm">
    <div class="container">
        <!-- Brand Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <!-- Menggunakan Logo Kustom -->
            <img src="{{ asset('images/logo-dokemas.png') }}" alt="Logo DOKEMAS" style="height: 40px; width: auto;" class="object-fit-contain">
            <div>
                <span class="fw-bold d-block text-navy lh-1" style="font-size: 1.1rem; letter-spacing: 0.5px;">DOKEMAS</span>
                <small class="text-muted fw-semibold" style="font-size: 0.65rem; letter-spacing: 1px;">DOLAN KELILING BANYUMAS</small>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Nav Links & Buttons -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-semibold">
                <li class="nav-item">
                    <a class="nav-link px-3 rounded-pill {{ request()->routeIs('home') ? 'text-primary bg-primary bg-opacity-10 fw-bold' : 'text-secondary' }}" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 rounded-pill {{ request()->routeIs('destinasi.*') ? 'text-primary bg-primary bg-opacity-10 fw-bold' : 'text-secondary' }}" href="{{ route('destinasi.index') }}">Wisata & Penginapan</a>
                </li>
                <li class="nav-item">
                    @auth
                        <a class="nav-link px-3 rounded-pill {{ request()->routeIs('mitra.register') ? 'text-primary bg-primary bg-opacity-10 fw-bold border border-primary border-opacity-25' : 'text-secondary' }}" href="{{ route('mitra.register') }}">Gabung Mitra</a>
                    @else
                        <a class="nav-link px-3 rounded-pill text-secondary cursor-pointer" href="javascript:void(0)" onclick="promptMitraLogin()">Gabung Mitra</a>
                    @endauth
                </li>
            </ul>

            <!-- Right Action Buttons -->
            <div class="d-flex align-items-center gap-3">
                @auth
                    <!-- Logo Profile & Menu Akun Interaktif -->
                    <div class="dropdown position-relative">
                        <button class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center p-0 shadow-sm border border-2 border-white" type="button" id="userProfileDropdownToggle" data-bs-toggle="dropdown" aria-expanded="false" style="width: 40px; height: 40px; cursor: pointer; background-color: #1967d2 !important; border-color: #1967d2 !important;" title="{{ Auth::user()->name }}">
                            <span class="fw-bold fs-6 text-white">{{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-2 p-2" id="userProfileDropdownMenu" aria-labelledby="userProfileDropdownToggle" style="min-width: 270px; z-index: 1060;">
                            <!-- Header Info -->
                            <li class="px-3 py-2 border-bottom mb-2 bg-light rounded-3">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold" style="width: 34px; height: 34px; font-size: 0.85rem; background-color: #1967d2;">
                                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="overflow-hidden">
                                        <span class="d-block fw-bold text-navy small text-truncate" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</span>
                                        <small class="text-muted d-block text-truncate" style="font-size: 0.72rem;">{{ Auth::user()->email }}</small>
                                    </div>
                                </div>
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-2 py-0-5" style="font-size: 0.65rem;">
                                    <i class="bi bi-shield-check me-1"></i>Akun Terverifikasi
                                </span>
                            </li>

                            <!-- Menu Items Interaktif -->
                            <li>
                                <button type="button" class="dropdown-item small py-2 px-3 rounded-3 d-flex align-items-center gap-3 w-100 text-start border-0 bg-transparent cursor-pointer" onclick="openModalDirectly('modalProfile')">
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                        <i class="bi bi-person fs-6"></i>
                                    </div>
                                    <div>
                                        <span class="d-block fw-bold text-navy lh-sm">Profil Saya</span>
                                        <span class="text-muted" style="font-size: 0.7rem;">Informasi akun & kontak</span>
                                    </div>
                                </button>
                            </li>
                            <li>
                                <a class="dropdown-item small py-2 px-3 rounded-3 d-flex align-items-center gap-3" href="{{ route('mitra.dashboard') }}">
                                    <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                        <i class="bi bi-speedometer2 fs-6"></i>
                                    </div>
                                    <div>
                                        <span class="d-block fw-bold text-navy lh-sm">Dashboard Mitra</span>
                                        <span class="text-muted" style="font-size: 0.7rem;">Kelola destinasi terdaftar Anda</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item small py-2 px-3 rounded-3 d-flex align-items-center gap-3" href="{{ route('mitra.register') }}">
                                    <div class="rounded-circle bg-secondary bg-opacity-10 text-secondary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                        <i class="bi bi-building-add fs-6"></i>
                                    </div>
                                    <div>
                                        <span class="d-block fw-bold text-navy lh-sm">Pendaftaran Mitra Baru</span>
                                        <span class="text-muted" style="font-size: 0.7rem;">Daftarkan destinasi/hotel</span>
                                    </div>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider my-2 opacity-50"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item small py-2 px-3 rounded-3 text-danger d-flex align-items-center gap-3 w-100">
                                        <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                            <i class="bi bi-box-arrow-right fs-6"></i>
                                        </div>
                                        <span class="fw-bold">Keluar (Logout)</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <!-- Hanya Tersisa Tombol Masuk / Daftar saat Belum Masuk -->
                    <button type="button" class="btn btn-green rounded-pill px-4 py-2 fw-bold text-white fs-7 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAuth" onclick="openNormalAuthModal()">
                        Masuk / Daftar
                    </button>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- MODAL MASUK / DAFTAR -->
<div class="modal fade" id="modalAuth" tabindex="-1" aria-labelledby="modalAuthLabel" aria-hidden="true" style="z-index: 1070;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-navy" id="modalAuthLabel">Akun DOKEMAS Banyumas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModalDirectly('modalAuth')"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Notifikasi Wajib Login -->
                <div id="modalAuthAlert" class="alert alert-warning small rounded-3 p-3 mb-3 d-flex align-items-center gap-2 border-0 bg-warning bg-opacity-10 text-dark {{ session('login_required') ? '' : 'd-none' }}">
                    <i class="bi bi-shield-lock-fill text-warning fs-5 flex-shrink-0"></i>
                    <span id="modalAuthAlertText">{{ session('login_required') ?? 'Silakan masuk (login) terlebih dahulu untuk mengakses Pendaftaran Kemitraan DOKEMAS Banyumas.' }}</span>
                </div>

                <!-- Nav Tabs Masuk & Daftar -->
                <ul class="nav nav-pills nav-fill bg-light p-1 rounded-pill mb-4" id="authTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill fw-bold small py-2 text-navy" id="login-tab" data-bs-toggle="tab" data-bs-target="#tabLogin" type="button" role="tab">Masuk</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill fw-bold small py-2 text-navy" id="register-tab" data-bs-toggle="tab" data-bs-target="#tabRegister" type="button" role="tab">Daftar Akun</button>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Form Masuk -->
                    <div class="tab-pane fade show active" id="tabLogin" role="tabpanel">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-navy fw-semibold small mb-1">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0" placeholder="nama@email.com" value="wisatawan@dokemas.id" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-navy fw-semibold small mb-1">Kata Sandi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-key"></i></span>
                                    <input type="password" name="password" class="form-control border-start-0" placeholder="Kata sandi akun" value="password123" required>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" checked>
                                    <label class="form-check-label text-secondary small" for="rememberMe">Ingat saya</label>
                                </div>
                                <a href="#" class="text-success small fw-semibold text-decoration-none">Lupa kata sandi?</a>
                            </div>
                            <button type="submit" class="btn btn-green w-100 rounded-pill py-2 fw-bold text-white shadow-sm mb-2">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Sekarang
                            </button>
                        </form>

                        <!-- Pembatas Divider -->
                        <div class="position-relative my-3 text-center">
                            <hr class="border-secondary opacity-25 my-0">
                            <span class="position-relative bg-white px-3 text-muted small" style="font-size: 0.72rem; top: -10px;">
                                atau masuk dengan
                            </span>
                        </div>

                        <!-- Tombol Masuk dengan Google -->
                        <a href="{{ route('login.google') }}" class="btn btn-outline-secondary w-100 rounded-pill py-2 fw-semibold small d-flex align-items-center justify-content-center gap-2 border-light-subtle shadow-xs text-decoration-none">
                            <svg width="18" height="18" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                            </svg>
                            <span class="text-navy">Lanjutkan dengan Google</span>
                        </a>
                    </div>

                    <!-- Form Daftar -->
                    <div class="tab-pane fade" id="tabRegister" role="tabpanel">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-navy fw-semibold small mb-1">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" placeholder="Contoh: Budi Santoso" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-navy fw-semibold small mb-1">Alamat Email</label>
                                <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-navy fw-semibold small mb-1">Kata Sandi</label>
                                <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                            </div>
                            <button type="submit" class="btn btn-green w-100 rounded-pill py-2 fw-bold text-white shadow-sm mb-2">
                                <i class="bi bi-person-plus me-1"></i> Buat Akun DOKEMAS
                            </button>
                        </form>

                        <!-- Pembatas Divider -->
                        <div class="position-relative my-3 text-center">
                            <hr class="border-secondary opacity-25 my-0">
                            <span class="position-relative bg-white px-3 text-muted small" style="font-size: 0.72rem; top: -10px;">
                                atau daftar dengan
                            </span>
                        </div>

                        <!-- Tombol Daftar dengan Google -->
                        <a href="{{ route('login.google') }}" class="btn btn-outline-secondary w-100 rounded-pill py-2 fw-semibold small d-flex align-items-center justify-content-center gap-2 border-light-subtle shadow-xs text-decoration-none">
                            <svg width="18" height="18" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                            </svg>
                            <span class="text-navy">Daftar dengan Akun Google</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PROFIL SAYA INTERAKTIF (Selalu ada di DOM untuk memastikan responsivitas) -->
<div class="modal fade" id="modalProfile" tabindex="-1" aria-labelledby="modalProfileLabel" aria-hidden="true" style="z-index: 1070;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-person-gear fs-5"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-navy" id="modalProfileLabel">Profil Saya</h5>
                        <p class="text-muted small mb-0">Informasi data diri dan pengaturan akun DOKEMAS</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModalDirectly('modalProfile')"></button>
            </div>
            <div class="modal-body p-4">
                <!-- User Summary Card -->
                <div class="card border-0 bg-light rounded-4 p-3 mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold fs-4 shadow-sm flex-shrink-0" style="width: 58px; height: 58px; background-color: #1967d2;">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="overflow-hidden">
                            <h6 class="fw-bold text-navy mb-0 text-truncate">{{ Auth::user()->name ?? 'Pengguna DOKEMAS' }}</h6>
                            <p class="text-muted small mb-1 text-truncate">{{ Auth::user()->email ?? 'user@dokemas.id' }}</p>
                            <div class="d-flex flex-wrap align-items-center gap-1">
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-2 py-0-5" style="font-size: 0.68rem;">
                                    <i class="bi bi-patch-check-fill me-1"></i>Akun Terverifikasi
                                </span>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2 py-0-5" style="font-size: 0.68rem;">
                                    Mitra & Wisatawan
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Update Profile Form -->
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-navy fw-semibold small mb-1">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-person"></i></span>
                            <input type="text" name="name" class="form-control border-start-0" value="{{ Auth::user()->name ?? 'Wisatawan Banyumas' }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-navy fw-semibold small mb-1">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control border-start-0" value="{{ Auth::user()->email ?? 'user@dokemas.id' }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-navy fw-semibold small mb-1">Nomor WhatsApp / Kontak</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-whatsapp text-success"></i></span>
                            <input type="tel" name="phone" class="form-control border-start-0" value="+62 813-9090-4421" placeholder="+62 8xx-xxxx-xxxx">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-navy fw-semibold small mb-1">Kota / Domisili</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-geo-alt"></i></span>
                            <input type="text" name="city" class="form-control border-start-0" value="Purwokerto, Kab. Banyumas">
                        </div>
                    </div>

                    <!-- Ringkasan Aktivitas Akun -->
                    <div class="p-3 bg-light rounded-4 mb-4">
                        <span class="text-secondary fw-semibold small d-block mb-2">Statistik Kunjungan & Dolan:</span>
                        <div class="row g-2 text-center">
                            <div class="col-4">
                                <div class="bg-white p-2 rounded-3 border border-light-subtle shadow-2xs">
                                    <span class="fw-bold text-primary d-block fs-6">4</span>
                                    <span class="text-muted" style="font-size: 0.68rem;">Destinasi Favorit</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-white p-2 rounded-3 border border-light-subtle shadow-2xs">
                                    <span class="fw-bold text-navy d-block fs-6">5</span>
                                    <span class="text-muted" style="font-size: 0.68rem;">Kunjungan Selesai</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-white p-2 rounded-3 border border-light-subtle shadow-2xs">
                                    <span class="fw-bold text-warning d-block fs-6">450</span>
                                    <span class="text-muted" style="font-size: 0.68rem;">Poin Dolan</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light rounded-pill px-4 py-2 small fw-semibold text-secondary" data-bs-dismiss="modal" onclick="closeModalDirectly('modalProfile')">Tutup</button>
                        <button type="submit" class="btn btn-green rounded-pill px-4 py-2 small fw-bold text-white shadow-sm">
                            <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- FLOATING TOAST NOTIFICATION CONTAINER -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1099;">
    <div id="liveToastApp" class="toast align-items-center text-bg-success border-0 shadow-lg rounded-4" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2 py-3 px-3">
                <i class="bi bi-check-circle-fill fs-5" id="liveToastIcon"></i>
                <span class="fw-semibold small" id="liveToastMessage">Aksi berhasil dilakukan.</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- JAVASCRIPT LOGIC INTERAKTIF -->
<script>
    // Inisialisasi handler dropdown profile yang andal
    document.addEventListener('DOMContentLoaded', function() {
        var toggleBtn = document.getElementById('userProfileDropdownToggle');
        var menu = document.getElementById('userProfileDropdownMenu');

        if (toggleBtn && menu) {
            // Deteksi jika Bootstrap data-api tidak membuka dropdown, lakukan toggle mandiri
            toggleBtn.addEventListener('click', function(e) {
                setTimeout(function() {
                    if (!menu.classList.contains('show') && toggleBtn.getAttribute('aria-expanded') !== 'true') {
                        menu.classList.add('show');
                        toggleBtn.classList.add('show');
                        toggleBtn.setAttribute('aria-expanded', 'true');
                    }
                }, 50);
            });

            // Menutup dropdown jika user klik di luar area profil
            document.addEventListener('click', function(e) {
                if (!toggleBtn.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.remove('show');
                    toggleBtn.classList.remove('show');
                    toggleBtn.setAttribute('aria-expanded', 'false');
                }
            });
        }

        // Listener klik di luar modal untuk menutup dialog
        ['modalProfile', 'modalAuth'].forEach(function(modalId) {
            var m = document.getElementById(modalId);
            if (m) {
                m.addEventListener('click', function(e) {
                    if (e.target === m) {
                        closeModalDirectly(modalId);
                    }
                });
            }
        });
    });

    // Prompt login ketika user belum masuk dan klik Gabung Mitra
    function promptMitraLogin(msg) {
        var defaultMsg = 'Silakan masuk (login) terlebih dahulu untuk mengakses Pendaftaran Kemitraan DOKEMAS Banyumas.';
        var alertBox = document.getElementById('modalAuthAlert');
        var alertText = document.getElementById('modalAuthAlertText');
        if (alertBox && alertText) {
            alertText.textContent = msg || defaultMsg;
            alertBox.classList.remove('d-none');
        }
        openModalDirectly('modalAuth');
    }

    // Reset notifikasi jika dibuka dari tombol biasa Masuk / Daftar
    function openNormalAuthModal() {
        var alertBox = document.getElementById('modalAuthAlert');
        @if(!session('login_required'))
        if (alertBox) {
            alertBox.classList.add('d-none');
        }
        @endif
    }

    // Membuka modal secara langsung & andal dengan dukungan fallback vanilla
    function openModalDirectly(modalId) {
        // 1. Sembunyikan semua dropdown menu yang aktif
        try {
            var activeDropdowns = document.querySelectorAll('.dropdown-menu.show');
            activeDropdowns.forEach(function(dd) { dd.classList.remove('show'); });
            var activeToggles = document.querySelectorAll('[data-bs-toggle="dropdown"].show, #userProfileDropdownToggle.show');
            activeToggles.forEach(function(t) {
                t.classList.remove('show');
                t.setAttribute('aria-expanded', 'false');
            });
        } catch(err) {}

        // 2. Ambil element modal sasaran
        var modalEl = document.getElementById(modalId);
        if (!modalEl) {
            console.error('Modal #' + modalId + ' tidak ditemukan');
            return;
        }

        // 3. Utamakan Bootstrap Modal instance jika tersedia
        if (window.bootstrap && window.bootstrap.Modal) {
            try {
                var modal = window.bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
                return;
            } catch(e) {
                console.warn('Bootstrap modal error, using direct display fallback:', e);
            }
        }

        // 4. Fallback murni jika Bootstrap belum siap
        modalEl.classList.add('show');
        modalEl.style.display = 'block';
        modalEl.removeAttribute('aria-hidden');
        modalEl.setAttribute('aria-modal', 'true');
        document.body.classList.add('modal-open');
        if (!document.getElementById('fallback-bd-' + modalId)) {
            var bd = document.createElement('div');
            bd.className = 'modal-backdrop fade show';
            bd.id = 'fallback-bd-' + modalId;
            document.body.appendChild(bd);
        }
    }

    // Menutup modal dengan bersih
    function closeModalDirectly(modalId) {
        var modalEl = document.getElementById(modalId);
        if (!modalEl) return;

        if (window.bootstrap && window.bootstrap.Modal) {
            try {
                var inst = window.bootstrap.Modal.getInstance(modalEl);
                if (inst) {
                    inst.hide();
                    return;
                }
            } catch(e) {}
        }

        modalEl.classList.remove('show');
        modalEl.style.display = 'none';
        modalEl.setAttribute('aria-hidden', 'true');
        modalEl.removeAttribute('aria-modal');
        document.body.classList.remove('modal-open');
        var bd = document.getElementById('fallback-bd-' + modalId);
        if (bd) bd.remove();
        var allBds = document.querySelectorAll('.modal-backdrop');
        allBds.forEach(function(b) { b.remove(); });
    }

    // Global listener untuk tombol dismiss modal
    document.addEventListener('click', function(e) {
        if (e.target.matches('[data-bs-dismiss="modal"]') || e.target.closest('[data-bs-dismiss="modal"]')) {
            var modal = e.target.closest('.modal');
            if (modal && modal.id) {
                closeModalDirectly(modal.id);
            }
        }
    });

    // Global Toast Notification Helper
    function showGlobalToast(message, type) {
        var toastEl = document.getElementById('liveToastApp');
        var msgEl = document.getElementById('liveToastMessage');
        var iconEl = document.getElementById('liveToastIcon');
        if (!toastEl || !msgEl) return;

        msgEl.textContent = message;
        if (type === 'danger') {
            toastEl.className = 'toast align-items-center text-bg-danger border-0 shadow-lg rounded-4';
            if (iconEl) iconEl.className = 'bi bi-exclamation-triangle-fill fs-5';
        } else {
            toastEl.className = 'toast align-items-center text-bg-success border-0 shadow-lg rounded-4';
            if (iconEl) iconEl.className = 'bi bi-check-circle-fill fs-5';
        }

        if (window.bootstrap && window.bootstrap.Toast) {
            var toast = window.bootstrap.Toast.getOrCreateInstance(toastEl);
            toast.show();
        } else if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
            var toast = bootstrap.Toast.getOrCreateInstance(toastEl);
            toast.show();
        }
    }
</script>
