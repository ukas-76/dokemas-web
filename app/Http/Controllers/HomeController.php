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
            // 1. Tarik Data Kategori dari API
            $categoriesResponse = Http::get("{$baseUrl}/categories");
            $categories = $categoriesResponse->successful() ? $categoriesResponse->json('data') : [];

            // 2. Tarik Data Destinasi & Hotel Unggulan dari API
            $destinationsResponse = Http::get("{$baseUrl}/destinations", [
                'limit' => 4,
                'q' => $request->query('q'),
                'category' => $request->query('kategori')
            ]);
            $destinations = $destinationsResponse->successful() ? $destinationsResponse->json('data') : [];

        } catch (\Exception $e) {
            // Fallback jika API offline/error
            $categories = [];
            $destinations = [];
        }

        return view('pages.home', compact('categories', 'destinations'));
    }
}