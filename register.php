<?php
/**
 * SunTrip Indonesia - Registration Handler & Page
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';

$redirect_pkg = clean($_REQUEST['redirect_pkg'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = clean($_POST['nama'] ?? '');
    $departemen = clean($_POST['departemen'] ?? '');
    $no_hp = clean($_POST['no_hp'] ?? '');

    if (!empty($nama) && !empty($departemen) && !empty($no_hp)) {
        register_or_login_member($nama, $departemen, $no_hp);

        if (!empty($redirect_pkg)) {
            header("Location: /detail-paket.php?slug=" . urlencode($redirect_pkg));
            exit;
        } else {
            header("Location: /member.php");
            exit;
        }
    } else {
        $error = "Mohon lengkapi seluruh formulir di bawah ini.";
    }
}

$pageTitle = "Pendaftaran Akses Member";
$activeNav = 'member';
require_once __DIR__ . '/includes/header.php';
?>

<div style="padding: 24px 16px;">
    <div style="text-align: center; margin-bottom: 24px;">
        <div style="width: 56px; height: 56px; background: var(--forest-50); border: 2px solid var(--forest-700); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; color: var(--forest-700);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <polyline points="16 11 18 13 22 9"></polyline>
            </svg>
        </div>
        <h1 class="section-title">Buka Akses Lengkap</h1>
        <p class="section-subtitle">Daftarkan identitas Anda untuk membuka seluruh itinerary & rancangan biaya perjalanan.</p>
    </div>

    <?php if (!empty($error)): ?>
        <div style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 10px 14px; border-radius: var(--radius-md); font-size: 12px; margin-bottom: 16px;">
            <?= clean($error) ?>
        </div>
    <?php endif; ?>

    <div style="background: white; border-radius: var(--radius-lg); padding: 20px 16px; border: 1px solid var(--card-border); box-shadow: var(--card-shadow);">
        <form method="POST" action="/register.php">
            <input type="hidden" name="redirect_pkg" value="<?= clean($redirect_pkg) ?>">

            <div class="form-group">
                <label class="form-label" for="nama">Nama Lengkap *</label>
                <input type="text" id="nama" name="nama" class="form-input" placeholder="Contoh: Budi Santoso" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="dept">Departemen / Divisi / Instansi *</label>
                <input type="text" id="dept" name="departemen" class="form-input" placeholder="Contoh: HRD / IT / Keuangan" required>
                <div class="form-help">Untuk mempermudah format penawaran rombongan kantor.</div>
            </div>

            <div class="form-group">
                <label class="form-label" for="hp">Nomor WhatsApp Aktif *</label>
                <input type="tel" id="hp" name="no_hp" class="form-input" placeholder="Contoh: 081234567890" required>
                <div class="form-help">Digunakan untuk update ketersediaan slot trip & pengiriman e-proposal.</div>
            </div>

            <button type="submit" class="btn-submit-form" style="margin-top: 16px;">
                <span>Buka Akses Seluruh Katalog</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M5 12h14"></path>
                    <path d="m12 5 7 7-7 7"></path>
                </svg>
            </button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
