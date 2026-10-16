<?php
/**
 * SunTrip Indonesia - Core Configuration
 * Mobile-First Travel Agency & Corporate Outing Portal
 */

// Start session if not active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Timezone
date_default_timezone_set('Asia/Jakarta');

// Website Meta & Settings
define('SITE_NAME', 'SunTrip Indonesia');
define('SITE_TAGLINE', 'Biro Perjalanan Wisata & Outing Korporat Terpercaya');
define('SITE_DESCRIPTION', 'Portal informasi dan etalase paket wisata eksklusif Nusantara untuk korporat, instansi, dan keluarga dengan kurasi itinerary terbaik.');
define('WHATSAPP_NUMBER', '6281234567890'); // Ganti dengan nomor WhatsApp Admin SunTrip
define('WHATSAPP_DISPLAY', '0812-3456-7890');
define('OFFICE_EMAIL', 'halo@suntripindonesia.com');
define('OFFICE_ADDRESS', 'Menara Palma Lt. 12, Jl. HR Rasuna Said, Kuningan, Jakarta Selatan');
define('LEGAL_LICENSE', 'Izin Biro Perjalanan Wisata (BPW): No. 503/BPW-ST/2022');

// Database Configuration (SQLite default - zero configuration needed)
define('DB_FILE', __DIR__ . '/../data/suntrip.sqlite');

/**
 * Get Database Connection (PDO SQLite)
 * Automatically creates tables and seeds default data on first run
 */
function get_db_connection() {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    $dbDir = dirname(DB_FILE);
    if (!is_dir($dbDir)) {
        mkdir($dbDir, 0777, true);
    }

    $isNewDb = !file_exists(DB_FILE);

    try {
        $pdo = new PDO('sqlite:' . DB_FILE);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        if ($isNewDb) {
            init_database($pdo);
        }

        return $pdo;
    } catch (PDOException $e) {
        die("Koneksi Database Gagal: " . $e->getMessage());
    }
}

/**
 * Initialize Tables and Seed Initial Data
 */
function init_database($pdo) {
    // 1. Members Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS members (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nama TEXT NOT NULL,
        departemen TEXT NOT NULL,
        no_hp TEXT NOT NULL,
        registered_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        last_login_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        notes TEXT NULL,
        status TEXT DEFAULT 'active'
    )");

    // 2. Packages Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS packages (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        slug TEXT UNIQUE NOT NULL,
        title TEXT NOT NULL,
        category TEXT NOT NULL,
        destination TEXT NOT NULL,
        duration TEXT NOT NULL,
        min_pax INTEGER DEFAULT 10,
        price_display TEXT NOT NULL,
        badge TEXT NULL,
        thumbnail TEXT NOT NULL,
        summary TEXT NOT NULL,
        itinerary_json TEXT NOT NULL,
        includes_json TEXT NOT NULL,
        excludes_json TEXT NOT NULL,
        hotel_info TEXT NOT NULL,
        is_featured INTEGER DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // 3. Trip Inquiries / Inbound Leads
    $pdo->exec("CREATE TABLE IF NOT EXISTS inquiries (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        member_id INTEGER NULL,
        nama TEXT NOT NULL,
        departemen TEXT NOT NULL,
        no_hp TEXT NOT NULL,
        package_id INTEGER NULL,
        package_title TEXT NULL,
        perkiraan_pax INTEGER NULL,
        perkiraan_tanggal TEXT NULL,
        pesan TEXT NULL,
        status TEXT DEFAULT 'baru',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // 4. Admin Users
    $pdo->exec("CREATE TABLE IF NOT EXISTS admins (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE NOT NULL,
        password_hash TEXT NOT NULL,
        name TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Seed default admin (admin / suntrip2026)
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO admins (username, password_hash, name) VALUES (?, ?, ?)");
    $stmt->execute(['admin', password_hash('suntrip2026', PASSWORD_DEFAULT), 'Administrator SunTrip']);

    // Seed initial travel packages
    require_once __DIR__ . '/data-seeder.php';
    seed_initial_packages($pdo);
}

/**
 * Helper to sanitize user input
 */
function clean($data) {
    return htmlspecialchars(trim($data ?? ''), ENT_QUOTES, 'UTF-8');
}

/**
 * Helper to format WhatsApp link
 */
function make_wa_url($phone, $message = '') {
    $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
    if (str_starts_with($cleanPhone, '0')) {
        $cleanPhone = '62' . substr($cleanPhone, 1);
    }
    return 'https://wa.me/' . $cleanPhone . ($message ? '?text=' . rawurlencode($message) : '');
}
