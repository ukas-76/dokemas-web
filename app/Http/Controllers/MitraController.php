<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class MitraController extends Controller
{
    /**
     * Tampilkan formulir onboarding pendaftaran mitra baru.
     * Default dimulai dari Langkah 1 (Informasi Akun & Verifikasi OTP)
     */
    public function register(Request $request)
    {
        $step = (int) $request->query('step', 1);
        if (!in_array($step, [1, 2, 3, 4])) {
            $step = 1;
        }

        $categories = Category::orderBy('name')->get();
        return view('pages.mitra.register', compact('categories', 'step'));
    }
}

