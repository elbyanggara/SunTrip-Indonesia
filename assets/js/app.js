/**
 * SunTrip Indonesia - Mobile First Application Scripts
 */

document.addEventListener('DOMContentLoaded', () => {
    initModalGatekeeper();
    initDesktopToggle();
    initWhatsAppLinks();
});

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
