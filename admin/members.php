<?php
/**
 * SunTrip Indonesia - Manage Members (Leads)
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_admin();
$pdo = get_db_connection();

// Handle CSV Export
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=suntrip_members_' . date('Ymd_His') . '.csv');

    $output = fopen('php://output', 'w');
    // Output BOM for Excel UTF-8 compatibility
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

    fputcsv($output, ['ID', 'Nama Lengkap', 'Departemen / Instansi', 'Nomor WhatsApp', 'Tanggal Registrasi', 'Login Terakhir']);

    $stmt = $pdo->query("SELECT id, nama, departemen, no_hp, registered_at, last_login_at FROM members ORDER BY id DESC");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}

// Handle Delete Member
if (isset($_GET['delete'])) {
    $delId = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM members WHERE id = ?");
    $stmt->execute([$delId]);
    header("Location: /admin/members.php?msg=deleted");
    exit;
}

// Search
$search = clean($_GET['q'] ?? '');
if (!empty($search)) {
    $stmt = $pdo->prepare("SELECT * FROM members WHERE nama LIKE ? OR departemen LIKE ? OR no_hp LIKE ? ORDER BY id DESC");
    $stmt->execute(["%$search%", "%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM members ORDER BY id DESC");
}
$members = $stmt->fetchAll();

$pageTitle = "Data Member & Pengunjung";
$activeAdminNav = 'members';
require_once __DIR__ . '/header.php';
?>

<div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
    <form method="GET" action="/admin/members.php" style="display: flex; gap: 8px;">
        <input type="text" name="q" value="<?= clean($search) ?>" class="form-input" style="height: 38px; width: 260px;" placeholder="Cari nama, dept, atau no WA...">
        <button type="submit" class="btn-card-action" style="height: 38px;">Cari</button>
        <?php if (!empty($search)): ?>
            <a href="/admin/members.php" class="btn-card-action" style="height: 38px; background: #64748B;">Reset</a>
        <?php endif; ?>
    </form>

    <div style="font-size: 13px; color: #64748B;">
        Total Member Terdaftar: <strong><?= count($members) ?></strong>
    </div>
</div>

<div class="admin-table-card">
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Nama Pengunjung</th>
                    <th>Departemen / Instansi</th>
                    <th>No. WhatsApp</th>
                    <th>Tanggal Terdaftar</th>
                    <th>Login Terakhir</th>
                    <th style="width: 170px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($members)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: #94A3B8; padding: 24px;">Tidak ada data member yang cocok.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($members as $m): ?>
                        <tr>
                            <td><?= $m['id'] ?></td>
                            <td><strong><?= clean($m['nama']) ?></strong></td>
                            <td><span class="badge-pill badge-green"><?= clean($m['departemen']) ?></span></td>
                            <td><?= clean($m['no_hp']) ?></td>
                            <td><?= date('d M Y, H:i', strtotime($m['registered_at'])) ?></td>
                            <td><?= !empty($m['last_login_at']) ? date('d M Y, H:i', strtotime($m['last_login_at'])) : '-' ?></td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <a href="<?= make_wa_url($m['no_hp'], 'Halo Bapak/Ibu ' . $m['nama'] . ' dari ' . $m['departemen'] . ', kami dari SunTrip Indonesia. Apakah ada rencana agenda perjalanan atau outing divisi yang ingin dikonsultasikan?') ?>" target="_blank" rel="noopener" class="btn-card-action" style="height: 30px; font-size: 11px; padding: 0 8px; background: #10B981;">
                                        <span>WA</span>
                                    </a>
                                    <a href="/admin/members.php?delete=<?= $m['id'] ?>" onclick="return confirm('Hapus data member ini?');" class="btn-card-action" style="height: 30px; font-size: 11px; padding: 0 8px; background: #EF4444;">
                                        <span>Hapus</span>
                                    </a>
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
