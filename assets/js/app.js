/**
 * SunTrip Indonesia - Mobile First Application Scripts
 */

document.addEventListener('DOMContentLoaded', () => {
    initSplashScreen();
    initModalGatekeeper();
    initDesktopToggle();
    initWhatsAppLinks();
});

/**
 * Authentic Editorial Splash Screen Controller
 */
function initSplashScreen() {
    const splash = document.getElementById('suntrip-splash');
    if (!splash) return;

    // Check if user requested to view or already viewed in this session
    const urlParams = new URLSearchParams(window.location.search);
    const forceSplash = urlParams.get('splash') === '1';

    if (!forceSplash && sessionStorage.getItem('suntrip_splash_seen')) {
        splash.style.display = 'none';
        document.body.classList.remove('splash-active');
        return;
    }

    // Hide bottom navigation while splash is active
    document.body.classList.add('splash-active');

    const enterBtn = document.getElementById('btn-splash-enter');
    const skipBtn = document.getElementById('btn-splash-skip');

    // Slides & Data
    const slides = splash.querySelectorAll('.splash-editorial-slide');
    const storyBars = splash.querySelectorAll('.story-track');
    const totalSlides = slides.length;

    let currentSlide = 0;
    let slideTimer = null;
    let progressTimer = null;
    const SLIDE_DURATION = 4600; // 4.6 seconds per destination for comfortable viewing

    function showSlide(index) {
        if (index < 0) index = totalSlides - 1;
        if (index >= totalSlides) index = 0;
        currentSlide = index;

        // Update slides visibility
        slides.forEach((slide, i) => {
            if (i === currentSlide) {
                slide.classList.add('active');
            } else {
                slide.classList.remove('active');
            }
        });

        // Update Story Progress Bars
        storyBars.forEach((bar, i) => {
            const fill = bar.querySelector('.story-progress');
            if (i < currentSlide) {
                bar.classList.add('completed');
                if (fill) fill.style.width = '100%';
            } else if (i === currentSlide) {
                bar.classList.remove('completed');
                if (fill) fill.style.width = '0%';
            } else {
                bar.classList.remove('completed');
                if (fill) fill.style.width = '0%';
            }
        });

        // Restart slide timing & progress animation
        startProgress();
    }

    function startProgress() {
        clearInterval(slideTimer);
        clearInterval(progressTimer);

        const activeBar = storyBars[currentSlide];
        const fill = activeBar ? activeBar.querySelector('.story-progress') : null;
        const startTime = Date.now();

        progressTimer = setInterval(() => {
            const elapsed = Date.now() - startTime;
            const percent = Math.min((elapsed / SLIDE_DURATION) * 100, 100);
            if (fill) fill.style.width = percent + '%';

            if (percent >= 100) {
                clearInterval(progressTimer);
                showSlide(currentSlide + 1);
            }
        }, 40);
    }

    // Story bar direct tap
    storyBars.forEach((bar, i) => {
        bar.addEventListener('click', () => {
            showSlide(i);
        });
    });

    // Dismissal logic
    function dismissSplash() {
        clearInterval(slideTimer);
        clearInterval(progressTimer);
        splash.classList.add('dismissed');
        document.body.classList.remove('splash-active');
        sessionStorage.setItem('suntrip_splash_seen', '1');
        setTimeout(() => {
            splash.style.display = 'none';
        }, 700);
    }

    if (enterBtn) enterBtn.addEventListener('click', dismissSplash);
    if (skipBtn) skipBtn.addEventListener('click', dismissSplash);

    // Replay button triggers from footer or URL
    const replayBtns = document.querySelectorAll('[data-replay-splash]');
    replayBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            document.body.classList.add('splash-active');
            splash.style.display = 'flex';
            void splash.offsetWidth; // Force reflow
            splash.classList.remove('dismissed');
            showSlide(0);
        });
    });

    // Start initial slide & animation
    showSlide(0);
}

/**
 * Toast Notification Helper
 */
function showToast(message, duration = 3000) {
    let toast = document.getElementById('app-toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'app-toast';
        toast.className = 'toast-notice';
        document.body.appendChild(toast);
    }
    toast.textContent = message;
    toast.classList.add('show');
    setTimeout(() => {
        toast.classList.remove('show');
    }, duration);
}

/**
 * Registration & Login Modal Controller
 */
function initModalGatekeeper() {
    const backdrop = document.getElementById('register-modal');
    if (!backdrop) return;

    // Trigger buttons
    const openBtns = document.querySelectorAll('[data-open-register]');
    const closeBtns = backdrop.querySelectorAll('[data-close-register]');

    openBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const sourcePkg = btn.getAttribute('data-package-title') || '';
            const pkgInput = backdrop.querySelector('input[name="redirect_pkg"]');
            if (pkgInput && sourcePkg) {
                pkgInput.value = sourcePkg;
            }
            openModal(backdrop);
        });
    });

    closeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            closeModal(backdrop);
        });
    });

    backdrop.addEventListener('click', (e) => {
        if (e.target === backdrop) {
            closeModal(backdrop);
        }
    });

    // Form Submission via AJAX for instant frictionless access
    const form = document.getElementById('form-register-member');
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            const nama = form.querySelector('[name="nama"]').value.trim();
            const departemen = form.querySelector('[name="departemen"]').value.trim();
            const no_hp = form.querySelector('[name="no_hp"]').value.trim();

            if (!nama || !departemen || !no_hp) {
                showToast('Mohon lengkapi Nama, Departemen, dan No HP');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span>Membuka Akses...</span>';

            try {
                const formData = new FormData(form);
                const response = await fetch('/api/auth.php?action=register', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    showToast('✅ Akses Terbuka! Selamat datang, ' + result.member.nama);
                    closeModal(backdrop);
                    setTimeout(() => {
                        window.location.reload();
                    }, 800);
                } else {
                    showToast(result.message || 'Gagal mendaftar, coba lagi.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            } catch (err) {
                // Fallback standard post if fetch fails
                form.submit();
            }
        });
    }
}

function openModal(modalEl) {
    modalEl.classList.add('show');
    document.body.style.overflow = 'hidden';
    const firstInput = modalEl.querySelector('input[name="nama"]');
    if (firstInput) {
        setTimeout(() => firstInput.focus(), 300);
    }
}

function closeModal(modalEl) {
    modalEl.classList.remove('show');
    document.body.style.overflow = '';
}

/**
 * Desktop Viewport Frame Toggle (Mobile Only frame vs Full width)
 */
function initDesktopToggle() {
    const toggleButtons = document.querySelectorAll('.desktop-view-toggle button');
    const viewport = document.querySelector('.app-viewport');
    if (!toggleButtons.length || !viewport) return;

    toggleButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            toggleButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const mode = btn.getAttribute('data-mode');
            if (mode === 'full') {
                viewport.classList.add('full-width-mode');
                document.body.classList.add('full-width-active');
            } else {
                viewport.classList.remove('full-width-mode');
                document.body.classList.remove('full-width-active');
            }
        });
    });
}

/**
 * Dynamic WhatsApp Prefill
 */
function initWhatsAppLinks() {
    const waButtons = document.querySelectorAll('[data-wa-booking]');
    waButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const pkgTitle = btn.getAttribute('data-package-title') || 'Paket Perjalanan';
            const memberName = btn.getAttribute('data-member-name') || '';
            const memberDept = btn.getAttribute('data-member-dept') || '';

            let msg = `Halo Admin SunTrip Indonesia, saya tertarik dengan informasi paket: *${pkgTitle}*.`;
            if (memberName) {
                msg += `\n\nNama: ${memberName}`;
                if (memberDept) msg += `\nDepartemen/Divisi: ${memberDept}`;
            }
            msg += `\n\nMohon info ketersediaan tanggal & proposal penawaran resminya. Terima kasih!`;

            const phone = btn.getAttribute('data-wa-phone') || '6281234567890';
            const url = `https://wa.me/${phone}?text=${encodeURIComponent(msg)}`;
            btn.href = url;
        });
    });
}
