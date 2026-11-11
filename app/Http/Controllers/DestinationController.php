<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Destination;

class DestinationController extends Controller
{
    /**
     * Halaman Katalog Pencarian Destinasi Wisata (Data murni dari Database)
     */
    public function index(Request $request)
    {
        // 1. Ambil Kategori dari Database beserta jumlah destinasi masing-masing
        $categories = Category::withCount('destinations')->get();

        // 2. Query Destinasi dengan relasi kategori
        $query = Destination::with('category');

        // Parameter input
        $q = trim((string) $request->query('q', ''));
        $selectedCategories = (array) $request->query('kategori', []);
        $selectedCategories = array_values(array_filter($selectedCategories));

        $minPrice = (int) $request->query('min_price', 0);
        $maxPrice = (int) $request->query('max_price', 1500000);

        $selectedRatings = (array) $request->query('rating', []);
        $selectedRatings = array_values(array_filter($selectedRatings));

        $selectedFacilities = (array) $request->query('fasilitas', []);
        $selectedFacilities = array_values(array_filter($selectedFacilities));

        $selectedArea = trim((string) $request->query('wilayah', ''));
        $sort = $request->query('sort', 'rating_desc');

        // A. Filter Pencarian Teks (q) Cerdas & Fleksibel
        if ($q !== '') {
            $rawTokens = preg_split('/\s+/', $q, -1, PREG_SPLIT_NO_EMPTY);
            $tokens = array_filter($rawTokens, fn($t) => mb_strlen($t) > 1);
            if (empty($tokens)) {
                $tokens = [$q];
            }

            $query->where(function ($sub) use ($tokens) {
                foreach ($tokens as $token) {
                    $variants = [$token];
                    // Normalisasi variasi ejaan umum Baturraden / Baturaden
                    if (stripos($token, 'baturaden') !== false) {
                        $variants[] = str_ireplace('baturaden', 'baturraden', $token);
                    } elseif (stripos($token, 'baturraden') !== false) {
                        $variants[] = str_ireplace('baturraden', 'baturaden', $token);
                    }

                    $sub->where(function ($tokenSub) use ($variants) {
                        foreach ($variants as $var) {
                            $tokenSub->orWhere('name', 'like', "%{$var}%")
                                     ->orWhere('description', 'like', "%{$var}%")
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

        // B. Filter Kategori (Array atau Tunggal)
        if (!empty($selectedCategories)) {
            // Normalisasi kategori umum atau sinonim (contoh: 'wisata' -> 'alam')
            $mappedCats = [];
            foreach ($selectedCategories as $catVal) {
                $mappedCats[] = $catVal;
                if ($catVal === 'wisata' || $catVal === 'wisata-alam') {
                    $mappedCats[] = 'alam';
                }
            }
            $mappedCats = array_unique(array_filter($mappedCats));

            $query->whereHas('category', function ($sub) use ($mappedCats) {
                $sub->whereIn('slug', $mappedCats)
                    ->orWhereIn('id', $mappedCats)
                    ->orWhere(function ($s) use ($mappedCats) {
                        foreach ($mappedCats as $mc) {
                            $s->orWhere('name', 'like', "%{$mc}%")
                              ->orWhere('slug', 'like', "%{$mc}%");
                        }
                    });
            });
        }

        // C. Filter Rentang Harga
        if ($maxPrice > 0 && $maxPrice < 1500000) {
            $query->where('price', '<=', $maxPrice);
        }
        if ($minPrice > 0) {
            $query->where('price', '>=', $minPrice);
        }

        // D. Filter Rating Pengunjung
        if (!empty($selectedRatings)) {
            $query->where(function ($sub) use ($selectedRatings) {
                foreach ($selectedRatings as $r) {
                    $val = (float) $r;
                    if ($val >= 4.9 || $val == 5) {
                        $sub->orWhere('rating', '>=', 4.9);
                    } elseif ($val >= 4.0 || $val == 4) {
                        $sub->orWhere('rating', '>=', 4.0);
                    } elseif ($val >= 3.0 || $val == 3) {
                        $sub->orWhere('rating', '>=', 3.0);
                    }
                }
            });
        }

        // E. Filter Fasilitas Pendukung (AND antar jenis fasilitas)
        if (!empty($selectedFacilities)) {
            foreach ($selectedFacilities as $fac) {
                $keywords = match ($fac) {
                    'parkir' => ['parkir', 'garasi'],
                    'mushola', 'musholla' => ['mushol', 'masjid'],
                    'toilet' => ['toilet', 'bilas'],
                    'wifi' => ['wifi', 'wi-fi', 'internet'],
                    'anak', 'ramah_anak', 'ramah-anak' => ['anak', 'keluarga', 'playground'],
                    'warung' => ['warung', 'makan', 'kuliner', 'soto', 'bakso', 'mendoan'],
                    'penginapan' => ['penginapan', 'hotel', 'villa', 'resort'],
                    'spot_foto', 'spot-foto' => ['spot foto', 'foto'],
                    'kolam' => ['kolam', 'pool', 'renang', 'air alami', 'air terjun'],
                    'gazebo' => ['gazebo', 'pondok', 'bale'],
                    default => [$fac]
                };

                $query->where(function ($facSub) use ($keywords) {
                    foreach ($keywords as $kw) {
                        $facSub->orWhere('facilities', 'like', "%{$kw}%");
                    }
                });
            }
        }

        // F. Filter Wilayah / Kawasan
        if ($selectedArea !== '') {
            $query->where(function ($sub) use ($selectedArea) {
                $sub->where('subdistrict', 'like', "%{$selectedArea}%")
                    ->orWhere('location', 'like', "%{$selectedArea}%");
            });
        }

        // G. Pengurutan Data (Sorting)
        if ($sort === 'price_asc' || $sort === 'termurah') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc' || $sort === 'termahal') {
            $query->orderBy('price', 'desc');
        } elseif ($sort === 'popular' || $sort === 'populer') {
            $query->orderByDesc('reviews_count')->orderByDesc('rating');
        } elseif ($sort === 'terbaru') {
            $query->orderByDesc('id');
        } else {
            // Default: rating tertinggi
            $query->orderByDesc('rating')->orderByDesc('reviews_count');
        }

        // H. Menghitung Total & Paginasi
        $totalRegistered = Destination::count();

        $perPage = (int) $request->query('per_page', 6);
        if (!in_array($perPage, [6, 9, 12, 24])) {
            $perPage = 6;
        }

        $viewMode = $request->query('view', 'grid');
        if (!in_array($viewMode, ['grid', 'list'])) {
            $viewMode = 'grid';
        }

        $destinations = $query->paginate($perPage)->withQueryString();
        $totalFound = $destinations->total();
        $currentPage = $destinations->currentPage();
        $totalPages = $destinations->lastPage();

        return view('pages.destinasi.index', compact(
            'destinations',
            'categories',
            'totalRegistered',
            'totalFound',
            'currentPage',
            'totalPages',
            'perPage',
            'viewMode',
            'minPrice',
            'maxPrice',
            'selectedCategories',
            'selectedRatings',
            'selectedFacilities',
            'selectedArea',
            'sort',
            'q'
        ));
    }

    /**
     * Halaman Detail Destinasi Wisata (Data murni dari Database)
     */
    public function show($slug)
    {
        // 1. Ambil data destinasi dari database berdasarkan slug atau id
        $destination = Destination::with('category')
            ->where('slug', $slug)
            ->orWhere('id', is_numeric($slug) ? (int)$slug : 0)
            ->first();

        // Fallback jika tidak ditemukan sama sekali: ambil destinasi pertama di database
        if (!$destination) {
            $destination = Destination::with('category')->firstOrFail();
        }

        // 2. Ambil destinasi terkait di kategori yang sama atau lokasi terdekat dari database
        $related = Destination::with('category')
            ->where('id', '!=', $destination->id)
            ->where('category_id', $destination->category_id)
            ->limit(3)
            ->get();

        // Jika di kategori yang sama kurang dari 3, lengkapi dengan destinasi populer lainnya dari database
        if ($related->count() < 3) {
            $needed = 3 - $related->count();
            $existingIds = $related->pluck('id')->push($destination->id)->all();
            $others = Destination::with('category')
                ->whereNotIn('id', $existingIds)
                ->orderByDesc('rating')
                ->limit($needed)
                ->get();

            $related = $related->concat($others);
        }

        return view('pages.destinasi.show', compact('destination', 'related'));
    }
}
