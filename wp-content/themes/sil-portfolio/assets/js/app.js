document.addEventListener('DOMContentLoaded', () => {
  const root = document.documentElement;
  const darkToggle = document.getElementById('dark-toggle');
  const darkToggleLabel = document.getElementById('dark-toggle-label');
  const darkToggleIcon = document.getElementById('dark-toggle-icon');
  const darkToggleDescription = document.getElementById('dark-toggle-description');
  const menuToggle = document.getElementById('menu-toggle');
  const sidebar = document.getElementById('sidebar');
  const sidebarOverlay = document.getElementById('sidebar-overlay');
  const elements = document.querySelectorAll('.fade-in');

  const updateThemeToggle = () => {
    const isDark = root.classList.contains('dark');

    if (darkToggleLabel) {
      darkToggleLabel.textContent = isDark ? 'Mode Terang' : 'Mode Gelap';
    }

    if (darkToggleDescription) {
      darkToggleDescription.textContent = isDark
        ? 'Tampilan gelap sedang aktif'
        : 'Tampilan terang sedang aktif';
    }

    if (darkToggle) {
      darkToggle.setAttribute('aria-checked', isDark ? 'true' : 'false');
    }

    if (darkToggleIcon) {
      darkToggleIcon.innerHTML = isDark
        ? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z"/></svg>'
        : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4"><circle cx="12" cy="12" r="3.5"/><path stroke-linecap="round" d="M12 2.5v2.2M12 19.3v2.2M4.9 4.9l1.5 1.5M17.6 17.6l1.5 1.5M2.5 12h2.2M19.3 12h2.2M4.9 19.1l1.5-1.5M17.6 6.4l1.5-1.5"/></svg>';
    }
  };

  const closeSidebar = () => {
    sidebar?.classList.add('-translate-x-full');
    sidebarOverlay?.classList.add('pointer-events-none', 'opacity-0');
  };

  const openSidebar = () => {
    sidebar?.classList.remove('-translate-x-full');
    sidebarOverlay?.classList.remove('pointer-events-none', 'opacity-0');
  };

  if (localStorage.getItem('theme') === 'dark') {
    root.classList.add('dark');
  }

  updateThemeToggle();

  darkToggle?.addEventListener('click', () => {
    root.classList.toggle('dark');

    if (root.classList.contains('dark')) {
      localStorage.setItem('theme', 'dark');
    } else {
      localStorage.setItem('theme', 'light');
    }

    updateThemeToggle();
  });

  menuToggle?.addEventListener('click', () => {
    if (sidebar?.classList.contains('-translate-x-full')) {
      openSidebar();
    } else {
      closeSidebar();
    }
  });

  sidebarOverlay?.addEventListener('click', closeSidebar);

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      closeSidebar();
    }
  });

  document.querySelectorAll('#sidebar a').forEach((link) => {
    link.addEventListener('click', () => {
      if (window.innerWidth < 1024) {
        closeSidebar();
      }
    });
  });

  document.querySelectorAll('img[data-fallback-src]').forEach((image) => {
    const markLoaded = () => {
      image.classList.add('is-loaded');
      image.parentElement?.classList.add('is-loaded');
    };

    image.addEventListener('error', () => {
      image.src = image.dataset.fallbackSrc;
    }, { once: true });

    image.addEventListener('load', () => {
      markLoaded();
    }, { once: true });

    if (image.complete && image.naturalWidth > 0) {
      markLoaded();
    }
  });

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('show');
      }
    });
  });

  elements.forEach((element) => observer.observe(element));
});
