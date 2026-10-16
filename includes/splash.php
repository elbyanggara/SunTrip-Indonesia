<?php
/**
 * SunTrip Indonesia - Premium Animated Splash Screen & Onboarding Entry
 */
?>
<!-- Premium Mobile Splash Screen Overlay -->
<div id="suntrip-splash" class="splash-screen-overlay" aria-label="Layar Sambutan SunTrip Indonesia">
    <!-- Ambient Animated Background Particles & Glow -->
    <div class="splash-ambient-bg">
        <div class="splash-glow-orb splash-orb-1"></div>
        <div class="splash-glow-orb splash-orb-2"></div>
        <div class="splash-contour-lines"></div>
    </div>

    <!-- Skip Button (Top Right) -->
    <button type="button" id="btn-splash-skip" class="splash-skip-btn" aria-label="Lewati ke Beranda">
        <span>Lewati</span>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
    </button>

    <!-- Center Content with Staggered Entrance Animations -->
    <div class="splash-center-content">
        <!-- Animated Sun Halo Brand Icon -->
        <div class="splash-brand-emblem">
            <div class="splash-halo-ring"></div>
            <div class="splash-halo-ring splash-halo-ring-2"></div>
            <div class="splash-icon-core">
                <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
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

        <!-- Official Tag & Brand Name -->
        <div class="splash-badge-wrap">
            <span class="splash-pill-badge">
                <span class="splash-dot-live"></span>
                BIRO PERJALANAN RESMI BPW
            </span>
        </div>

        <h1 class="splash-brand-title">
            SunTrip <span class="splash-gold-text">Indonesia</span>
        </h1>
        <p class="splash-tagline">
            Exclusive Archipelago Journeys & Corporate Outing
        </p>

        <!-- Feature Points in Splash -->
        <div class="splash-feature-strip">
            <div class="splash-feat-item">
                <span class="feat-bullet">✦</span>
                <span>Phinisi Liveaboard</span>
            </div>
            <div class="splash-feat-divider">•</div>
            <div class="splash-feat-item">
                <span class="feat-bullet">✦</span>
                <span>Custom Outing</span>
            </div>
            <div class="splash-feat-divider">•</div>
            <div class="splash-feat-item">
                <span class="feat-bullet">✦</span>
                <span>Gated Itinerary</span>
            </div>
        </div>
    </div>

    <!-- Bottom Action Card (Tanda Masuk / Enter Portal) -->
    <div class="splash-bottom-action">
        <div class="splash-quote-caption">
            "Buka pintu ke destinasi terindah nusantara dengan kurasi itinerary eksklusif."
        </div>

        <!-- Big Thumb-Friendly Interactive Enter Button -->
        <button type="button" id="btn-splash-enter" class="splash-btn-enter">
            <span class="splash-btn-ripple"></span>
            <span class="splash-btn-text">Masuk ke Halaman Utama</span>
            <div class="splash-btn-arrow-box">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </div>
        </button>

        <div class="splash-footer-legal">
            Terdaftar di Kemenparekraf • Hak Cipta © <?= date('Y') ?> SunTrip ID
        </div>
    </div>
</div>
