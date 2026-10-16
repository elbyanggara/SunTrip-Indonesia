<?php
/**
 * SunTrip Indonesia - Add / Edit Tour Package
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_admin();
$pdo = get_db_connection();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$package = null;

if ($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM packages WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    $package = $stmt->fetch();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = clean($_POST['title'] ?? '');
    $slug = clean($_POST['slug'] ?? '');
    $category = clean($_POST['category'] ?? '');
    $destination = clean($_POST['destination'] ?? '');
    $duration = clean($_POST['duration'] ?? '');
    $min_pax = (int)($_POST['min_pax'] ?? 10);
    $price_display = clean($_POST['price_display'] ?? '');
    $badge = clean($_POST['badge'] ?? '');
    $thumbnail = clean($_POST['thumbnail'] ?? '');
    $summary = clean($_POST['summary'] ?? '');
    $hotel_info = clean($_POST['hotel_info'] ?? '');
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // Build Itinerary JSON from structured lines
    $itinerary_raw = trim($_POST['itinerary_raw'] ?? '');
    $itinerary_array = [];
    $days = preg_split('/\r\n|\r|\n/', $itinerary_raw);
    $dayCount = 1;
    foreach ($days as $line) {
        $line = trim($line);
        if (!empty($line)) {
            $parts = explode('|', $line, 2);
            $dayTitle = trim($parts[0] ?? "Hari $dayCount");
            $dayDesc = trim($parts[1] ?? $dayTitle);
            $itinerary_array[] = [
                'day' => $dayCount++,
                'title' => $dayTitle,
                'desc' => $dayDesc
            ];
        }
    }
    $itinerary_json = json_encode($itinerary_array, JSON_UNESCAPED_UNICODE);

    // Build Includes JSON
    $includes_raw = trim($_POST['includes_raw'] ?? '');
    $includes_array = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $includes_raw)));
    $includes_json = json_encode(array_values($includes_array), JSON_UNESCAPED_UNICODE);

    // Build Excludes JSON
    $excludes_raw = trim($_POST['excludes_raw'] ?? '');
    $excludes_array = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $excludes_raw)));
    $excludes_json = json_encode(array_values($excludes_array), JSON_UNESCAPED_UNICODE);

    if (empty($slug)) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    }

    if (!empty($title) && !empty($destination)) {
        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE packages SET slug = ?, title = ?, category = ?, destination = ?, duration = ?, min_pax = ?, price_display = ?, badge = ?, thumbnail = ?, summary = ?, itinerary_json = ?, includes_json = ?, excludes_json = ?, hotel_info = ?, is_featured = ? WHERE id = ?");
            $stmt->execute([$slug, $title, $category, $destination, $duration, $min_pax, $price_display, $badge, $thumbnail, $summary, $itinerary_json, $includes_json, $excludes_json, $hotel_info, $is_featured, $id]);
            $success = "Paket berhasil diperbarui!";
        } else {
            $stmt = $pdo->prepare("INSERT INTO packages (slug, title, category, destination, duration, min_pax, price_display, badge, thumbnail, summary, itinerary_json, includes_json, excludes_json, hotel_info, is_featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$slug, $title, $category, $destination, $duration, $min_pax, $price_display, $badge, $thumbnail, $summary, $itinerary_json, $includes_json, $excludes_json, $hotel_info, $is_featured]);
            $id = $pdo->lastInsertId();
            $success = "Paket baru berhasil ditambahkan!";
        }

        // Reload package
        $stmt = $pdo->prepare("SELECT * FROM packages WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $package = $stmt->fetch();
    } else {
        $error = "Mohon lengkapi Judul dan Destinasi paket.";
    }
}

// Prepare display values for textarea fields
$itinerary_text = '';
if ($package) {
    $existingItin = json_decode($package['itinerary_json'], true) ?? [];
    foreach ($existingItin as $item) {
        $itinerary_text .= ($item['title'] ?? '') . " | " . ($item['desc'] ?? '') . "\n";
    }
}

$includes_text = '';
if ($package) {
    $existingInc = json_decode($package['includes_json'], true) ?? [];
    $includes_text = implode("\n", $existingInc);
}

$excludes_text = '';
if ($package) {
    $existingExc = json_decode($package['excludes_json'], true) ?? [];
    $excludes_text = implode("\n", $existingExc);
}

$pageTitle = $id > 0 ? "Edit Paket: " . $package['title'] : "Tambah Paket Baru";
$activeAdminNav = 'packages';
require_once __DIR__ . '/header.php';
?>

<?php if (!empty($success)): ?>
    <div style="background: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; padding: 12px; border-radius: var(--radius-md); font-size: 13px; margin-bottom: 16px;">
        <?= clean($success) ?>
    </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 12px; border-radius: var(--radius-md); font-size: 13px; margin-bottom: 16px;">
        <?= clean($error) ?>
    </div>
<?php endif; ?>

<div class="admin-table-card" style="padding: 24px; max-width: 800px;">
    <form method="POST">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 14px;">
            <div class="form-group">
                <label class="form-label">Judul Paket Perjalanan *</label>
                <input type="text" name="title" value="<?= clean($package['title'] ?? '') ?>" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Kategori *</label>
                <input type="text" name="category" value="<?= clean($package['category'] ?? 'Corporate Outing') ?>" class="form-input" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px;">
            <div class="form-group">
                <label class="form-label">Destinasi *</label>
                <input type="text" name="destination" value="<?= clean($package['destination'] ?? '') ?>" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Durasi Trip *</label>
                <input type="text" name="duration" value="<?= clean($package['duration'] ?? '3 Hari 2 Malam (3D2N)') ?>" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Estimasi Harga *</label>
                <input type="text" name="price_display" value="<?= clean($package['price_display'] ?? 'Mulai Rp 2.500.000 / pax') ?>" class="form-input" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px;">
            <div class="form-group">
                <label class="form-label">Min. Peserta (Pax)</label>
                <input type="number" name="min_pax" value="<?= clean($package['min_pax'] ?? 10) ?>" class="form-input" min="1">
            </div>
            <div class="form-group">
                <label class="form-label">Badge Label (Opsional)</label>
                <input type="text" name="badge" value="<?= clean($package['badge'] ?? '') ?>" class="form-input" placeholder="Contoh: Best Seller">
            </div>
            <div class="form-group">
                <label class="form-label">URL Slug (Otomatis)</label>
                <input type="text" name="slug" value="<?= clean($package['slug'] ?? '') ?>" class="form-input" placeholder="contoh-paket-trip">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">URL Foto / Thumbnail</label>
            <input type="url" name="thumbnail" value="<?= clean($package['thumbnail'] ?? '') ?>" class="form-input" placeholder="https://images.unsplash.com/..." required>
        </div>

        <div class="form-group">
            <label class="form-label">Ringkasan / Teaser (Ditampilkan di Kartu Depan)</label>
            <textarea name="summary" class="form-input" style="height: 70px; padding: 10px 14px;"><?= clean($package['summary'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Rundown Itinerary Hari Demi Hari (🔒 Gated Content)</label>
            <div class="form-help" style="margin-bottom: 6px;">Format: <code>Judul Hari | Rincian kegiatan</code> (satu baris per hari)</div>
            <textarea name="itinerary_raw" class="form-input" style="height: 120px; font-family: monospace; font-size: 12px; padding: 10px 14px;"><?= clean(trim($itinerary_text)) ?></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
            <div class="form-group">
                <label class="form-label">Fasilitas Termasuk (Include)</label>
                <div class="form-help" style="margin-bottom: 4px;">Satu fasilitas per baris</div>
                <textarea name="includes_raw" class="form-input" style="height: 100px; font-size: 12px; padding: 10px 14px;"><?= clean(trim($includes_text)) ?></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Fasilitas Belum Termasuk (Exclude)</label>
                <div class="form-help" style="margin-bottom: 4px;">Satu poin per baris</div>
                <textarea name="excludes_raw" class="form-input" style="height: 100px; font-size: 12px; padding: 10px 14px;"><?= clean(trim($excludes_text)) ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Standar Hotel / Akomodasi</label>
            <input type="text" name="hotel_info" value="<?= clean($package['hotel_info'] ?? 'Hotel Bintang 4 / Resort') ?>" class="form-input">
        </div>

        <div style="margin-top: 10px; margin-bottom: 20px;">
            <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; cursor: pointer;">
                <input type="checkbox" name="is_featured" value="1" <?= (!empty($package['is_featured'])) ? 'checked' : '' ?>>
                <span>Tampilkan sebagai Paket Unggulan di Halaman Depan</span>
            </label>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn-card-action" style="background: #0C362B; height: 42px; padding: 0 24px;">
                <span>Simpan Paket</span>
            </button>
            <a href="/admin/packages.php" class="btn-card-action" style="background: #94A3B8; height: 42px; padding: 0 16px;">
                Batal
            </a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
