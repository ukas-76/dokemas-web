<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Destination;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data kategori langsung dari database
        $categories = Category::withCount('destinations')->get();

        // 2. Query destinasi unggulan dari database
        $destinationsQuery = Destination::with('category');

        if ($request->filled('q')) {
            $q = trim($request->query('q'));
            $destinationsQuery->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('location', 'like', "%{$q}%")
                    ->orWhere('subdistrict', 'like', "%{$q}%");
            });
        }

        if ($request->filled('kategori')) {
            $cat = $request->query('kategori');
            $destinationsQuery->whereHas('category', function ($sub) use ($cat) {
                $sub->where('slug', 'like', "%{$cat}%");
            });
        }

        // Ambil 4-8 destinasi pilihan terpopuler
        $destinations = $destinationsQuery->orderByDesc('is_featured')
            ->orderByDesc('rating')
            ->limit(4)
            ->get();

        return view('pages.home', compact('categories', 'destinations'));
    }
}