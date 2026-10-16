<?php
/**
 * SunTrip Indonesia - Admin Header Include
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';

require_admin();
$admin = current_admin();
$activeAdminNav = $activeAdminNav ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= clean($pageTitle ?? 'Admin') ?> | SunTrip Indonesia</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body class="admin-body">
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="admin-sidebar-brand">
                <div class="brand-logo-icon" style="width: 32px; height: 32px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="12" cy="12" r="4"></circle>
                        <path d="M12 2v2"></path>
                        <path d="M12 20v2"></path>
                    </svg>
                </div>
                <div>
                    <strong style="font-size: 14px; display: block; line-height: 1.2;">SunTrip Admin</strong>
                    <span style="font-size: 10px; opacity: 0.7;">Portal Pengelola</span>
                </div>
            </div>

            <nav class="admin-nav">
                <a href="/admin/index.php" class="admin-nav-link <?= $activeAdminNav === 'dashboard' ? 'active' : '' ?>">
                    <span>📊 Ringkasan</span>
                </a>
                <a href="/admin/members.php" class="admin-nav-link <?= $activeAdminNav === 'members' ? 'active' : '' ?>">
                    <span>👥 Data Member (Leads)</span>
                </a>
                <a href="/admin/packages.php" class="admin-nav-link <?= $activeAdminNav === 'packages' ? 'active' : '' ?>">
                    <span>🗺️ Kelola Paket Tour</span>
                </a>
                <a href="/admin/inquiries.php" class="admin-nav-link <?= $activeAdminNav === 'inquiries' ? 'active' : '' ?>">
                    <span>📩 Request Custom Trip</span>
                </a>
                <a href="/" target="_blank" class="admin-nav-link" style="margin-top: auto; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 12px;">
                    <span>🌐 Buka Website Utama ↗</span>
                </a>
                <a href="/admin/logout.php" class="admin-nav-link" style="color: #F87171;">
                    <span>🚪 Keluar</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="admin-content">
            <div class="admin-topbar">
                <div>
                    <h1 style="font-size: 20px; font-weight: 800; color: #0C362B;"><?= clean($pageTitle ?? 'Dashboard') ?></h1>
                    <span style="font-size: 12px; color: #64748B;">Login sebagai: <strong><?= clean($admin['name']) ?></strong></span>
                </div>
                <div>
                    <a href="/admin/members.php?export=csv" class="btn-card-action" style="background: #10B981; height: 38px;">
                        <span>📥 Download Data Member (CSV)</span>
                    </a>
                </div>
            </div>
