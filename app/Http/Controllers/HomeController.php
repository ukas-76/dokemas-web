<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $baseUrl = env('API_BASE_URL', 'https://porto-backend-dokemas.rryxja.easypanel.host/api');

        try {
            // 1. Tarik Data Kategori
            $categoriesResponse = Http::get("{$baseUrl}/categories");
            $categoriesRaw = $categoriesResponse->json();
            // Mengecek apakah respon berupa array langsung atau terbungkus 'data'
            $categories = isset($categoriesRaw['data']) ? $categoriesRaw['data'] : (is_array($categoriesRaw) ? $categoriesRaw : []);

            // 2. Tarik Data Destinasi
            $destinationsResponse = Http::get("{$baseUrl}/destinations", [
                'limit' => 4,
                'q' => $request->query('q'),
                'category' => $request->query('kategori')
            ]);
            $destinationsRaw = $destinationsResponse->json();
            // Data destinasi berada di dalam $destinationsRaw['data'] (paginasi Laravel)
            $destinations = $destinationsRaw['data'] ?? [];

        } catch (\Exception $e) {
            $categories = [];
            $destinations = [];
        }

        return view('pages.home', compact('categories', 'destinations'));
    }
}