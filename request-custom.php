<?php
/**
 * SunTrip Indonesia - Custom Outing & Gathering Request
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/auth.php';

$pdo = get_db_connection();
$currentMember = current_member();
$pkgPrefill = clean($_GET['pkg'] ?? '');

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = clean($_POST['nama'] ?? '');
    $departemen = clean($_POST['departemen'] ?? '');
    $no_hp = clean($_POST['no_hp'] ?? '');
    $destinasi = clean($_POST['destinasi'] ?? '');
    $pax = (int)($_POST['pax'] ?? 0);
    $tanggal = clean($_POST['tanggal'] ?? '');
    $pesan = clean($_POST['pesan'] ?? '');

    if (!empty($nama) && !empty($departemen) && !empty($no_hp) && !empty($destinasi)) {
        // Auto register/login member if not already
        if (!is_member_logged_in()) {
            register_or_login_member($nama, $departemen, $no_hp);
        }

        $memberId = $_SESSION['member_id'] ?? null;

        $stmt = $pdo->prepare("INSERT INTO inquiries (member_id, nama, departemen, no_hp, package_title, perkiraan_pax, perkiraan_tanggal, pesan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$memberId, $nama, $departemen, $no_hp, $destinasi, $pax, $tanggal, $pesan]);

        $success = true;

        // Prepare WhatsApp message
        $waMsg = "Halo Admin SunTrip Indonesia, saya ingin mengajukan penawaran Custom Outing/Trip:";
        $waMsg .= "\n- Nama PIC: " . $nama;
        $waMsg .= "\n- Departemen / Instansi: " . $departemen;
        $waMsg .= "\n- Rencana Destinasi: " . $destinasi;
        if ($pax > 0) $waMsg .= "\n- Perkiraan Peserta: " . $pax . " Orang";
        if (!empty($tanggal)) $waMsg .= "\n- Estimasi Waktu/Bulan: " . $tanggal;
        if (!empty($pesan)) $waMsg .= "\n- Catatan Khusus: " . $pesan;
        $waMsg .= "\n\nMohon dibantu pembuatan proposal dan estimasi biayanya. Terima kasih!";

        $redirectWaUrl = make_wa_url(WHATSAPP_NUMBER, $waMsg);
    } else {
        $error = "Mohon lengkapi Nama, Departemen, No WhatsApp, dan Destinasi rencana Anda.";
    }
}

$pageTitle = "Ajukan Custom Outing & Gathering";
$activeNav = 'custom';
require_once __DIR__ . '/includes/header.php';
?>

<div style="padding: 20px 16px;">
    <div style="text-align: center; margin-bottom: 20px;">
        <span style="font-size: 11px; font-weight: 700; color: var(--sun-gold-hover); background: var(--sun-gold-light); padding: 3px 10px; border-radius: var(--radius-full); text-transform: uppercase;">
            SOLUSI OUTING & GATHERING
        </span>
        <h1 class="section-title" style="margin-top: 8px;">Rancang Trip Khusus Tim Anda</h1>
        <p class="section-subtitle">Dapatkan proposal resmi, rundown fleksibel, dan negosiasi budget terbaik untuk divisi kantor Anda.</p>
    </div>

    <?php if ($success): ?>
        <div style="background: #ECFDF5; border: 2px solid #10B981; border-radius: var(--radius-lg); padding: 20px; text-align: center;">
            <div style="width: 50px; height: 50px; background: #10B981; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            <h2 style="font-size: 17px; font-weight: 800; color: #064E3B; margin-bottom: 6px;">Permintaan Berhasil Dikirim!</h2>
            <p style="font-size: 12px; color: #047857; margin-bottom: 16px;">
                Data rencana trip Anda sudah tersimpan di sistem kami. Klik tombol di bawah untuk langsung terhubung dengan Tim Konsultan SunTrip di WhatsApp.
            </p>
            <a href="<?= $redirectWaUrl ?>" target="_blank" rel="noopener" class="btn-submit-form" style="background: #10B981; text-decoration: none;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                </svg>
                <span>Lanjutkan ke WhatsApp Konsultan</span>
            </a>
        </div>
    <?php else: ?>

        <?php if (!empty($error)): ?>
            <div style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 12px; border-radius: var(--radius-md); font-size: 12px; margin-bottom: 16px;">
                <?= clean($error) ?>
            </div>
        <?php endif; ?>

        <div style="background: white; border-radius: var(--radius-lg); padding: 20px 16px; border: 1px solid var(--card-border); box-shadow: var(--card-shadow);">
            <form method="POST" action="/request-custom.php">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap PIC *</label>
                    <input type="text" name="nama" value="<?= clean($currentMember['nama'] ?? '') ?>" class="form-input" placeholder="Contoh: Hendra Wijaya" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Departemen / Divisi / Nama Instansi *</label>
                    <input type="text" name="departemen" value="<?= clean($currentMember['departemen'] ?? '') ?>" class="form-input" placeholder="Contoh: Divisi Keuangan PT Mandiri Sejahtera" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor WhatsApp Aktif *</label>
                    <input type="tel" name="no_hp" value="<?= clean($currentMember['no_hp'] ?? '') ?>" class="form-input" placeholder="Contoh: 081234567890" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Destinasi yang Dituju *</label>
                    <input type="text" name="destinasi" value="<?= clean($pkgPrefill) ?>" class="form-input" placeholder="Contoh: Labuan Bajo / Bromo Malang / Bali / Lainnya" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div class="form-group">
                        <label class="form-label">Estimasi Peserta</label>
                        <input type="number" name="pax" class="form-input" placeholder="Contoh: 25" min="1">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Rencana Bulan/Tgl</label>
                        <input type="text" name="tanggal" class="form-input" placeholder="Contoh: Nov 2026">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Kebutuhan Tambahan / Catatan Khusus</label>
                    <textarea name="pesan" class="form-input" style="height: 80px; padding: 10px 14px; resize: vertical;" placeholder="Contoh: Perlu meeting room 1 hari, kaos seragam rombongan, dan fun outbound games."></textarea>
                </div>

                <button type="submit" class="btn-submit-form" style="margin-top: 10px;">
                    <span>Ajukan Rancangan Proposal</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg>
                </button>
            </form>
        </div>

    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
