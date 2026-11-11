@extends('layouts.app')

@section('title', 'DOKEMAS Mitra - Formulir Pendaftaran & Onboarding Pengelola')

@section('content')
<div class="container py-4 py-lg-5">

    <!-- 1. HEADER STEPPER CARD -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
        <!-- Top Row Meta Info -->
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between pb-3 mb-4 border-bottom border-light-subtle gap-2">
            <div>
                <h5 class="fw-bold text-navy mb-1" style="font-size: 1.15rem; letter-spacing: -0.3px;">Pendaftaran Kemitraan DOKEMAS</h5>
                <p class="text-muted small mb-0">Portal resmi onboarding pengelola destinasi wisata & penginapan Kabupaten Banyumas</p>
            </div>
            <div>
                <span class="badge bg-success bg-opacity-10 text-success fw-semibold border border-success-subtle rounded-pill px-3 py-2 d-inline-flex align-items-center gap-2" id="stepperProgressBadge" style="font-size: 0.82rem;">
                    <span class="rounded-circle bg-success d-inline-block" style="width: 7px; height: 7px;"></span>
                    <span id="stepperProgressText">
                        @if(($step ?? 1) == 1)
                            Langkah 1 dari 4: 25% Selesai
                        @elseif(($step ?? 1) == 2)
                            Langkah 2 dari 4: 50% Selesai
                        @elseif(($step ?? 1) == 3)
                            Langkah 3 dari 4: 75% Selesai
                        @else
                            Langkah 4 dari 4: 100% Siap Dikirim
                        @endif
                    </span>
                </span>
            </div>
        </div>

        <!-- Stepper Progress Bar -->
        <div class="row g-3 align-items-center" id="stepperNavRow">
            <!-- Step 1 -->
            <div class="col-6 col-lg-3" onclick="goToStep(1)" style="cursor: pointer;" title="Klik untuk ke Langkah 1">
                <div class="d-flex align-items-center gap-3">
                    <div class="step-circle {{ ($step ?? 1) == 1 ? 'active' : 'completed' }} flex-shrink-0" id="stepIndicatorCircle1">
                        @if(($step ?? 1) == 1)
                            1
                        @else
                            <i class="bi bi-check-lg fs-5"></i>
                        @endif
                    </div>
                    <div class="flex-grow-1 min-w-0" id="stepIndicatorLabel1">
                        <span class="text-success fw-semibold d-block" style="font-size: 0.72rem;">Langkah 1</span>
                        <strong class="d-block text-navy text-truncate" style="font-size: 0.88rem;">Informasi Akun</strong>
                        <small class="text-muted d-block text-truncate" style="font-size: 0.75rem;">Data kontak & PIC</small>
                    </div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="col-6 col-lg-3" onclick="goToStep(2)" style="cursor: pointer;" title="Klik untuk ke Langkah 2">
                <div class="d-flex align-items-center gap-3">
                    <div class="step-circle {{ ($step ?? 1) == 2 ? 'active' : (($step ?? 1) > 2 ? 'completed' : 'inactive') }} flex-shrink-0" id="stepIndicatorCircle2">
                        @if(($step ?? 1) > 2)
                            <i class="bi bi-check-lg fs-5"></i>
                        @else
                            2
                        @endif
                    </div>
                    <div class="flex-grow-1 min-w-0" id="stepIndicatorLabel2">
                        <span class="{{ ($step ?? 1) >= 2 ? 'text-success fw-semibold' : 'text-muted' }} d-block" style="font-size: 0.72rem;">Langkah 2</span>
                        <strong class="d-block text-navy text-truncate" style="font-size: 0.88rem;">Profil Destinasi</strong>
                        <small class="text-muted d-block text-truncate" style="font-size: 0.75rem;">Lokasi & fasilitas</small>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="col-6 col-lg-3" onclick="goToStep(3)" style="cursor: pointer;" title="Klik untuk ke Langkah 3">
                <div class="d-flex align-items-center gap-3">
                    <div class="step-circle {{ ($step ?? 1) == 3 ? 'active' : (($step ?? 1) > 3 ? 'completed' : 'inactive') }} flex-shrink-0" id="stepIndicatorCircle3">
                        @if(($step ?? 1) > 3)
                            <i class="bi bi-check-lg fs-5"></i>
                        @else
                            3
                        @endif
                    </div>
                    <div class="flex-grow-1 min-w-0" id="stepIndicatorLabel3">
                        <span class="{{ ($step ?? 1) >= 3 ? 'text-success fw-semibold' : 'text-muted' }} d-block" style="font-size: 0.72rem;">Langkah 3</span>
                        <strong class="d-block text-navy text-truncate" style="font-size: 0.88rem;">Dokumen Legalitas</strong>
                        <small class="text-muted d-block text-truncate" style="font-size: 0.75rem;">NIB OSS & izin</small>
                    </div>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="col-6 col-lg-3" onclick="goToStep(4)" style="cursor: pointer;" title="Klik untuk ke Langkah 4">
                <div class="d-flex align-items-center gap-3">
                    <div class="step-circle {{ ($step ?? 1) == 4 ? 'active' : 'inactive' }} flex-shrink-0" id="stepIndicatorCircle4">
                        4
                    </div>
                    <div class="flex-grow-1 min-w-0" id="stepIndicatorLabel4">
                        <span class="{{ ($step ?? 1) == 4 ? 'text-success fw-semibold' : 'text-muted' }} d-block" style="font-size: 0.72rem;">Langkah 4</span>
                        <strong class="d-block text-navy text-truncate" style="font-size: 0.88rem;">Review & Kirim</strong>
                        <small class="text-muted d-block text-truncate" style="font-size: 0.75rem;">Konfirmasi akhir</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. MAIN CONTENT (2 COLUMNS) -->
    <div class="row g-4">

        <!-- LEFT SIDEBAR -->
        <div class="col-lg-4 col-xl-4">
            
            <!-- Banner & Info Card -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
                <!-- Image Header with Overlay -->
                <div class="position-relative" style="height: 190px;">
                    <img src="{{ asset('images/gunung-selamet.jpg') }}" alt="Gunung Slamet Banyumas" class="w-100 h-100 object-fit-cover">
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-between p-3" style="background: linear-gradient(180deg, rgba(13,35,58,0.3) 0%, rgba(11,27,42,0.85) 100%);">
                        <div>
                            <span class="badge bg-black bg-opacity-60 text-white text-uppercase px-2 py-1 fw-semibold" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                                BANYUMAS HOSPITALITY
                            </span>
                        </div>
                        <div>
                            <h5 class="text-white fw-bold mb-0 lh-sm" style="font-size: 1.18rem;">
                                Terhubung ke 120.000+ Wisatawan Aktif
                            </h5>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-4">
                    <p class="text-secondary small mb-3" style="line-height: 1.6;">
                        Pendaftaran tempat Anda langsung masuk ke direktori resmi portal pariwisata terpadu <strong class="text-navy">DOKEMAS</strong> dan kalender event tahunan Kabupaten Banyumas.
                    </p>

                    <!-- Info Box 1: Jaminan Verifikasi Resmi -->
                    <div class="p-3 rounded-3 mb-3 border border-light-subtle bg-light">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-shield-check text-navy fs-5 mt-n1"></i>
                            <div>
                                <strong class="text-navy d-block small mb-1">Jaminan Verifikasi Resmi</strong>
                                <p class="text-muted mb-0" style="font-size: 0.75rem; line-height: 1.45;">
                                    Tim kurasi Dinporabudpar memastikan kelayakan fasilitas dan membantu pembuatan QR Statis resmi destinasi.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Info Box 2: Tips Dinamis Berdasarkan Langkah -->
                    <div class="p-3 rounded-3 border border-success-subtle bg-success bg-opacity-10" id="sidebarTipsContainer">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-lightbulb text-success fs-5 mt-n1"></i>
                            <div id="sidebarTipsContent">
                                @if(($step ?? 1) == 1)
                                    <strong class="text-success d-block small mb-1">Tips Langkah 1:</strong>
                                    <p class="text-secondary mb-0" style="font-size: 0.75rem; line-height: 1.45;">
                                        Pastikan data penanggung jawab sesuai KTP dan nomor WhatsApp aktif untuk menerima kode verifikasi OTP instan.
                                    </p>
                                @elseif(($step ?? 1) == 2)
                                    <strong class="text-success d-block small mb-1">Tips Pengisian:</strong>
                                    <p class="text-secondary mb-0" style="font-size: 0.75rem; line-height: 1.45;">
                                        Unggah foto berformat horizontal (landscape) agar tampil proporsional pada katalog kartu aplikasi wisatawan.
                                    </p>
                                @elseif(($step ?? 1) == 3)
                                    <strong class="text-success d-block small mb-1">Tips Legalitas & Dokumen:</strong>
                                    <p class="text-secondary mb-0" style="font-size: 0.75rem; line-height: 1.45;">
                                        Pastikan berkas scan NIB OSS, KTP, dan surat rekomendasi/izin terbaca jelas untuk mempermudah validasi kurator Dinporabudpar.
                                    </p>
                                @else
                                    <strong class="text-success d-block small mb-1">Tips Review & Kirim:</strong>
                                    <p class="text-secondary mb-0" style="font-size: 0.75rem; line-height: 1.45;">
                                        Periksa kembali seluruh informasi formulir sebelum dikirim. Tim Dinporabudpar akan memverifikasi berkas dalam 1x24 jam kerja.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Operator WhatsApp CTA Card -->
            <div class="p-3 rounded-4 shadow-sm bg-navy-main text-white d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                        <i class="bi bi-headset fs-5 text-white"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-white small">Butuh Bantuan Operator?</div>
                        <small class="text-white-50 d-block" style="font-size: 0.72rem;">WhatsApp Respon Cepat (08:00 - 16:00)</small>
                    </div>
                </div>
                <a href="https://wa.me/6281390904421" target="_blank" class="btn btn-green rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" style="width: 36px; height: 36px;">
                    <i class="bi bi-arrow-right text-white"></i>
                </a>
            </div>

        </div>

        <!-- RIGHT MAIN FORM -->
        <div class="col-lg-8 col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                <form action="#" method="POST" enctype="multipart/form-data" id="formOnboardingMitra">
                    @csrf

                    <!-- ============================================================== -->
                    <!-- KONTEN LANGKAH 1: INFORMASI AKUN & VERIFIKASI NO OTP           -->
                    <!-- ============================================================== -->
                    <div id="step1Container" style="{{ ($step ?? 1) == 1 ? 'display: block;' : 'display: none;' }}">
                        
                        <!-- Header Seksi 01 -->
                        <div class="mb-4 pb-2 border-bottom">
                            <h5 class="fw-bold text-navy mb-1 d-flex align-items-center gap-2" style="font-size: 1.05rem;">
                                <i class="bi bi-person-badge text-success"></i> Data Penanggung Jawab
                            </h5>
                            <p class="text-muted small mb-0">Informasi identitas pengelola resmi destinasi untuk keperluan administrasi kemitraan.</p>
                        </div>

                        <!-- Nama Lengkap & NIK KTP -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="form-label fw-bold text-navy small mb-0">Nama Lengkap Penanggung Jawab <span class="text-danger">*</span></label>
                                </div>
                                <input type="text" class="form-control form-control-lg rounded-3 fs-6" name="owner_name" id="ownerNameInput" placeholder="Contoh: Rizko Afryan Santoso" value="Rizko Afryan Santoso" required>
                                <small class="text-muted d-block mt-1" style="font-size: 0.73rem;">Sesuai dengan nama pada identitas KTP resmi</small>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="form-label fw-bold text-navy small mb-0">Nomor Induk Kependudukan (NIK KTP) <span class="text-danger">*</span></label>
                                </div>
                                <div class="input-group input-group-lg rounded-3">
                                    <span class="input-group-text bg-light text-muted border-end-0 fs-6"><i class="bi bi-person-vcard"></i></span>
                                    <input type="text" class="form-control fs-6 border-start-0" name="owner_nik" id="ownerNikInput" placeholder="3302xxxxxxxxxxxx (16 Digit)" value="3302198765430001" maxlength="16" required>
                                </div>
                                <small class="text-muted d-block mt-1" style="font-size: 0.73rem;">Untuk verifikasi izin berusaha dan perlindungan kemitraan</small>
                            </div>
                        </div>

                        <!-- Bentuk Entitas & Nama Komunitas/Lembaga -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-navy small mb-2">Bentuk Entitas Pengelola <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg rounded-3 fs-6" name="entity_type" required>
                                    <option value="perorangan" selected>Perorangan / Pemilik Usaha Pribadi</option>
                                    <option value="pokdarwis">Kelompok Sadar Wisata (POKDARWIS)</option>
                                    <option value="bumdes">BUMDes / Pengelola Desa Wisata</option>
                                    <option value="badan_usaha">Badan Usaha (PT / CV / Koperasi / Yayasan)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-navy small mb-2">Jabatan dalam Pengelolaan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg rounded-3 fs-6" name="owner_position" placeholder="Contoh: Pemilik Usaha / Ketua POKDARWIS" value="Ketua Tim Pengelola" required>
                            </div>
                        </div>

                        <!-- Header Seksi 02 -->
                        <div class="mb-4 pb-2 border-bottom pt-3">
                            <h5 class="fw-bold text-navy mb-1 d-flex align-items-center gap-2" style="font-size: 1.05rem;">
                                <i class="bi bi-shield-lock text-success"></i> Kontak Resmi & Keamanan Akun
                            </h5>
                            <p class="text-muted small mb-0">Nomor WhatsApp dan kata sandi untuk login portal dashboard mitra.</p>
                        </div>

                        <!-- Nomor WhatsApp & Tombol Kirim OTP -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-7">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="form-label fw-bold text-navy small mb-0">Nomor WhatsApp Pengelola (Nomor Utama) <span class="text-danger">*</span></label>
                                </div>
                                <div class="input-group input-group-lg rounded-3">
                                    <span class="input-group-text bg-light text-muted border-end-0 fs-6 fw-semibold">+62</span>
                                    <input type="text" class="form-control fs-6 border-start-0 border-end-0" id="step1PhoneInput" name="owner_phone" placeholder="813-xxxx-xxxx" value="813-9090-4421" required>
                                    <button type="button" class="btn btn-light border border-start-0 text-success fw-semibold px-3 small d-inline-flex align-items-center" id="btnSendOtp" onclick="sendOtpCode()">
                                        <i class="bi bi-send me-1"></i> Kirim OTP
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-1" style="font-size: 0.73rem;">Kode verifikasi OTP 6 digit akan dikirim ke WhatsApp ini</small>
                            </div>

                            <!-- Input OTP -->
                            <div class="col-md-5">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="form-label fw-bold text-navy small mb-0">Kode Verifikasi OTP <span class="text-danger">*</span></label>
                                    <span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1" id="otpStatusBadge" style="font-size: 0.68rem;">
                                        <i class="bi bi-patch-check-fill me-1"></i> Terverifikasi
                                    </span>
                                </div>
                                <div class="input-group input-group-lg rounded-3">
                                    <span class="input-group-text bg-light text-muted border-end-0 fs-6"><i class="bi bi-shield-lock"></i></span>
                                    <input type="text" class="form-control fs-6 border-start-0 fw-bold text-navy text-center" id="otpCodeInput" name="otp_code" placeholder="6 Digit Angka" value="849201" maxlength="6" style="letter-spacing: 4px;">
                                </div>
                                <small class="text-success d-block mt-1" id="otpSuccessMsg" style="font-size: 0.73rem;">
                                    <i class="bi bi-check-circle-fill"></i> Nomor berhasil terhubung ke server WhatsApp
                                </small>
                            </div>
                        </div>

                        <!-- Email Resmi & Kata Sandi Portal -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-navy small mb-2">Alamat Email Resmi <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg rounded-3">
                                    <span class="input-group-text bg-light text-muted border-end-0 fs-6"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control fs-6 border-start-0" name="owner_email" placeholder="nama@pengelola.com" value="mitra@dokemas.banyumaskab.go.id" required>
                                </div>
                                <small class="text-muted d-block mt-1" style="font-size: 0.73rem;">Untuk pengiriman laporan kunjungan dan akses portal mitra</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-navy small mb-2">Buat Kata Sandi Portal Mitra <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg rounded-3">
                                    <span class="input-group-text bg-light text-muted border-end-0 fs-6"><i class="bi bi-key"></i></span>
                                    <input type="password" class="form-control fs-6 border-start-0 border-end-0" id="portalPassword" name="password" value="DokemasBanyumas2026!" placeholder="Minimal 8 karakter" required>
                                    <button type="button" class="btn btn-light border border-start-0 text-muted" onclick="togglePasswordVisibility()">
                                        <i class="bi bi-eye" id="passwordEyeIcon"></i>
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-1" style="font-size: 0.73rem;">Gunakan minimal 8 karakter kombinasi huruf dan angka</small>
                            </div>
                        </div>

                        <!-- Pernyataan / Checkbox Persetujuan -->
                        <div class="p-3 rounded-3 bg-light border border-light-subtle mb-5">
                            <div class="form-check d-flex align-items-start gap-2">
                                <input class="form-check-input mt-1 flex-shrink-0" type="checkbox" id="checkAgreeTerms" checked required>
                                <label class="form-check-label small text-secondary" for="checkAgreeTerms" style="font-size: 0.8rem; line-height: 1.5;">
                                    Saya menyatakan bahwa data penanggung jawab dan nomor kontak yang dimasukkan adalah benar, sah, dan bersedia mengikuti regulasi pariwisata Pemerintah Kabupaten Banyumas.
                                </label>
                            </div>
                        </div>

                        <!-- Tombol Aksi Langkah 1 -->
                        <div class="pt-4 border-top border-light-subtle d-flex flex-column flex-sm-row align-items-center justify-content-between gap-3">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold small w-100 w-sm-auto text-decoration-none">
                                <i class="bi bi-arrow-left me-1"></i> Batal
                            </a>
                            <div class="d-flex align-items-center gap-2 w-100 w-sm-auto justify-content-end">
                                <button type="button" class="btn btn-light border border-slate-200 rounded-pill px-4 py-2 fw-semibold text-secondary small">
                                    <i class="bi bi-bookmark me-1"></i> Simpan Draf
                                </button>
                                <button type="button" class="btn btn-green rounded-pill px-4 py-2 fw-bold text-white small shadow-sm" onclick="goToStep(2)">
                                    Lanjutkan ke Langkah 2 <i class="bi bi-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- ============================================================== -->
                    <!-- KONTEN LANGKAH 2: DETAIL TEMPAT & FASILITAS                    -->
                    <!-- ============================================================== -->
                    <div id="step2Container" style="{{ ($step ?? 1) == 2 ? 'display: block;' : 'display: none;' }}">
                        
                        <!-- ============================================== -->
                        <!-- SECTION 01: INFORMASI DASAR USAHA -->
                        <!-- ============================================== -->
                        <div class="mb-4 pb-2 border-bottom">
                            <h5 class="fw-bold text-navy mb-1 d-flex align-items-center gap-2" style="font-size: 1.05rem;">
                                <i class="bi bi-building text-success"></i> Profil & Kategori Usaha
                            </h5>
                            <p class="text-muted small mb-0">Informasi nama tempat, kategori wisata, dan jam operasional kunjungan.</p>
                        </div>

                        <!-- Nama Destinasi -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <label class="form-label fw-bold text-navy small mb-0">Nama Destinasi / Tempat Usaha <span class="text-danger">*</span></label>
                                <span class="text-muted" style="font-size: 0.75rem;">Sesuai plang atau izin resmi</span>
                            </div>
                            <input type="text" class="form-control form-control-lg rounded-3 fs-6" name="name" placeholder="Contoh: Hutan Pinus Limpakuwus Baturraden" value="Hutan Pinus Limpakuwus Baturraden" required>
                        </div>

                        <!-- Kategori & Kisaran Harga -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-navy small mb-2">Jenis Usaha / Kategori <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg rounded-3 fs-6" name="category_id" required>
                                    <option value="" disabled>Pilih Kategori Utama...</option>
                                    @if(isset($categories) && count($categories) > 0)
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id ?? $cat->slug }}" {{ $loop->first ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="alam" selected>Wisata Alam & Pegunungan</option>
                                        <option value="keluarga">Wisata Keluarga & Rekreasi</option>
                                        <option value="penginapan">Penginapan, Villa & Homestay</option>
                                        <option value="kuliner">Kuliner & Kafe Tradisional</option>
                                        <option value="budaya">Wisata Budaya & Sejarah</option>
                                        <option value="edukasi">Wisata Edukasi & Agro</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-navy small mb-2">Kisaran Harga Tiket / Sewa <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg rounded-3">
                                    <span class="input-group-text bg-light text-muted border-end-0 fs-6 fw-semibold">Rp</span>
                                    <input type="text" class="form-control fs-6 border-start-0" name="price_range" placeholder="Contoh: 15.000 / orang atau 450.000 / kamar" value="15.000 / orang">
                                </div>
                            </div>
                        </div>

                        <!-- Jam Operasional -->
                        <div class="mb-5">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <label class="form-label fw-bold text-navy small mb-0">Jam Operasional Kunjungan <span class="text-danger">*</span></label>
                                <span class="text-muted" style="font-size: 0.75rem;">Waktu Indonesia Barat (WIB)</span>
                            </div>
                            <div class="d-flex flex-column flex-sm-row gap-2 align-items-stretch">
                                <div class="flex-grow-1">
                                    <input type="text" id="inputJamOperasional" class="form-control form-control-lg rounded-3 fs-6" name="open_hours" placeholder="Contoh: 08:00 - 17:00 WIB (Setiap Hari)" value="08:00 - 17:00 WIB (Setiap Hari)" required>
                                </div>
                                <button type="button" class="btn btn-light border rounded-3 px-3 fs-6 fw-semibold text-secondary flex-shrink-0 d-inline-flex align-items-center justify-content-center" onclick="document.getElementById('inputJamOperasional').value='00:00 - 24:00 WIB (Buka 24 Jam)'">
                                    <i class="bi bi-clock-history me-1"></i> Set Buka 24 Jam
                                </button>
                            </div>
                        </div>

                        <!-- ============================================== -->
                        <!-- SECTION 02: LOKASI & KONTAK PENGELOLA -->
                        <!-- ============================================== -->
                        <div class="mb-4 pb-2 border-bottom pt-3">
                            <h5 class="fw-bold text-navy mb-1 d-flex align-items-center gap-2" style="font-size: 1.05rem;">
                                <i class="bi bi-geo-alt text-success"></i> Lokasi & Kontak Operasional
                            </h5>
                            <p class="text-muted small mb-0">Tautan titik Google Maps dan alamat lengkap petunjuk rute wisatawan.</p>
                        </div>

                        <!-- Kecamatan & Link Maps -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-5">
                                <label class="form-label fw-bold text-navy small mb-2">Kecamatan di Kab. Banyumas <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg rounded-3 fs-6" name="subdistrict" required>
                                    <option value="Baturraden" selected>Baturraden</option>
                                    <option value="Purwokerto Timur">Purwokerto Timur</option>
                                    <option value="Purwokerto Barat">Purwokerto Barat</option>
                                    <option value="Purwokerto Selatan">Purwokerto Selatan</option>
                                    <option value="Purwokerto Utara">Purwokerto Utara</option>
                                    <option value="Cilongok">Cilongok</option>
                                    <option value="Kedungbanteng">Kedungbanteng</option>
                                    <option value="Sumbang">Sumbang</option>
                                    <option value="Karanglewas">Karanglewas</option>
                                    <option value="Sokaraja">Sokaraja</option>
                                    <option value="Ajibarang">Ajibarang</option>
                                    <option value="Wangon">Wangon</option>
                                    <option value="Banyumas">Banyumas</option>
                                </select>
                            </div>
                            <div class="col-md-7">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="form-label fw-bold text-navy small mb-0">Titik Lokasi / Link Google Maps <span class="text-danger">*</span></label>
                                    <a href="https://maps.google.com" target="_blank" class="text-success text-decoration-none small fw-semibold">
                                        Buka Maps <i class="bi bi-box-arrow-up-right" style="font-size: 0.75rem;"></i>
                                    </a>
                                </div>
                                <div class="input-group input-group-lg rounded-3 mb-1">
                                    <span class="input-group-text bg-light border-end-0 text-success">
                                        <i class="bi bi-geo-alt-fill"></i>
                                    </span>
                                    <input type="url" class="form-control fs-6 border-start-0" name="maps_link" placeholder="https://maps.app.goo.gl/..." value="https://maps.app.goo.gl/BanyumasTourism" required>
                                </div>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Buka Google Maps lalu salin tautan lokasi destinasi Anda</small>
                            </div>
                        </div>

                        <!-- Alamat Lengkap & Petunjuk Arah -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-navy small mb-2">Alamat Lengkap & Petunjuk Arah Akses Kendaraan <span class="text-danger">*</span></label>
                            <textarea class="form-control rounded-3 fs-6" name="address_full" rows="3" required placeholder="Tuliskan nama jalan, nomor, RT/RW, dan patokan akses (misal: muat dua bus besar, akses tanjakan, dsb)">Jl. Raya Baturraden Timur KM 12, Karangsalam, Baturraden. Masuk gapura sebelah barat 100 meter, jalan beraspal halus dan muat papasan dua bus besar.</textarea>
                        </div>

                        <!-- Nomor WhatsApp CS -->
                        <div class="mb-5">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-2">
                                <label class="form-label fw-bold text-navy small mb-0">Nomor WhatsApp Pengelola / Customer Service Resmi <span class="text-danger">*</span></label>
                                <span class="badge bg-success bg-opacity-10 text-success fw-semibold border border-success-subtle rounded-pill px-2 py-1" style="font-size: 0.72rem;">
                                    <i class="bi bi-check2-circle me-1"></i> Notifikasi pemesanan & verifikasi instan
                                </span>
                            </div>
                            <div class="input-group input-group-lg rounded-3">
                                <span class="input-group-text bg-light text-muted border-end-0 fs-6 fw-semibold">+62</span>
                                <input type="text" class="form-control fs-6 border-start-0" name="phone" placeholder="812-xxxx-xxxx" value="813-9090-4421" required>
                            </div>
                        </div>

                        <!-- ============================================== -->
                        <!-- SECTION 03: FOTO SAMPUL & GALERI DESTINASI -->
                        <!-- ============================================== -->
                        <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom pt-3">
                            <div>
                                <h5 class="fw-bold text-navy mb-1 d-flex align-items-center gap-2" style="font-size: 1.05rem;">
                                    <i class="bi bi-images text-success"></i> Foto Sampul & Galeri Destinasi
                                </h5>
                                <p class="text-muted small mb-0">Unggah foto berkualitas tinggi untuk tampilan katalog wisatawan.</p>
                            </div>
                            <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill small">Minimal 3 Foto</span>
                        </div>

                        <!-- Drag & Drop Upload Zone -->
                        <div class="upload-dropzone p-4 p-md-5 text-center mb-4" onclick="document.getElementById('inputUploadFoto').click();">
                            <input type="file" id="inputUploadFoto" class="d-none" multiple accept="image/png, image/jpeg, image/webp">
                            
                            <div class="bg-white rounded-circle shadow-sm mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 58px; height: 58px;">
                                <i class="bi bi-cloud-arrow-up text-success fs-3"></i>
                            </div>
                            
                            <p class="text-navy fw-semibold mb-1 fs-6">
                                Tarik & letakkan foto di sini, atau <span class="text-success text-decoration-underline fw-bold">Klik untuk Memilih Berkas</span>
                            </p>
                            <p class="text-muted small mb-3">
                                Format JPG, PNG, atau WEBP maks 5MB per foto. Disarankan minimal 3 foto beresolusi tinggi dengan orientasi lanskap (16:9).
                            </p>

                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                <span class="badge bg-white text-secondary border border-light-subtle rounded-pill px-3 py-2 fw-semibold" style="font-size: 0.72rem;">
                                    Resolusi Rekomendasi: 1920&times;1080px
                                </span>
                                <span class="badge bg-white text-secondary border border-light-subtle rounded-pill px-3 py-2 fw-semibold" style="font-size: 0.72rem;">
                                    Bebas Watermark Promosi Luar
                                </span>
                            </div>
                        </div>

                        <!-- Uploaded Photos List -->
                        <div class="mb-5">
                            <div class="text-uppercase text-muted fw-bold mb-3" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                                FOTO YANG BERHASIL TERUNGGAH (2 DARI 3 FOTO)
                            </div>

                            <div class="row g-3" id="uploadedPhotosContainer">
                                <!-- File 1: Utama -->
                                <div class="col-md-6" id="photoItem1">
                                    <div class="uploaded-file-card d-flex align-items-center gap-3">
                                        <div class="position-relative rounded-2 overflow-hidden flex-shrink-0" style="width: 54px; height: 54px;">
                                            <img src="{{ asset('images/gunung-selamet.jpg') }}" alt="Foto Utama" class="w-100 h-100 object-fit-cover">
                                            <span class="position-absolute bottom-0 start-0 end-0 bg-navy-dark text-white text-center fw-bold" style="font-size: 0.55rem; padding: 1px 0;">UTAMA</span>
                                        </div>
                                        <div class="flex-grow-1 min-w-0">
                                            <div class="fw-bold text-navy text-truncate small">foto_utama_lanskap.jpg</div>
                                            <div class="text-success d-flex align-items-center gap-1" style="font-size: 0.72rem;">
                                                <i class="bi bi-check-circle-fill"></i> 2.4 MB &bull; Siap Publish
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-link text-muted p-1 hover-danger" onclick="document.getElementById('photoItem1').remove();" title="Hapus foto">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- File 2 -->
                                <div class="col-md-6" id="photoItem2">
                                    <div class="uploaded-file-card d-flex align-items-center gap-3">
                                        <div class="position-relative rounded-2 overflow-hidden flex-shrink-0" style="width: 54px; height: 54px;">
                                            <img src="{{ asset('images/menara pandang.webp') }}" alt="Area Parkir" class="w-100 h-100 object-fit-cover">
                                        </div>
                                        <div class="flex-grow-1 min-w-0">
                                            <div class="fw-bold text-navy text-truncate small">area_parkir_dan_loket.jpg</div>
                                            <div class="text-success d-flex align-items-center gap-1" style="font-size: 0.72rem;">
                                                <i class="bi bi-check-circle-fill"></i> 1.8 MB &bull; Siap Publish
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-link text-muted p-1 hover-danger" onclick="document.getElementById('photoItem2').remove();" title="Hapus foto">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ============================================== -->
                        <!-- SECTION 04: KELENGKAPAN FASILITAS WISATA -->
                        <!-- ============================================== -->
                        <div class="mb-3 pb-2 border-bottom pt-3">
                            <h5 class="fw-bold text-navy mb-1 d-flex align-items-center gap-2" style="font-size: 1.05rem;">
                                <i class="bi bi-grid text-success"></i> Kelengkapan Fasilitas Destinasi
                            </h5>
                            <p class="text-muted small mb-0">Pilih fasilitas yang tersedia untuk membantu penyaringan fitur pencarian wisatawan.</p>
                        </div>

                        <!-- Interactive Facility Chips Grid -->
                        <div class="d-flex flex-wrap gap-2 mb-5">
                            <!-- 1. Parkir Luas & Bus (Checked) -->
                            <div>
                                <input type="checkbox" id="fac1" class="d-none facility-toggle-input" name="facilities[]" value="Parkir Luas & Bus" checked>
                                <label for="fac1" class="facility-toggle-label">
                                    <i class="bi bi-p-circle-fill"></i> Parkir Luas & Bus
                                </label>
                            </div>

                            <!-- 2. Mushola Bersih (Checked) -->
                            <div>
                                <input type="checkbox" id="fac2" class="d-none facility-toggle-input" name="facilities[]" value="Mushola Bersih" checked>
                                <label for="fac2" class="facility-toggle-label">
                                    <i class="bi bi-moon-stars-fill"></i> Mushola Bersih
                                </label>
                            </div>

                            <!-- 3. Toilet & Bilas (Checked) -->
                            <div>
                                <input type="checkbox" id="fac3" class="d-none facility-toggle-input" name="facilities[]" value="Toilet & Bilas" checked>
                                <label for="fac3" class="facility-toggle-label">
                                    <i class="bi bi-droplet-fill"></i> Toilet & Bilas
                                </label>
                            </div>

                            <!-- 4. Akses WiFi Gratis (Checked) -->
                            <div>
                                <input type="checkbox" id="fac4" class="d-none facility-toggle-input" name="facilities[]" value="Akses WiFi Gratis" checked>
                                <label for="fac4" class="facility-toggle-label">
                                    <i class="bi bi-wifi"></i> Akses WiFi Gratis
                                </label>
                            </div>

                            <!-- 5. Warung Makan & Kafe (Checked) -->
                            <div>
                                <input type="checkbox" id="fac5" class="d-none facility-toggle-input" name="facilities[]" value="Warung Makan & Kafe" checked>
                                <label for="fac5" class="facility-toggle-label">
                                    <i class="bi bi-cup-hot-fill"></i> Warung Makan & Kafe
                                </label>
                            </div>

                            <!-- 6. Ramah Anak & Difabel (Checked) -->
                            <div>
                                <input type="checkbox" id="fac6" class="d-none facility-toggle-input" name="facilities[]" value="Ramah Anak & Difabel" checked>
                                <label for="fac6" class="facility-toggle-label">
                                    <i class="bi bi-person-wheelchair"></i> Ramah Anak & Difabel
                                </label>
                            </div>

                            <!-- 7. Pembayaran QRIS Resmi (Checked) -->
                            <div>
                                <input type="checkbox" id="fac7" class="d-none facility-toggle-input" name="facilities[]" value="Pembayaran QRIS Resmi" checked>
                                <label for="fac7" class="facility-toggle-label">
                                    <i class="bi bi-qr-code-scan"></i> Pembayaran QRIS Resmi
                                </label>
                            </div>

                            <!-- 8. Area Camping Ground (Unchecked) -->
                            <div>
                                <input type="checkbox" id="fac8" class="d-none facility-toggle-input" name="facilities[]" value="Area Camping Ground">
                                <label for="fac8" class="facility-toggle-label">
                                    <i class="bi bi-tree-fill"></i> Area Camping Ground
                                </label>
                            </div>

                            <!-- 9. Stasiun Pengisian Daya / Colokan (Unchecked) -->
                            <div>
                                <input type="checkbox" id="fac9" class="d-none facility-toggle-input" name="facilities[]" value="Stasiun Pengisian Daya / Colokan">
                                <label for="fac9" class="facility-toggle-label">
                                    <i class="bi bi-lightning-charge-fill"></i> Stasiun Pengisian Daya / Colokan
                                </label>
                            </div>
                        </div>

                        <!-- ============================================== -->
                        <!-- BOTTOM ACTIONS (NAVIGATION & SUBMIT) -->
                        <!-- ============================================== -->
                        <div class="pt-4 border-top border-light-subtle d-flex flex-column flex-sm-row align-items-center justify-content-between gap-3">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold small w-100 w-sm-auto" onclick="goToStep(1)">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </button>
                            <div class="d-flex align-items-center gap-2 w-100 w-sm-auto justify-content-end">
                                <button type="button" class="btn btn-light border border-slate-200 rounded-pill px-4 py-2 fw-semibold text-secondary small">
                                    <i class="bi bi-bookmark me-1"></i> Simpan Draf
                                </button>
                                <button type="button" class="btn btn-green rounded-pill px-4 py-2 fw-bold text-white small shadow-sm" onclick="goToStep(3)">
                                    Lanjutkan ke Langkah 3 <i class="bi bi-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- ============================================================== -->
                    <!-- KONTEN LANGKAH 3: UPLOAD LEGALITAS & DOKUMEN PERIZINAN        -->
                    <!-- ============================================================== -->
                    <div id="step3Container" style="{{ ($step ?? 1) == 3 ? 'display: block;' : 'display: none;' }}">

                        <!-- ============================================== -->
                        <!-- SECTION 01: LEGALITAS & PERIZINAN BERUSAHA -->
                        <!-- ============================================== -->
                        <div class="mb-4 pb-2 border-bottom">
                            <h5 class="fw-bold text-navy mb-1 d-flex align-items-center gap-2" style="font-size: 1.05rem;">
                                <i class="bi bi-file-earmark-check text-success"></i> Legalitas & Perizinan Berusaha
                            </h5>
                            <p class="text-muted small mb-0">Nomor izin berusaha OSS-RBA dan status legalitas pengelolaan lahan destinasi.</p>
                        </div>

                        <!-- NIB & NPWP -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="form-label fw-bold text-navy small mb-0">Nomor Induk Berusaha (NIB OSS RBA) <span class="text-danger">*</span></label>
                                    <span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1" style="font-size: 0.68rem;">
                                        <i class="bi bi-patch-check-fill me-1"></i> Terkoneksi OSS
                                    </span>
                                </div>
                                <div class="input-group input-group-lg rounded-3">
                                    <span class="input-group-text bg-light text-muted border-end-0 fs-6"><i class="bi bi-file-earmark-check"></i></span>
                                    <input type="text" class="form-control fs-6 border-start-0" id="step3NibInput" name="business_nib" placeholder="13 Digit Angka NIB" value="1289000451234" maxlength="13" required>
                                </div>
                                <small class="text-muted d-block mt-1" style="font-size: 0.73rem;">Nomor legalitas resmi dari sistem OSS Kementerian Investasi / BKPM</small>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="form-label fw-bold text-navy small mb-0">Nomor Pokok Wajib Pajak (NPWP) <span class="text-danger">*</span></label>
                                </div>
                                <div class="input-group input-group-lg rounded-3">
                                    <span class="input-group-text bg-light text-muted border-end-0 fs-6"><i class="bi bi-credit-card-2-front"></i></span>
                                    <input type="text" class="form-control fs-6 border-start-0" id="step3NpwpInput" name="business_npwp" placeholder="16 Digit NPWP Usaha / Pribadi" value="08.123.456.7-521.000" required>
                                </div>
                                <small class="text-muted d-block mt-1" style="font-size: 0.73rem;">NPWP badan usaha, koperasi, yayasan, atau penanggung jawab</small>
                            </div>
                        </div>

                        <!-- Izin Lingkungan & Status Lahan -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-navy small mb-2">Izin Lingkungan / Surat Rekomendasi <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg rounded-3 fs-6" id="step3IzinSelect" name="env_permit" required>
                                    <option value="SPPL (Surat Pernyataan Pengelolaan Lingkungan)" selected>SPPL (Surat Pernyataan Pengelolaan Lingkungan)</option>
                                    <option value="UKL-UPL (Upaya Pengelolaan & Pemantauan)">UKL-UPL (Upaya Pengelolaan & Pemantauan)</option>
                                    <option value="Surat Rekomendasi POKDARWIS & Desa">Surat Keputusan / Rekomendasi POKDARWIS Desa</option>
                                    <option value="AMDAL (Analisis Mengenai Dampak Lingkungan)">AMDAL (Analisis Mengenai Dampak Lingkungan)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-navy small mb-2">Status Hak Pengelolaan / Lahan <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg rounded-3 fs-6" id="step3LahanSelect" name="land_status" required>
                                    <option value="Kerjasama Perhutani (PKS KPH)" selected>Kerjasama Perhutani (PKS KPH Banyumas Timur/Barat)</option>
                                    <option value="Milik Sendiri (SHM / SHGB)">Milik Sendiri (Sertifikat SHM / SHGB)</option>
                                    <option value="Tanah Kas Desa / Bengkok">Tanah Kas Desa / Bengkok (Izin Pemdes)</option>
                                    <option value="Perjanjian Sewa / Kontrak Usaha">Perjanjian Sewa / Kontrak Usaha</option>
                                </select>
                            </div>
                        </div>

                        <!-- ============================================== -->
                        <!-- SECTION 02: UNGGAH BERKAS DOKUMEN RESMI -->
                        <!-- ============================================== -->
                        <div class="mb-3 pb-2 border-bottom pt-3">
                            <h5 class="fw-bold text-navy mb-1 d-flex align-items-center gap-2" style="font-size: 1.05rem;">
                                <i class="bi bi-file-earmark-arrow-up text-success"></i> Berkas Dokumen Persyaratan
                            </h5>
                            <p class="text-muted small mb-0">Unggah berkas untuk proses verifikasi kurasi oleh Dinporabudpar Banyumas.</p>
                        </div>

                        <p class="text-secondary small mb-3">
                            Unggah berkas resmi beresolusi jelas untuk proses kurasi verifikasi lapangan oleh Dinporabudpar Banyumas (Maksimal 10MB per berkas):
                        </p>

                        <!-- Uploaded Documents List Cards -->
                        <div class="row g-3 mb-4">
                            <!-- Dokumen 1: NIB OSS -->
                            <div class="col-12" id="docItem1">
                                <div class="uploaded-file-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center gap-3 min-w-0">
                                        <div class="bg-danger bg-opacity-10 text-danger rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                                            <i class="bi bi-file-earmark-pdf-fill fs-4"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="d-flex align-items-center gap-2">
                                                <strong class="text-navy text-truncate small">Scan NIB OSS-RBA Resmi (KBLI 93293)</strong>
                                                <span class="badge bg-danger bg-opacity-10 text-danger fw-bold" style="font-size: 0.65rem;">WAJIB</span>
                                            </div>
                                            <span class="text-muted d-block small" style="font-size: 0.73rem;">NIB_OSS_HutanPinusLimpakuwus_2024.pdf &bull; 1.4 MB</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                        <span class="badge bg-success bg-opacity-10 text-success fw-semibold px-2 py-1 d-none d-sm-inline-flex align-items-center gap-1" style="font-size: 0.72rem;">
                                            <i class="bi bi-check-circle-fill"></i> Terunggah
                                        </span>
                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="alert('Pratinjau berkas NIB: Berkas resmi OSS-RBA valid.')">
                                            <i class="bi bi-eye me-1"></i> Lihat
                                        </button>
                                        <button type="button" class="btn btn-link text-muted p-1 hover-danger" onclick="document.getElementById('docItem1').remove();" title="Hapus dokumen">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Dokumen 2: KTP Penanggung Jawab -->
                            <div class="col-12" id="docItem2">
                                <div class="uploaded-file-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center gap-3 min-w-0">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                                            <i class="bi bi-person-vcard-fill fs-4"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="d-flex align-items-center gap-2">
                                                <strong class="text-navy text-truncate small">Foto / Scan KTP Penanggung Jawab</strong>
                                                <span class="badge bg-danger bg-opacity-10 text-danger fw-bold" style="font-size: 0.65rem;">WAJIB</span>
                                            </div>
                                            <span class="text-muted d-block small" style="font-size: 0.73rem;">KTP_PenanggungJawab_RizkoAfryan.jpg &bull; 850 KB</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                        <span class="badge bg-success bg-opacity-10 text-success fw-semibold px-2 py-1 d-none d-sm-inline-flex align-items-center gap-1" style="font-size: 0.72rem;">
                                            <i class="bi bi-check-circle-fill"></i> Terunggah
                                        </span>
                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="alert('Pratinjau KTP Penanggung Jawab: Identitas sesuai NIK 3302198765430001.')">
                                            <i class="bi bi-eye me-1"></i> Lihat
                                        </button>
                                        <button type="button" class="btn btn-link text-muted p-1 hover-danger" onclick="document.getElementById('docItem2').remove();" title="Hapus dokumen">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Dokumen 3: SK POKDARWIS / Rekomendasi Desa -->
                            <div class="col-12" id="docItem3">
                                <div class="uploaded-file-card d-flex align-items-center justify-content-between p-3">
                                    <div class="d-flex align-items-center gap-3 min-w-0">
                                        <div class="bg-success bg-opacity-10 text-success rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px;">
                                            <i class="bi bi-award-fill fs-4"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="d-flex align-items-center gap-2">
                                                <strong class="text-navy text-truncate small">SK POKDARWIS / Surat Perjanjian Kerjasama Lahan (PKS)</strong>
                                                <span class="badge bg-success bg-opacity-10 text-success fw-bold" style="font-size: 0.65rem;">TERSEDIA</span>
                                            </div>
                                            <span class="text-muted d-block small" style="font-size: 0.73rem;">SK_Desa_Rekomendasi_POKDARWIS_2024.pdf &bull; 2.1 MB</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                        <span class="badge bg-success bg-opacity-10 text-success fw-semibold px-2 py-1 d-none d-sm-inline-flex align-items-center gap-1" style="font-size: 0.72rem;">
                                            <i class="bi bi-check-circle-fill"></i> Terunggah
                                        </span>
                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="alert('Pratinjau SK Rekomendasi: Surat Izin Pengelolaan Wilayah Wisata Limpakuwus terlampir.')">
                                            <i class="bi bi-eye me-1"></i> Lihat
                                        </button>
                                        <button type="button" class="btn btn-link text-muted p-1 hover-danger" onclick="document.getElementById('docItem3').remove();" title="Hapus dokumen">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Optional Upload Dropzone -->
                        <div class="upload-dropzone p-3 p-md-4 text-center mb-5" onclick="document.getElementById('inputUploadDocTambahan').click();">
                            <input type="file" id="inputUploadDocTambahan" class="d-none" multiple accept=".pdf, image/png, image/jpeg">
                            <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                                <i class="bi bi-file-earmark-arrow-up text-success fs-5"></i>
                                <span class="fw-semibold text-navy small">Unggah Berkas Pendukung Tambahan Lainnya (Opsional)</span>
                            </div>
                            <small class="text-muted" style="font-size: 0.75rem;">Format PDF/JPG/PNG maksimal 10MB per file (Contoh: Polis Asuransi Pengunjung, Dokumen SPPL, dsb)</small>
                        </div>

                        <!-- ============================================== -->
                        <!-- SECTION 03: REKENING PENYALURAN DANA TIKET -->
                        <!-- ============================================== -->
                        <div class="mb-3 pb-2 border-bottom pt-3">
                            <h5 class="fw-bold text-navy mb-1 d-flex align-items-center gap-2" style="font-size: 1.05rem;">
                                <i class="bi bi-bank text-success"></i> Rekening Penyaluran Pendapatan Tiket
                            </h5>
                            <p class="text-muted small mb-0">Rekening resmi pengelola untuk pencairan tiket online & QRIS DOKEMAS.</p>
                        </div>

                        <div class="p-3 rounded-3 bg-light border border-light-subtle mb-4">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-info-circle-fill text-success fs-5"></i>
                                <small class="text-secondary" style="font-size: 0.78rem; line-height: 1.5;">
                                    Penyaluran dana penjualan tiket melalui portal DOKEMAS & QRIS resmi ditransfer otomatis setiap hari kerja (H+1) langsung ke rekening pengelola tanpa potongan administrasi tambahan.
                                </small>
                            </div>
                        </div>

                        <!-- Row Bank, Nomor Rekening, Pemilik -->
                        <div class="row g-3 mb-5">
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-navy small mb-2">Nama Bank Mitra <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg rounded-3 fs-6" id="step3BankSelect" name="bank_name" required>
                                    <option value="Bank Jateng" selected>Bank Jateng (Rekomendasi Pemkab Banyumas)</option>
                                    <option value="BCA">BCA (Bank Central Asia)</option>
                                    <option value="BRI">BRI (Bank Rakyat Indonesia)</option>
                                    <option value="Bank Mandiri">Bank Mandiri</option>
                                    <option value="BNI">BNI (Bank Negara Indonesia)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-navy small mb-2">Nomor Rekening <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg rounded-3 fs-6" id="step3RekeningNo" name="bank_account_number" placeholder="Contoh: 100239482819" value="1002-3948-2819" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-navy small mb-2">Nama Pemilik Rekening <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg rounded-3 fs-6" id="step3RekeningName" name="bank_account_holder" placeholder="Sesuai buku rekening" value="Hutan Pinus Limpakuwus Baturraden" required>
                            </div>
                        </div>

                        <!-- Bottom Actions Langkah 3 -->
                        <div class="pt-4 border-top border-light-subtle d-flex flex-column flex-sm-row align-items-center justify-content-between gap-3">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold small w-100 w-sm-auto" onclick="goToStep(2)">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </button>
                            <div class="d-flex align-items-center gap-2 w-100 w-sm-auto justify-content-end">
                                <button type="button" class="btn btn-light border border-slate-200 rounded-pill px-4 py-2 fw-semibold text-secondary small">
                                    <i class="bi bi-bookmark me-1"></i> Simpan Draf
                                </button>
                                <button type="button" class="btn btn-green rounded-pill px-4 py-2 fw-bold text-white small shadow-sm" onclick="goToStep(4)">
                                    Lanjutkan ke Langkah 4 <i class="bi bi-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- ============================================================== -->
                    <!-- KONTEN LANGKAH 4: REVIEW & KONFIRMASI PENDAFTARAN             -->
                    <!-- ============================================================== -->
                    <div id="step4Container" style="{{ ($step ?? 1) == 4 ? 'display: block;' : 'display: none;' }}">

                        <!-- Banner Info Siap Kirim -->
                        <div class="alert alert-success d-flex align-items-start gap-3 rounded-4 p-3 mb-4 border-0 bg-success bg-opacity-10">
                            <i class="bi bi-patch-check-fill text-success fs-3 flex-shrink-0 mt-n1"></i>
                            <div>
                                <strong class="text-navy d-block mb-1" style="font-size: 0.95rem;">Langkah Terakhir: Tinjau & Konfirmasi Pendaftaran Mitra</strong>
                                <p class="text-secondary mb-0 small" style="line-height: 1.5;">
                                    Silakan periksa kembali seluruh ringkasan data destinasi, identitas penanggung jawab, dan berkas perizinan sebelum dikirimkan ke tim kurasi Dinporabudpar Kabupaten Banyumas.
                                </p>
                            </div>
                        </div>

                        <!-- 3 Review Cards Section -->
                        <div class="row g-3 mb-4">
                            <!-- Review Card 1: Pengelola & Akun -->
                            <div class="col-12">
                                <div class="card border border-light-subtle rounded-4 p-3 p-md-4 bg-light bg-opacity-50">
                                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom border-light-subtle pb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-person-circle text-success fs-5"></i>
                                            <strong class="text-navy small">Data Pengelola & Akun Resmi</strong>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 py-1" onclick="goToStep(1)">
                                            <i class="bi bi-pencil-square me-1"></i> Ubah
                                        </button>
                                    </div>
                                    <div class="row g-2 small text-secondary">
                                        <div class="col-sm-6">
                                            <span class="text-muted d-block" style="font-size: 0.72rem;">NAMA LENGKAP PENANGGUNG JAWAB:</span>
                                            <strong class="text-navy fs-6" id="revOwnerName">Rizko Afryan Santoso</strong>
                                        </div>
                                        <div class="col-sm-6">
                                            <span class="text-muted d-block" style="font-size: 0.72rem;">NOMOR INDUK KEPENDUDUKAN (NIK):</span>
                                            <strong class="text-navy fs-6" id="revOwnerNik">3302198765430001</strong>
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <span class="text-muted d-block" style="font-size: 0.72rem;">ENTITAS & JABATAN:</span>
                                            <span class="text-navy fw-semibold" id="revEntity">Perorangan &bull; Ketua Tim Pengelola</span>
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <span class="text-muted d-block" style="font-size: 0.72rem;">WHATSAPP & EMAIL TERVERIFIKASI:</span>
                                            <span class="text-navy fw-semibold" id="revContact">+62 813-9090-4421 &bull; mitra@dokemas.banyumaskab.go.id</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Review Card 2: Destinasi & Fasilitas -->
                            <div class="col-12">
                                <div class="card border border-light-subtle rounded-4 p-3 p-md-4 bg-light bg-opacity-50">
                                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom border-light-subtle pb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-geo-alt-fill text-success fs-5"></i>
                                            <strong class="text-navy small">Detail Destinasi & Fasilitas</strong>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 py-1" onclick="goToStep(2)">
                                            <i class="bi bi-pencil-square me-1"></i> Ubah
                                        </button>
                                    </div>
                                    <div class="row g-2 small text-secondary">
                                        <div class="col-sm-6">
                                            <span class="text-muted d-block" style="font-size: 0.72rem;">NAMA DESTINASI / USAHA:</span>
                                            <strong class="text-navy fs-6" id="revDestName">Hutan Pinus Limpakuwus Baturraden</strong>
                                        </div>
                                        <div class="col-sm-6">
                                            <span class="text-muted d-block" style="font-size: 0.72rem;">KATEGORI & HARGA TIKET / SEWA:</span>
                                            <span class="badge bg-success bg-opacity-10 text-success fw-bold me-1" id="revCategory">Wisata Alam & Pegunungan</span>
                                            <strong class="text-navy" id="revPrice">Rp 15.000 (tiket)</strong>
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <span class="text-muted d-block" style="font-size: 0.72rem;">JAM OPERASIONAL:</span>
                                            <span class="text-navy fw-semibold" id="revHours">08:00 - 17:00 WIB (Setiap Hari)</span>
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <span class="text-muted d-block" style="font-size: 0.72rem;">KECAMATAN & TITIK GOOGLE MAPS:</span>
                                            <span class="text-navy fw-semibold" id="revLocation">Baturraden, Kab. Banyumas &bull; Terhubung Maps</span>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <span class="text-muted d-block mb-1" style="font-size: 0.72rem;">FASILITAS UTAMA AKTIF:</span>
                                            <div class="d-flex flex-wrap gap-1" id="revFacilitiesList">
                                                <span class="badge bg-white text-navy border border-light-subtle rounded-pill px-2 py-1"><i class="bi bi-p-circle-fill text-success me-1"></i> Parkir Luas</span>
                                                <span class="badge bg-white text-navy border border-light-subtle rounded-pill px-2 py-1"><i class="bi bi-moon-stars-fill text-success me-1"></i> Mushola</span>
                                                <span class="badge bg-white text-navy border border-light-subtle rounded-pill px-2 py-1"><i class="bi bi-droplet-fill text-success me-1"></i> Toilet Bersih</span>
                                                <span class="badge bg-white text-navy border border-light-subtle rounded-pill px-2 py-1"><i class="bi bi-wifi text-success me-1"></i> WiFi Gratis</span>
                                                <span class="badge bg-white text-navy border border-light-subtle rounded-pill px-2 py-1"><i class="bi bi-cup-hot-fill text-success me-1"></i> Warung Makan</span>
                                                <span class="badge bg-white text-navy border border-light-subtle rounded-pill px-2 py-1"><i class="bi bi-qr-code-scan text-success me-1"></i> QRIS Resmi</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Review Card 3: Dokumen Legalitas & Rekening -->
                            <div class="col-12">
                                <div class="card border border-light-subtle rounded-4 p-3 p-md-4 bg-light bg-opacity-50">
                                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom border-light-subtle pb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-file-earmark-lock-fill text-success fs-5"></i>
                                            <strong class="text-navy small">Legalitas, Berkas & Rekening</strong>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 py-1" onclick="goToStep(3)">
                                            <i class="bi bi-pencil-square me-1"></i> Ubah
                                        </button>
                                    </div>
                                    <div class="row g-2 small text-secondary">
                                        <div class="col-sm-6">
                                            <span class="text-muted d-block" style="font-size: 0.72rem;">NOMOR INDUK BERUSAHA (NIB OSS):</span>
                                            <strong class="text-navy" id="revNib">1289000451234 (KBLI 93293)</strong>
                                        </div>
                                        <div class="col-sm-6">
                                            <span class="text-muted d-block" style="font-size: 0.72rem;">NPWP RESMI:</span>
                                            <strong class="text-navy" id="revNpwp">08.123.456.7-521.000</strong>
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <span class="text-muted d-block" style="font-size: 0.72rem;">STATUS LAHAN & IZIN:</span>
                                            <span class="text-navy fw-semibold" id="revLahan">Kerjasama Perhutani (PKS KPH) & SPPL</span>
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                            <span class="text-muted d-block" style="font-size: 0.72rem;">REKENING PENYALURAN DANA TIKET:</span>
                                            <span class="text-navy fw-semibold" id="revBank">Bank Jateng &bull; 1002-3948-2819 an. Hutan Pinus Limpakuwus</span>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <span class="text-muted d-block mb-1" style="font-size: 0.72rem;">BERKAS RESMI TERLAMPIR:</span>
                                            <div class="d-flex flex-wrap gap-2">
                                                <span class="badge bg-white text-navy border border-light-subtle px-2 py-1"><i class="bi bi-file-earmark-pdf-fill text-danger me-1"></i> Scan NIB OSS (1.4 MB)</span>
                                                <span class="badge bg-white text-navy border border-light-subtle px-2 py-1"><i class="bi bi-person-vcard-fill text-primary me-1"></i> Scan KTP (850 KB)</span>
                                                <span class="badge bg-white text-navy border border-light-subtle px-2 py-1"><i class="bi bi-award-fill text-success me-1"></i> SK POKDARWIS / PKS (2.1 MB)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pakta Integritas Section -->
                        <div class="mb-3 pb-2 border-bottom pt-3">
                            <h5 class="fw-bold text-navy mb-1 d-flex align-items-center gap-2" style="font-size: 1.05rem;">
                                <i class="bi bi-clipboard-check text-success"></i> Pakta Integritas & Persetujuan Kemitraan
                            </h5>
                            <p class="text-muted small mb-0">Pernyataan kesanggupan pengelolaan dan pemenuhan standar pelayanan pariwisata.</p>
                        </div>

                        <!-- 3 Checklist Persetujuan -->
                        <div class="p-4 rounded-4 bg-light border border-light-subtle mb-4">
                            <div class="form-check d-flex align-items-start gap-2 mb-3">
                                <input class="form-check-input mt-1 flex-shrink-0" type="checkbox" id="agreeRule1" checked required>
                                <label class="form-check-label small text-secondary" for="agreeRule1" style="font-size: 0.82rem; line-height: 1.5;">
                                    <strong class="text-navy d-block">Keabsahan Data & Dokumen:</strong>
                                    Saya menjamin dengan sesungguhnya bahwa seluruh data profil destinasi, legalitas, kepemilikan/pengelolaan lahan, dan berkas perizinan yang dilampirkan adalah benar, sah, dan dapat dipertanggungjawabkan sesuai hukum Republik Indonesia.
                                </label>
                            </div>
                            <div class="form-check d-flex align-items-start gap-2 mb-3">
                                <input class="form-check-input mt-1 flex-shrink-0" type="checkbox" id="agreeRule2" checked required>
                                <label class="form-check-label small text-secondary" for="agreeRule2" style="font-size: 0.82rem; line-height: 1.5;">
                                    <strong class="text-navy d-block">Standar Pelayanan & CHSE Banyumas:</strong>
                                    Bersedia menerapkan standar kebersihan, kesehatan, keselamatan, dan kelestarian lingkungan (CHSE), menjaga keasrian alam Banyumas, serta memberikan pelayanan terbaik dan transparan kepada seluruh wisatawan.
                                </label>
                            </div>
                            <div class="form-check d-flex align-items-start gap-2">
                                <input class="form-check-input mt-1 flex-shrink-0" type="checkbox" id="agreeRule3" checked required>
                                <label class="form-check-label small text-secondary" for="agreeRule3" style="font-size: 0.82rem; line-height: 1.5;">
                                    <strong class="text-navy d-block">Integrasi Sistem & Kunjungan Kurasi Dinporabudpar:</strong>
                                    Menyetujui pendaftaran profil destinasi ke dalam ekosistem portal terpadu DOKEMAS dan bersedia menerima pendampingan serta verifikasi lapangan oleh Dinas Pemuda, Olahraga, Kebudayaan dan Pariwisata (Dinporabudpar) Kab. Banyumas.
                                </label>
                            </div>
                        </div>

                        <!-- Digital Signature Declaration -->
                        <div class="card border border-success-subtle bg-success bg-opacity-10 rounded-4 p-4 mb-5">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-7">
                                    <span class="text-uppercase text-success fw-bold d-block" style="font-size: 0.7rem; letter-spacing: 0.5px;">PERNYATAAN ELEKTRONIK PENANGGUNG JAWAB</span>
                                    <h6 class="fw-bold text-navy mb-1" id="sigNameDisplay">Rizko Afryan Santoso</h6>
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">Disahkan secara elektronik melalui verifikasi WhatsApp aktif pada tanggal <span id="sigDateDisplay">{{ date('d F Y') }}</span></small>
                                </div>
                                <div class="col-md-5 text-md-end">
                                    <span class="badge bg-white text-success border border-success-subtle rounded-pill px-3 py-2 fw-bold" style="font-size: 0.78rem;">
                                        <i class="bi bi-shield-check me-1"></i> Tanda Tangan Digital Sah
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Actions Langkah 4 -->
                        <div class="pt-4 border-top border-light-subtle d-flex flex-column flex-sm-row align-items-center justify-content-between gap-3">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold small w-100 w-sm-auto" onclick="goToStep(3)">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </button>
                            <div class="d-flex align-items-center gap-2 w-100 w-sm-auto justify-content-end">
                                <button type="button" class="btn btn-light border border-slate-200 rounded-pill px-4 py-2 fw-semibold text-secondary small" onclick="window.print()">
                                    <i class="bi bi-printer me-1"></i> Cetak Ringkasan
                                </button>
                                <button type="button" class="btn btn-green rounded-pill px-4 py-2 fw-bold text-white small shadow-sm" onclick="submitPendaftaranMitra()">
                                    <i class="bi bi-check2-circle me-1"></i> Kirim Pendaftaran
                                </button>
                            </div>
                        </div>
                        </div>

                    </div>

                </form>
            </div>
        </div>

    </div>

</div>

<!-- ============================================================== -->
<!-- MODAL POPUP PENDAFTARAN BERHASIL                              -->
<!-- ============================================================== -->
<div class="modal fade" id="modalPendaftaranBerhasil" tabindex="-1" aria-labelledby="modalPendaftaranLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <!-- Modal Header Pattern -->
            <div class="p-4 p-md-5 text-center bg-navy-main text-white position-relative">
                <div class="bg-white bg-opacity-10 rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 76px; height: 76px;">
                    <i class="bi bi-check2-circle text-success" style="font-size: 3rem;"></i>
                </div>
                <h4 class="fw-bold mb-2">Pendaftaran Mitra Berhasil Dikirim!</h4>
                <p class="text-white-50 small mb-0 mx-auto" style="max-width: 520px; line-height: 1.6;">
                    Data profil destinasi dan berkas legalitas Anda telah berhasil kami terima dalam sistem resmi Dinporabudpar Kabupaten Banyumas.
                </p>
            </div>

            <!-- Modal Body Details -->
            <div class="p-4 p-md-4 bg-white">
                <div class="card border border-light-subtle rounded-3 p-3 bg-light mb-4">
                    <div class="row g-2 align-items-center text-center text-sm-start">
                        <div class="col-sm-6">
                            <span class="text-muted d-block" style="font-size: 0.72rem;">KODE PENDAFTARAN RESMI:</span>
                            <span class="fw-bold text-navy fs-5" style="letter-spacing: 1px;">REG-DKM-2026-08849</span>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-2 rounded-pill" style="font-size: 0.78rem;">
                                <i class="bi bi-hourglass-split me-1"></i> Menunggu Kurasi (1x24 Jam)
                            </span>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-start gap-3 mb-3 p-3 rounded-3 border border-light-subtle">
                    <i class="bi bi-whatsapp text-success fs-3 flex-shrink-0"></i>
                    <div>
                        <strong class="text-navy d-block small mb-1">Notifikasi Status Otomatis via WhatsApp</strong>
                        <p class="text-secondary small mb-0" style="line-height: 1.45;">
                            Kode akses portal mitra dan hasil kurasi kelayakan destinasi akan dikirimkan langsung ke nomor WhatsApp <strong class="text-navy">+62 813-9090-4421</strong>.
                        </p>
                    </div>
                </div>

                <div class="d-flex align-items-start gap-3 p-3 rounded-3 border border-light-subtle">
                    <i class="bi bi-qr-code text-navy fs-3 flex-shrink-0"></i>
                    <div>
                        <strong class="text-navy d-block small mb-1">Penerbitan QRIS & Brosur Resmi DOKEMAS</strong>
                        <p class="text-secondary small mb-0" style="line-height: 1.45;">
                            Setelah terverifikasi, destinasi Anda akan otomatis terbit di katalog publik DOKEMAS beserta standee QRIS tiket resmi Pemkab Banyumas.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer Actions -->
            <div class="p-4 border-top border-light-subtle bg-light d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold small w-100 w-sm-auto" onclick="window.print()">
                    <i class="bi bi-download me-1"></i> Unduh Tanda Terima (PDF)
                </button>
                <a href="{{ route('home') }}" class="btn btn-green rounded-pill px-4 py-2 fw-bold text-white small w-100 w-sm-auto text-decoration-none">
                    Kembali ke Halaman Utama <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Navigasi Antar Langkah (Multi-Step Onboarding 1 - 4)
    function goToStep(stepNum) {
        const step1 = document.getElementById('step1Container');
        const step2 = document.getElementById('step2Container');
        const step3 = document.getElementById('step3Container');
        const step4 = document.getElementById('step4Container');

        const circle1 = document.getElementById('stepIndicatorCircle1');
        const circle2 = document.getElementById('stepIndicatorCircle2');
        const circle3 = document.getElementById('stepIndicatorCircle3');
        const circle4 = document.getElementById('stepIndicatorCircle4');

        const label1 = document.getElementById('stepIndicatorLabel1');
        const label2 = document.getElementById('stepIndicatorLabel2');
        const label3 = document.getElementById('stepIndicatorLabel3');
        const label4 = document.getElementById('stepIndicatorLabel4');

        const progressText = document.getElementById('stepperProgressText');
        const tipsContent = document.getElementById('sidebarTipsContent');

        // Sembunyikan semua step terlebih dahulu
        if (step1) step1.style.display = 'none';
        if (step2) step2.style.display = 'none';
        if (step3) step3.style.display = 'none';
        if (step4) step4.style.display = 'none';

        // Helper update circle status
        function updateCircle(el, num, current) {
            if (!el) return;
            if (num < current) {
                el.className = 'step-circle completed flex-shrink-0';
                el.innerHTML = '<i class="bi bi-check-lg fs-5"></i>';
            } else if (num === current) {
                el.className = 'step-circle active flex-shrink-0';
                el.innerHTML = num;
            } else {
                el.className = 'step-circle inactive flex-shrink-0';
                el.innerHTML = num;
            }
        }

        updateCircle(circle1, 1, stepNum);
        updateCircle(circle2, 2, stepNum);
        updateCircle(circle3, 3, stepNum);
        updateCircle(circle4, 4, stepNum);

        // Helper update label status
        function setStepLabel(el, num, current, title, desc) {
            if (!el) return;
            const isActive = num === current;
            const isCompleted = num < current;
            const colorClass = (isActive || isCompleted) ? 'text-success fw-semibold' : 'text-muted';
            const titleColorClass = isActive ? 'text-navy fw-bold' : (isCompleted ? 'text-navy fw-semibold' : 'text-secondary fw-semibold');
            el.innerHTML = `
                <span class="${colorClass} d-block" style="font-size: 0.72rem;">Langkah ${num}</span>
                <strong class="d-block ${titleColorClass} text-truncate" style="font-size: 0.88rem;">${title}</strong>
                <small class="text-muted d-block text-truncate" style="font-size: 0.75rem;">${desc}</small>
            `;
        }

        setStepLabel(label1, 1, stepNum, 'Informasi Akun', 'Data kontak & PIC');
        setStepLabel(label2, 2, stepNum, 'Profil Destinasi', 'Lokasi & fasilitas');
        setStepLabel(label3, 3, stepNum, 'Dokumen Legalitas', 'NIB OSS & izin');
        setStepLabel(label4, 4, stepNum, 'Review & Kirim', 'Konfirmasi akhir');

        // Tampilkan Step Terpilih
        if (stepNum === 1) {
            if (step1) step1.style.display = 'block';
            if (progressText) progressText.innerText = 'Progress Pendaftaran: 25% Selesai';
            if (tipsContent) {
                tipsContent.innerHTML = `
                    <strong class="text-success d-block small mb-1">Tips Langkah 1:</strong>
                    <p class="text-secondary mb-0" style="font-size: 0.75rem; line-height: 1.45;">
                        Pastikan data penanggung jawab sesuai KTP dan nomor WhatsApp aktif untuk menerima kode verifikasi OTP instan.
                    </p>
                `;
            }
        } else if (stepNum === 2) {
            if (step2) step2.style.display = 'block';
            if (progressText) progressText.innerText = 'Progress Pendaftaran: 50% Selesai';
            if (tipsContent) {
                tipsContent.innerHTML = `
                    <strong class="text-success d-block small mb-1">Tips Pengisian:</strong>
                    <p class="text-secondary mb-0" style="font-size: 0.75rem; line-height: 1.45;">
                        Unggah foto berformat horizontal (landscape) agar tampil proporsional pada katalog kartu aplikasi wisatawan.
                    </p>
                `;
            }
        } else if (stepNum === 3) {
            if (step3) step3.style.display = 'block';
            if (progressText) progressText.innerText = 'Progress Pendaftaran: 75% Selesai';
            if (tipsContent) {
                tipsContent.innerHTML = `
                    <strong class="text-success d-block small mb-1">Tips Legalitas & Dokumen:</strong>
                    <p class="text-secondary mb-0" style="font-size: 0.75rem; line-height: 1.45;">
                        Pastikan berkas scan NIB OSS, KTP, dan surat rekomendasi/izin terbaca jelas untuk mempermudah validasi kurator Dinporabudpar.
                    </p>
                `;
            }
        } else if (stepNum === 4) {
            if (step4) step4.style.display = 'block';
            if (progressText) progressText.innerText = 'Progress Pendaftaran: 100% Siap Dikirim';
            if (tipsContent) {
                tipsContent.innerHTML = `
                    <strong class="text-success d-block small mb-1">Tips Review & Kirim:</strong>
                    <p class="text-secondary mb-0" style="font-size: 0.75rem; line-height: 1.45;">
                        Periksa kembali seluruh informasi formulir sebelum dikirim. Tim Dinporabudpar akan memverifikasi berkas dalam 1x24 jam kerja.
                    </p>
                `;
            }
            syncReviewData();
        }

        // Update URL query string tanpa reload
        const url = new URL(window.location);
        url.searchParams.set('step', stepNum);
        window.history.pushState({}, '', url);

        // Scroll halus ke atas formulir
        window.scrollTo({ top: 120, behavior: 'smooth' });
    }

    // Sinkronisasi data formulir ke kartu ringkasan review langkah 4
    function syncReviewData() {
        // 1. Data Akun
        const ownerName = document.getElementById('ownerNameInput')?.value || 'Rizko Afryan Santoso';
        const ownerNik = document.getElementById('ownerNikInput')?.value || '3302198765430001';
        const ownerPhone = document.getElementById('step1PhoneInput')?.value || '813-9090-4421';
        const ownerEmail = document.querySelector('input[name="owner_email"]')?.value || 'mitra@dokemas.banyumaskab.go.id';
        const entityType = document.querySelector('select[name="entity_type"]')?.selectedOptions[0]?.text || 'Perorangan';
        const ownerPos = document.querySelector('input[name="owner_position"]')?.value || 'Ketua Tim Pengelola';

        if (document.getElementById('revOwnerName')) document.getElementById('revOwnerName').innerText = ownerName;
        if (document.getElementById('revOwnerNik')) document.getElementById('revOwnerNik').innerText = ownerNik;
        if (document.getElementById('revEntity')) document.getElementById('revEntity').innerText = `${entityType} • ${ownerPos}`;
        if (document.getElementById('revContact')) document.getElementById('revContact').innerText = `+62 ${ownerPhone} • ${ownerEmail}`;
        if (document.getElementById('sigNameDisplay')) document.getElementById('sigNameDisplay').innerText = ownerName;

        // 2. Data Tempat & Fasilitas
        const destName = document.querySelector('input[name="name"]')?.value || 'Hutan Pinus Limpakuwus Baturraden';
        const catSelect = document.querySelector('select[name="category_id"]');
        const catName = catSelect?.selectedOptions[0]?.text || 'Wisata Alam & Pegunungan';
        const priceRange = document.querySelector('input[name="price_range"]')?.value || '15.000 (tiket)';
        const openHours = document.querySelector('input[name="open_hours"]')?.value || '08:00 - 17:00 WIB (Setiap Hari)';
        const subdistrict = document.querySelector('select[name="subdistrict"]')?.value || 'Baturraden';

        if (document.getElementById('revDestName')) document.getElementById('revDestName').innerText = destName;
        if (document.getElementById('revCategory')) document.getElementById('revCategory').innerText = catName;
        if (document.getElementById('revPrice')) document.getElementById('revPrice').innerText = `Rp ${priceRange}`;
        if (document.getElementById('revHours')) document.getElementById('revHours').innerText = openHours;
        if (document.getElementById('revLocation')) document.getElementById('revLocation').innerText = `${subdistrict}, Kab. Banyumas • Terhubung Maps`;

        // 3. Legalitas & Rekening
        const nib = document.getElementById('step3NibInput')?.value || '1289000451234';
        const npwp = document.getElementById('step3NpwpInput')?.value || '08.123.456.7-521.000';
        const izin = document.getElementById('step3IzinSelect')?.value || 'SPPL';
        const lahan = document.getElementById('step3LahanSelect')?.value || 'Kerjasama Perhutani (PKS KPH)';
        const bank = document.getElementById('step3BankSelect')?.value || 'Bank Jateng';
        const rekNo = document.getElementById('step3RekeningNo')?.value || '1002-3948-2819';
        const rekName = document.getElementById('step3RekeningName')?.value || 'Hutan Pinus Limpakuwus Baturraden';

        if (document.getElementById('revNib')) document.getElementById('revNib').innerText = `${nib} (OSS-RBA Aktif)`;
        if (document.getElementById('revNpwp')) document.getElementById('revNpwp').innerText = npwp;
        if (document.getElementById('revLahan')) document.getElementById('revLahan').innerText = `${lahan} & ${izin}`;
        if (document.getElementById('revBank')) document.getElementById('revBank').innerText = `${bank} • ${rekNo} an. ${rekName}`;
    }

    // Aksi submit pendaftaran resmi
    function submitPendaftaranMitra() {
        const check1 = document.getElementById('agreeRule1');
        const check2 = document.getElementById('agreeRule2');
        const check3 = document.getElementById('agreeRule3');
        if ((check1 && !check1.checked) || (check2 && !check2.checked) || (check3 && !check3.checked)) {
            alert('Mohon menyetujui seluruh pakta integritas dan regulasi kemitraan resmi terlebih dahulu.');
            return;
        }

        const modalEl = document.getElementById('modalPendaftaranBerhasil');
        if (!modalEl) return;

        if (window.bootstrap && window.bootstrap.Modal) {
            const modal = new window.bootstrap.Modal(modalEl);
            modal.show();
        } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        } else {
            modalEl.classList.add('show');
            modalEl.style.display = 'block';
            document.body.classList.add('modal-open');
            let backdrop = document.getElementById('customBackdrop');
            if (!backdrop) {
                backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show';
                backdrop.id = 'customBackdrop';
                document.body.appendChild(backdrop);
            }
        }
    }

    // Toggle Tampilkan/Sembunyikan Password
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('portalPassword');
        const eyeIcon = document.getElementById('passwordEyeIcon');
        if (!passwordInput || !eyeIcon) return;

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.className = 'bi bi-eye-slash';
        } else {
            passwordInput.type = 'password';
            eyeIcon.className = 'bi bi-eye';
        }
    }

    // Simulasi Kirim OTP WhatsApp
    function sendOtpCode() {
        const btn = document.getElementById('btnSendOtp');
        const phone = document.getElementById('step1PhoneInput').value;
        if (!phone) {
            alert('Silakan masukkan nomor WhatsApp Anda terlebih dahulu.');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Mengirim...';

        setTimeout(() => {
            btn.innerHTML = '<i class="bi bi-check2"></i> Terkirim (60s)';
            alert('Kode OTP 6-digit verifikasi pendaftaran telah dikirim ke WhatsApp +62 ' + phone);
            
            let countdown = 60;
            const timer = setInterval(() => {
                countdown--;
                if (countdown > 0) {
                    btn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Kirim Ulang (' + countdown + 's)';
                } else {
                    clearInterval(timer);
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-send me-1"></i> Kirim OTP';
                }
            }, 1000);
        }, 1000);
    }
</script>
@endsection
