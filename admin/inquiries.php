<?php
/**
 * SunTrip Indonesia - Inbound Custom Trip Requests (Inquiries)
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_admin();
$pdo = get_db_connection();

// Handle status toggle
if (isset($_GET['done'])) {
    $doneId = (int)$_GET['done'];
    $stmt = $pdo->prepare("UPDATE inquiries SET status = 'selesai' WHERE id = ?");
    $stmt->execute([$doneId]);
    header("Location: /admin/inquiries.php");
    exit;
}

$inquiries = $pdo->query("SELECT * FROM inquiries ORDER BY id DESC")->fetchAll();

$pageTitle = "Permintaan Custom Outing";
$activeAdminNav = 'inquiries';
require_once __DIR__ . '/header.php';
?>

<div style="margin-bottom: 20px;">
    <p style="font-size: 13px; color: #64748B; margin: 0;">Total Permintaan Masuk: <strong><?= count($inquiries) ?> Leads</strong></p>
</div>

<div class="admin-table-card">
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>PIC & Dept</th>
                    <th>Kontak WhatsApp</th>
                    <th>Destinasi Rencana</th>
                    <th>Estimasi Peserta</th>
                    <th>Bulan/Tanggal</th>
                    <th>Catatan Kebutuhan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($inquiries)): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; color: #94A3B8; padding: 24px;">Belum ada permintaan custom trip masuk.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($inquiries as $inq): ?>
                        <tr>
                            <td>
                                <strong><?= clean($inq['nama']) ?></strong>
                                <div style="font-size: 11px; color: #64748B;"><?= clean($inq['departemen']) ?></div>
                            </td>
                            <td><?= clean($inq['no_hp']) ?></td>
                            <td><strong><?= clean($inq['package_title']) ?></strong></td>
                            <td><?= $inq['perkiraan_pax'] ? clean($inq['perkiraan_pax']) . ' Pax' : '-' ?></td>
                            <td><?= clean($inq['perkiraan_tanggal'] ?? '-') ?></td>
                            <td style="max-width: 200px; font-size: 12px; color: #475569;"><?= clean($inq['pesan'] ?? '-') ?></td>
                            <td>
                                <?php if ($inq['status'] === 'selesai'): ?>
                                    <span class="badge-pill badge-green">Ditindaklanjuti</span>
                                <?php else: ?>
                                    <span class="badge-pill badge-gold">Baru</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <a href="<?= make_wa_url($inq['no_hp'], 'Halo Bapak/Ibu ' . $inq['nama'] . ' dari ' . $inq['departemen'] . ', kami menindaklanjuti pengajuan custom trip ' . $inq['package_title'] . ' untuk rombongan Anda.') ?>" target="_blank" rel="noopener" class="btn-card-action" style="height: 30px; font-size: 11px; padding: 0 8px; background: #10B981;">
                                        <span>Balas WA</span>
                                    </a>
                                    <?php if ($inq['status'] !== 'selesai'): ?>
                                        <a href="/admin/inquiries.php?done=<?= $inq['id'] ?>" class="btn-card-action" style="height: 30px; font-size: 11px; padding: 0 8px; background: #64748B;">
                                            <span>Selesai</span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
