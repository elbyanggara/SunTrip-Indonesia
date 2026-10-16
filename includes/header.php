<?php
/**
 * SunTrip Indonesia - Global Header
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';

$currentMember = current_member();
$pageTitle = isset($pageTitle) ? $pageTitle . ' | ' . SITE_NAME : SITE_NAME . ' - ' . SITE_TAGLINE;
$activeNav = $activeNav ?? 'home';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title><?= clean($pageTitle) ?></title>
    <meta name="description" content="<?= SITE_DESCRIPTION ?>">
    <meta name="theme-color" content="#FAF8F5">
    
    <!-- Open Graph Meta -->
    <meta property="og:title" content="<?= clean($pageTitle) ?>">
    <meta property="og:description" content="<?= SITE_DESCRIPTION ?>">
    <meta property="og:type" content="website">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

    <!-- Desktop View Toggle Bar (Only visible on tablet & desktop screen) -->
    <div class="desktop-view-toggle">
        <span>Tampilan:</span>
        <button type="button" class="active" data-mode="mobile">📱 Mode HP (Mobile-Only)</button>
        <button type="button" data-mode="full">💻 Mode Layar Lebar</button>
    </div>

    <!-- Main Viewport Box (Centered phone simulation on desktop, natural fluid on smartphone) -->
    <div class="app-viewport">

        <?php if (!empty($showSplash)): ?>
            <?php require_once __DIR__ . '/splash.php'; ?>
        <?php endif; ?>

        <div class="app-container">

            <!-- Top Header App Bar -->
            <header class="app-header">
                <a href="/" class="brand-group">
                    <div class="brand-logo-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="4"></circle>
                            <path d="M12 2v2"></path>
                            <path d="M12 20v2"></path>
                            <path d="m4.93 4.93 1.41 1.41"></path>
                            <path d="m17.66 17.66 1.41 1.41"></path>
                            <path d="M2 12h2"></path>
                            <path d="M20 12h2"></path>
                            <path d="m6.34 17.66-1.41 1.41"></path>
                            <path d="m19.07 4.93-1.41 1.41"></path>
                        </svg>
                    </div>
                    <div class="brand-text-col">
                        <div class="brand-name">SunTrip <span>ID</span></div>
                        <div class="brand-tag">Travel & Outing</div>
                    </div>
                </a>

                <div class="header-user-status">
                    <?php if ($currentMember): ?>
                        <a href="/member.php" class="member-chip" title="Area Member Terdaftar">
                            <span class="pulse-dot"></span>
                            <span><?= clean(explode(' ', $currentMember['nama'])[0]) ?></span>
                        </a>
                    <?php else: ?>
                        <button type="button" class="btn-header-login" data-open-register>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <span>Buka Akses</span>
                        </button>
                    <?php endif; ?>
                </div>
            </header>
