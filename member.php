<?php
/**
 * SunTrip Indonesia - Member Dashboard (Area Khusus Terdaftar)
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';

if (!is_member_logged_in()) {
    header("Location: /register.php");
    exit;
}

$member = current_member();
$pdo = get_db_connection();

// Fetch all unlocked packages
$stmt = $pdo->query("SELECT * FROM packages ORDER BY id ASC");
$packages = $stmt->fetchAll();

// Fetch previous inquiries made by this member
$inqStmt = $pdo->prepare("SELECT * FROM inquiries WHERE no_hp = ? ORDER BY id DESC LIMIT 5");
$inqStmt->execute([$member['no_hp']]);
$inquiries = $inqStmt->fetchAll();

$pageTitle = "Area Member Eksklusif";
$activeNav = 'member';
require_once __DIR__ . '/includes/header.php';
?>

<div style="padding: 16px;">

    <!-- Member Identity Card -->
    <div style="background: linear-gradient(135deg, var(--forest-900), var(--forest-700)); color: white; border-radius: var(--radius-lg); padding: 20px; box-shadow: 0 10px 25px -4px rgba(8, 40, 32, 0.3); margin-bottom: 20px; position: relative; overflow: hidden;">
        <div style="position: absolute; right: -15px; top: -15px; width: 90px; height: 90px; border-radius: 50%; background: rgba(217, 119, 6, 0.15); pointer-events: none;"></div>
        
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
            <div>
                <span style="font-size: 10px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; background: rgba(255, 255, 255, 0.18); padding: 3px 8px; border-radius: var(--radius-full); color: #FEF3C7;">
                    MEMBER TERDAFTAR
                </span>
                <h1 style="font-size: 20px; font-weight: 800; margin-top: 6px; line-height: 1.2;"><?= clean($member['nama']) ?></h1>
                <div style="font-size: 12px; opacity: 0.85; margin-top: 2px;">
                    Departemen: <strong><?= clean($member['departemen']) ?></strong>
                </div>
            </div>
            <a href="/logout.php" style="background: rgba(255, 255, 255, 0.15); color: white; text-decoration: none; padding: 6px 12px; border-radius: var(--radius-full); font-size: 11px; font-weight: 700;">
                Keluar
            </a>
        </div>

        <div style="border-top: 1px solid rgba(255, 255, 255, 0.12); padding-top: 12px; display: flex; justify-content: space-between; font-size: 11px; opacity: 0.9;">
            <div>No. WhatsApp: <strong><?= clean($member['no_hp']) ?></strong></div>
            <div style="color: #6EE7B7; font-weight: 700;">✓ Akses Terbuka Penuh</div>
        </div>
    </div>

    <!-- Quick Action Hub -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 24px;">
        <a href="/request-custom.php" style="background: white; border: 1px solid var(--card-border); border-radius: var(--radius-md); padding: 14px; text-decoration: none; color: inherit; box-shadow: var(--card-shadow); display: flex; flex-direction: column; gap: 6px;">
            <div style="width: 32px; height: 32px; background: var(--forest-50); color: var(--forest-800); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
            </div>
            <strong style="font-size: 13px; color: var(--forest-900);">Request Custom Outing</strong>
            <span style="font-size: 11px; color: var(--slate-500);">Rancang trip khusus departemen Anda</span>
        </a>

        <a href="<?= make_wa_url(WHATSAPP_NUMBER, 'Halo Admin SunTrip, saya ' . $member['nama'] . ' dari ' . $member['departemen'] . ' ingin konsultasi paket wisata.') ?>" target="_blank" rel="noopener" style="background: white; border: 1px solid var(--card-border); border-radius: var(--radius-md); padding: 14px; text-decoration: none; color: inherit; box-shadow: var(--card-shadow); display: flex; flex-direction: column; gap: 6px;">
            <div style="width: 32px; height: 32px; background: #ECFDF5; color: #10B981; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                </svg>
            </div>
            <strong style="font-size: 13px; color: var(--forest-900);">Konsultasi PIC</strong>
            <span style="font-size: 11px; color: var(--slate-500);">Respon cepat WhatsApp 24 Jam</span>
        </a>
    </div>

    <!-- Unlocked Itinerary Quick List -->
    <div class="section-heading" style="padding-left: 0; padding-right: 0;">
        <div>
            <h2 class="section-title">Itinerary yang Dapat Anda Akses</h2>
            <div class="section-subtitle">Pilih destinasi untuk melihat alur kegiatan lengkap</div>
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 10px;">
        <?php foreach ($packages as $pkg): ?>
            <a href="/detail-paket.php?slug=<?= urlencode($pkg['slug']) ?>" style="background: white; border: 1px solid var(--card-border); border-radius: var(--radius-md); padding: 12px; text-decoration: none; color: inherit; display: flex; align-items: center; gap: 12px; box-shadow: var(--card-shadow);">
                <img src="<?= clean($pkg['thumbnail']) ?>" alt="" style="width: 60px; height: 60px; border-radius: var(--radius-sm); object-fit: cover; flex-shrink: 0;">
                <div style="flex-grow: 1; min-width: 0;">
                    <span style="font-size: 10px; font-weight: 700; color: var(--sun-gold);"><?= clean($pkg['duration']) ?></span>
                    <h4 style="font-size: 13px; font-weight: 800; color: var(--forest-900); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 2px;">
                        <?= clean($pkg['title']) ?>
                    </h4>
                    <span style="font-size: 11px; color: var(--slate-500);"><?= clean($pkg['price_display']) ?></span>
                </div>
                <div style="flex-shrink: 0; color: var(--forest-800);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="m9 18 6-6-6-6"></path>
                    </svg>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
