<?php
/**
 * SunTrip Indonesia - Authentication & Access Gatekeeper
 */

require_once __DIR__ . '/config.php';

/**
 * Check if a member is currently logged in
 */
function is_member_logged_in() {
    return !empty($_SESSION['member_id']) && !empty($_SESSION['member_nama']);
}

/**
 * Get current logged in member info
 */
function current_member() {
    if (!is_member_logged_in()) {
        return null;
    }
    return [
        'id' => $_SESSION['member_id'],
        'nama' => $_SESSION['member_nama'],
        'departemen' => $_SESSION['member_dept'] ?? '-',
        'no_hp' => $_SESSION['member_phone'] ?? '',
        'login_time' => $_SESSION['member_login_time'] ?? time(),
    ];
}

/**
 * Register or login member with Nama, Departemen, No HP
 * If phone exists, updates last login and returns existing member ID
 * Otherwise inserts a new member record
 */
function register_or_login_member($nama, $departemen, $no_hp) {
    $pdo = get_db_connection();

    // Standardize phone format (e.g. 0812... or 62812...)
    $clean_phone = preg_replace('/[^0-9]/', '', $no_hp);
    if (str_starts_with($clean_phone, '62')) {
        $clean_phone = '0' . substr($clean_phone, 2);
    }

    // Check if phone already registered
    $stmt = $pdo->prepare("SELECT * FROM members WHERE no_hp = ? LIMIT 1");
    $stmt->execute([$clean_phone]);
    $existing = $stmt->fetch();

    if ($existing) {
        // Update name, dept, and last_login
        $updateStmt = $pdo->prepare("UPDATE members SET nama = ?, departemen = ?, last_login_at = CURRENT_TIMESTAMP WHERE id = ?");
        $updateStmt->execute([$nama, $departemen, $existing['id']]);
        $memberId = $existing['id'];
    } else {
        // Insert new member
        $insertStmt = $pdo->prepare("INSERT INTO members (nama, departemen, no_hp) VALUES (?, ?, ?)");
        $insertStmt->execute([$nama, $departemen, $clean_phone]);
        $memberId = $pdo->lastInsertId();
    }

    // Set Session
    $_SESSION['member_id'] = $memberId;
    $_SESSION['member_nama'] = $nama;
    $_SESSION['member_dept'] = $departemen;
    $_SESSION['member_phone'] = $clean_phone;
    $_SESSION['member_login_time'] = time();

    // Set cookie for convenience (30 days)
    $cookie_payload = base64_encode(json_encode([
        'id' => $memberId,
        'nama' => $nama,
        'dept' => $departemen,
        'phone' => $clean_phone,
        'hash' => hash('sha256', $clean_phone . 'suntrip_secret_salt')
    ]));
    setcookie('suntrip_member_token', $cookie_payload, time() + (86400 * 30), "/");

    return [
        'id' => $memberId,
        'nama' => $nama,
        'departemen' => $departemen,
        'no_hp' => $clean_phone
    ];
}

/**
 * Auto-restore member session from cookie if available
 */
function restore_member_from_cookie() {
    if (is_member_logged_in()) {
        return true;
    }
    if (!empty($_COOKIE['suntrip_member_token'])) {
        try {
            $data = json_decode(base64_decode($_COOKIE['suntrip_member_token']), true);
            if (!empty($data['phone']) && !empty($data['hash'])) {
                $expected = hash('sha256', $data['phone'] . 'suntrip_secret_salt');
                if (hash_equals($expected, $data['hash'])) {
                    $_SESSION['member_id'] = $data['id'];
                    $_SESSION['member_nama'] = $data['nama'];
                    $_SESSION['member_dept'] = $data['dept'];
                    $_SESSION['member_phone'] = $data['phone'];
                    $_SESSION['member_login_time'] = time();
                    return true;
                }
            }
        } catch (Exception $e) {
            // Ignore corrupted cookie
        }
    }
    return false;
}

/**
 * Log out member
 */
function logout_member() {
    unset($_SESSION['member_id']);
    unset($_SESSION['member_nama']);
    unset($_SESSION['member_dept']);
    unset($_SESSION['member_phone']);
    unset($_SESSION['member_login_time']);
    if (isset($_COOKIE['suntrip_member_token'])) {
        setcookie('suntrip_member_token', '', time() - 3600, "/");
    }
}

/**
 * Check if admin is logged in
 */
function is_admin_logged_in() {
    return !empty($_SESSION['admin_id']) && !empty($_SESSION['admin_user']);
}

/**
 * Current admin
 */
function current_admin() {
    if (!is_admin_logged_in()) return null;
    return [
        'id' => $_SESSION['admin_id'],
        'username' => $_SESSION['admin_user'],
        'name' => $_SESSION['admin_name'] ?? 'Admin'
    ];
}

/**
 * Require admin access, redirect to admin login if not authenticated
 */
function require_admin($redirect_to = '/admin/login.php') {
    if (!is_admin_logged_in()) {
        header("Location: " . $redirect_to);
        exit;
    }
}

// Auto-run cookie restoration on file load
restore_member_from_cookie();
