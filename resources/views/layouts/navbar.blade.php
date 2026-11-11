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
                    <a class="nav-link px-3 rounded-pill {{ request()->routeIs('home') ? 'text-success bg-success bg-opacity-10 fw-bold' : 'text-secondary' }}" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 rounded-pill {{ request()->routeIs('destinasi.*') ? 'text-success bg-success bg-opacity-10 fw-bold' : 'text-secondary' }}" href="{{ route('destinasi.index') }}">Wisata & Penginapan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 rounded-pill {{ request()->routeIs('mitra.*') ? 'text-success bg-success bg-opacity-10 fw-bold border border-success border-opacity-25' : 'text-secondary' }}" href="{{ route('mitra.register') }}">Gabung Mitra</a>
                </li>
            </ul>

            <!-- Right Action Buttons -->
            <div class="d-flex align-items-center gap-3">
                @auth
                    <!-- Logo Profile & Menu Akun (Hanya Muncul Jika User Telah Masuk) -->
                    <div class="dropdown">
                        <button class="btn btn-dark rounded-circle d-flex align-items-center justify-content-center p-0 shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 38px; height: 38px;" title="{{ Auth::user()->name }}">
                            <i class="bi bi-person-fill fs-5"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 mt-2 py-2" style="min-width: 210px;">
                            <li class="px-3 py-2 border-bottom">
                                <span class="d-block fw-bold text-navy small text-truncate">{{ Auth::user()->name }}</span>
                                <small class="text-muted d-block text-truncate" style="font-size: 0.72rem;">{{ Auth::user()->email }}</small>
                            </li>
                            <li><a class="dropdown-item small py-2 d-flex align-items-center gap-2" href="#"><i class="bi bi-person text-secondary"></i> Profil Saya</a></li>
                            <li><a class="dropdown-item small py-2 d-flex align-items-center gap-2" href="#"><i class="bi bi-ticket-perforated text-secondary"></i> Tiket & Reservasi</a></li>
                            <li><a class="dropdown-item small py-2 d-flex align-items-center gap-2" href="{{ route('mitra.register') }}"><i class="bi bi-shop text-secondary"></i> Portal Mitra</a></li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item small py-2 text-danger d-flex align-items-center gap-2">
                                        <i class="bi bi-box-arrow-right"></i> Keluar (Logout)
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <!-- Hanya Tersisa Tombol Masuk / Daftar saat Belum Masuk -->
                    <button type="button" class="btn btn-green rounded-pill px-4 py-2 fw-bold text-white fs-7 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAuth">
                        Masuk / Daftar
                    </button>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- MODAL MASUK / DAFTAR -->
<div class="modal fade" id="modalAuth" tabindex="-1" aria-labelledby="modalAuthLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-navy" id="modalAuthLabel">Akun DOKEMAS Banyumas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
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