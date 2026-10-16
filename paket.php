<?php
/**
 * SunTrip Indonesia - Package Catalog
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';

$pdo = get_db_connection();
$isLoggedIn = is_member_logged_in();
$currentMember = current_member();

$search = clean($_GET['q'] ?? '');
$categoryFilter = clean($_GET['kat'] ?? 'semua');

$query = "SELECT * FROM packages WHERE 1=1";
$params = [];

if (!empty($search)) {
    $query .= " AND (title LIKE ? OR destination LIKE ? OR summary LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if ($categoryFilter !== 'semua') {
    $query .= " AND category LIKE ?";
    $params[] = "%$categoryFilter%";
}

$query .= " ORDER BY is_featured DESC, id ASC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$packages = $stmt->fetchAll();

$pageTitle = "Katalog Paket Tour & Outing";
$activeNav = 'paket';
require_once __DIR__ . '/includes/header.php';
?>

<div style="padding: 16px 16px 8px;">
    <h1 class="section-title">Katalog Paket Tour</h1>
    <p class="section-subtitle">Pilihan rute wisata eksklusif nusantara untuk perorangan & korporat.</p>

    <!-- Search Form -->
    <form method="GET" action="/paket.php" style="margin-top: 12px; display: flex; gap: 8px;">
        <input type="text" name="q" value="<?= clean($search) ?>" class="form-input" style="height: 42px; font-size: 13px;" placeholder="Cari destinasi (Bajo, Bromo, Bali...)">
        <button type="submit" class="btn-card-action" style="height: 42px; padding: 0 16px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.3-4.3"></path>
            </svg>
        </button>
    </form>
</div>

<!-- Category Chips -->
<div class="category-scroller" style="margin-top: 4px;">
    <a href="/paket.php?kat=semua" class="filter-chip <?= $categoryFilter === 'semua' ? 'active' : '' ?>">Semua</a>
    <a href="/paket.php?kat=Corporate" class="filter-chip <?= $categoryFilter === 'Corporate' ? 'active' : '' ?>">🏢 Corporate Outing</a>
    <a href="/paket.php?kat=VIP" class="filter-chip <?= $categoryFilter === 'VIP' ? 'active' : '' ?>">⛵ VIP & Phinisi</a>
    <a href="/paket.php?kat=Team" class="filter-chip <?= $categoryFilter === 'Team' ? 'active' : '' ?>">🎯 Team Building</a>
    <a href="/paket.php?kat=Family" class="filter-chip <?= $categoryFilter === 'Family' ? 'active' : '' ?>">🏖️ Santai & Keluarga</a>
</div>

<?php if (!$isLoggedIn): ?>
    <div style="margin: 0 16px 16px; padding: 12px; background: #FEF3C7; border: 1px solid #FDE68A; border-radius: var(--radius-md); font-size: 12px; color: #92400E; display: flex; align-items: center; justify-content: space-between;">
        <span>🔒 Detail rundown terkunci untuk umum.</span>
        <a href="#" data-open-register style="color: #B45309; font-weight: 800; text-decoration: underline;">Daftar Sekarang</a>
    </div>
<?php endif; ?>

<!-- Tour List -->
<div class="tour-list">
    <?php if (empty($packages)): ?>
        <div style="text-align: center; padding: 40px 16px; background: white; border-radius: var(--radius-lg); margin: 0 16px;">
            <p style="font-size: 14px; font-weight: 700; color: var(--forest-900);">Tidak ada paket yang sesuai pencarian.</p>
            <p style="font-size: 12px; color: var(--slate-500); margin-top: 4px;">Coba gunakan kata kunci lain atau lihat seluruh katalog.</p>
            <a href="/paket.php" class="btn-card-action" style="display: inline-flex; margin-top: 12px;">Reset Pencarian</a>
        </div>
    <?php else: ?>
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

                    <div class="tour-gated-indicator <?= $isLoggedIn ? 'unlocked' : '' ?>">
                        <?php if ($isLoggedIn): ?>
                            <div class="gated-text">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: #10B981;">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                <span>Akses Rundown Lengkap Terbuka</span>
                            </div>
                            <span class="gated-badge-action">Lihat Day 1-<?= count(json_decode($pkg['itinerary_json'], true) ?? [1,2,3]) ?></span>
                        <?php else: ?>
                            <div class="gated-text">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color: var(--sun-gold);">
                                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <span>Rundown Terkunci</span>
                            </div>
                            <span class="gated-badge-action">Daftar untuk Buka 🔒</span>
                        <?php endif; ?>
                    </div>

                    <div class="tour-card-footer">
                        <div class="tour-price-group">
                            <span class="tour-price-label">Estimasi Harga</span>
                            <span class="tour-price-val"><?= clean($pkg['price_display']) ?></span>
                        </div>

                        <a href="/detail-paket.php?slug=<?= urlencode($pkg['slug']) ?>" class="btn-card-action <?= $isLoggedIn ? '' : 'btn-accent' ?>">
                            <span><?= $isLoggedIn ? 'Detail Full' : 'Buka Detail' ?></span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
