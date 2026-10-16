<?php
/**
 * SunTrip Indonesia - Global Footer & Bottom Nav
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';

$currentMember = current_member();
$activeNav = $activeNav ?? 'home';
?>
            <!-- Compact Trust Footer -->
            <footer class="app-footer">
                <div class="footer-brand"><?= SITE_NAME ?></div>
                <p class="footer-desc">Biro Perjalanan Wisata & Partner Outing Korporat Terpercaya. Berpengalaman menangani gathering instansi, BUMN, dan private leisure tour ke pelosok nusantara.</p>
                
                <div class="footer-contacts">
                    <div>📍 <?= OFFICE_ADDRESS ?></div>
                    <div>📞 WhatsApp: <?= WHATSAPP_DISPLAY ?></div>
                    <div>✉️ Email: <?= OFFICE_EMAIL ?></div>
                </div>

                <div class="footer-legal">
                    <span><?= LEGAL_LICENSE ?></span>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <a href="/?splash=1" data-replay-splash style="font-size: 10px; color: #F59E0B; text-decoration: none;">✨ Putar Splash</a>
                        <a href="/admin/login.php" style="font-size: 9px; opacity: 0.6;">Portal Admin</a>
                    </div>
                </div>
            </footer>

        </div> <!-- /app-container -->

        <?php if (!empty($customBottomBar)): ?>
            <?= $customBottomBar ?>
        <?php elseif (empty($hideBottomNav)): ?>
            <!-- Bottom Mobile App Bar (Thumb-Friendly Navigation) -->
            <nav class="bottom-nav">
                <a href="/" class="nav-item <?= $activeNav === 'home' ? 'active' : '' ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span>Beranda</span>
                </a>

                <a href="/paket.php" class="nav-item <?= $activeNav === 'paket' ? 'active' : '' ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="20" height="14" x="2" y="7" rx="2" ry="2"></rect>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                    <span>Paket Tour</span>
                </a>

                <a href="/request-custom.php" class="nav-item <?= $activeNav === 'custom' ? 'active' : '' ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <span>Custom Trip</span>
                </a>

                <?php if ($currentMember): ?>
                    <a href="/member.php" class="nav-item <?= $activeNav === 'member' ? 'active' : '' ?>">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span>Area Member</span>
                    </a>
                <?php else: ?>
                    <a href="#" class="nav-item" data-open-register>
                        <span class="nav-badge-lock">🔒</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <span>Buka Akses</span>
                    </a>
                <?php endif; ?>

                <a href="<?= make_wa_url(WHATSAPP_NUMBER, 'Halo Admin SunTrip, saya ingin konsultasi perjalanan wisata.') ?>" target="_blank" rel="noopener" class="nav-item nav-item-wa">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    <span>Chat WA</span>
                </a>
            </nav>
        <?php endif; ?>

        <!-- Frictionless Member Registration Modal (Bottom Sheet Drawer) -->
        <div id="register-modal" class="modal-backdrop" aria-hidden="true">
            <div class="modal-sheet">
                <div class="modal-drag-pill"></div>
                
                <div class="modal-header-row">
                    <h3 class="modal-title">Buka Akses Itinerary Lengkap</h3>
                    <button type="button" class="btn-close-modal" data-close-register aria-label="Tutup">✕</button>
                </div>
                
                <p class="modal-subtitle">
                    Daftar sekali dalam 10 detik untuk membuka seluruh rincian itinerary hari-ke-hari, rundown, dan estimasi biaya paket tour.
                </p>

                <form id="form-register-member" method="POST" action="/register.php">
                    <input type="hidden" name="redirect_pkg" value="">

                    <div class="form-group">
                        <label class="form-label" for="reg-nama">Nama Lengkap *</label>
                        <input type="text" id="reg-nama" name="nama" class="form-input" placeholder="Contoh: Budi Santoso" required autocomplete="name">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reg-dept">Departemen / Divisi / Instansi *</label>
                        <input type="text" id="reg-dept" name="departemen" class="form-input" placeholder="Contoh: IT & Digital / HRD / Umum" required autocomplete="organization">
                        <div class="form-help">Untuk penyesuaian kebutuhan itinerary & format penawaran rombongan.</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reg-hp">Nomor WhatsApp Aktif *</label>
                        <input type="tel" id="reg-hp" name="no_hp" class="form-input" placeholder="Contoh: 081234567890" required autocomplete="tel">
                        <div class="form-help">Akan digunakan untuk verifikasi akses dan pengiriman update brosur.</div>
                    </div>

                    <button type="submit" class="btn-submit-form">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <span>Buka Akses Sekarang</span>
                    </button>
                </form>
            </div>
        </div>

    </div> <!-- /app-viewport -->

    <!-- Scripts with Cache Busting -->
    <script src="/assets/js/app.js?v=<?= filemtime(__DIR__ . '/../assets/js/app.js') ?>"></script>
</body>
</html>
