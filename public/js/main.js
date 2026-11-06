/**
 * Pondok Pesantren Nurus Syam - Official Scripts
 * Includes Search Modal & Mobile Sidebar Drawer
 */

document.addEventListener('DOMContentLoaded', function () {
  // Elements: Search Modal
  const searchModal = document.getElementById('searchModal');
  const openSearchBtn = document.getElementById('openSearchBtn');
  const openSearchBtnMobile = document.getElementById('openSearchBtnMobile');
  const closeSearchBtn = document.getElementById('closeSearchBtn');
  const searchInput = document.getElementById('searchInput');
  const searchResults = document.getElementById('searchResults');

  // Elements: Mobile Sidebar
  const openMobileSidebarBtn = document.getElementById('openMobileSidebarBtn');
  const closeMobileSidebarBtn = document.getElementById('closeMobileSidebarBtn');
  const mobileSidebarDrawer = document.getElementById('mobileSidebarDrawer');
  const mobileSidebarOverlay = document.getElementById('mobileSidebarOverlay');
  const mobileAccordionToggles = document.querySelectorAll('.mobile-accordion-toggle');

  // Open Search Modal (Desktop & Mobile)
  function handleOpenSearch(e) {
    if (e) e.preventDefault();
    if (searchModal) {
      searchModal.classList.add('open');
      setTimeout(() => searchInput && searchInput.focus(), 100);
    }
  }

  if (openSearchBtn) {
    openSearchBtn.addEventListener('click', handleOpenSearch);
  }

  if (openSearchBtnMobile) {
    openSearchBtnMobile.addEventListener('click', handleOpenSearch);
  }

  // Close Search Modal
  if (closeSearchBtn && searchModal) {
    closeSearchBtn.addEventListener('click', function () {
      searchModal.classList.remove('open');
    });
  }

  if (searchModal) {
    searchModal.addEventListener('click', function (e) {
      if (e.target === searchModal) {
        searchModal.classList.remove('open');
      }
    });
  }

  // Instant Filter in Search Modal
  if (searchInput && searchResults) {
    searchInput.addEventListener('input', function () {
      const q = this.value.trim().toLowerCase();
      if (!q) {
        searchResults.innerHTML = '<p style="color:#64748b; font-size:0.85rem; text-align:center; padding:15px;">Ketik judul artikel atau berita untuk mencari...</p>';
        return;
      }

      const allCards = document.querySelectorAll('.featured-card, .catatan-card-item, .news-vert-item');
      let matches = [];

      allCards.forEach(card => {
        const titleEl = card.querySelector('.featured-card-title, .catatan-item-title, .news-vert-title');
        const descEl = card.querySelector('.catatan-item-desc, .featured-card-meta, .news-vert-date');
        const title = titleEl ? titleEl.textContent.trim() : '';
        const desc = descEl ? descEl.textContent.trim() : '';
        const link = card.getAttribute('href') || (titleEl && titleEl.querySelector('a') ? titleEl.querySelector('a').getAttribute('href') : '#');

        if (title.toLowerCase().includes(q) || desc.toLowerCase().includes(q)) {
          matches.push({ title, desc, link });
        }
      });

      if (matches.length === 0) {
        searchResults.innerHTML = `<p style="color:#ef4444; font-size:0.85rem; text-align:center; padding:15px;">Tidak ditemukan hasil untuk "<strong>${q}</strong>".</p>`;
      } else {
        let html = '<div style="display:flex; flex-direction:column; gap:8px;">';
        matches.forEach(item => {
          html += `
            <a href="${item.link}" style="display:block; padding:10px 14px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:6px; text-decoration:none; color:inherit;">
              <strong style="color:#0f8528; font-size:0.9rem; display:block; margin-bottom:2px;">${item.title}</strong>
              <span style="color:#64748b; font-size:0.78rem; display:block;">${item.desc.substring(0, 90)}...</span>
            </a>
          `;
        });
        html += '</div>';
        searchResults.innerHTML = html;
      }
    });
  }

  // Mobile Sidebar Functions
  function openMobileSidebar() {
    if (mobileSidebarDrawer && mobileSidebarOverlay) {
      mobileSidebarDrawer.classList.add('active');
      mobileSidebarOverlay.classList.add('active');
      document.body.classList.add('sidebar-locked');
    }
  }

  function closeMobileSidebar() {
    if (mobileSidebarDrawer && mobileSidebarOverlay) {
      mobileSidebarDrawer.classList.remove('active');
      mobileSidebarOverlay.classList.remove('active');
      document.body.classList.remove('sidebar-locked');
    }
  }

  if (openMobileSidebarBtn) {
    openMobileSidebarBtn.addEventListener('click', function (e) {
      e.preventDefault();
      openMobileSidebar();
    });
  }

  if (closeMobileSidebarBtn) {
    closeMobileSidebarBtn.addEventListener('click', function (e) {
      e.preventDefault();
      closeMobileSidebar();
    });
  }

  if (mobileSidebarOverlay) {
    mobileSidebarOverlay.addEventListener('click', function () {
      closeMobileSidebar();
    });
  }

  // Mobile Accordion Dropdown Submenu Toggle
  if (mobileAccordionToggles.length > 0) {
    mobileAccordionToggles.forEach(toggle => {
      toggle.addEventListener('click', function (e) {
        e.preventDefault();
        const parent = this.closest('.has-accordion');
        if (parent) {
          const submenu = parent.querySelector('.mobile-submenu-box');
          if (submenu) {
            const isOpen = submenu.classList.contains('open');
            // Close other open submenus if desired
            document.querySelectorAll('.mobile-submenu-box.open').forEach(el => {
              if (el !== submenu) el.classList.remove('open');
            });
            document.querySelectorAll('.mobile-accordion-toggle.open').forEach(btn => {
              if (btn !== toggle) btn.classList.remove('open');
            });

            // Toggle current
            submenu.classList.toggle('open', !isOpen);
            toggle.classList.toggle('open', !isOpen);
          }
        }
      });
    });
  }

  // Close modals & sidebar on Escape key
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      if (searchModal && searchModal.classList.contains('open')) {
        searchModal.classList.remove('open');
      }
      closeMobileSidebar();
    }
  });

  // Back to Top button logic
  const backToTopBtn = document.getElementById('backToTopBtn');
  if (backToTopBtn) {
    window.addEventListener('scroll', function () {
      if (window.scrollY > 200) {
        backToTopBtn.classList.add('visible');
      } else {
        backToTopBtn.classList.remove('visible');
      }
    });

    backToTopBtn.addEventListener('click', function () {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }

  // =========================================================================
  // SOCIAL MEDIA STATS - COUNT-UP ANIMATION (0 TO REAL NUMBER)
  // =========================================================================
  function animateCounter(element, target, duration = 1800) {
    if (element.dataset.counted === 'true') return;
    element.dataset.counted = 'true';

    const startVal = 0;
    const startTime = performance.now();

    function step(currentTime) {
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);

      // Ease-Out Expo curve: fast start, smooth deceleration
      const ease = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
      const current = Math.floor(startVal + (target - startVal) * ease);

      element.textContent = current.toLocaleString('en-US');

      if (progress < 1) {
        requestAnimationFrame(step);
      } else {
        element.textContent = target.toLocaleString('en-US');
      }
    }

    requestAnimationFrame(step);
  }

  function initSocialCounters() {
    const counterElements = document.querySelectorAll('.soc-count[data-target]');
    if (!counterElements.length) return;

    // Use IntersectionObserver to start counting when visible or immediately on load
    if ('IntersectionObserver' in window) {
      const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const el = entry.target;
            const target = parseInt(el.getAttribute('data-target'), 10) || 0;
            // Slight delay so the user clearly sees it counting from 0
            setTimeout(() => {
              animateCounter(el, target, 1800);
            }, 150);
            obs.unobserve(el);
          }
        });
      }, {
        threshold: 0.15
      });

      counterElements.forEach(el => observer.observe(el));
    } else {
      // Fallback if observer not supported
      counterElements.forEach(el => {
        const target = parseInt(el.getAttribute('data-target'), 10) || 0;
        setTimeout(() => {
          animateCounter(el, target, 1800);
        }, 150);
      });
    }
  }

  // Start counters
  initSocialCounters();

  // =========================================================================
  // SMART SCROLL POSITION PRESERVATION (ANTI-LOMPAT KE ATAS SAAT ISI FITUR)
  // =========================================================================
  (function initScrollPreservation() {
    // 1. Simpan posisi scroll sebelum form dikirimkan
    document.addEventListener('submit', function (e) {
      const form = e.target;
      if (!form || form.tagName !== 'FORM') return;
      if (form.target === '_blank') return;

      try {
        sessionStorage.setItem('ns_last_scroll_y', String(window.scrollY || window.pageYOffset));
        if (form.id) {
          sessionStorage.setItem('ns_last_form_id', form.id);
        }
      } catch (err) {}
    }, true);

    // 2. Pulihkan posisi scroll saat halaman selesai dimuat
    function restoreScrollTarget() {
      // Prioritas A: Jika URL memiliki anchor (#form-daftar, #cek-status, #sukses-psb, dll)
      const hash = window.location.hash;
      if (hash && hash.length > 1) {
        const targetEl = document.querySelector(hash);
        if (targetEl) {
          const headerOffset = 85;
          const elementPosition = targetEl.getBoundingClientRect().top;
          const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

          window.scrollTo({
            top: Math.max(0, offsetPosition),
            behavior: 'smooth'
          });

          try {
            sessionStorage.removeItem('ns_last_scroll_y');
            sessionStorage.removeItem('ns_last_form_id');
          } catch (e) {}
          return;
        }
      }

      // Prioritas B: Jika ada alert hasil submit (sukses pendaftaran, error pendaftaran, hasil cek, sukses donasi)
      const resultBox = document.querySelector('#sukses-psb, #error-psb, #form-errors, #sukses-donasi, .alert-success, .alert-danger');
      if (resultBox) {
        const headerOffset = 85;
        const boxPos = resultBox.getBoundingClientRect().top + window.pageYOffset - headerOffset;
        window.scrollTo({
          top: Math.max(0, boxPos),
          behavior: 'smooth'
        });

        try {
          sessionStorage.removeItem('ns_last_scroll_y');
          sessionStorage.removeItem('ns_last_form_id');
        } catch (e) {}
        return;
      }

      // Prioritas C: Pulihkan posisi scroll semula tempat user mengisi form / filter
      try {
        const savedY = sessionStorage.getItem('ns_last_scroll_y');
        if (savedY !== null) {
          sessionStorage.removeItem('ns_last_scroll_y');
          sessionStorage.removeItem('ns_last_form_id');
          const y = parseInt(savedY, 10);
          if (!isNaN(y) && y > 0) {
            window.scrollTo({
              top: y,
              behavior: 'instant'
            });
          }
        }
      } catch (e) {}
    }

    // Jalankan segera dan ulangi setelah layout browser stabil
    setTimeout(restoreScrollTarget, 60);
    window.addEventListener('load', function () {
      setTimeout(restoreScrollTarget, 100);
    });
  })();
});
