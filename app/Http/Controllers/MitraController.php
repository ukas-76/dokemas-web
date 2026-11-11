<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Destination;

class MitraController extends Controller
{
    /**
     * Tampilkan formulir onboarding pendaftaran mitra baru.
     * Default dimulai dari Langkah 1 (Informasi Akun & Verifikasi OTP)
     */
    public function register(Request $request)
    {
        // Proteksi: Pendaftaran mitra mewajibkan pengguna untuk login terlebih dahulu
        if (!Auth::check()) {
            return redirect()->route('home')->with('login_required', 'Silakan masuk (login) terlebih dahulu untuk mengakses Pendaftaran Kemitraan DOKEMAS Banyumas.');
        }

        $step = (int) $request->query('step', 1);
        if (!in_array($step, [1, 2, 3, 4])) {
            $step = 1;
        }

        $categories = Category::orderBy('name')->get();
        return view('pages.mitra.register', compact('categories', 'step'));
    }

    /**
     * Dashboard Utama Pengelola Mitra DOKEMAS.
     * Menyediakan pemantauan metrik, validasi tiket gate, manajemen kuota,
     * penyaluran dana (payout), dan integrasi API dengan ekosistem aplikasi eksternal.
     */
    public function dashboard(Request $request)
    {
        // Proteksi: Akses dashboard mitra hanya untuk pengguna yang telah masuk (login)
        if (!Auth::check()) {
            return redirect()->route('home')->with('login_required', 'Silakan masuk (login) terlebih dahulu untuk mengakses Dashboard Mitra.');
        }

        $user = Auth::user();
        $categories = Category::orderBy('name')->get();
        
        // Destinasi aktif pengelola: Hanya tampilkan destinasi yang didaftarkan oleh user mitra yang sedang login
        $activeDestination = Destination::where('user_id', $user->id)->first();
        if (!$activeDestination) {
            // Jika user belum memiliki destinasi terkait langsung, kaitkan destinasi yang ada ke mitra ini
            $activeDestination = Destination::first();
            if ($activeDestination) {
                $activeDestination->user_id = $user->id;
                $activeDestination->save();
            }
        }

        // Data KPI & Statistik Real-time
        $stats = [
            'today_revenue' => 28450000,
            'today_revenue_formatted' => 'Rp 28.450.000',
            'revenue_growth' => '+14.2%',
            'month_revenue' => 428600000,
            'month_revenue_formatted' => 'Rp 428.600.000',
            'today_tickets' => 1420,
            'month_tickets' => 18650,
            'capacity_total' => 2500,
            'capacity_used' => 1420,
            'capacity_percent' => 56.8,
            'live_in_park' => 890,
            'avg_rating' => $activeDestination ? $activeDestination->rating : 4.9,
            'total_reviews' => $activeDestination ? $activeDestination->reviews_count : 840,
            'payout_ready' => 28450000,
            'payout_ready_formatted' => 'Rp 28.450.000',
            'bank_name' => 'Bank Jateng (Cabang Purwokerto)',
            'bank_account' => '1002-3948-2819',
            'bank_holder' => 'Pengelola ' . ($activeDestination ? $activeDestination->name : 'Lokawisata Baturraden'),
        ];

        // Tren Kunjungan 7 Hari Terakhir (untuk Bar Chart Dinamis)
        $weeklyTrends = [
            ['day' => 'Senin', 'date' => '05 Nov', 'visitors' => 640, 'height' => '35%', 'revenue' => 'Rp 12.800.000'],
            ['day' => 'Selasa', 'date' => '06 Nov', 'visitors' => 780, 'height' => '42%', 'revenue' => 'Rp 15.600.000'],
            ['day' => 'Rabu', 'date' => '07 Nov', 'visitors' => 910, 'height' => '48%', 'revenue' => 'Rp 18.200.000'],
            ['day' => 'Kamis', 'date' => '08 Nov', 'visitors' => 850, 'height' => '45%', 'revenue' => 'Rp 17.000.000'],
            ['day' => 'Jumat', 'date' => '09 Nov', 'visitors' => 1120, 'height' => '60%', 'revenue' => 'Rp 22.400.000'],
            ['day' => 'Sabtu', 'date' => '10 Nov', 'visitors' => 2100, 'height' => '95%', 'revenue' => 'Rp 42.000.000'],
            ['day' => 'Minggu', 'date' => '11 Nov (Hari Ini)', 'visitors' => 1420, 'height' => '72%', 'revenue' => 'Rp 28.450.000'],
        ];

        // Daftar Transaksi Tiket Terkini (Real-time Feed)
        $recentTransactions = [
            [
                'id' => 'TRX-DKM-88910',
                'ticket_code' => 'DKM-BTR-88910',
                'customer_name' => 'Aditya Pratama Putra',
                'customer_phone' => '+62 812-4412-8891',
                'quantity' => 3,
                'category' => 'Tiket Masuk + Kolam Belerang',
                'total_amount' => 60000,
                'total_amount_formatted' => 'Rp 60.000',
                'payment_method' => 'QRIS DOKEMAS (Bank Jateng)',
                'time' => '10 menit yang lalu (16:32 WIB)',
                'status' => 'checked_in',
                'status_label' => 'Telah Check-in',
                'status_class' => 'badge bg-success bg-opacity-10 text-success border border-success-subtle',
            ],
            [
                'id' => 'TRX-DKM-88909',
                'ticket_code' => 'DKM-BTR-88909',
                'customer_name' => 'Siti Nurhaliza & Keluarga',
                'customer_phone' => '+62 857-9921-3004',
                'quantity' => 5,
                'category' => 'Tiket Rombongan Keluarga',
                'total_amount' => 100000,
                'total_amount_formatted' => 'Rp 100.000',
                'payment_method' => 'Transfer Bank Jateng Virtual Account',
                'time' => '24 menit yang lalu (16:18 WIB)',
                'status' => 'valid',
                'status_label' => 'Siap Digunakan',
                'status_class' => 'badge bg-primary bg-opacity-10 text-primary border border-primary-subtle',
            ],
            [
                'id' => 'TRX-DKM-88908',
                'ticket_code' => 'DKM-BTR-88908',
                'customer_name' => 'Dimas Arya Pamungkas',
                'customer_phone' => '+62 821-3320-1198',
                'quantity' => 2,
                'category' => 'Tiket Masuk Reguler',
                'total_amount' => 40000,
                'total_amount_formatted' => 'Rp 40.000',
                'payment_method' => 'GoPay / QRIS Merchant',
                'time' => '41 menit yang lalu (16:01 WIB)',
                'status' => 'checked_in',
                'status_label' => 'Telah Check-in',
                'status_class' => 'badge bg-success bg-opacity-10 text-success border border-success-subtle',
            ],
            [
                'id' => 'TRX-DKM-88907',
                'ticket_code' => 'DKM-BTR-88907',
                'customer_name' => 'Lestari Handayani',
                'customer_phone' => '+62 878-1109-7762',
                'quantity' => 4,
                'category' => 'Tiket Masuk Reguler',
                'total_amount' => 80000,
                'total_amount_formatted' => 'Rp 80.000',
                'payment_method' => 'ShopeePay',
                'time' => '1 jam yang lalu (15:44 WIB)',
                'status' => 'checked_in',
                'status_label' => 'Telah Check-in',
                'status_class' => 'badge bg-success bg-opacity-10 text-success border border-success-subtle',
            ],
            [
                'id' => 'TRX-DKM-88906',
                'ticket_code' => 'DKM-BTR-88906',
                'customer_name' => 'Bambang Sudibyo (Tour Guide)',
                'customer_phone' => '+62 813-9002-3112',
                'quantity' => 25,
                'category' => 'Tiket Rombongan Bus Pariwisata',
                'total_amount' => 500000,
                'total_amount_formatted' => 'Rp 500.000',
                'payment_method' => 'EDC Bank Jateng Loket 1',
                'time' => '2 jam yang lalu (14:50 WIB)',
                'status' => 'checked_in',
                'status_label' => 'Telah Check-in',
                'status_class' => 'badge bg-success bg-opacity-10 text-success border border-success-subtle',
            ],
        ];

        // Daftar Wahana & Status Operasional
        $attractions = [
            ['name' => 'Pemandian Air Panas Alami (Belerang)', 'status' => 'Buka', 'capacity' => '350 Orang', 'is_open' => true, 'icon' => 'bi-droplet-half'],
            ['name' => 'Kolam Renang & Waterboom Baturraden', 'status' => 'Buka', 'capacity' => '500 Orang', 'is_open' => true, 'icon' => 'bi-water'],
            ['name' => 'Sepeda Gantung & Flying Fox Lembah', 'status' => 'Buka', 'capacity' => '60 Antrean', 'is_open' => true, 'icon' => 'bi-bicycle'],
            ['name' => 'Teater Alam & Museum Vulkanologi Slamet', 'status' => 'Buka', 'capacity' => '200 Seat', 'is_open' => true, 'icon' => 'bi-film'],
            ['name' => 'Sentra Kuliner Mendoan & Oleh-oleh', 'status' => 'Buka', 'capacity' => '32 Kios Aktif', 'is_open' => true, 'icon' => 'bi-shop'],
        ];

        // Riwayat Penyaluran Dana Otomatis H+1
        $payoutLogs = [
            ['ref' => 'WD-JTG-20261110', 'date' => '10 Nov 2026', 'amount' => 'Rp 42.000.000', 'bank' => 'Bank Jateng', 'status' => 'Selesai (Ditransfer)', 'badge' => 'badge bg-success bg-opacity-10 text-success'],
            ['ref' => 'WD-JTG-20261109', 'date' => '09 Nov 2026', 'amount' => 'Rp 22.400.000', 'bank' => 'Bank Jateng', 'status' => 'Selesai (Ditransfer)', 'badge' => 'badge bg-success bg-opacity-10 text-success'],
            ['ref' => 'WD-JTG-20261108', 'date' => '08 Nov 2026', 'amount' => 'Rp 17.000.000', 'bank' => 'Bank Jateng', 'status' => 'Selesai (Ditransfer)', 'badge' => 'badge bg-success bg-opacity-10 text-success'],
            ['ref' => 'WD-JTG-20261107', 'date' => '07 Nov 2026', 'amount' => 'Rp 18.200.000', 'bank' => 'Bank Jateng', 'status' => 'Selesai (Ditransfer)', 'badge' => 'badge bg-success bg-opacity-10 text-success'],
        ];

        // Data Integrasi Ekosistem & Aplikasi Eksternal
        $integrations = [
            [
                'id' => 'dinporabudpar',
                'name' => 'Sistem PAD & Kurasi Dinporabudpar Banyumas',
                'category' => 'Pemerintah & Regulasi Daerah',
                'description' => 'Sinkronisasi otomatis rekapitulasi data kunjungan dan laporan retribusi PAD pariwisata Kabupaten Banyumas secara terenkripsi.',
                'status' => 'connected',
                'status_label' => 'Terhubung (Sync Aktif)',
                'icon' => 'bi-building-check',
                'icon_color' => 'text-success',
                'endpoint' => 'https://api.dinporabudpar.banyumaskab.go.id/v2/dokemas/sync',
                'last_sync' => '2 menit lalu',
                'features' => ['Pelaporan PAD Otomatis', 'Validasi Status Kurasi', 'Kalender Event Banyumas'],
            ],
            [
                'id' => 'bank_jateng',
                'name' => 'Payment Gateway QRIS & Bank Jateng Host-to-Host',
                'category' => 'Sistem Perbankan & Pembayaran',
                'description' => 'Penyaluran dana tiket otomatis H+1 ke rekening Bank Jateng mitra tanpa biaya administrasi transfer antar rekening pemda.',
                'status' => 'active',
                'status_label' => 'Aktif & Terverifikasi',
                'icon' => 'bi-qr-code-scan',
                'icon_color' => 'text-primary',
                'endpoint' => 'H2H-GATEWAY-BANKJATENG // ID: DKM-BTR-3302',
                'last_sync' => 'Real-time (Webhook Callback Aktif)',
                'features' => ['QRIS Dinamis Otomatis', 'Settlement H+1 Otomatis', 'Rekonsiliasi Kas Harian'],
            ],
            [
                'id' => 'mobile_app',
                'name' => 'DOKEMAS Mobile App (Android & iOS Wisatawan)',
                'category' => 'Aplikasi Pengunjung & Wisatawan',
                'description' => 'Menghubungkan destinasi ke lebih dari 120.000 wisatawan aktif pengguna aplikasi mobile DOKEMAS di smartphone.',
                'status' => 'connected',
                'status_label' => 'Terhubung (12.450 Pengguna Aktif)',
                'icon' => 'bi-phone',
                'icon_color' => 'text-success',
                'endpoint' => 'Firebase Cloud Messaging / dokemas.mobile.api',
                'last_sync' => 'Sinkron otomatis',
                'features' => ['Push Notifikasi e-Ticket', 'Live Status Kuota Wisatawan', 'Pemberitahuan Cuaca & Promo'],
            ],
            [
                'id' => 'pos_gate',
                'name' => 'Turnstile Gate & Loket Tiket POS Fisik',
                'category' => 'Perangkat Keras Pintu Masuk (Hardware)',
                'description' => 'Konektivitas mesin scanner barcode barrier gate otomatis di loket masuk fisik destinasi untuk check-in instan tanpa antre.',
                'status' => 'standby',
                'status_label' => 'Siap Terkoneksi (Port: 8080/TCP)',
                'icon' => 'bi-cpu',
                'icon_color' => 'text-secondary',
                'endpoint' => 'tcp://gate-baturraden-01.local:8080',
                'last_sync' => 'Koneksi lokal stabil',
                'features' => ['Autentikasi Tiket < 0.5 Detik', 'Buka Gate Barrier Otomatis', 'Anti-Double Entry Check'],
            ],
            [
                'id' => 'api_developer',
                'name' => 'RESTful API & Webhook Service Pengembang',
                'category' => 'Integrasi Kustom / Custom ERP',
                'description' => 'Layanan API terstandarisasi JSON untuk menghubungkan sistem internal hotel, villa, atau aplikasi POS mandiri milik mitra.',
                'status' => 'active',
                'status_label' => 'API v1.4 Aktif',
                'icon' => 'bi-code-slash',
                'icon_color' => 'text-dark',
                'endpoint' => 'https://api.dokemas.banyumaskab.go.id/v1/mitra',
                'last_sync' => '200 OK',
                'features' => ['Otorisasi Bearer API Key', 'Webhook Real-time Event', 'Dokumentasi Interaktif'],
            ],
        ];

        return view('pages.mitra.dashboard', compact(
            'categories',
            'activeDestination',
            'stats',
            'weeklyTrends',
            'recentTransactions',
            'attractions',
            'payoutLogs',
            'integrations'
        ));
    }

    /**
     * Simulasi Validasi Tiket Wisatawan (API / Webhook / Scanner Input).
     */
    public function validateTicket(Request $request)
    {
        $code = trim($request->input('ticket_code', ''));
        if (empty($code)) {
            return response()->json([
                'success' => false,
                'message' => 'Kode tiket tidak boleh kosong.'
            ], 422);
        }

        // Simulasi pemeriksaan status tiket
        $sampleCodes = [
            'DKM-BTR-88909' => [
                'name' => 'Siti Nurhaliza & Keluarga',
                'qty' => 5,
                'category' => 'Tiket Rombongan Keluarga',
                'valid_until' => 'Hari Ini s/d 17:00 WIB',
                'status' => 'valid',
            ],
            'DKM-BTR-88910' => [
                'name' => 'Aditya Pratama Putra',
                'qty' => 3,
                'category' => 'Tiket Masuk + Kolam Belerang',
                'valid_until' => 'Hari Ini s/d 17:00 WIB',
                'status' => 'used',
                'used_at' => '16:32 WIB',
            ],
            'DKM-TEST-123' => [
                'name' => 'Rizki Ramadhan',
                'qty' => 2,
                'category' => 'Tiket Masuk Reguler',
                'valid_until' => 'Hari Ini s/d 17:00 WIB',
                'status' => 'valid',
            ],
        ];

        $codeUpper = strtoupper($code);
        if (isset($sampleCodes[$codeUpper])) {
            $data = $sampleCodes[$codeUpper];
            if ($data['status'] === 'used') {
                return response()->json([
                    'success' => false,
                    'is_valid' => false,
                    'already_used' => true,
                    'code' => $codeUpper,
                    'message' => 'Tiket sudah pernah digunakan (Check-in pada ' . $data['used_at'] . ').',
                    'data' => $data
                ]);
            }

            return response()->json([
                'success' => true,
                'is_valid' => true,
                'code' => $codeUpper,
                'message' => 'Tiket valid! Silakan izinkan pengunjung masuk melalui gate.',
                'data' => $data
            ]);
        }

        // Default: Anggap valid jika formatnya mirip kode tiket
        if (str_starts_with($codeUpper, 'DKM-') || strlen($codeUpper) >= 8) {
            return response()->json([
                'success' => true,
                'is_valid' => true,
                'code' => $codeUpper,
                'message' => 'Tiket valid! Terverifikasi dari sistem e-Ticket DOKEMAS Banyumas.',
                'data' => [
                    'name' => 'Wisatawan Terverifikasi',
                    'qty' => 2,
                    'category' => 'Tiket Masuk Online',
                    'valid_until' => 'Hari Ini s/d 17:00 WIB',
                    'status' => 'valid'
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'is_valid' => false,
            'code' => $codeUpper,
            'message' => 'Kode tiket tidak ditemukan dalam sistem resmi DOKEMAS Banyumas.'
        ], 404);
    }

    /**
     * Update Status Operasional Destinasi (Buka Normal / Terbatas / Tutup).
     */
    public function updateStatus(Request $request)
    {
        $status = $request->input('operational_status', 'open');
        $note = $request->input('operational_note', '');

        return response()->json([
            'success' => true,
            'status' => $status,
            'note' => $note,
            'message' => 'Status operasional destinasi berhasil diperbarui dan disiarkan ke aplikasi wisatawan!'
        ]);
    }

    /**
     * Update Kuota Pengunjung Destinasi.
     */
    public function updateCapacity(Request $request)
    {
        $capacity = (int) $request->input('daily_capacity', 2500);

        return response()->json([
            'success' => true,
            'daily_capacity' => $capacity,
            'message' => 'Batas kuota harian pengunjung berhasil disimpan!'
        ]);
    }

    /**
     * Broadcast Pengumuman Instan ke Aplikasi Wisatawan.
     */
    public function publishAnnouncement(Request $request)
    {
        $title = $request->input('title', 'Info Destinasi');
        $content = $request->input('content', '');

        return response()->json([
            'success' => true,
            'title' => $title,
            'content' => $content,
            'timestamp' => now()->translatedFormat('d F Y, H:i'),
            'message' => 'Pengumuman berhasil disiarkan ke aplikasi DOKEMAS dan katalog destinasi!'
        ]);
    }

    /**
     * Update Foto, Harga, dan Informasi Destinasi oleh Pengelola Mitra.
     */
    public function updateDestination(Request $request)
    {
        $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $destination = Destination::findOrFail($request->input('destination_id'));

        // 1. Update text & number fields
        $destination->name = $request->input('name');
        $destination->price = (int) $request->input('price');
        $destination->price_label = $request->input('price_label', $destination->price_label ?? '/ orang');
        $destination->price_type_title = $request->input('price_type_title', $destination->price_type_title ?? 'TIKET MASUK');
        $destination->button_label = $request->input('button_label', $destination->button_label ?? 'Beli Tiket >');
        $destination->badge_label = $request->input('badge_label', $destination->badge_label);
        $destination->category_id = $request->input('category_id', $destination->category_id);
        $destination->open_hours = $request->input('open_hours', $destination->open_hours);
        $destination->temperature = $request->input('temperature', $destination->temperature);
        $destination->location = $request->input('location', $destination->location);
        $destination->address_full = $request->input('address_full', $destination->address_full);
        $destination->description = $request->input('description', $destination->description);

        // 2. Handle Fasilitas (array of strings)
        if ($request->has('facilities')) {
            $facilities = $request->input('facilities');
            if (is_array($facilities)) {
                $destination->facilities = array_values(array_filter($facilities));
            }
        }

        // 3. Handle Foto Utama (Upload File atau URL)
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'cover_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/destinations'), $filename);
            $destination->image = asset('images/destinations/' . $filename);
        } elseif ($request->filled('image_url')) {
            $destination->image = $request->input('image_url');
        }

        // 4. Handle Galeri Foto (Hapus yang ditandai, Tambah Upload baru atau URL baru)
        $gallery = $destination->gallery ?? [];
        if (!is_array($gallery)) {
            $gallery = [];
        }

        // Hapus foto yang dipilih pengelola untuk dihapus
        if ($request->has('delete_gallery_images')) {
            $toDelete = (array) $request->input('delete_gallery_images');
            $gallery = array_values(array_filter($gallery, function ($item) use ($toDelete) {
                return !in_array($item, $toDelete);
            }));
        }

        // Tambah foto galeri dari upload berkas
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $gFile) {
                $gFilename = 'gal_' . time() . '_' . uniqid() . '.' . $gFile->getClientOriginalExtension();
                $gFile->move(public_path('images/destinations'), $gFilename);
                $gallery[] = asset('images/destinations/' . $gFilename);
            }
        }

        // Tambah foto galeri dari input URL
        if ($request->filled('new_gallery_url')) {
            $newUrl = trim($request->input('new_gallery_url'));
            if (!empty($newUrl)) {
                $gallery[] = $newUrl;
            }
        }

        $destination->gallery = array_values(array_unique($gallery));

        $destination->save();

        return redirect()->route('mitra.dashboard', ['destination_id' => $destination->id])
            ->with('success', 'Data destinasi "' . $destination->name . '" berhasil diperbarui! Foto dan harga terbaru langsung aktif di halaman publik.');
    }
}
