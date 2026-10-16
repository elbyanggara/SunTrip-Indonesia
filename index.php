<?php
/**
 * SunTrip Indonesia - Homepage & Company Profile Portal
 * Mobile-First Travel Showcase with Gated Content System
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';

$pdo = get_db_connection();
$currentMember = current_member();
$isLoggedIn = is_member_logged_in();

// Fetch packages
$categoryFilter = clean($_GET['kat'] ?? 'semua');
if ($categoryFilter !== 'semua') {
    $stmt = $pdo->prepare("SELECT * FROM packages WHERE category LIKE ? ORDER BY is_featured DESC, id ASC");
    $stmt->execute(['%' . $categoryFilter . '%']);
} else {
    $stmt = $pdo->query("SELECT * FROM packages ORDER BY is_featured DESC, id ASC");
}
$packages = $stmt->fetchAll();

$pageTitle = "Biro Perjalanan Wisata & Outing Korporat";
$activeNav = 'home';
$showSplash = true;
require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-compact">
    <div class="hero-pill-legal">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
        </svg>
        <span>BPW Resmi Terdaftar • Legal & Berasuransi</span>
    </div>

    <h1 class="hero-title">
        Jelajahi Nusantara Bersama <em>SunTrip</em>.
    </h1>

    <p class="hero-desc">
        Katalog eksklusif perjalanan wisata, family trip, dan gathering korporat dengan kurasi itinerary terpercaya & pelayanan standar VIP.
    </p>

    <!-- Key Stats -->
    <div class="hero-highlights">
        <div class="highlight-box">
            <strong>120+</strong>
            <span>Trip Korporat</span>
        </div>
        <div class="highlight-box">
            <strong>100%</strong>
            <span>Legal & Aman</span>
        </div>
        <div class="highlight-box">
            <strong>4.9 ★</strong>
            <span>Rating Klien</span>
        </div>
    </div>
</section>

<!-- Gated Content Awareness Banner -->
<?php if ($isLoggedIn): ?>
    <div class="member-unlocked-banner">
        <div class="member-welcome-header">
            <div class="member-welcome-title">Halo, <?= clean($currentMember['nama']) ?>! 👋</div>
            <div class="member-welcome-dept"><?= clean($currentMember['departemen']) ?></div>
        </div>
        <p class="member-welcome-desc">
            Akses member aktif. Seluruh jadwal rundown, day-by-day itinerary, dan fasilitas paket tour dapat Anda buka secara penuh.
        </p>
        <a href="/member.php" style="color: #A7F3D0; font-size: 11px; font-weight: 700; text-decoration: none;">
            Buka Dashboard Profil & Penawaran →
        </a>
    </div>
<?php else: ?>
    <div class="gatekeeper-banner">
        <div class="gatekeeper-content">
            <div class="gatekeeper-tag">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                <span>SISTEM AKSES TERTUTUP</span>
            </div>
            <h2 class="gatekeeper-title">Rincian Lengkap Itinerary Hanya untuk Member Terdaftar</h2>
            <p class="gatekeeper-text">
                Demi menjaga privasi alur trip & rancangan eksklusif, detail kegiatan dan susunan acara hanya dapat dilihat oleh pengunjung yang mendaftar.
            </p>
            <button type="button" class="btn-gate-register" data-open-register>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M19 8v6"></path>
                    <path d="M22 11h-6"></path>
                </svg>
                <span>Buka Akses Itinerary (10 Detik)</span>
            </button>
        </div>
    </div>
<?php endif; ?>

<!-- Category Filter Scroller -->
<div class="category-scroller">
    <a href="/?kat=semua" class="filter-chip <?= $categoryFilter === 'semua' ? 'active' : '' ?>">Semua Destinasi</a>
    <a href="/?kat=Corporate" class="filter-chip <?= $categoryFilter === 'Corporate' ? 'active' : '' ?>">🏢 Corporate Outing</a>
    <a href="/?kat=VIP" class="filter-chip <?= $categoryFilter === 'VIP' ? 'active' : '' ?>">⛵ VIP & Phinisi</a>
    <a href="/?kat=Team" class="filter-chip <?= $categoryFilter === 'Team' ? 'active' : '' ?>">🎯 Team Building</a>
    <a href="/?kat=Family" class="filter-chip <?= $categoryFilter === 'Family' ? 'active' : '' ?>">🏖️ Santai & Keluarga</a>
</div>

<!-- Section Heading -->
<div class="section-heading">
    <div>
        <h2 class="section-title">Katalog Pilihan</h2>
        <div class="section-subtitle">Pilihan rute terfavorit tahun 2026</div>
    </div>
    <a href="/paket.php" class="section-link">Semua (<?= count($packages) ?>) →</a>
</div>

<!-- Tour Packages List -->
<div class="tour-list">
    <?php foreach ($packages as $pkg): ?>
        <article class="tour-card">
            <div class="tour-thumb-wrapper">
                <img src="<?= clean($pkg['thumbnail']) ?>" alt="<?= clean($pkg['title']) ?>" class="tour-thumb" loading="lazy">
                
                <?php if (!empty($pkg['badge'])): ?>
                    <div class="tour-badge-top">
                        <span>★</span> <?= clean($pkg['badge']) ?>
                    </div>
                <?php endif; ?>

                <div class="tour-duration-badge">
                    <?= clean($pkg['duration']) ?>
                </div>
            </div>

            <div class="tour-card-body">
                <div class="tour-dest-label">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <span><?= clean($pkg['destination']) ?></span>
                </div>

                <h3 class="tour-card-title"><?= clean($pkg['title']) ?></h3>

                <p class="tour-card-summary"><?= clean($pkg['summary']) ?></p>

                <!-- Gated Status Indicator -->
                <div class="tour-gated-indicator <?= $isLoggedIn ? 'unlocked' : '' ?>">
                    <?php if ($isLoggedIn): ?>
                        <div class="gated-text">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: #10B981;">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            <span>Rundown Lengkap Terbuka</span>
                        </div>
                        <span class="gated-badge-action">Lihat Hari 1-<?= count(json_decode($pkg['itinerary_json'], true) ?? [1,2,3]) ?></span>
                    <?php else: ?>
                        <div class="gated-text">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--sun-gold);">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <span>Itinerary Terkunci</span>
                        </div>
                        <span class="gated-badge-action">Daftar untuk Buka 🔒</span>
                    <?php endif; ?>
                </div>

                <div class="tour-card-footer">
                    <div class="tour-price-group">
                        <span class="tour-price-label">Estimasi Biaya</span>
                        <span class="tour-price-val"><?= clean($pkg['price_display']) ?></span>
                    </div>

                    <a href="/detail-paket.php?slug=<?= urlencode($pkg['slug']) ?>" class="btn-card-action <?= $isLoggedIn ? '' : 'btn-accent' ?>">
                        <?php if ($isLoggedIn): ?>
                            <span>Detail Full</span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        <?php else: ?>
                            <span>Buka Detail</span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </article>
    <?php endforeach; ?>
</div>

<!-- Why Choose SunTrip Indonesia (Trust & Corporate Reliability) -->
<section class="trust-section">
    <div class="section-title">Mengapa SunTrip Indonesia?</div>
    <div class="section-subtitle">Standar tinggi penanganan rombongan & korporat</div>

    <div class="trust-grid">
        <div class="trust-card">
            <div class="trust-icon-box">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
            </div>
            <div class="trust-info">
                <h4>Legalitas Resmi & Berizin</h4>
                <p>Terdaftar resmi di Kemenparekraf dengan izin BPW sah, faktur pajak resmi, dan rekanan hotel terverifikasi.</p>
            </div>
        </div>

        <div class="trust-card">
            <div class="trust-icon-box">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="d22 19a6 6 0 0 0-6-6 6 6 0 0 0-6 6"></path>
                </svg>
            </div>
            <div class="trust-info">
                <h4>Khusus Outing & Gathering</h4>
                <p>Memahami dinamika rombongan kantor: pembagian kamar fleksibel, banner custom, seragam, hingga gala dinner terkonsep.</p>
            </div>
        </div>

        <div class="trust-card">
            <div class="trust-icon-box">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 6v6l4 2"></path>
                </svg>
            </div>
            <div class="trust-info">
                <h4>Rundown Tepat Waktu & Nyaman</h4>
                <p>Itinerary dirancang manusiawi, tidak buru-buru, memperhatikan waktu istirahat dan ibadah seluruh peserta.</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonial Section -->
<section class="testi-section">
    <div class="section-title">Suara Klien Kami</div>
    <div class="section-subtitle">Kepercayaan instansi & divisi kerja</div>

    <div class="testi-card">
        <p class="testi-quote">
            "Acara gathering 45 orang tim IT ke Bromo dan Malang berjalan sangat rapi. Rundown-nya tertata, makanan melimpah, dan dokumentasi videonya sangat profesional untuk laporan ke direksi."
        </p>
        <div class="testi-author">
            <div class="testi-avatar">R</div>
            <div class="testi-author-info">
                <strong>Rian Firmansyah</strong>
                <span>Lead Engineer, Tech Startup Jakarta</span>
            </div>
        </div>
    </div>

    <div class="testi-card">
        <p class="testi-quote">
            "Sewa Phinisi di Labuan Bajo bersama SunTrip benar-benar pengalaman tak terlupakan. Fasilitas kabin bersih, chef on-board masaknya enak, dan guide sangat ramah."
        </p>
        <div class="testi-author">
            <div class="testi-avatar">D</div>
            <div class="testi-author-info">
                <strong>Dewi Lestari</strong>
                <span>Divisi HR & GA Perbankan Nasional</span>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
