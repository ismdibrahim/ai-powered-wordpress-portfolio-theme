(() => {
  function copyFallback(text) {
    const focused = document.activeElement;
    const field = document.createElement('textarea');
    field.value = text;
    field.readOnly = true;
    field.style.cssText = 'position:fixed;left:-9999px;top:0;opacity:0;font-size:16px';
    document.body.appendChild(field);
    field.select();
    field.setSelectionRange(0, text.length);
    let copied = false;
    try { copied = document.execCommand('copy'); }
    finally {
      field.remove();
      focused?.focus({ preventScroll: true });
    }
    return copied;
  }
  document.addEventListener('click', async event => {
    const button = event.target.closest('[data-copy-email]');
    if (!button) return;
    const status = button.parentElement.querySelector('.dc-copy-status');
    const email = button.dataset.copyEmail;
    let copied = false;
    if (window.isSecureContext && navigator.clipboard?.writeText) {
      try { await navigator.clipboard.writeText(email); copied = true; }
      catch { /* Try the user-initiated copy fallback below. */ }
    }
    if (!copied) {
      try { copied = copyFallback(email); } catch { copied = false; }
    }
    if (status) status.textContent = copied ? 'Copied!' : `Please select and copy: ${email}`;
  });
})();
