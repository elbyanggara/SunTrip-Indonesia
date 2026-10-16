<?php
/**
 * SunTrip Indonesia - Fast Member Login by WhatsApp Phone
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone_input = clean($_POST['no_hp'] ?? '');
    $clean_phone = preg_replace('/[^0-9]/', '', $phone_input);
    if (str_starts_with($clean_phone, '62')) {
        $clean_phone = '0' . substr($clean_phone, 2);
    }

    if (!empty($clean_phone)) {
        $pdo = get_db_connection();
        $stmt = $pdo->prepare("SELECT * FROM members WHERE no_hp = ? OR no_hp = ? LIMIT 1");
        $stmt->execute([$clean_phone, '0' . ltrim($clean_phone, '0')]);
        $member = $stmt->fetch();

        if ($member) {
            register_or_login_member($member['nama'], $member['departemen'], $member['no_hp']);
            header("Location: /member.php");
            exit;
        } else {
            $error = "Nomor WhatsApp belum terdaftar. Silakan masukkan nama dan departemen Anda terlebih dahulu.";
        }
    } else {
        $error = "Masukkan nomor WhatsApp yang pernah Anda daftarkan.";
    }
}

$pageTitle = "Masuk Member";
$activeNav = 'member';
require_once __DIR__ . '/includes/header.php';
?>

<div style="padding: 24px 16px;">
    <div style="text-align: center; margin-bottom: 24px;">
        <h1 class="section-title">Masuk Area Member</h1>
        <p class="section-subtitle">Akses kembali seluruh rincian itinerary yang telah dibuka.</p>
    </div>

    <?php if (!empty($error)): ?>
        <div style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 12px; border-radius: var(--radius-md); font-size: 12px; margin-bottom: 16px;">
            <?= clean($error) ?>
            <div style="margin-top: 8px;">
                <a href="/register.php" style="color: #991B1B; font-weight: 800; text-decoration: underline;">Daftar Baru di Sini →</a>
            </div>
        </div>
    <?php endif; ?>

    <div style="background: white; border-radius: var(--radius-lg); padding: 20px 16px; border: 1px solid var(--card-border); box-shadow: var(--card-shadow);">
        <form method="POST" action="/login.php">
            <div class="form-group">
                <label class="form-label" for="phone">Nomor WhatsApp Terdaftar *</label>
                <input type="tel" id="phone" name="no_hp" class="form-input" placeholder="081234567890" required autofocus>
                <div class="form-help">Cukup masukkan nomor WA yang Anda gunakan saat pertama kali mendaftar.</div>
            </div>

            <button type="submit" class="btn-submit-form" style="margin-top: 14px;">
                <span>Masuk Sekarang</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M5 12h14"></path>
                    <path d="m12 5 7 7-7 7"></path>
                </svg>
            </button>
        </form>

        <div style="text-align: center; margin-top: 18px; font-size: 12px; color: var(--slate-500);">
            Belum pernah mendaftar? <a href="/register.php" style="color: var(--sun-gold-hover); font-weight: 700; text-decoration: underline;">Daftar 10 Detik di Sini</a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
