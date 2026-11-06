/**
 * ============================================================================
 * LUXURY SINGLE PRELOADER (NO DOUBLE LOADING) - PP. NURUS SYAM
 * ============================================================================
 * 1. RESPON INSTAN (0ms): Begitu link fitur/halaman berbeda diklik atau form
 *    (seperti Login, Logout, Ganti Akun Role) dikirimkan, animasi loading
 *    langsung aktif memberikan feedback visual instan selagi browser mengunduh tujuan.
 * 2. KELAS PENGELOLA & AKUN: Mendukung transisi pergantian sesi/role secara mulus.
 * 3. TIDAK ADA 2 KALI LOADING: Halaman tujuan yang baru dibuka TIDAK memutar ulang
 *    animasi ganda karena status transisi tersimpan rapi.
 * 4. DUKUNGAN REFRESH (F5) & AUTH: Menampilkan animasi anggun saat login/logout/refresh.
 */

(function () {
    'use strict';

    const preloader = document.getElementById('nurussyam-preloader');
    if (!preloader) return;

    const fillBar = preloader.querySelector('.preloader-progress-fill');
    let dismissed = false;

    function setProgress(pct) {
        if (fillBar) {
            fillBar.style.width = Math.min(100, Math.max(10, pct)) + '%';
        }
    }

    /**
     * Sembunyikan preloader dengan animasi pudar halus
     */
    function hidePreloader() {
        if (dismissed) return;
        dismissed = true;

        setProgress(100);
        setTimeout(function () {
            preloader.classList.remove('preloader-active');
            preloader.classList.add('preloader-hidden');
        }, 140);
    }

    /**
     * Deteksi apakah halaman saat ini dimuat akibat Reload / Refresh (F5)
     */
    function isPageReload() {
        try {
            const navEntries = performance.getEntriesByType('navigation');
            if (navEntries && navEntries.length > 0) {
                return navEntries[0].type === 'reload';
            }
            return performance.navigation && performance.navigation.type === 1;
        } catch (e) {
            return false;
        }
    }

    // Periksa apakah ini adalah kedatangan dari klik navigasi link atau autentikasi (login/logout/ganti role)
    let isTransition = false;
    let isAuthActive = false;
    try {
        isTransition = (sessionStorage.getItem('ns_nav_active') === '1') ||
            (sessionStorage.getItem('ns_nav_transition') === '1');
        isAuthActive = (sessionStorage.getItem('ns_auth_active') === '1');

        // Bersihkan tanda navigasi agar sesi berikutnya bersih
        sessionStorage.removeItem('ns_nav_active');
        sessionStorage.removeItem('ns_nav_transition');
        sessionStorage.removeItem('ns_auth_active');
    } catch (e) { }

    // Deteksi Refresh (F5) & First Visit
    const isReload = isPageReload();
    let isFirstVisit = false;
    try {
        isFirstVisit = !sessionStorage.getItem('ns_visited');
        if (isFirstVisit) {
            sessionStorage.setItem('ns_visited', '1');
        }
    } catch (e) { }

    // Halaman yang baru dimuat menampilkan preloader jika:
    // 1. Kedatangan dari Login / Logout / Ganti Role (isAuthActive === true)
    // 2. User menekan REFRESH (F5)
    // 3. Kunjungan pertama kali saat membuka website
    const shouldShowOnLoad = isAuthActive || (!isTransition && (isReload || isFirstVisit));

    if (shouldShowOnLoad) {
        preloader.classList.remove('preloader-hidden');
        preloader.classList.add('preloader-active');
        setProgress(40);

        setTimeout(function () {
            if (!dismissed) setProgress(80);
        }, 80);

        if (document.readyState === 'complete') {
            setTimeout(hidePreloader, 220);
        } else {
            window.addEventListener('load', function () {
                setTimeout(hidePreloader, 180);
            });
        }

        // Failsafe timeout
        setTimeout(hidePreloader, 1200);
    } else {
        // Navigasi link antar fitur biasa: matikan preloader
        dismissed = true;
        preloader.classList.remove('preloader-active');
        preloader.classList.add('preloader-hidden');
    }

    /**
     * TANGANI KLIK LINK NAVIGASI:
     * Respon INSTAN (0ms) begitu user mengklik link menuju fitur / URL yang berbeda.
     */
    document.addEventListener('click', function (e) {
        // 1. Abaikan jika bukan klik kiri biasa
        if (e.button !== 0 || e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) return;

        // 2. Cari elemen link <a> terdekat
        const link = e.target.closest('a');
        if (!link) return;

        // 3. Abaikan jika default sudah dibatalkan oleh script lain
        if (e.defaultPrevented) return;

        // 4. Abaikan link tab baru, download, atau yang diberi data-no-preloader
        if (link.target === '_blank' || link.hasAttribute('download')) return;
        if (link.hasAttribute('data-no-preloader') || link.closest('[data-no-preloader]')) return;

        // 5. Periksa atribut href
        const href = link.getAttribute('href');
        if (!href) return;

        // Abaikan link hash di halaman yang sama, javascript, tel, wa, mailto
        if (href.startsWith('#') ||
            href.startsWith('javascript:') ||
            href.startsWith('mailto:') ||
            href.startsWith('tel:') ||
            href.startsWith('data:')) {
            return;
        }

        // 6. Validasi URL tujuan
        let targetUrl;
        try {
            targetUrl = new URL(link.href, window.location.origin);
        } catch (err) {
            return;
        }

        // Abaikan link ke domain luar (external)
        if (targetUrl.origin !== window.location.origin) return;

        // 7. Normalisasi path
        const currentPath = window.location.pathname.replace(/\/+$/, '') || '/';
        const targetPath = targetUrl.pathname.replace(/\/+$/, '') || '/';
        const currentSearch = window.location.search || '';
        const targetSearch = targetUrl.search || '';

        // JIKA TUJUAN KE HALAMAN YANG PERSIS SAMA (path & query sama):
        // Jangan tampilkan animasi (user tetap di dalam fitur yang sama)
        if (targetPath === currentPath && targetSearch === currentSearch) {
            return;
        }

        // =====================================================================
        // PINDAH KE FITUR / HALAMAN BERBEDA:
        // Tampilkan animasi loading INSTAN 0ms di halaman ini!
        // =====================================================================
        dismissed = false;
        preloader.classList.remove('preloader-hidden');
        preloader.classList.add('preloader-active');
        setProgress(35);

        setTimeout(function () {
            if (!dismissed) setProgress(70);
        }, 70);

        setTimeout(function () {
            if (!dismissed) setProgress(90);
        }, 350);

        try {
            sessionStorage.setItem('ns_nav_active', '1');
        } catch (err) { }

        // Failsafe timer (4 detik) jika browser membatalkan navigasi
        clearTimeout(window.__nsNavSafetyTimer);
        window.__nsNavSafetyTimer = setTimeout(function () {
            hidePreloader();
            try { sessionStorage.removeItem('ns_nav_active'); } catch (e) { }
        }, 4000);
    }, false);

    /**
     * TANGANI PENGIRIMAN FORM (LOGIN, LOGOUT, GANTI ROLE, SIMPAN DATA):
     * Respon seketika saat form autentikasi atau perpindahan halaman dikirimkan.
     */
    document.addEventListener('submit', function (e) {
        const form = e.target;
        if (!form || form.tagName !== 'FORM') return;

        // Abaikan jika form dibatalkan oleh validator lain
        if (e.defaultPrevented) return;

        // Abaikan form dengan target tab baru atau yang dikecualikan
        if (form.target === '_blank' || form.hasAttribute('data-no-preloader') || form.closest('[data-no-preloader]')) {
            return;
        }

        // Cek validitas form jika browser mendukung HTML5 validation
        if (typeof form.checkValidity === 'function' && !form.checkValidity()) {
            return;
        }

        const action = (form.getAttribute('action') || '').toLowerCase();
        const isAuthForm = action.includes('login') || action.includes('logout') || form.classList.contains('auth-form') || form.id === 'autoLogoutForm';

        dismissed = false;
        preloader.classList.remove('preloader-hidden');
        preloader.classList.add('preloader-active');
        setProgress(35);

        // Perbarui teks status jika tersedia
        const statusSpan = preloader.querySelector('.preloader-status-text span');
        if (statusSpan) {
            if (action.includes('logout')) {
                statusSpan.textContent = 'Mengakhiri sesi akun...';
            } else if (action.includes('login')) {
                statusSpan.textContent = 'Memverifikasi akun & role...';
            } else {
                statusSpan.textContent = 'Memproses data...';
            }
        }

        setTimeout(function () {
            if (!dismissed) setProgress(70);
        }, 70);

        setTimeout(function () {
            if (!dismissed) setProgress(90);
        }, 350);

        try {
            sessionStorage.setItem('ns_nav_active', '1');
            if (isAuthForm) {
                sessionStorage.setItem('ns_auth_active', '1');
            }
        } catch (err) { }

        // Efek tombol submit: beri rasa responsif & cegah double-click
        const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
        if (submitBtn) {
            setTimeout(function () {
                try {
                    submitBtn.style.pointerEvents = 'none';
                    submitBtn.style.opacity = '0.75';
                } catch (err) { }
            }, 10);
        }

        clearTimeout(window.__nsNavSafetyTimer);
        window.__nsNavSafetyTimer = setTimeout(function () {
            hidePreloader();
            try {
                sessionStorage.removeItem('ns_nav_active');
                sessionStorage.removeItem('ns_auth_active');
            } catch (e) { }
            if (submitBtn) {
                submitBtn.style.pointerEvents = '';
                submitBtn.style.opacity = '';
            }
        }, 5000);
    }, false);

    // Dukungan navigasi Back / Forward browser (bfcache)
    window.addEventListener('pageshow', function (event) {
        if (event.persisted) {
            dismissed = true;
            preloader.classList.remove('preloader-active');
            preloader.classList.add('preloader-hidden');
            try {
                sessionStorage.removeItem('ns_nav_active');
                sessionStorage.removeItem('ns_auth_active');
            } catch (e) { }
        }
    });

    // Batalkan preloader jika user menekan tombol Escape
    window.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && preloader.classList.contains('preloader-active')) {
            hidePreloader();
            try {
                sessionStorage.removeItem('ns_nav_active');
                sessionStorage.removeItem('ns_auth_active');
            } catch (e) { }
        }
    });
})();
