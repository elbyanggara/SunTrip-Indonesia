<?php
/**
 * SunTrip Indonesia - Admin Overview Dashboard
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

$pdo = get_db_connection();

// Metrics
$totalMembers = $pdo->query("SELECT COUNT(*) FROM members")->fetchColumn();
$totalPackages = $pdo->query("SELECT COUNT(*) FROM packages")->fetchColumn();
$totalInquiries = $pdo->query("SELECT COUNT(*) FROM inquiries")->fetchColumn();

// Latest Members
$latestMembers = $pdo->query("SELECT * FROM members ORDER BY id DESC LIMIT 5")->fetchAll();

$pageTitle = "Ringkasan Portal";
$activeAdminNav = 'dashboard';
require_once __DIR__ . '/header.php';
?>

<!-- Statistics Grid -->
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-card-title">Total Member Terdaftar</div>
        <div class="stat-card-value"><?= number_format($totalMembers) ?></div>
        <div style="font-size: 11px; color: #10B981; margin-top: 4px; font-weight: 600;">Pengunjung yang mengisi Nama & Dept</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-title">Paket Perjalanan Aktif</div>
        <div class="stat-card-value"><?= number_format($totalPackages) ?></div>
        <div style="font-size: 11px; color: #64748B; margin-top: 4px; font-weight: 600;">Destinasi dalam katalog</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-title">Permintaan Custom Trip</div>
        <div class="stat-card-value"><?= number_format($totalInquiries) ?></div>
        <div style="font-size: 11px; color: #D97706; margin-top: 4px; font-weight: 600;">Leads outing masuk</div>
    </div>
</div>

<!-- Recent Member Registrations Table -->
<div class="admin-table-card">
    <div style="padding: 16px; border-bottom: 1px solid #E2E8F0; display: flex; justify-content: space-between; align-items: center;">
        <h2 style="font-size: 15px; font-weight: 800; color: #0C362B; margin: 0;">Pendaftar Member Terbaru (Gated Access)</h2>
        <a href="/admin/members.php" style="font-size: 12px; font-weight: 700; color: #D97706; text-decoration: none;">Lihat Semua Data →</a>
    </div>

    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nama Pengunjung</th>
                    <th>Departemen / Instansi</th>
                    <th>No. WhatsApp</th>
                    <th>Waktu Daftar</th>
                    <th>Aksi Cepat</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($latestMembers)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: #94A3B8; padding: 24px;">Belum ada member terdaftar.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($latestMembers as $m): ?>
                        <tr>
                            <td><strong><?= clean($m['nama']) ?></strong></td>
                            <td><span class="badge-pill badge-green"><?= clean($m['departemen']) ?></span></td>
                            <td><?= clean($m['no_hp']) ?></td>
                            <td><?= date('d M Y, H:i', strtotime($m['registered_at'])) ?></td>
                            <td>
                                <a href="<?= make_wa_url($m['no_hp'], 'Halo Bapak/Ibu ' . $m['nama'] . ' dari ' . $m['departemen'] . ', terima kasih telah mengunjungi SunTrip Indonesia. Ada rencana destinasi outing yang bisa kami bantu persiapkan?') ?>" target="_blank" rel="noopener" class="btn-card-action" style="height: 30px; font-size: 11px; padding: 0 10px; background: #10B981; display: inline-flex;">
                                    <span>Chat WhatsApp</span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
