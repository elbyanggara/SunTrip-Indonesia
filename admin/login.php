<?php
/**
 * SunTrip Indonesia - Admin Login
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $pdo = get_db_connection();
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ? LIMIT 1");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_user'] = $admin['username'];
        $_SESSION['admin_name'] = $admin['name'];
        header("Location: /admin/index.php");
        exit;
    } else {
        $error = "Username atau password admin tidak valid.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengelola | SunTrip Indonesia</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: #082820;
            padding: 16px;
        }
        .admin-box {
            background: white;
            border-radius: var(--radius-lg);
            padding: 28px 24px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <div class="admin-box">
        <div style="text-align: center; margin-bottom: 20px;">
            <div style="width: 44px; height: 44px; background: var(--forest-800); border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; color: var(--sun-gold); margin-bottom: 10px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <circle cx="12" cy="12" r="4"></circle>
                    <path d="M12 2v2"></path>
                    <path d="M12 20v2"></path>
                </svg>
            </div>
            <h2 style="font-size: 18px; font-weight: 800; color: var(--forest-900);">SunTrip Admin Portal</h2>
            <p style="font-size: 12px; color: var(--slate-500);">Masuk untuk mengelola member dan paket wisata</p>
        </div>

        <?php if (!empty($error)): ?>
            <div style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 10px; border-radius: var(--radius-md); font-size: 12px; margin-bottom: 16px;">
                <?= clean($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/admin/login.php">
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-input" value="admin" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                <div class="form-help">Default: <strong>admin</strong> / <strong>suntrip2026</strong></div>
            </div>

            <button type="submit" class="btn-submit-form" style="margin-top: 14px;">
                <span>Masuk ke Dashboard</span>
            </button>
        </form>

        <div style="text-align: center; margin-top: 16px;">
            <a href="/" style="font-size: 11px; color: var(--slate-500); text-decoration: none;">← Kembali ke Halaman Utama</a>
        </div>
    </div>
</body>
</html>
