<?php
/**
 * SunTrip Indonesia - Manage Tour Packages
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_admin();
$pdo = get_db_connection();

// Handle Delete Package
if (isset($_GET['delete'])) {
    $delId = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM packages WHERE id = ?");
    $stmt->execute([$delId]);
    header("Location: /admin/packages.php?msg=deleted");
    exit;
}

$packages = $pdo->query("SELECT * FROM packages ORDER BY id ASC")->fetchAll();

$pageTitle = "Kelola Paket Wisata";
$activeAdminNav = 'packages';
require_once __DIR__ . '/header.php';
?>

<div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
    <div>
        <p style="font-size: 13px; color: #64748B; margin: 0;">Total Paket Perjalanan: <strong><?= count($packages) ?> Paket</strong></p>
    </div>
    <a href="/admin/package-edit.php" class="btn-card-action" style="background: var(--sun-gold); height: 38px;">
        <span>+ Tambah Paket Baru</span>
    </a>
</div>

<div class="admin-table-card">
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 60px;">Foto</th>
                    <th>Judul Paket</th>
                    <th>Destinasi</th>
                    <th>Kategori</th>
                    <th>Durasi</th>
                    <th>Estimasi Biaya</th>
                    <th style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($packages as $pkg): ?>
                    <tr>
                        <td>
                            <img src="<?= clean($pkg['thumbnail']) ?>" alt="" style="width: 48px; height: 36px; object-fit: cover; border-radius: 6px;">
                        </td>
                        <td>
                            <strong><?= clean($pkg['title']) ?></strong>
                            <?php if ($pkg['badge']): ?>
                                <span class="badge-pill badge-gold" style="font-size: 9px; margin-left: 4px;"><?= clean($pkg['badge']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?= clean($pkg['destination']) ?></td>
                        <td><span class="badge-pill badge-green"><?= clean($pkg['category']) ?></span></td>
                        <td><?= clean($pkg['duration']) ?></td>
                        <td><strong><?= clean($pkg['price_display']) ?></strong></td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <a href="/admin/package-edit.php?id=<?= $pkg['id'] ?>" class="btn-card-action" style="height: 30px; font-size: 11px; padding: 0 10px; background: #0C362B;">
                                    Edit
                                </a>
                                <a href="/admin/packages.php?delete=<?= $pkg['id'] ?>" onclick="return confirm('Hapus paket ini?');" class="btn-card-action" style="height: 30px; font-size: 11px; padding: 0 10px; background: #EF4444;">
                                    Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
