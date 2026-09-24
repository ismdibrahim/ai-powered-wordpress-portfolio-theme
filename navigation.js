(() => {
  const toggle = document.getElementById('menu-toggle');
  const dialog = document.getElementById('mobile-menu');
  if (!toggle || !dialog || typeof dialog.showModal !== 'function') return;
  document.documentElement.classList.add('navigation-ready');
  toggle.hidden = false;
  const close = () => dialog.close();
  toggle.addEventListener('click', () => {
    dialog.showModal();
    toggle.setAttribute('aria-expanded', 'true');
    document.documentElement.classList.add('menu-open');
  });
  document.getElementById('menu-close').addEventListener('click', close);
  dialog.addEventListener('close', () => {
    toggle.setAttribute('aria-expanded', 'false');
    document.documentElement.classList.remove('menu-open');
  });
  dialog.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
    close();
    const url = new URL(link.href, window.location.href);
    if (url.pathname === location.pathname && url.hash) {
      const target = document.getElementById(decodeURIComponent(url.hash.slice(1)));
      if (target) { target.setAttribute('tabindex', '-1'); target.focus({ preventScroll: true }); }
    }
  }));
  window.matchMedia('(min-width: 768px)').addEventListener('change', event => {
    if (event.matches && dialog.open) {
      close();
      document.querySelector('.header-inner .brand').focus();
    }
  });
})();
