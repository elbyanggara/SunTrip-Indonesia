<?php
/**
 * SunTrip Indonesia - Editorial Luxury Travel Splash Screen
 * Authentic, Handcrafted, Human-Designed — Zero AI Slop
 */

$splashSlides = [
    [
        'image' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=1200&q=85',
        'number' => '01',
        'location' => 'Labuan Bajo, Flores',
        'title' => 'Pelayaran Phinisi & Pesona Gugusan Pulau Padar',
        'type' => 'Private Charter & VIP Outing'
    ],
    [
        'image' => 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?auto=format&fit=crop&w=1200&q=85',
        'number' => '02',
        'location' => 'Taman Nasional Bromo',
        'title' => 'Fajar Keemasan di Atas Lautan Pasir & Savana',
        'type' => 'Corporate Gathering & Team Building'
    ],
    [
        'image' => 'https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?auto=format&fit=crop&w=1200&q=85',
        'number' => '03',
        'location' => 'Raja Ampat, Papua Barat',
        'title' => 'Mahakarya Kepulauan Karst & Surga Terumbu Karang',
        'type' => 'Executive Incentive Trip'
    ],
    [
        'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=85',
        'number' => '04',
        'location' => 'Nusa Penida & Uluwatu, Bali',
        'title' => 'Kemegahan Tebing Samudera & Sunset Tari Kecak',
        'type' => 'Company Outing & Leisure'
    ],
    [
        'image' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?auto=format&fit=crop&w=1200&q=85',
        'number' => '05',
        'location' => 'Yogyakarta & Magelang',
        'title' => 'Warisan Keagungan Candi Borobudur & Merapi',
        'type' => 'Heritage & Cultural Experience'
    ]
];
?>
<!-- Editorial Luxury Splash Screen Overlay -->
<div id="suntrip-splash" class="splash-editorial-overlay" aria-label="Selamat Datang di SunTrip Indonesia">

    <!-- Cinematic Background Slides -->
    <div class="splash-slideshow-wrap">
        <?php foreach ($splashSlides as $idx => $slide): ?>
            <div class="splash-editorial-slide <?= $idx === 0 ? 'active' : '' ?>" data-index="<?= $idx ?>">
                <img src="<?= clean($slide['image']) ?>" alt="<?= clean($slide['title']) ?>" class="splash-editorial-img" loading="<?= $idx === 0 ? 'eager' : 'lazy' ?>">
                <div class="splash-editorial-vignette"></div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Top Editorial Header (Story Bars & Skip) -->
    <div class="splash-editorial-top">
        <div class="splash-story-timeline">
            <?php foreach ($splashSlides as $idx => $slide): ?>
                <div class="story-track" data-index="<?= $idx ?>">
                    <div class="story-progress"></div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="splash-top-row">
            <span class="splash-origin-badge">
                <span class="badge-dot"></span>
                <span>BIRO RESMI BPW • NUSANTARA</span>
            </span>

            <button type="button" id="btn-splash-skip" class="splash-text-skip" aria-label="Lewati ke Halaman Utama">
                <span>Lewati</span>
                <span class="skip-arrow">→</span>
            </button>
        </div>
    </div>

    <!-- Center Brand Identity (Classic Travel Agency Elegance) -->
    <div class="splash-editorial-center">
        <div class="brand-monogram-emblem">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="5"></circle>
                <line x1="12" y1="1" x2="12" y2="3"></line>
                <line x1="12" y1="21" x2="12" y2="23"></line>
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                <line x1="1" y1="12" x2="3" y2="12"></line>
                <line x1="21" y1="12" x2="23" y2="12"></line>
                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
            </svg>
        </div>

        <h1 class="splash-editorial-name">
            SunTrip
        </h1>
        <div class="splash-editorial-sub">
            I N D O N E S I A
        </div>
        <p class="splash-editorial-tagline">
            Kurasi Perjalanan Wisata & Outing Korporat
        </p>
    </div>

    <!-- Bottom Editorial Destination Caption & Action -->
    <div class="splash-editorial-bottom">
        <!-- Destination Info Block -->
        <div class="editorial-dest-block">
            <div class="dest-meta-header">
                <span class="dest-index-label" id="dest-number-label">01 / 05</span>
                <span class="dest-type-pill" id="dest-type-pill"><?= clean($splashSlides[0]['type']) ?></span>
            </div>
            <div class="dest-loc-title" id="dest-loc-text">
                📍 <?= clean($splashSlides[0]['location']) ?>
            </div>
            <h2 class="dest-main-title" id="dest-title-text">
                <?= clean($splashSlides[0]['title']) ?>
            </h2>
        </div>

        <!-- Slide Stepper (Prev / Next) -->
        <div class="editorial-stepper-row">
            <div class="stepper-nav">
                <button type="button" class="stepper-arrow-btn" id="btn-slide-prev" aria-label="Destinasi Sebelumnya">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
                <span class="stepper-dots-text" id="stepper-dots-text">Destinasi Pilihan</span>
                <button type="button" class="stepper-arrow-btn" id="btn-slide-next" aria-label="Destinasi Berikutnya">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Primary Solid Tactile Enter Button -->
        <button type="button" id="btn-splash-enter" class="btn-editorial-enter">
            <span class="btn-enter-text">Jelajahi Sekarang</span>
            <div class="btn-enter-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </div>
        </button>

        <div class="editorial-legal-mark">
            Legalitas Izin Resmi BPW Kemenparekraf RI
        </div>
    </div>

</div>

<!-- Data Passing -->
<script>
    window.SUNTRIP_SPLASH_SLIDES = <?= json_encode($splashSlides, JSON_UNESCAPED_UNICODE) ?>;
</script>
