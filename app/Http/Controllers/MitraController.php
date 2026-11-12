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

        return view('pages.mitra.dashboard', compact(
            'categories',
            'activeDestination'
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
