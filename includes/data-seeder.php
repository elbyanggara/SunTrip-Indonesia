<?php
/**
 * SunTrip Indonesia - Package Data Seeder
 * Curated authentic Indonesian destinations for corporate outings & leisure
 */

function seed_initial_packages($pdo) {
    $packages = [
        [
            'slug' => 'labuan-bajo-komodo-phinisi-luxury',
            'title' => 'Labuan Bajo & Komodo Liveaboard Luxury',
            'category' => 'Corporate VIP & Gathering',
            'destination' => 'Labuan Bajo, Flores, NTT',
            'duration' => '3 Hari 2 Malam (3D2N)',
            'min_pax' => 10,
            'price_display' => 'Mulai Rp 3.850.000 / pax',
            'badge' => 'Favorit Korporat',
            'thumbnail' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=1200&q=80',
            'summary' => 'Jelajahi keajaiban Pulau Padar, Pink Beach, habitat Komodo, dan bermalam di kapal Phinisi ber-AC dengan fasilitas VIP chef on-board.',
            'itinerary_json' => json_encode([
                [
                    'day' => 1,
                    'title' => 'Kedatangan Bajo & Sunset Pulau Kelor',
                    'desc' => 'Tim SunTrip menyambut kedatangan Anda di Bandara Komodo (LBJ). Dilanjutkan dengan Welcome Lunch seafood khas Flores di restoran tepi laut. Boarding ke Kapal Phinisi, pengenalan kru kapal, dan berlayar santai menuju Pulau Kelor untuk mini trekking serta menikmati pemandangan perbukitan laut toska. Sunset dinner mewah di dek kapal sambil stargazing di perairan Pulau Kalong.'
                ],
                [
                    'day' => 2,
                    'title' => 'Sunrise Puncak Padar, Pink Beach & Komodo Dragon',
                    'desc' => '05.00 Pagi trekking ikonik menuju Puncak Pulau Padar untuk menyaksikan sunrise terindah di Indonesia. Dilanjutkan ke Pink Beach untuk berenang, snorkeling, dan sesi foto profesional dengan drone. Siang hari mengunjungi Pulau Komodo didampingi Naturalist Guide (Ranger resmi Taman Nasional). Sore hari berenang bersama pari manta liar di Manta Point dan bersantai di gosong pasir Taka Makassar.'
                ],
                [
                    'day' => 3,
                    'title' => 'Snorkeling Pulau Kanawa & Oleh-Oleh Manggarai',
                    'desc' => 'Sunrise snorkeling di taman terumbu karang Pulau Kanawa yang jernih bagaikan akuarium raksasa. Sarapan pagi di dek kapal sembari berlayar kembali menuju Marina Labuan Bajo. Berbelanja souvenir lokal: Kopi Manggarai, Kain Tenun Songke, dan cemilan khas. Pengantaran kembali ke Bandara Komodo untuk penerbangan pulang.'
                ]
            ], JSON_UNESCAPED_UNICODE),
            'includes_json' => json_encode([
                'Charter Kapal Phinisi Semi-Luxury (Kabin AC, Kamar Mandi Dalam)',
                'Makan 3x sehari oleh Chef on-board + Free-flow Kopi/Teh/Snack',
                'Tiket masuk resmi Balai Taman Nasional Komodo & Ranger fee',
                'Peralatan Snorkeling lengkap (Masker, Snorkel, Fin, Life Vest)',
                'Dokumentasi Eksklusif: Mirrorless Camera & Drone 4K',
                'Tour Leader berpengalaman khusus corporate handling',
                'Asuransi Perjalanan Wisata & P3K Standar Medis',
                'Antar-jemput Bandara - Pelabuhan - Hotel'
            ], JSON_UNESCAPED_UNICODE),
            'excludes_json' => json_encode([
                'Tiket pesawat dari/ke Labuan Bajo (dapat dibantu booking grup)',
                'Pengeluaran pribadi & laundry di luar paket',
                'Tipping sukarela untuk Kru Kapal & Guide'
            ], JSON_UNESCAPED_UNICODE),
            'hotel_info' => 'Kabin AC Private di Kapal Phinisi (Twin/Double bed) + Fasilitas Genset 24 Jam & Sun Deck santai.',
            'is_featured' => 1
        ],
        [
            'slug' => 'bromo-sunrise-malang-team-building',
            'title' => 'Bromo Golden Sunrise & Malang Outing Outbound',
            'category' => 'Corporate Outing & Team Building',
            'destination' => 'Taman Nasional Bromo & Kota Batu, Jatim',
            'duration' => '3 Hari 2 Malam (3D2N)',
            'min_pax' => 20,
            'price_display' => 'Mulai Rp 1.950.000 / pax',
            'badge' => 'Best Value Team',
            'thumbnail' => 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?auto=format&fit=crop&w=1200&q=80',
            'summary' => 'Petualangan Jeep 4x4 melintasi lautan pasir Bromo, sunrise Penanjakan, dan program team building seru mempererat sinergi tim di alam sejuk Batu.',
            'itinerary_json' => json_encode([
                [
                    'day' => 1,
                    'title' => 'Penjemputan, Wisata Apel & Gala Dinner Kota Batu',
                    'desc' => 'Tiba di Bandara Juanda Surabaya / Stasiun Malang. Perjalanan darat menuju Kota Batu yang sejuk. Makan siang di resto tradisional Jawa Timur, petik apel langsung di kebun petani, dan check-in hotel resort bintang 4. Malam hari disambut dengan Gala Dinner perusahaan lengkap dengan sound system, live acoustic, dan award session internal.'
                ],
                [
                    'day' => 2,
                    'title' => 'Midnight Jeep 4x4 Bromo, Pasir Berbisik & Savana',
                    'desc' => 'Pukul 00.30 bersiap transfer Jeep 4x4 menuju Penanjakan 1 Bromo untuk menyaksikan megahnya golden sunrise di atas lautan awan. Menjelajahi Kawah Bromo, Pura Luhur Poten, Pasir Berbisik, dan Bukit Teletubbies (Savana hijau). Siang hari kembali ke hotel untuk istirahat. Sore harinya diadakan sesi Fun Games & Team Building di lapangan hijau dipandu Master Trainer tersertifikasi.'
                ],
                [
                    'day' => 3,
                    'title' => 'Belanja Oleh-Oleh Khas Malang & Pelepasan',
                    'desc' => 'Sarapan buffet di hotel, waktu bebas menikmati kolam renang dan fasilitas resort. Check-out dan menuju pusat oleh-oleh khas Malang (Strudel, Keripik Apel, Bakso Frozen). Makan siang legendaris Rawon Nguling dan pengantaran kembali ke Stasiun / Bandara.'
                ]
            ], JSON_UNESCAPED_UNICODE),
            'includes_json' => json_encode([
                'Transportasi Bus Pariwisata AC Executive selama tour',
                'Armada Jeep 4x4 Bromo (1 Jeep isi 5-6 orang)',
                'Akomodasi Hotel Bintang 4 di Kota Batu (2 Malam, Twin Sharing)',
                'Makan 7x (Breakfast, Lunch, Dinner + 1x Gala Dinner Khusus)',
                'Tiket masuk seluruh objek wisata & Bromo Retribution',
                'Instruktur Games Outbound, Alat Games & Sound System',
                'Spanduk / Banner Foto Perjalanan Custom Logo Perusahaan',
                'Dokumentasi Foto & Video Cinematic Drone'
            ], JSON_UNESCAPED_UNICODE),
            'excludes_json' => json_encode([
                'Tiket transportasi dari kota asal (Kereta / Pesawat)',
                'Sewa kuda di lautan pasir Bromo (opsional)',
                'Pengeluaran pribadi di luar program'
            ], JSON_UNESCAPED_UNICODE),
            'hotel_info' => 'Golden Tulip Holland Resort / Kusuma Agrowisata Resort Batu (Bintang 4).',
            'is_featured' => 1
        ],
        [
            'slug' => 'bali-nusa-penida-jimbaran-escape',
            'title' => 'Bali Coastal Paradise & Nusa Penida Island Escape',
            'category' => 'Corporate Gathering & Incentive',
            'destination' => 'Denpasar, Nusa Penida & Ubud, Bali',
            'duration' => '4 Hari 3 Malam (4D3N)',
            'min_pax' => 15,
            'price_display' => 'Mulai Rp 2.850.000 / pax',
            'badge' => 'Eksklusif Populer',
            'thumbnail' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=80',
            'summary' => 'Eksplorasi tebing Kelingking Nusa Penida, sunset romantis di Uluwatu dengan Tari Kecak, santap seafood Jimbaran, dan arung jeram Sungai Ayung.',
            'itinerary_json' => json_encode([
                [
                    'day' => 1,
                    'title' => 'Penyambutan Khas Dewata, Melasti & Sunset Kecak Uluwatu',
                    'desc' => 'Penyambutan hangat di Bandara I Gusti Ngurah Rai dengan kalungan bunga kamboja Bali. Menuju pantai berpasir putih Melasti Beach, dilanjutkan sore hari ke Pura Luhur Uluwatu bertengger di atas tebing samudera untuk menyaksikan Tari Kecak & Api saat matahari terbenam. Makan malam Seafood BBQ pinggir pantai Jimbaran dengan deburan ombak.'
                ],
                [
                    'day' => 2,
                    'title' => 'Fast Boat Nusa Penida: Kelingking, Broken Beach & Angel Billabong',
                    'desc' => 'Pagi hari menyeberang dengan Speedboat dari Pantai Sanur ke Nusa Penida. Mengunjungi T-Rex Kelingking Cliff yang mendunia, kolam alami Angel’s Billabong, dan fenomena tebing melengkung Broken Beach. Makan siang prasmanan di Nusa Penida dan santai sore di Crystal Bay sebelum kembali ke daratan utama Bali.'
                ],
                [
                    'day' => 3,
                    'title' => 'White Water Rafting Ubud & Malam Keakraban',
                    'desc' => 'Petualangan seru Arung Jeram (White Water Rafting) di Sungai Ayung Ubud melintasi relief batu alam dan air terjun alami. Makan siang buffet di pinggir lembah hijau Ubud. Sore hari eksplorasi Ubud Monkey Forest dan Pasar Seni Tradisional. Malam puncak: Gala Dinner Gathering di Restaurant Rooftop Seminyak.'
                ],
                [
                    'day' => 4,
                    'title' => 'Belanja Oleh-Oleh & Transfer Out Bandara',
                    'desc' => 'Sarapan pagi santai di hotel. Belanja souvenir dan cinderamata khas Bali di Krisna Oleh-Oleh Nusantara / The Keranjang. Makan siang Ayam Betutu Khas Gilimanuk sebelum menuju Bandara Ngurah Rai.'
                ]
            ], JSON_UNESCAPED_UNICODE),
            'includes_json' => json_encode([
                'Hotel Bintang 4 di area Kuta / Seminyak (Twin Sharing)',
                'Tiket Speedboat PP Sanur - Nusa Penida',
                'Transportasi Bus Pariwisata AC Executive di Bali & Private Car di Penida',
                'Makan sesuai program termasuk Seafood BBQ Jimbaran',
                'Tiket Masuk Wisata & Pertunjukan Tari Kecak Uluwatu',
                'Paket Rafting Sungai Ayung Ubud lengkap perlengkapan keselamatan',
                'Tour Guide HPI Bahasa Indonesia berpengalaman',
                'Air Mineral 600ml setiap hari'
            ], JSON_UNESCAPED_UNICODE),
            'excludes_json' => json_encode([
                'Tiket Pesawat PP Denpasar (bisa request booking korporat)',
                'Biaya water sport di Tanjung Benoa (opsional)',
                'Tipping Guide & Supir'
            ], JSON_UNESCAPED_UNICODE),
            'hotel_info' => 'The ONE Legian / Fairfield by Marriott Bali Sunset Road (Bintang 4).',
            'is_featured' => 1
        ],
        [
            'slug' => 'raja-ampat-pianemo-coral-wonderland',
            'title' => 'Raja Ampat Pianemo & Misool Coral Wonderland',
            'category' => 'Executive & VIP Incentive',
            'destination' => 'Waisai & Pianemo, Raja Ampat, Papua Barat',
            'duration' => '4 Hari 3 Malam (4D3N)',
            'min_pax' => 8,
            'price_display' => 'Mulai Rp 7.500.000 / pax',
            'badge' => 'Bucket List VIP',
            'thumbnail' => 'https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?auto=format&fit=crop&w=1200&q=80',
            'summary' => 'Puncak destinasi maritim dunia: gugusan karst Pianemo, Telaga Bintang, snorkeling bersama ribuan biota laut langka, dan menginap di cottage atas air.',
            'itinerary_json' => json_encode([
                [
                    'day' => 1,
                    'title' => 'Tiba di Sorong, Speedboat Marina & Check-in Overwater Resort',
                    'desc' => 'Penjemputan di Bandara DEO Sorong pagi hari. Menggunakan VIP Speedboat melintasi Selat Dampier menuju kepulauan Raja Ampat. Check-in di resort eksklusif di atas air (overwater bungalow). Sunset kayaking di teluk yang tenang dan makan malam ikan bakar segar olahan chef lokal.'
                ],
                [
                    'day' => 2,
                    'title' => 'Ikon Karst Pianemo, Telaga Bintang & Snorkeling Sawinggrai',
                    'desc' => 'Mendaki 320 anak tangga kayu menuju Puncak Pianemo untuk menikmati panorama gugusan bukit karst zamrud di atas air laut gradasi toska-biru tua. Mengunjungi laguna berbentuk bintang di Telaga Bintang. Berenang dan snorkeling di Sawinggrai menyapa gerombolan ikan karang jinak.'
                ],
                [
                    'day' => 3,
                    'title' => 'Pasir Timbul, Friwen Beach & Barbeque Night',
                    'desc' => 'Pagi hari mengunjungi Pasir Timbul di tengah lautan yang hanya muncul saat air surut. Snorkeling di Friwen Wall dengan keanekaragaman terumbu karang terbaik di dunia. Berinteraksi ramah dengan anak-anak lokal di Kampung Wisata Arborek. Barbeque dinner di tepi pantai dengan api unggun.'
                ],
                [
                    'day' => 4,
                    'title' => 'Kembali ke Sorong, Roti Abon Gulung & Drop Off',
                    'desc' => 'Sarapan pagi dengan pemandangan sunrise samudera. Speedboat kembali ke Sorong. Singgah membeli oleh-oleh legendaris Roti Abon Gulung Sorong dan souvenir etnik Papua. Pengantaran kembali ke Bandara Sorong.'
                ]
            ], JSON_UNESCAPED_UNICODE),
            'includes_json' => json_encode([
                'Akomodasi 3 Malam di Overwater Cottage Resort Raja Ampat',
                'Speedboat Khusus Private selama 4 hari penuh',
                'PIN / Kartu Izin Masuk Taman Laut Raja Ampat (Tarif Domestik)',
                'Makan 3x sehari full board seafood & hidangan nusantara',
                'Peralatan Snorkeling & Life Jacket kualitas tinggi',
                'Guide lokal asli Raja Ampat & Fotografer Underwater Go-Pro',
                'Asuransi perjalanan laut & P3K'
            ], JSON_UNESCAPED_UNICODE),
            'excludes_json' => json_encode([
                'Tiket Pesawat ke Sorong (SOQ)',
                'Diving gear (jika ingin scuba diving berlisensi)',
                'Pengeluaran pribadi di resort'
            ], JSON_UNESCAPED_UNICODE),
            'hotel_info' => 'Raja Ampat Dive Lodge / Afu Resort (Overwater Bungalow).',
            'is_featured' => 0
        ],
        [
            'slug' => 'belitung-laskar-pelangi-granite-hopping',
            'title' => 'Belitung Island Hopping & Granite Geopark',
            'category' => 'Corporate Relax & Family',
            'destination' => 'Tanjung Pandan & Belitung Barat',
            'duration' => '3 Hari 2 Malam (3D2N)',
            'min_pax' => 12,
            'price_display' => 'Mulai Rp 1.650.000 / pax',
            'badge' => 'Paling Santai',
            'thumbnail' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=1200&q=80',
            'summary' => 'Jelajah gugusan batu granit raksasa di Pantai Tanjung Tinggi, snorkeling Pulau Lengkuas dengan mercusuar bersejarah, dan Danau Kaolin yang memukau.',
            'itinerary_json' => json_encode([
                [
                    'day' => 1,
                    'title' => 'Kedatangan, Mie Belitung Atep & Pantai Tanjung Tinggi',
                    'desc' => 'Tiba di Bandara Tanjung Pandan. Langsung mencicipi sarapan otentik Mie Belitung Atep disiram kuah udang gurih dengan Es Jeruk Kunci segar. Mengunjungi Pantai Tanjung Tinggi yang terkenal sebagai lokasi syuting film Laskar Pelangi dengan bongkahan batu granit raksasa. Sunset santai di Pantai Tanjung Pendam.'
                ],
                [
                    'day' => 2,
                    'title' => 'Traditional Boat Hopping: Mercusuar Lengkuas & Bintang Laut',
                    'desc' => 'Naik perahu nelayan tradisional berlayar ke Pulau Pasir untuk menemukan bintang laut oranye besar di air sebening kaca. Dilanjutkan ke Pulau Batu Berlayar, snorkeling terumbu karang di Pulau Lengkuas yang memiliki mercusuar tua peninggalan Belanda tahun 1882. Makan siang prasmanan kepiting dan ikan bakar di Pulau Kepayang. Malam hari santap malam kepiting asap legendaris.'
                ],
                [
                    'day' => 3,
                    'title' => 'Danau Kaolin Biru, Kopi Manggar & Kepulangan',
                    'desc' => 'Mengunjungi Danau Kaolin dengan air toska cemerlang bekas galian tambang putih salju. Menikmati kopi saring khas Kota 1001 Warung Kopi Manggar. Berbelanja kerupuk ikan, terasi Belitung, dan kerajinan tangan. Pengantaran ke Bandara Tanjung Pandan.'
                ]
            ], JSON_UNESCAPED_UNICODE),
            'includes_json' => json_encode([
                'Hotel Bintang 4 Tepi Pantai (Santika Premiere / BW Suite Belitung)',
                'Perahu Tradisional Kayu untuk Island Hopping & Alat Snorkeling',
                'Transportasi Bus Pariwisata AC selama di Belitung',
                'Makan 3x sehari termasuk Kuliner Mie Atep & Kepiting Asap',
                'Tiket masuk seluruh objek Geopark Belitung',
                'Tour Guide lokal ramah & berpengalaman',
                'Dokumentasi Foto Drone & DSLR'
            ], JSON_UNESCAPED_UNICODE),
            'excludes_json' => json_encode([
                'Tiket Pesawat PP Tanjung Pandan (TJQ)',
                'Pengeluaran pribadi & room service',
                'Tipping Guide & Driver'
            ], JSON_UNESCAPED_UNICODE),
            'hotel_info' => 'Hotel Santika Premiere Beach Resort Belitung / Swiss-Belresort Tanjung Binga.',
            'is_featured' => 0
        ],
        [
            'slug' => 'jogja-heritage-borobudur-merapi-lava',
            'title' => 'Yogyakarta Heritage, Borobudur & Merapi Lava Tour',
            'category' => 'Cultural & Capacity Building',
            'destination' => 'Yogyakarta, Sleman & Magelang',
            'duration' => '3 Hari 2 Malam (3D2N)',
            'min_pax' => 15,
            'price_display' => 'Mulai Rp 1.550.000 / pax',
            'badge' => 'Edukasi & Budaya',
            'thumbnail' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?auto=format&fit=crop&w=1200&q=80',
            'summary' => 'Menyatu dengan filosofi Yogyakarta: Kemegahan Candi Borobudur, aksi memacu adrenalin Jeep Merapi Lava Tour, dan malam keakraban Malioboro.',
            'itinerary_json' => json_encode([
                [
                    'day' => 1,
                    'title' => 'Kedatangan Jogja, Candi Prambanan & Tebing Breksi',
                    'desc' => 'Tiba di Bandara YIA / Stasiun Tugu Jogja. Makan siang di Jejamuran resto unik serba jamur. Menjelajahi kemegahan Candi Hindu terbesar Prambanan dan menikmati sunset magis dari atas pahatan Tebing Breksi. Check-in hotel bintang 4 di jantung kota, makan malam Gudeg Yu Djum yang legendaris.'
                ],
                [
                    'day' => 2,
                    'title' => 'Borobudur Sunrise View, Jeep Lava Tour & Gala Dinner',
                    'desc' => 'Pagi hari menikmati siluet Candi Borobudur dari Punthuk Setumbu. Lanjut ke lereng Gunung Merapi untuk petualangan offroad Jeep 4x4 melintasi Bunker Kaliadem, Museum Sisa Hartaku, dan manuver air di Sungai Kalikuning. Sore hari rileks di Kotagede belajar kerajinan perak. Malam hari Gala Dinner bertema Jawa Klasik dengan pertunjukan gamelan.'
                ],
                [
                    'day' => 3,
                    'title' => 'Keraton, Tamansari & Wisata Belanja Bakpia',
                    'desc' => 'Kunjungan budaya ke Keraton Kesultanan Yogyakarta dan kompleks pemandian putri raja Tamansari Water Castle. Berbelanja batik di Malioboro dan Bakpia Kukus Tugu Jogja langsung dari pabriknya. Pengantaran ke Stasiun / Bandara.'
                ]
            ], JSON_UNESCAPED_UNICODE),
            'includes_json' => json_encode([
                'Hotel Bintang 4 di sekitar Malioboro (Grand Mercure / The Phoenix)',
                'Armada Jeep 4x4 Merapi Lava Tour rute medium',
                'Bus Pariwisata AC Executive & Driver berlisensi',
                'Makan 7x khas kuliner otentik Yogyakarta',
                'Seluruh tiket masuk destinasi wisata & pemandu Keraton',
                'Tour Leader berdedikasi 24 jam',
                'Banner rombongan & dokumentasi foto video cinematic'
            ], JSON_UNESCAPED_UNICODE),
            'excludes_json' => json_encode([
                'Tiket Kereta Api / Pesawat dari kota asal',
                'Pengeluaran pribadi belanja & mini bar hotel',
                'Tipping Guide & Driver'
            ], JSON_UNESCAPED_UNICODE),
            'hotel_info' => 'Grand Inna Malioboro / Harper Malioboro Hotel Yogyakarta.',
            'is_featured' => 0
        ]
    ];

    $stmt = $pdo->prepare("INSERT OR IGNORE INTO packages (
        slug, title, category, destination, duration, min_pax, price_display,
        badge, thumbnail, summary, itinerary_json, includes_json, excludes_json, hotel_info, is_featured
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($packages as $pkg) {
        $stmt->execute([
            $pkg['slug'],
            $pkg['title'],
            $pkg['category'],
            $pkg['destination'],
            $pkg['duration'],
            $pkg['min_pax'],
            $pkg['price_display'],
            $pkg['badge'],
            $pkg['thumbnail'],
            $pkg['summary'],
            $pkg['itinerary_json'],
            $pkg['includes_json'],
            $pkg['excludes_json'],
            $pkg['hotel_info'],
            $pkg['is_featured']
        ]);
    }
}
