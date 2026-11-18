<footer class="bg-navy-dark text-white pt-5 pb-4 mt-0">
    <div class="container">
        <div class="row g-4 mb-5">
            <!-- Col 1: Brand Info -->
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <!-- Kotak Putih Penampung Logo -->
                    <div class="bg-white p-1 rounded-2 d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">
                        <img src="{{ asset('images/logo-dokemas.png') }}" alt="Logo DOKEMAS" class="w-100 h-100 object-fit-contain">
                    </div>
                    <div>
                        <span class="fw-bold d-block text-white lh-1">DOKEMAS</span>
                        <small class="text-white-50" style="font-size: 0.6rem;">DOLAN KELILING BANYUMAS</small>
                    </div>
                </div>
                <p class="text-white-50 small mb-0" style="line-height: 1.6;">
                    Platform itinerary perjalanan, destinasi alam Gunung Slamet, reservasi homestay otentik, dan pemberdayaan ekowisata lokal Kabupaten Banyumas.
                </p>
            </div>

            <!-- Col 2: Eksplorasi -->
            <div class="col-lg-2 col-md-6 ms-lg-auto">
                <h6 class="fw-bold text-white mb-3">Eksplorasi</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 small text-white-50">
                    <li><a href="{{ route('destinasi.index', ['kategori' => ['alam']]) }}" class="text-white-50 text-decoration-none">Wisata Alam</a></li>
                    <li><a href="{{ route('destinasi.index', ['fasilitas' => ['penginapan']]) }}" class="text-white-50 text-decoration-none">Hotel & Villa</a></li>
                    <li><a href="{{ route('destinasi.index', ['kategori' => ['kuliner']]) }}" class="text-white-50 text-decoration-none">Kuliner Banyumasan</a></li>
                </ul>
            </div>

            <!-- Col 3: Kemitraan -->
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold text-white mb-3">Kemitraan</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 small text-white-50">
                    <li><a href="{{ route('mitra.register') }}" class="text-white-50 text-decoration-none">Daftar Menjadi Mitra</a></li>
                    <li><a href="{{ route('mitra.dashboard') }}" class="text-white-50 text-decoration-none">Portal Pengelola</a></li>
                </ul>
            </div>

            <!-- Col 4: Pusat Kontak -->
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold text-white mb-3">Pusat Kontak</h6>
                <ul class="list-unstyled d-flex flex-column gap-3 small text-white-50">
                    <li>
                        <a href="https://maps.google.com/?q=Purwokerto+Banyumas" target="_blank" rel="noopener noreferrer" class="text-white-50 text-decoration-none d-flex align-items-start gap-2">
                            <i class="bi bi-geo-alt text-success fs-6 mt-1 flex-shrink-0"></i>
                            <span>Banyumas Tourism Center, Jl. Jend. Soedirman, Purwokerto</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer" class="text-white-50 text-decoration-none d-flex align-items-center gap-2">
                            <i class="bi bi-whatsapp text-success fs-6 flex-shrink-0"></i>
                            <span>+62 812-3456-7890</span>
                        </a>
                    </li>
                    <li>
                        <a href="mailto:halo@dokemas.id" class="text-white-50 text-decoration-none d-flex align-items-center gap-2">
                            <i class="bi bi-envelope text-success fs-6 flex-shrink-0"></i>
                            <span>halo@dokemas.id</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="border-secondary opacity-25 my-4">

        <!-- Bottom Copyright -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small text-white-50 gap-2">
            <div>© 2025 DOKEMAS (Dolan Keliling Banyumas). Hak Cipta Dilindungi.</div>
            <div class="d-flex gap-3">
                <a href="#" class="text-white-50 text-decoration-none">Kebijakan Privasi</a>
                <a href="#" class="text-white-50 text-decoration-none">Syarat & Ketentuan</a>
                <a href="#" class="text-white-50 text-decoration-none">Peta Situs</a>
            </div>
        </div>
    </div>
</footer>