<?php
/**
 * SunTrip Indonesia - Detail Paket & Gated Itinerary
 * Core Gated Content Feature
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';

$pdo = get_db_connection();
$slug = clean($_GET['slug'] ?? '');

if (empty($slug)) {
    header("Location: /paket.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM packages WHERE slug = ? LIMIT 1");
$stmt->execute([$slug]);
$package = $stmt->fetch();

if (!$package) {
    header("Location: /paket.php");
    exit;
}

$isLoggedIn = is_member_logged_in();
$currentMember = current_member();

$itinerary = json_decode($package['itinerary_json'], true) ?? [];
$includes = json_decode($package['includes_json'], true) ?? [];
$excludes = json_decode($package['excludes_json'], true) ?? [];

$pageTitle = $package['title'];
$activeNav = 'paket';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Detail Hero Cover -->
<div class="detail-hero">
    <img src="<?= clean($package['thumbnail']) ?>" alt="<?= clean($package['title']) ?>" class="detail-hero-img">
    <div class="detail-hero-gradient"></div>

    <a href="/paket.php" class="detail-hero-back" aria-label="Kembali ke Katalog">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="m15 18-6-6 6-6"></path>
        </svg>
    </a>

    <div class="detail-hero-content">
        <div class="detail-tags">
            <span class="detail-tag"><?= clean($package['category']) ?></span>
            <?php if (!empty($package['badge'])): ?>
                <span class="detail-tag" style="background: var(--sun-gold); color: white;">★ <?= clean($package['badge']) ?></span>
            <?php endif; ?>
        </div>
        <h1 class="detail-title"><?= clean($package['title']) ?></h1>
    </div>
</div>

<!-- Quick Info Strip -->
<div class="detail-info-strip">
    <div class="info-col">
        <strong><?= clean($package['duration']) ?></strong>
        <span>Durasi Trip</span>
    </div>
    <div class="info-col" style="border-left: 1px solid var(--slate-200); border-right: 1px solid var(--slate-200);">
        <strong>Min. <?= $package['min_pax'] ?> Pax</strong>
        <span>Kapasitas Rombongan</span>
    </div>
    <div class="info-col">
        <strong><?= clean($package['destination']) ?></strong>
        <span>Lokasi Wisata</span>
    </div>
</div>

<!-- Main Body -->
<div class="detail-body">

    <!-- Overview Section -->
    <section class="detail-section">
        <h2 class="detail-section-title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="16" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
            <span>Ringkasan Perjalanan</span>
        </h2>
        <p style="font-size: 13px; color: var(--slate-700); line-height: 1.6;">
            <?= clean($package['summary']) ?>
        </p>
    </section>

    <!-- GATED ITINERARY SECTION -->
    <?php if ($isLoggedIn): ?>
        <!-- UNLOCKED VIEW: Full Day-by-Day Timeline -->
        <section class="detail-section" id="rundown-section">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
                <h2 class="detail-section-title" style="margin-bottom: 0;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <span>Rundown & Itinerary Lengkap</span>
                </h2>
                <span style="font-size: 11px; background: #DCFCE7; color: #15803D; font-weight: 700; padding: 2px 8px; border-radius: 12px;">
                    ✓ Terbuka
                </span>
            </div>

            <p style="font-size: 12px; color: var(--slate-500); margin-bottom: 16px;">
                Jadwal dapat disesuaikan (custom) dengan jam penerbangan dan agenda meeting rombongan <?= clean($currentMember['departemen']) ?>.
            </p>

            <div class="timeline-list">
                <?php foreach ($itinerary as $index => $item): ?>
                    <div class="timeline-item">
                        <div class="timeline-marker"><?= $item['day'] ?? ($index + 1) ?></div>
                        <h3 class="timeline-day-title">Hari <?= $item['day'] ?? ($index + 1) ?>: <?= clean($item['title'] ?? '') ?></h3>
                        <p class="timeline-day-desc"><?= clean($item['desc'] ?? '') ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Facilities Included & Excluded -->
        <section class="detail-section">
            <h2 class="detail-section-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="9 11 12 14 22 4"></polyline>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                </svg>
                <span>Fasilitas Paket</span>
            </h2>

            <div style="font-size: 13px; font-weight: 700; color: #065F46; margin-bottom: 8px;">Sudah Termasuk (Include):</div>
            <div class="facility-grid" style="margin-bottom: 16px;">
                <?php foreach ($includes as $inc): ?>
                    <div class="facility-item included">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span><?= clean($inc) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <div style="font-size: 13px; font-weight: 700; color: #991B1B; margin-bottom: 8px;">Belum Termasuk (Exclude):</div>
            <div class="facility-grid">
                <?php foreach ($excludes as $exc): ?>
                    <div class="facility-item excluded">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                        <span><?= clean($exc) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Hotel & Accommodation -->
        <section class="detail-section">
            <h2 class="detail-section-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M3 21h18"></path>
                    <path d="M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"></path>
                </svg>
                <span>Standar Akomodasi</span>
            </h2>
            <p style="font-size: 12px; color: var(--slate-700); line-height: 1.5;">
                <?= clean($package['hotel_info']) ?>
            </p>
        </section>

        <!-- Member Quick Action Box -->
        <div style="background: #F0FDF4; border: 1px solid #BBF7D0; border-radius: var(--radius-lg); padding: 14px; margin-bottom: 80px; text-align: center;">
            <p style="font-size: 12px; color: #166534; font-weight: 600; margin-bottom: 8px;">
                Membutuhkan penyesuaian khusus (custom budget / hotel) untuk rombongan <?= clean($currentMember['departemen']) ?>?
            </p>
            <a href="/request-custom.php?pkg=<?= urlencode($package['title']) ?>" style="font-size: 12px; color: #15803D; font-weight: 800; text-decoration: underline;">
                Buat Penawaran Custom Khusus Tim Anda →
            </a>
        </div>

    <?php else: ?>
        <!-- LOCKED GATED VIEW: Prompt user to register/login -->
        <div class="gated-locked-box">
            <div class="locked-icon-bubble">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
            </div>

            <h2 class="locked-heading">Detail Itinerary & Biaya Terkunci</h2>
            <p class="locked-subtext">
                Konten rundown acara hari-ke-hari, pembagian rute, fasilitas include/exclude, dan estimasi biaya per pax diproteksi khusus member terdaftar.
            </p>

            <!-- Blurred Silhouette preview to tease the content -->
            <div class="locked-preview-blur" aria-hidden="true">
                <div style="height: 14px; background: #94A3B8; border-radius: 4px; width: 60%; margin: 8px auto;"></div>
                <div style="height: 10px; background: #CBD5E1; border-radius: 4px; width: 90%; margin: 6px auto;"></div>
                <div style="height: 10px; background: #CBD5E1; border-radius: 4px; width: 80%; margin: 6px auto;"></div>
                <div style="height: 14px; background: #94A3B8; border-radius: 4px; width: 50%; margin: 12px auto 6px;"></div>
                <div style="height: 10px; background: #CBD5E1; border-radius: 4px; width: 85%; margin: 6px auto;"></div>
            </div>

            <!-- Fast In-Page Instant Registration Form (Mobile optimized) -->
            <div style="background: var(--bg-sand-light); border: 1px solid var(--slate-200); border-radius: var(--radius-md); padding: 14px; text-align: left; margin-top: 14px;">
                <div style="font-size: 13px; font-weight: 800; color: var(--forest-900); margin-bottom: 4px;">
                    Daftar Langsung di Sini (10 Detik)
                </div>
                <p style="font-size: 11px; color: var(--slate-500); margin-bottom: 12px;">
                    Cukup masukkan 3 data dasar untuk membuka seluruh katalog secara instan:
                </p>

                <form method="POST" action="/register.php">
                    <input type="hidden" name="redirect_pkg" value="<?= clean($package['slug']) ?>">

                    <div class="form-group" style="margin-bottom: 10px;">
                        <label class="form-label" style="font-size: 11px;">Nama Lengkap *</label>
                        <input type="text" name="nama" class="form-input" style="height: 42px; font-size: 13px;" placeholder="Nama Anda" required>
                    </div>

                    <div class="form-group" style="margin-bottom: 10px;">
                        <label class="form-label" style="font-size: 11px;">Departemen / Instansi *</label>
                        <input type="text" name="departemen" class="form-input" style="height: 42px; font-size: 13px;" placeholder="Contoh: HRD / Keuangan / IT" required>
                    </div>

                    <div class="form-group" style="margin-bottom: 12px;">
                        <label class="form-label" style="font-size: 11px;">Nomor WhatsApp *</label>
                        <input type="tel" name="no_hp" class="form-input" style="height: 42px; font-size: 13px;" placeholder="Contoh: 081234567890" required>
                    </div>

                    <button type="submit" class="btn-submit-form" style="height: 46px; font-size: 13px; background: var(--sun-gold);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <span>Buka Rincian Paket Ini Sekarang</span>
                    </button>
                </form>
            </div>
        </div>
    <?php endif; ?>

</div> <!-- /detail-body -->

<!-- Sticky Bottom Bar for Detail Page -->
<aside class="sticky-detail-bar">
    <div class="sticky-price-group">
        <span class="sticky-price-label">Estimasi Biaya</span>
        <span class="sticky-price-val"><?= clean($package['price_display']) ?></span>
    </div>

    <?php if ($isLoggedIn): ?>
        <a href="#" 
           class="btn-sticky-booking" 
           data-wa-booking 
           data-package-title="<?= clean($package['title']) ?>"
           data-member-name="<?= clean($currentMember['nama']) ?>"
           data-member-dept="<?= clean($currentMember['departemen']) ?>"
           data-wa-phone="<?= WHATSAPP_NUMBER ?>">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
            </svg>
            <span>Tanya Admin WA</span>
        </a>
    <?php else: ?>
        <button type="button" class="btn-card-action btn-accent" style="height: 46px; padding: 0 18px;" data-open-register data-package-title="<?= clean($package['title']) ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            <span>Buka Akses Itinerary</span>
        </button>
    <?php endif; ?>
</aside>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
