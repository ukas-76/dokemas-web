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
                    <a class="nav-link px-3 text-secondary" href="#">Gabung Mitra</a>
                </li>
            </ul>

            <!-- Right Action Buttons -->
            <div class="d-flex align-items-center gap-3">
                <a href="#" class="text-secondary fs-5"><i class="bi bi-question-circle"></i></a>
                <a href="#" class="text-secondary fs-5"><i class="bi bi-search"></i></a>
                <a href="#" class="btn btn-green rounded-pill px-4 py-2 fw-bold text-white fs-7">Masuk / Daftar</a>
                <a href="#" class="btn btn-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                    <i class="bi bi-person"></i>
                </a>
            </div>
        </div>
    </div>
</nav>