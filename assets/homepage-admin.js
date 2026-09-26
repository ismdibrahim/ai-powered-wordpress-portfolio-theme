jQuery(function ($) {
  const box = document.getElementById('devcanvas-homepage');
  function toggleBox() {
    const editor = window.wp?.data?.select('core/editor');
    const template = editor?.getEditedPostAttribute('template') ?? document.getElementById('page_template')?.value;
    if (box && template !== undefined) box.hidden = template !== 'templates/template-homepage.php';
    const projectsBox = document.getElementById('devcanvas-projects-page');
    if (projectsBox && template !== undefined) projectsBox.hidden = template !== 'templates/template-projects.php';
  }
  toggleBox();
  document.getElementById('page_template')?.addEventListener('change', toggleBox);
  if (window.wp?.data) wp.data.subscribe(toggleBox);
  $(document).on('click', '.dc-pick-image', function () {
    const input = document.getElementById(this.dataset.input);
    const frame = wp.media({ title: 'Choose an image', button: { text: 'Use this image' }, library: { type: 'image' }, multiple: false });
    frame.on('select', function () {
      input.value = frame.state().get('selection').first().toJSON().url;
      $(input).trigger('change');
    });
    frame.open();
  });
  $(document).on('click', '.dc-clear-image', function () {
    const input = document.getElementById(this.dataset.input);
    input.value = '';
    $(input).trigger('change');
  });
  $(document).on('change', '#devcanvas-homepage input', function () {
    const image = this.parentElement.querySelector('.dc-image-preview');
    if (image) { image.hidden = !this.value; if (this.value) image.src = this.value; else image.removeAttribute('src'); }
  });
});
jQuery(function ($) {
  const repeater = document.getElementById('dc-services-repeater');
  if (!repeater) return;
  const rows = repeater.querySelector('.dc-service-rows');
  const add = repeater.querySelector('.dc-service-add');
  const status = repeater.querySelector('.dc-service-status');
  let nextIndex = rows.children.length;
  function changed(message) {
    rows.querySelectorAll('.dc-service-row').forEach((row, i) => {
      row.querySelector('.dc-service-up').disabled = i === 0;
      row.querySelector('.dc-service-down').disabled = i === rows.children.length - 1;
    });
    status.textContent = message;
    $(repeater.querySelector('[name="devcanvas_services_present"]')).trigger('change');
  }
  add.addEventListener('click', () => {
    const template = document.getElementById('dc-service-template');
    const holder = document.createElement('div');
    holder.innerHTML = template.innerHTML.replaceAll('__INDEX__', String(nextIndex++));
    const row = holder.firstElementChild;
    rows.append(row);
    row.open = true;
    row.querySelector('input[name$="[title]"]').focus();
    changed('Service added. Save the page to apply changes.');
  });
  repeater.addEventListener('input', event => {
    if (event.target.matches('input[name$="[title]"]')) {
      event.target.closest('.dc-service-row').querySelector('summary').textContent = event.target.value || 'New service';
    }
  });
  repeater.addEventListener('click', event => {
    const button = event.target.closest('button');
    const row = button?.closest('.dc-service-row');
    if (!row) return;
    if (button.classList.contains('dc-service-remove')) {
      const focusTarget = row.nextElementSibling || row.previousElementSibling;
      row.remove();
      changed('Service removed. Save the page to apply changes.');
      (focusTarget?.querySelector('summary') || add).focus();
    } else if (button.classList.contains('dc-service-up') && row.previousElementSibling) {
      rows.insertBefore(row, row.previousElementSibling);
      changed('Service moved up.');
      row.querySelector('summary').focus();
    } else if (button.classList.contains('dc-service-down') && row.nextElementSibling) {
      rows.insertBefore(row.nextElementSibling, row);
      changed('Service moved down.');
      row.querySelector('summary').focus();
    }
  });
  changed('');
});
