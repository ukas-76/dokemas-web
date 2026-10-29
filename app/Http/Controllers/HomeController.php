<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Data Dummy Kategori
        $categories = [
            ['name' => 'Wisata Alam', 'count' => '48 Destinasi', 'image' => 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?auto=format&fit=crop&w=400&q=80'],
            ['name' => 'Hotel', 'count' => '24 Pilihan', 'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=400&q=80'],
            ['name' => 'Homestay', 'count' => '36 Tempat', 'image' => 'https://images.unsplash.com/photo-1587061949409-02df41d5e562?auto=format&fit=crop&w=400&q=80'],
            ['name' => 'Kuliner', 'count' => '52 Resto & Sentra', 'image' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=400&q=80'],
            ['name' => 'Villa', 'count' => '18 Properti', 'image' => 'https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&w=400&q=80'],
        ];

        // 2. Data Dummy Destinasi Unggulan (Bisa ditarik dari REST API nantinya)
        $destinations = [
            [
                'title' => 'Curug Jaten Baturraden',
                'category' => 'Wisata Alam',
                'rating' => '4.8',
                'reviews_count' => '840+',
                'location' => 'Karangmangu, Baturraden',
                'tags' => ['Air Alami', 'Parkir Luas', 'Gazebo'],
                'price_label' => 'TIKET MASUK',
                'price' => 'Rp 15.000',
                'price_unit' => '/ org',
                'image' => 'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?auto=format&fit=crop&w=500&q=80'
            ],
            [
                'title' => 'Grand Pine Eco Resort',
                'category' => 'Hotel & Resort',
                'rating' => '4.9',
                'reviews_count' => '520+',
                'location' => 'Kawasan Atas Baturraden',
                'tags' => ['Air Panas', 'Sarapan', 'WiFi 50Mbps'],
                'price_label' => 'MULAI DARI',
                'price' => 'Rp 650.000',
                'price_unit' => '/ mlm',
                'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=500&q=80'
            ],
            [
                'title' => 'Menggala Ranch',
                'category' => 'Ekowisata Edukasi',
                'rating' => '4.7',
                'reviews_count' => '970+',
                'location' => 'Tumiyang, Pekuncen',
                'tags' => ['Feeding Sheep', 'Ramah Anak', 'Cafe'],
                'price_label' => 'TIKET MASUK',
                'price' => 'Rp 25.000',
                'price_unit' => '/ org',
                'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=500&q=80'
            ],
            [
                'title' => 'Oemah Nyaman Homestay',
                'category' => 'Homestay Keluarga',
                'rating' => '4.9',
                'reviews_count' => '310+',
                'location' => 'Dusun Ketenger, Baturraden',
                'tags' => ['3 Kamar', 'Dapur Bersih', 'Balkon Dingin'],
                'price_label' => 'SEWA 1 RUMAH',
                'price' => 'Rp 420.000',
                'price_unit' => '/ mlm',
                'image' => 'https://images.unsplash.com/photo-1587061949409-02df41d5e562?auto=format&fit=crop&w=500&q=80'
            ]
        ];

        return view('pages.home', compact('categories', 'destinations'));
    }
}