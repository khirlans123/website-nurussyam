/**
 * ============================================================================
 * ANIMATED POP-UP NOTIFICATION ENGINE - PONDOK PESANTREN NURUSSYAM
 * ============================================================================
 * Mesin Notifikasi Khusus AKSI FITUR SISTEM:
 * 1. Berita: Menambah berita, memperbarui berita, menghapus berita, ubah status terbit/utama
 * 2. Santri & KTS: Cetak Kartu Tanda Santri (KTS), tambah santri, edit santri, hapus santri
 * 3. PSB: Verifikasi berkas, persetujuan santri diterima, cetak bukti PSB, hapus pendaftar
 * 4. Kategori: Tambah kategori, edit kategori, hapus kategori
 * 5. LAZISWAF: Catat donasi, verifikasi donasi, hapus donasi, salin rekening
 * 6. Role & Hak Akses: Tambah role, edit wewenang wewenang, hapus role
 * 7. Pengguna: Tambah akun, edit akun, hapus akun
 * 8. Pengaturan: Simpan konfigurasi website, perbarui media sosial
 * 9. Flash Messages otomatis dari respon server Laravel (success, error, warning)
 *
 * * Navigasi menu biasa & browsing halaman tetap tenang tanpa spam popup.
 */

(function () {
    'use strict';

    // 1. Container Management
    function getOrCreatePortal() {
        let portal = document.getElementById('nurussyam-toast-portal');
        if (!portal) {
            portal = document.createElement('div');
            portal.id = 'nurussyam-toast-portal';
            portal.className = 'toast-portal-container';
            portal.setAttribute('role', 'region');
            portal.setAttribute('aria-label', 'Pemberitahuan Sistem');
            document.body.appendChild(portal);
        }
        return portal;
    }

    // Default icons mapping
    const DEFAULT_ICONS = {
        success: 'ri-checkbox-circle-fill',
        info: 'ri-information-fill',
        warning: 'ri-alert-fill',
        error: 'ri-close-circle-fill',
        action: 'ri-sparkling-fill'
    };

    /**
     * Show Animated Toast Notification
     * @param {Object} options
     * @param {string} options.title - Notification title
     * @param {string} options.message - Notification message
     * @param {string} options.type - success | info | warning | error | action
     * @param {string} [options.icon] - Optional icon class
     * @param {number} [options.duration=3200] - Duration in ms
     */
    function showToast({
        title = 'Pemberitahuan',
        message = '',
        type = 'info',
        icon = null,
        duration = 3200
    } = {}) {
        const portal = getOrCreatePortal();

        // Limit active toasts to 3 to keep viewport clean
        const existingToasts = portal.querySelectorAll('.toast-item:not(.toast-hiding)');
        if (existingToasts.length >= 3) {
            dismissToast(existingToasts[0]);
        }

        const toast = document.createElement('div');
        toast.className = `toast-item toast-${type}`;
        toast.setAttribute('role', 'alert');

        const iconClass = icon || DEFAULT_ICONS[type] || DEFAULT_ICONS.info;

        toast.innerHTML = `
            <div class="toast-icon-wrapper">
                <i class="${iconClass}"></i>
            </div>
            <div class="toast-content">
                <div class="toast-title">${escapeHtml(title)}</div>
                ${message ? `<div class="toast-message">${escapeHtml(message)}</div>` : ''}
            </div>
            <button type="button" class="toast-close-btn" aria-label="Tutup">
                <i class="ri-close-line"></i>
            </button>
            <div class="toast-progress" style="animation-duration: ${duration}ms;"></div>
        `;

        // Close button click
        const closeBtn = toast.querySelector('.toast-close-btn');
        closeBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            dismissToast(toast);
        });

        portal.appendChild(toast);

        // Auto dismiss timer
        let timer = setTimeout(() => {
            dismissToast(toast);
        }, duration);

        // Pause on hover
        toast.addEventListener('mouseenter', () => {
            clearTimeout(timer);
            const progress = toast.querySelector('.toast-progress');
            if (progress) progress.style.animationPlayState = 'paused';
        });

        toast.addEventListener('mouseleave', () => {
            const progress = toast.querySelector('.toast-progress');
            if (progress) progress.style.animationPlayState = 'running';
            timer = setTimeout(() => {
                dismissToast(toast);
            }, 1200);
        });

        return toast;
    }

    function dismissToast(toast) {
        if (!toast || toast.classList.contains('toast-hiding')) return;
        toast.classList.add('toast-hiding');
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 320);
    }

    function escapeHtml(string) {
        if (!string) return '';
        const entityMap = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;'
        };
        return String(string).replace(/[&<>"']/g, s => entityMap[s]);
    }

    // Expose Global API
    window.showToast = showToast;
    window.notify = function (message, type = 'info', title = null, icon = null, duration = 3000) {
        const defaultTitles = {
            success: 'Berhasil!',
            error: 'Terjadi Kesalahan',
            warning: 'Peringatan',
            info: 'Informasi',
            action: 'Aksi Diproses'
        };
        return showToast({
            title: title || defaultTitles[type] || 'Pemberitahuan',
            message: message,
            type: type,
            icon: icon,
            duration: duration
        });
    };

    // 2. Process Flash Messages from Laravel Blade
    function checkInitialToasts() {
        if (window.__INITIAL_TOASTS__ && Array.isArray(window.__INITIAL_TOASTS__)) {
            window.__INITIAL_TOASTS__.forEach((toast, idx) => {
                setTimeout(() => {
                    showToast(toast);
                }, idx * 250);
            });
        }
    }

    // 3. TARGETED ACTION DISPATCHER (SEMUA AKSI DI DALAM FITUR)
    let lastActionTime = 0;
    const THROTTLE_MS = 600;

    function handleActionTrigger(target, eventType) {
        if (!target) return;
        if (target.closest('#nurussyam-toast-portal')) return;

        const now = Date.now();
        if (now - lastActionTime < THROTTLE_MS && !target.hasAttribute('data-toast')) {
            return;
        }

        // A. Custom data-toast attribute explicitly provided on element
        if (target.hasAttribute('data-toast')) {
            lastActionTime = now;
            showToast({
                title: target.getAttribute('data-toast-title') || 'Aksi Diproses',
                message: target.getAttribute('data-toast') || 'Fitur sedang dijalankan...',
                type: target.getAttribute('data-toast-type') || 'action',
                icon: target.getAttribute('data-toast-icon') || 'ri-sparkling-fill',
                duration: 2600
            });
            return;
        }

        const text = (target.innerText || target.value || '').trim();
        const lowerText = text.toLowerCase();
        const titleAttr = (target.getAttribute('title') || target.getAttribute('aria-label') || '').toLowerCase();
        const href = (target.getAttribute('href') || '').toLowerCase();
        const form = target.tagName === 'FORM' ? target : target.closest('form');
        const formAction = form ? (form.getAttribute('action') || '').toLowerCase() : '';
        const formMethod = form ? (form.getAttribute('method') || '').toLowerCase() : '';
        const isDeleteMethod = form && !!form.querySelector('input[name="_method"][value="DELETE"]');

        // B. AKSI CETAK KTS (KARTU TANDA SANTRI) & BUKTI PSB
        const isKtsAction = (
            href.includes('/card') ||
            lowerText.includes('kts') ||
            titleAttr.includes('kts') ||
            titleAttr.includes('kartu santri') ||
            titleAttr.includes('cetak kartu') ||
            (target.classList.contains('btn-print') && (document.title.toLowerCase().includes('kartu santri') || document.querySelector('.kts-card')))
        );

        if (isKtsAction) {
            lastActionTime = now;
            showToast({
                title: 'Mencetak Kartu Tanda Santri',
                message: 'Menyiapkan berkas dan membuka dialog cetak KTS resmi santri...',
                type: 'success',
                icon: 'ri-id-card-fill',
                duration: 3200
            });
            return;
        }

        const isPsbPrintAction = (
            href.includes('/print') ||
            titleAttr.includes('cetak bukti') ||
            lowerText.includes('cetak slip') ||
            (target.classList.contains('btn-print') && document.title.toLowerCase().includes('bukti pendaftaran'))
        );

        if (isPsbPrintAction) {
            lastActionTime = now;
            showToast({
                title: 'Mencetak Bukti PSB',
                message: 'Menyiapkan lembar bukti pendaftaran santri baru...',
                type: 'info',
                icon: 'ri-printer-fill',
                duration: 3000
            });
            return;
        }

        // C. AKSI MENGHAPUS DATA (DELETE)
        const isDeleteAction = (
            isDeleteMethod ||
            target.classList.contains('btn-danger') ||
            lowerText.includes('hapus') ||
            titleAttr.includes('hapus') ||
            (target.getAttribute('onclick') && target.getAttribute('onclick').toLowerCase().includes('hapus')) ||
            (form && form.getAttribute('onsubmit') && form.getAttribute('onsubmit').toLowerCase().includes('hapus'))
        );

        if (isDeleteAction) {
            lastActionTime = now;

            if (formAction.includes('donation') || titleAttr.includes('donasi') || lowerText.includes('donasi')) {
                showToast({
                    title: 'Menghapus Data Donasi',
                    message: 'Sedang memproses penghapusan riwayat transaksi donasi...',
                    type: 'error',
                    icon: 'ri-delete-bin-fill',
                    duration: 2800
                });
                return;
            }

            if (formAction.includes('article') || titleAttr.includes('berita') || lowerText.includes('berita')) {
                showToast({
                    title: 'Menghapus Berita',
                    message: 'Sedang memproses penghapusan artikel berita dari sistem...',
                    type: 'error',
                    icon: 'ri-delete-bin-2-fill',
                    duration: 2800
                });
                return;
            }

            if (formAction.includes('categor') || titleAttr.includes('kategori') || lowerText.includes('kategori')) {
                showToast({
                    title: 'Menghapus Kategori Berita',
                    message: 'Sedang menghapus kategori berita dari sistem...',
                    type: 'error',
                    icon: 'ri-delete-bin-fill',
                    duration: 2800
                });
                return;
            }

            if (formAction.includes('student') || titleAttr.includes('santri') || lowerText.includes('santri')) {
                showToast({
                    title: 'Menghapus Data Santri',
                    message: 'Sedang memproses penghapusan data santri aktif...',
                    type: 'error',
                    icon: 'ri-user-unfollow-fill',
                    duration: 2800
                });
                return;
            }

            if (formAction.includes('registration') || titleAttr.includes('psb') || lowerText.includes('psb')) {
                showToast({
                    title: 'Menghapus Berkas PSB',
                    message: 'Sedang menghapus data pendaftaran santri baru...',
                    type: 'error',
                    icon: 'ri-delete-bin-fill',
                    duration: 2800
                });
                return;
            }

            if (formAction.includes('role')) {
                showToast({
                    title: 'Menghapus Role Akses',
                    message: 'Sedang menghapus role wewenang dari sistem...',
                    type: 'error',
                    icon: 'ri-shield-cross-fill',
                    duration: 2800
                });
                return;
            }

            if (formAction.includes('user')) {
                showToast({
                    title: 'Menghapus Pengguna',
                    message: 'Sedang memproses penghapusan akun pengguna...',
                    type: 'error',
                    icon: 'ri-user-minus-fill',
                    duration: 2800
                });
                return;
            }

            // Generic delete
            showToast({
                title: 'Menghapus Data',
                message: 'Memproses konfirmasi penghapusan data secara permanen...',
                type: 'error',
                icon: 'ri-delete-bin-line',
                duration: 2600
            });
            return;
        }

        // D. AKSI DONASI & LAZISWAF (VERIFIKASI & CATAT)
        if (formAction.includes('donation') || formAction.includes('donasi')) {
            // Verifikasi donasi
            if (formAction.includes('verify') || lowerText.includes('verifikasi') || titleAttr.includes('verifikasi')) {
                lastActionTime = now;
                showToast({
                    title: 'Verifikasi Donasi Masuk',
                    message: 'Sedang memproses verifikasi dana infaq/donasi donatur...',
                    type: 'success',
                    icon: 'ri-hand-heart-fill',
                    duration: 2800
                });
                return;
            }

            // Simpan / Catat donasi baru
            if (eventType === 'submit' || target.type === 'submit') {
                lastActionTime = now;
                showToast({
                    title: 'Menyimpan Catatan Donasi',
                    message: 'Sedang mencatat transaksi LAZISWAF / infaq donatur...',
                    type: 'success',
                    icon: 'ri-hand-coin-fill',
                    duration: 2800
                });
                return;
            }
        }

        // E. AKSI BERITA & ARTIKEL
        if (href.includes('/articles/create') || titleAttr.includes('tulis berita') || (lowerText.includes('upload') && lowerText.includes('berita')) || (lowerText.includes('tulis') && lowerText.includes('berita'))) {
            lastActionTime = now;
            showToast({
                title: 'Upload Berita Baru',
                message: 'Membuka formulir untuk menulis dan mengunggah warta berita...',
                type: 'action',
                icon: 'ri-quill-pen-fill',
                duration: 2500
            });
            return;
        }

        if (form && (formAction.includes('articles') || formAction.includes('berita'))) {
            if (formAction.includes('toggle-publish')) {
                lastActionTime = now;
                showToast({
                    title: 'Status Publikasi Berita',
                    message: 'Sedang memperbarui status tayang warta (Terbit/Draft)...',
                    type: 'info',
                    icon: 'ri-toggle-line',
                    duration: 2500
                });
                return;
            }

            if (formAction.includes('toggle-featured')) {
                lastActionTime = now;
                showToast({
                    title: 'Status Berita Utama',
                    message: 'Sedang memperbarui status berita pilihan/unggulan...',
                    type: 'warning',
                    icon: 'ri-star-fill',
                    duration: 2500
                });
                return;
            }

            if (eventType === 'submit' || (target.type === 'submit' && formMethod === 'post')) {
                lastActionTime = now;
                const isUpdate = !!form.querySelector('input[name="_method"][value="PUT"]') || formAction.match(/\/\d+$/);
                showToast({
                    title: isUpdate ? 'Memperbarui Berita' : 'Mengunggah Berita Baru',
                    message: isUpdate ? 'Sedang menyimpan perubahan artikel warta...' : 'Sedang menyimpan dan mempublikasikan berita baru...',
                    type: 'success',
                    icon: 'ri-newspaper-fill',
                    duration: 2800
                });
                return;
            }
        }

        // F. AKSI KATEGORI BERITA
        if (form && formAction.includes('categories') && (eventType === 'submit' || target.type === 'submit')) {
            lastActionTime = now;
            const isUpdate = !!form.querySelector('input[name="_method"][value="PUT"]');
            showToast({
                title: isUpdate ? 'Perbarui Kategori' : 'Tambah Kategori Baru',
                message: isUpdate ? 'Sedang menyimpan perubahan nama & warna kategori...' : 'Sedang mendaftarkan kategori berita baru ke sistem...',
                type: 'action',
                icon: 'ri-price-tag-3-fill',
                duration: 2800
            });
            return;
        }

        // G. AKSI SANTRI AKTIF
        if (href.includes('/students/create') || (lowerText.includes('tambah') && lowerText.includes('santri'))) {
            lastActionTime = now;
            showToast({
                title: 'Tambah Santri Baru',
                message: 'Membuka formulir penambahan data santri resmi...',
                type: 'action',
                icon: 'ri-user-add-fill',
                duration: 2500
            });
            return;
        }

        if (form && formAction.includes('students') && (eventType === 'submit' || target.type === 'submit')) {
            lastActionTime = now;
            const isUpdate = !!form.querySelector('input[name="_method"][value="PUT"]') || formAction.match(/students\/\d+/);
            showToast({
                title: isUpdate ? 'Perbarui Data Santri' : 'Menyimpan Data Santri',
                message: isUpdate ? 'Sedang menyimpan pembaruan profil & biodata santri...' : 'Sedang memproses penyimpanan biodata santri aktif...',
                type: 'success',
                icon: 'ri-save-fill',
                duration: 2800
            });
            return;
        }

        // H. AKSI PSB: VERIFIKASI BERKAS & PERSETUJUAN KETERIMA SANTRI
        if (form && formAction.includes('registrations')) {
            if (formAction.includes('status') || lowerText.includes('verifikasi') || titleAttr.includes('verifikasi')) {
                lastActionTime = now;
                showToast({
                    title: 'Verifikasi Berkas PSB',
                    message: 'Sedang memproses verifikasi kelengkapan dokumen santri...',
                    type: 'info',
                    icon: 'ri-file-check-fill',
                    duration: 2800
                });
                return;
            }

            if (formAction.includes('approve') || lowerText.includes('setujui') || titleAttr.includes('setujui')) {
                lastActionTime = now;
                showToast({
                    title: 'Persetujuan Santri Diterima',
                    message: 'Menetapkan persetujuan kelulusan santri baru...',
                    type: 'success',
                    icon: 'ri-checkbox-circle-fill',
                    duration: 2800
                });
                return;
            }
        }

        // I. AKSI ROLE & HAK AKSES
        if (form && formAction.includes('roles') && (eventType === 'submit' || target.type === 'submit')) {
            lastActionTime = now;
            const isUpdate = !!form.querySelector('input[name="_method"][value="PUT"]');
            showToast({
                title: isUpdate ? 'Perbarui Hak Akses' : 'Tambah Role Baru',
                message: 'Sedang menyimpan pengaturan wewenang hak akses role...',
                type: 'action',
                icon: 'ri-shield-keyhole-fill',
                duration: 2800
            });
            return;
        }

        // J. AKSI PENGGUNA (USER)
        if (form && formAction.includes('users') && (eventType === 'submit' || target.type === 'submit')) {
            lastActionTime = now;
            const isUpdate = !!form.querySelector('input[name="_method"][value="PUT"]');
            showToast({
                title: isUpdate ? 'Perbarui Akun Pengguna' : 'Simpan Akun Pengguna',
                message: isUpdate ? 'Sedang menyimpan perubahan akun pengguna...' : 'Sedang memproses data akun pengguna & penugasan role...',
                type: 'action',
                icon: 'ri-user-settings-fill',
                duration: 2800
            });
            return;
        }

        // K. AKSI PROFIL PENGELOLA
        if (form && formAction.includes('profile') && (eventType === 'submit' || target.type === 'submit')) {
            lastActionTime = now;
            showToast({
                title: 'Perbarui Profil Akun',
                message: 'Sedang menyimpan perubahan data profil dan keamanan...',
                type: 'success',
                icon: 'ri-user-follow-fill',
                duration: 2800
            });
            return;
        }

        // L. AKSI PENGATURAN WEBSITE & MEDIA SOSIAL
        if (form && (formAction.includes('settings') || formAction.includes('social')) && (eventType === 'submit' || target.type === 'submit')) {
            lastActionTime = now;
            showToast({
                title: 'Simpan Pengaturan Website',
                message: 'Sedang menyimpan pembaruan kontak, rekening, & statistik...',
                type: 'success',
                icon: 'ri-save-3-fill',
                duration: 2800
            });
            return;
        }

        // M. AKSI BERSIHKAN ARSIP LOG AKTIVITAS
        if (form && formAction.includes('clear-old') && (eventType === 'submit' || target.type === 'submit')) {
            lastActionTime = now;
            showToast({
                title: 'Membersihkan Log Aktivitas',
                message: 'Sedang membersihkan riwayat audit aktivitas lama...',
                type: 'warning',
                icon: 'ri-brush-fill',
                duration: 2800
            });
            return;
        }

        // N. AKSI SALIN / COPY REKENING & NOMOR
        if (lowerText.includes('salin') || lowerText.includes('copy') || titleAttr.includes('salin') || target.classList.contains('btn-copy') || target.classList.contains('copy-btn')) {
            lastActionTime = now;
            showToast({
                title: 'Data Berhasil Disalin',
                message: 'Nomor rekening atau informasi telah disalin ke clipboard.',
                type: 'success',
                icon: 'ri-file-copy-2-fill',
                duration: 2600
            });
            return;
        }

        // O. FORMULIR PENDAFTARAN ONLINE SANTRI BARU (PUBLIC PSB)
        if (form && formAction.includes('pendaftaran') && (eventType === 'submit' || target.type === 'submit')) {
            lastActionTime = now;
            showToast({
                title: 'Mengirim Pendaftaran PSB',
                message: 'Sedang mengirimkan dan mencatat formulir santri baru...',
                type: 'info',
                icon: 'ri-send-plane-fill',
                duration: 3000
            });
            return;
        }
    }

    // Attach Event Listeners
    function initListeners() {
        checkInitialToasts();

        // 1. Click Listener for interactive action buttons & links
        document.addEventListener('click', function (e) {
            const target = e.target.closest('button, a, input[type="submit"], input[type="button"], [data-toast]');
            if (target) {
                handleActionTrigger(target, 'click');
            }
        }, { capture: true });

        // 2. Submit Listener for forms to catch form actions directly
        document.addEventListener('submit', function (e) {
            if (e.target && e.target.tagName === 'FORM') {
                handleActionTrigger(e.target, 'submit');
            }
        }, { capture: true });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initListeners);
    } else {
        initListeners();
    }
})();
