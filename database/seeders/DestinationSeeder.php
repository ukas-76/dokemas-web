<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Category;
use App\Models\Destination;

class DestinationSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Kategori Resmi dari Database DOKEMAS
        $categoriesData = [
            [
                'id' => 7,
                'name' => 'Alam',
                'slug' => 'alam',
                'icon' => 'forest',
                'description' => 'Wisata alam dan air terjun alami lereng Gunung Slamet Banyumas.'
            ],
            [
                'id' => 14,
                'name' => 'Alam Bebas',
                'slug' => 'alam-bebas',
                'icon' => 'beach_access',
                'description' => 'Eksplorasi alam terbuka dan panorama pegunungan.'
            ],
            [
                'id' => 12,
                'name' => 'Hidden Gem',
                'slug' => 'hidden-gem',
                'icon' => 'diamond',
                'description' => 'Destinasi tersembunyi yang eksotis dan mempesona.'
            ],
            [
                'id' => 11,
                'name' => 'Keluarga',
                'slug' => 'keluarga',
                'icon' => 'family_restroom',
                'description' => 'Wisata rekreasi ramah anak dan keluarga di Banyumas.'
            ],
            [
                'id' => 8,
                'name' => 'Kuliner',
                'slug' => 'kuliner',
                'icon' => 'restaurant',
                'description' => 'Cita rasa kuliner khas Banyumas yang melegenda.'
            ],
            [
                'id' => 10,
                'name' => 'Religi',
                'slug' => 'religi',
                'icon' => 'mosque',
                'description' => 'Wisata religi dan tempat ibadah bersejarah di Banyumas.'
            ],
            [
                'id' => 9,
                'name' => 'Sejarah',
                'slug' => 'sejarah',
                'icon' => 'museum',
                'description' => 'Situs cagar budaya dan museum bersejarah di Banyumas.'
            ],
        ];

        // Coba sinkronisasi kategori langsung dari API jika server aktif
        try {
            $catApiRes = Http::timeout(4)->get('https://porto-backend-dokemas.rryxja.easypanel.host/api/categories');
            if ($catApiRes->successful() && is_array($catApiRes->json())) {
                $categoriesData = $catApiRes->json();
            }
        } catch (\Exception $e) {
            // Gunakan $categoriesData baku
        }

        foreach ($categoriesData as $c) {
            Category::updateOrCreate(
                ['id' => $c['id']],
                [
                    'name' => $c['name'],
                    'slug' => $c['slug'],
                    'icon' => $c['icon'] ?? 'bi-grid-fill',
                    'description' => $c['description'] ?? null,
                ]
            );
        }

        // 2. Data Destinasi Resmi dari Database DOKEMAS
        $destinationsData = [
            [
                'id' => 10,
                'category_id' => 11,
                'name' => 'Lokawisata Baturraden',
                'slug' => 'lokawisata-baturraden-AGJ8m',
                'badge_label' => 'Wisata Keluarga',
                'description' => 'Salah satu tempat wisata yang menjadi idola dan wajib dikunjungi saat berada di Kabupaten Banyumas adalah Lokawisata Baturraden. Obyek wisata di lereng Gunung Slamet ini memiliki fasilitas terlengkap untuk semua umur, mulai dari pemandian air panas alami, kolam renang, sepeda gantung, teater alam, hingga sentra kuliner mendoan dan pecel khas Banyumas.',
                'location' => 'Karangmangu, Kec. Baturraden',
                'subdistrict' => 'Baturraden',
                'address_full' => 'Jl. Raya Baturaden No.174, Dusun I Karangmangu, Karangmangu, Kec. Baturraden, Kabupaten Banyumas, Jawa Tengah 53151',
                'price' => 20000,
                'price_label' => '/ orang',
                'price_type_title' => 'TIKET MASUK',
                'rating' => 5.0,
                'reviews_count' => 840,
                'image' => 'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/6c7b6a0d-17c6-42e8-94b2-4b9ee77ffbea.webp',
                'gallery' => [
                    'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/cd0bcf32-d7fe-48e0-8172-48fedaa074f9.webp',
                    'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/8a735657-3ebb-4ebe-b37d-c2f6e269fc99.webp',
                    'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/74233992-949c-41e2-a99d-b9435af8f887.webp',
                ],
                'facilities' => ['Toilet Bersih', 'Penginapan', 'Wifi Cepat', 'Parkir Luas', 'Musholla', 'Area Bermain Anak', 'Warung Makan'],
                'highlights' => [
                    'Pemandian air panas belerang alami bersumber langsung dari Gunung Slamet',
                    'Kolam renang luas dan wahana sepeda gantung melintasi lembah',
                    'Sentra kuliner mendoan hangat & sate kelinci lereng Slamet',
                    'Fasilitas ramah keluarga dengan area bermain anak dan taman bunga asri'
                ],
                'type' => 'ticket',
                'button_label' => 'Lihat Detail >',
                'button_class' => 'btn-slate-soft',
                'is_featured' => true,
                'open_hours' => '08:00 - 17:00 WIB',
                'temperature' => '20° - 23° C',
            ],
            [
                'id' => 11,
                'category_id' => 7,
                'name' => 'Curug Cipendok',
                'slug' => 'curug-cipendok-YXqw5',
                'badge_label' => 'Wisata Alam',
                'description' => 'Air terjun setinggi 92 meter di kaki Gunung Slamet yang dikelilingi hutan pinus dan damar alami. Suasana sejuk pegunungan, gemuruh air terjun yang megah, serta udara segar tanpa polusi menjadikannya destinasi favorit untuk relaksasi dan refreshing.',
                'location' => 'Karangtengah, Kec. Cilongok',
                'subdistrict' => 'Cilongok',
                'address_full' => 'Dusun II Lebaksiu, Desa Karangtengah, Kec. Cilongok, Kabupaten Banyumas, Jawa Tengah 53162',
                'price' => 15000,
                'price_label' => '/ orang',
                'price_type_title' => 'TIKET MASUK',
                'rating' => 5.0,
                'reviews_count' => 620,
                'image' => 'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/1f9f30c2-2d98-42c8-907f-1c17b3274a09.webp',
                'gallery' => [
                    'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/8f9f30ac-c9d2-4037-a134-8694ae30e841.webp',
                    'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/bf510384-ab57-415d-a9fb-e0e241d3f20c.webp',
                ],
                'facilities' => ['Toilet Bersih', 'Musholla', 'Warung Makan', 'Spot Foto Estetik', 'Parkir Luas', 'Gazebo Teduh'],
                'highlights' => [
                    'Air terjun tertinggi di Banyumas dengan ketinggian 92 meter',
                    'Jalur setapak paving teduh di bawah rimbunnya hutan lindung',
                    'Spot foto jembatan pandang dengan latar air terjun megah',
                    'Dekat sentra susu murni dan perkebunan lereng Cilongok'
                ],
                'type' => 'ticket',
                'button_label' => 'Lihat Detail >',
                'button_class' => 'btn-slate-soft',
                'is_featured' => true,
                'open_hours' => '08:00 - 17:00 WIB',
                'temperature' => '19° - 22° C',
            ],
            [
                'id' => 18,
                'category_id' => 7,
                'name' => 'Air Terjun Curug Bayan',
                'slug' => 'air-terjun-curug-bayan-ybcG8',
                'badge_label' => 'Wisata Alam',
                'description' => 'Air terjun ramah keluarga di Dusun Ketenger Baturraden dengan kolam alami dangkal berbatu yang sangat aman untuk bermain air. Berlatar bendungan peninggalan zaman kolonial Belanda dan dikelilingi pondok wisata kayu yang asri.',
                'location' => 'Desa Ketenger, Kec. Baturraden',
                'subdistrict' => 'Baturraden',
                'address_full' => 'Desa Ketenger, Kecamatan Baturraden, Kabupaten Banyumas, Jawa Tengah 53151',
                'price' => 7500,
                'price_label' => '/ orang',
                'price_type_title' => 'TIKET MASUK',
                'rating' => 4.8,
                'reviews_count' => 450,
                'image' => 'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/eb6f1691-fd97-4ef7-a41b-39e710a9031c.webp',
                'gallery' => [
                    'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/f7951264-e440-4420-a3b2-d3dcea69b008.webp',
                    'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/5619c078-b308-4602-aa96-26ea4507b928.webp',
                ],
                'facilities' => ['Parkir Luas', 'Toilet Bersih', 'Musholla', 'Warung Makan', 'Penginapan Villa', 'Kolam Renang Alami'],
                'highlights' => [
                    'Aliran air tenang dan kolam dangkal sangat ramah anak-anak',
                    'Bangunan jembatan bendungan bersejarah peninggalan Belanda yang fotogenik',
                    'Penginapan bernuansa kabin kayu tepat di tepi aliran curug'
                ],
                'type' => 'ticket',
                'button_label' => 'Lihat Detail >',
                'button_class' => 'btn-slate-soft',
                'is_featured' => true,
                'open_hours' => '07:00 - 17:00 WIB',
                'temperature' => '20° - 23° C',
            ],
            [
                'id' => 20,
                'category_id' => 8,
                'name' => 'Bakso & Soto "Sami Asih"',
                'slug' => 'bakso-soto-sami-asih-A3CYA',
                'badge_label' => 'Sentra Kuliner',
                'description' => 'Kuliner legendaris khas Banyumas yang terkenal dengan soto sokaraja gurih bertabur kerupuk cantir merah dan sambal kacang otentik, dipadukan dengan bakso sapi kenyal berdaging padat yang memanjakan lidah.',
                'location' => 'Purwokerto Selatan, Banyumas',
                'subdistrict' => 'Purwokerto',
                'address_full' => 'Jl. Pramuka No.23, Sodagaran, Purwokerto Kulon, Kec. Purwokerto Selatan, Kabupaten Banyumas, Jawa Tengah 53141',
                'price' => 25000,
                'price_label' => '/ porsi',
                'price_type_title' => 'HARGA MULAI',
                'rating' => 4.9,
                'reviews_count' => 980,
                'image' => 'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/097ae45e-4216-4736-a451-1de71535e127.webp',
                'gallery' => [
                    'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/617d012c-8c0a-40be-9e57-ac970a7c8ec5.webp',
                    'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/c4f47330-2cf8-419b-9bbd-1efe64e00e71.webp',
                    'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/a4f5908c-9bf7-48eb-88ab-1d69691eeb42.webp',
                ],
                'facilities' => ['Parkir Luas', 'Toilet Bersih', 'Warung Makan', 'Wifi Cepat', 'Musholla'],
                'highlights' => [
                    'Resep bumbu rempah soto sokaraja legendaris sejak puluhan tahun',
                    'Kuah kaldu sapi kaya rasa disajikan panas dengan sambal kacang khas',
                    'Lokasi strategis di pusat kota Purwokerto dengan pelayanan cepat'
                ],
                'type' => 'kuliner',
                'button_label' => 'Lihat Menu',
                'button_class' => 'btn-blue-soft',
                'is_featured' => true,
                'open_hours' => '09:00 - 21:00 WIB',
                'temperature' => '26° - 30° C',
            ],
            [
                'id' => 21,
                'category_id' => 9,
                'name' => 'Sumur Mas Banyumas',
                'slug' => 'sumur-mas-banyumas-VqjU7',
                'badge_label' => 'Wisata Sejarah',
                'description' => 'Situs cagar budaya bersejarah di kawasan Taman Kota Lama Banyumas. Sumur Mas dipercaya sebagai salah satu peninggalan tertua berdirinya Kadipaten Banyumas yang sarat akan nilai sejarah luhur dan kearifan lokal.',
                'location' => 'Kota Lama, Kec. Banyumas',
                'subdistrict' => 'Banyumas',
                'address_full' => 'Taman Kota Lama Banyumas, Sudagaran, Kec. Banyumas, Kabupaten Banyumas, Jawa Tengah 53192',
                'price' => 10000,
                'price_label' => '/ orang',
                'price_type_title' => 'TIKET MASUK',
                'rating' => 4.7,
                'reviews_count' => 310,
                'image' => 'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/9dbbd4a1-aec3-4cad-b7fb-79b5d794f913.webp',
                'gallery' => [
                    'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/dfda8361-0b71-4044-af64-14361a312bd6.webp',
                    'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/9685cb25-1c44-4d8a-9a42-b87f0aa9c037.webp',
                    'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/a7178a25-64a2-423d-82a0-13b2182c5353.webp',
                ],
                'facilities' => ['Parkir Luas', 'Toilet Bersih', 'Spot Foto', 'Musholla', 'Taman Kota'],
                'highlights' => [
                    'Pusat sejarah awal mula berdirinya Kadipaten Banyumas kuno',
                    'Dikelilingi suasana arsitektur klasik Kota Lama Banyumas yang asri',
                    'Spot wisata edukasi sejarah bernilai tinggi'
                ],
                'type' => 'ticket',
                'button_label' => 'Lihat Detail >',
                'button_class' => 'btn-slate-soft',
                'is_featured' => false,
                'open_hours' => '08:00 - 17:00 WIB',
                'temperature' => '25° - 29° C',
            ],
            [
                'id' => 13,
                'category_id' => 10,
                'name' => 'Masjid Agung Baitussalam Purwokerto',
                'slug' => 'masjid-agung-baitussalam-purwokerto-qgrUP',
                'badge_label' => 'Wisata Religi',
                'description' => 'Masjid agung megah pusat kegiatan keagamaan dan ibadah di sisi barat Alun-Alun Purwokerto. Memadukan arsitektur Islam modern dengan sentuhan budaya Jawa yang anggun dan berwibawa.',
                'location' => 'Sokanegara, Purwokerto Timur',
                'subdistrict' => 'Purwokerto',
                'address_full' => 'Jl. Masjid No.1, Sokanegara, Kec. Purwokerto Timur, Kabupaten Banyumas, Jawa Tengah 53115',
                'price' => 0,
                'price_label' => 'Gratis',
                'price_type_title' => 'INFAK / DONASI',
                'rating' => 4.9,
                'reviews_count' => 1250,
                'image' => 'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/7e3981cc-5d7b-402d-b4ea-334c437bf7fa.webp',
                'gallery' => [
                    'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/a38d9950-96b5-4b66-beae-d47c6c6de93a.webp',
                    'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/b14d9a79-a2ff-4e0c-ada2-c63b6b232ad6.webp',
                    'http://porto-backend-dokemas.rryxja.easypanel.host/storage/destinations/35afc625-a0c3-4481-b0a1-1635ed3d74d2.webp',
                ],
                'facilities' => ['Parkir Luas', 'Toilet Bersih', 'Area Bermain Anak', 'Tempat Wudhu Nyaman', 'Ruang Sholat Ber-AC'],
                'highlights' => [
                    'Berada persis di jantung kota menghadap Alun-Alun Purwokerto',
                    'Arsitektur kubah megah dengan ruang sholat utama yang sejuk dan hening',
                    'Fasilitas wudhu air mengalir yang bersih dan terawat prima'
                ],
                'type' => 'ticket',
                'button_label' => 'Lihat Detail >',
                'button_class' => 'btn-slate-soft',
                'is_featured' => true,
                'open_hours' => '24 Jam Terbuka',
                'temperature' => '25° - 29° C',
            ],
            [
                'id' => 14,
                'category_id' => 9,
                'name' => 'Museum Bank Rakyat Indonesia',
                'slug' => 'museum-bank-rakyat-indonesia-GIrWU',
                'badge_label' => 'Wisata Sejarah',
                'description' => 'Museum sejarah perbankan pertama dan tertua di Indonesia yang didirikan oleh Raden Aria Wirjaatmadja pada tahun 1895 di Purwokerto. Menyimpan koleksi uang koin dan kertas kuno dari era kolonial hingga masa kini.',
                'location' => 'Purwokerto Barat, Banyumas',
                'subdistrict' => 'Purwokerto',
                'address_full' => 'Jl. Jenderal Soedirman No.57, Pesayangan, Kedungwuluh, Kec. Purwokerto Barat, Kabupaten Banyumas 53131',
                'price' => 5000,
                'price_label' => '/ orang',
                'price_type_title' => 'TIKET MASUK',
                'rating' => 4.8,
                'reviews_count' => 380,
                'image' => 'https://images.unsplash.com/photo-1566127444979-b3d2b654e3d7?auto=format&fit=crop&w=1200&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1566127444979-b3d2b654e3d7?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=800&q=80',
                ],
                'facilities' => ['Toilet Bersih', 'Musholla', 'Warung Makan', 'Area Bermain Anak', 'Penginapan', 'Wifi Cepat', 'Parkir Luas'],
                'highlights' => [
                    'Saksi sejarah kelahiran bank rakyat pertama di bumi Nusantara',
                    'Koleksi lengkap uang kuno nusantara dari zaman kerajaan hingga revolusi',
                    'Ruang diorama interaktif sejarah ekonomi perbankan'
                ],
                'type' => 'ticket',
                'button_label' => 'Lihat Detail >',
                'button_class' => 'btn-slate-soft',
                'is_featured' => false,
                'open_hours' => '08:00 - 16:00 WIB',
                'temperature' => '25° - 29° C',
            ],
            [
                'id' => 15,
                'category_id' => 11,
                'name' => 'Pratistha Harsa',
                'slug' => 'pratistha-harsa-PyfDj',
                'badge_label' => 'Wisata Keluarga',
                'description' => 'Sentra wisata edukasi, outbound, dan pasar kuliner terpadu di kawasan Baturraden. Memiliki area perkemahan rindang, taman bermain ramah anak, serta pusat jajanan dan oleh-oleh khas Banyumas.',
                'location' => 'Baturraden, Banyumas',
                'subdistrict' => 'Baturraden',
                'address_full' => 'Jl. Pereng No. 1, Baturraden, Kabupaten Banyumas, Jawa Tengah 53151',
                'price' => 30000,
                'price_label' => '/ orang',
                'price_type_title' => 'TIKET MASUK',
                'rating' => 4.7,
                'reviews_count' => 290,
                'image' => 'https://images.unsplash.com/photo-1484557052118-f32bd25b45b5?auto=format&fit=crop&w=1200&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1484557052118-f32bd25b45b5?auto=format&fit=crop&w=800&q=80',
                ],
                'facilities' => ['Parkir Luas', 'Musholla', 'Spot Foto', 'Area Bermain Anak', 'Penginapan', 'Wifi Cepat', 'Toilet Bersih'],
                'highlights' => [
                    'Arena outbound dan camping ground berhawa sejuk lereng Baturraden',
                    'Pasar kuliner UMKM khas Banyumas yang lengkap dan terjangkau',
                    'Wahana rekreasi ramah anak dan keluarga besar'
                ],
                'type' => 'ticket',
                'button_label' => 'Lihat Detail >',
                'button_class' => 'btn-slate-soft',
                'is_featured' => false,
                'open_hours' => '08:00 - 17:00 WIB',
                'temperature' => '20° - 23° C',
            ],
        ];

        // Sinkronisasi data dari API bila ada data tambahan
        try {
            $destApiRes = Http::timeout(4)->get('https://porto-backend-dokemas.rryxja.easypanel.host/api/destinations?limit=100');
            if ($destApiRes->successful() && isset($destApiRes->json()['data'])) {
                foreach ($destApiRes->json()['data'] as $apiDest) {
                    $foundKey = null;
                    foreach ($destinationsData as $k => $localD) {
                        if ($localD['id'] == $apiDest['id'] || $localD['slug'] == $apiDest['slug']) {
                            $foundKey = $k;
                            break;
                        }
                    }

                    if ($foundKey !== null) {
                        // Perbarui data aktual dari backend
                        if (!empty($apiDest['name'])) $destinationsData[$foundKey]['name'] = $apiDest['name'];
                        if (!empty($apiDest['slug'])) $destinationsData[$foundKey]['slug'] = $apiDest['slug'];
                        if (!empty($apiDest['address'])) $destinationsData[$foundKey]['address_full'] = $apiDest['address'];
                        if (isset($apiDest['price'])) $destinationsData[$foundKey]['price'] = (int)$apiDest['price'];
                        if (!empty($apiDest['thumbnail_url'])) $destinationsData[$foundKey]['image'] = $apiDest['thumbnail_url'];
                    }
                }
            }
        } catch (\Exception $e) {
            // Gunakan $destinationsData baku
        }

        foreach ($destinationsData as $dest) {
            Destination::updateOrCreate(
                ['id' => $dest['id']],
                $dest
            );
        }
    }
}
