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
            $rawTokens = preg_split('/\s+/', $q, -1, PREG_SPLIT_NO_EMPTY);
            $tokens = array_filter($rawTokens, fn($t) => mb_strlen($t) > 1);
            if (empty($tokens)) {
                $tokens = [$q];
            }

            $destinationsQuery->where(function ($sub) use ($tokens) {
                foreach ($tokens as $token) {
                    $variants = [$token];
                    if (stripos($token, 'baturaden') !== false) {
                        $variants[] = str_ireplace('baturaden', 'baturraden', $token);
                    } elseif (stripos($token, 'baturraden') !== false) {
                        $variants[] = str_ireplace('baturraden', 'baturaden', $token);
                    }

                    $sub->where(function ($tokenSub) use ($variants) {
                        foreach ($variants as $var) {
                            $tokenSub->orWhere('name', 'like', "%{$var}%")
                                     ->orWhere('location', 'like', "%{$var}%")
                                     ->orWhere('subdistrict', 'like', "%{$var}%")
                                     ->orWhereHas('category', function ($catSub) use ($var) {
                                         $catSub->where('name', 'like', "%{$var}%")
                                                ->orWhere('slug', 'like', "%{$var}%");
                                     });
                        }
                    });
                }
            });
        }

        if ($request->filled('kategori')) {
            $cat = trim($request->query('kategori'));
            $mappedCats = [$cat];
            if ($cat === 'wisata' || $cat === 'wisata-alam') {
                $mappedCats[] = 'alam';
            }
            $destinationsQuery->whereHas('category', function ($sub) use ($mappedCats) {
                $sub->whereIn('slug', $mappedCats)
                    ->orWhere(function ($s) use ($mappedCats) {
                        foreach ($mappedCats as $mc) {
                            $s->orWhere('name', 'like', "%{$mc}%")
                              ->orWhere('slug', 'like', "%{$mc}%");
                        }
                    });
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