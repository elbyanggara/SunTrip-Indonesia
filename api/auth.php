<?php
/**
 * SunTrip Indonesia - Authentication API Endpoint
 */

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'register' || $action === 'login') {
        $nama = clean($_POST['nama'] ?? '');
        $departemen = clean($_POST['departemen'] ?? '');
        $no_hp = clean($_POST['no_hp'] ?? '');

        if (empty($nama) || empty($departemen) || empty($no_hp)) {
            echo json_encode([
                'success' => false,
                'message' => 'Lengkapi Nama, Departemen, dan Nomor WhatsApp Anda.'
            ]);
            exit;
        }

        // Basic phone validation
        $phone_clean = preg_replace('/[^0-9]/', '', $no_hp);
        if (strlen($phone_clean) < 9 || strlen($phone_clean) > 15) {
            echo json_encode([
                'success' => false,
                'message' => 'Nomor WhatsApp tidak valid (minimal 9 digit).'
            ]);
            exit;
        }

        try {
            $member = register_or_login_member($nama, $departemen, $no_hp);

            echo json_encode([
                'success' => true,
                'message' => 'Registrasi berhasil! Akses terbuka.',
                'member' => $member
            ]);
            exit;
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ]);
            exit;
        }
    }
}

echo json_encode(['success' => false, 'message' => 'Invalid action']);
exit;
