<?php
/**
 * SunTrip Indonesia - Cinematic Animated Tourism Diversity Splash Screen
 * Features Ken-Burns cinematic slideshow, story progress bars, and interactive entry
 */

$splashSlides = [
    [
        'image' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?auto=format&fit=crop&w=1200&q=85',
        'location' => 'Labuan Bajo, Flores',
        'title' => 'Eksotisme Phinisi & Pulau Padar',
        'badge' => 'Wisata Bahari VIP'
    ],
    [
        'image' => 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?auto=format&fit=crop&w=1200&q=85',
        'location' => 'Taman Nasional Bromo',
        'title' => 'Golden Sunrise di Atas Lautan Awan',
        'badge' => 'Corporate Outing Favorit'
    ],
    [
        'image' => 'https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?auto=format&fit=crop&w=1200&q=85',
        'location' => 'Raja Ampat, Papua Barat',
        'title' => 'Mahakarya Karst & Biota Laut Terkaya',
        'badge' => 'Bucket List Dunia'
    ],
    [
        'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=85',
        'location' => 'Nusa Penida & Uluwatu, Bali',
        'title' => 'Kemegahan Tebing Samudera & Budaya',
        'badge' => 'Coastal Luxury'
    ],
    [
        'image' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?auto=format&fit=crop&w=1200&q=85',
        'location' => 'Yogyakarta & Candi Borobudur',
        'title' => 'Keagungan Warisan Budaya Nusantara',
        'badge' => 'Heritage & Team Gathering'
    ]
];
?>
<!-- Cinematic Mobile Splash Screen Overlay -->
<div id="suntrip-splash" class="splash-screen-overlay" aria-label="Layar Sambutan Keanekaragaman Wisata Nusantara">

    <!-- Cinematic Ken Burns Slideshow Background -->
    <div class="splash-slideshow-container" id="splash-slideshow">
        <?php foreach ($splashSlides as $idx => $slide): ?>
            <div class="splash-slide <?= $idx === 0 ? 'active' : '' ?>" data-slide-index="<?= $idx ?>">
                <img src="<?= clean($slide['image']) ?>" alt="<?= clean($slide['title']) ?>" class="splash-slide-media" loading="<?= $idx === 0 ? 'eager' : 'lazy' ?>">
                <div class="splash-slide-overlay"></div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Ambient Glow Particles Over Slides -->
    <div class="splash-ambient-bg">
        <div class="splash-glow-orb splash-orb-1"></div>
        <div class="splash-glow-orb splash-orb-2"></div>
    </div>

    <!-- Top Story Progress Bar & Navigation -->
    <div class="splash-top-bar">
        <!-- Story-style Progress Bars -->
        <div class="splash-story-bars" id="splash-story-bars">
            <?php foreach ($splashSlides as $idx => $slide): ?>
                <div class="story-bar-track" data-index="<?= $idx ?>">
                    <div class="story-bar-fill"></div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="splash-top-actions">
            <!-- Live Indicator Badge -->
            <div class="splash-live-badge">
                <span class="splash-dot-live"></span>
                <span>DESTINASI NUSANTARA</span>
            </div>

            <!-- Skip Button -->
            <button type="button" id="btn-splash-skip" class="splash-skip-btn" aria-label="Lewati ke Beranda">
                <span>Lewati</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        </div>
    </div>

    <!-- Center Content with Brand Emblem & Dynamic Destination Showcase -->
    <div class="splash-center-content">
        <!-- Brand Emblem with Rotating Halo Rings -->
        <div class="splash-brand-emblem">
            <div class="splash-halo-ring"></div>
            <div class="splash-halo-ring splash-halo-ring-2"></div>
            <div class="splash-icon-core">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="4"></circle>
                    <path d="M12 2v2"></path>
                    <path d="M12 20v2"></path>
                    <path d="m4.93 4.93 1.41 1.41"></path>
                    <path d="m17.66 17.66 1.41 1.41"></path>
                    <path d="M2 12h2"></path>
                    <path d="M20 12h2"></path>
                    <path d="m6.34 17.66-1.41 1.41"></path>
                    <path d="m19.07 4.93-1.41 1.41"></path>
                </svg>
            </div>
        </div>

        <!-- Brand Name -->
        <h1 class="splash-brand-title">
            SunTrip <span class="splash-gold-text">Indonesia</span>
        </h1>
        <p class="splash-tagline">
            Biro Perjalanan Wisata & Outing Korporat Terpercaya
        </p>

        <!-- Dynamic Destination Showcase Card (Changes dynamically on each slide) -->
        <div class="splash-dest-card" id="splash-dest-card">
            <div class="dest-badge-row">
                <span class="dest-location-pill" id="splash-dest-loc">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <span id="splash-loc-text"><?= clean($splashSlides[0]['location']) ?></span>
                </span>
                <span class="dest-category-pill" id="splash-badge-text"><?= clean($splashSlides[0]['badge']) ?></span>
            </div>
            <div class="dest-title-text" id="splash-title-text">
                "<?= clean($splashSlides[0]['title']) ?>"
            </div>
        </div>
    </div>

    <!-- Bottom Action Card (Tanda Masuk / Enter Portal) -->
    <div class="splash-bottom-action">
        <!-- Interactive Story Navigation Arrows -->
        <div class="splash-slide-controls">
            <button type="button" class="splash-nav-arrow" id="btn-slide-prev" aria-label="Destinasi Sebelumnya">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
            <span class="splash-slide-counter" id="splash-counter">1 / <?= count($splashSlides) ?></span>
            <button type="button" class="splash-nav-arrow" id="btn-slide-next" aria-label="Destinasi Selanjutnya">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        </div>

        <!-- Big Thumb-Friendly Interactive Enter Button -->
        <button type="button" id="btn-splash-enter" class="splash-btn-enter">
            <div class="splash-btn-content">
                <span class="splash-btn-label">Buka Portal SunTrip</span>
                <span class="splash-btn-sub">Eksplorasi Katalog & Rencana Perjalanan</span>
            </div>
            <div class="splash-btn-arrow-box">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </div>
        </button>

        <div class="splash-footer-legal">
            Izin Resmi BPW Kemenparekraf • Hak Cipta © <?= date('Y') ?> SunTrip Indonesia
        </div>
    </div>
</div>

<!-- Slides Data JSON for smooth JS transitions -->
<script>
    window.SUNTRIP_SPLASH_SLIDES = <?= json_encode($splashSlides, JSON_UNESCAPED_UNICODE) ?>;
</script>
