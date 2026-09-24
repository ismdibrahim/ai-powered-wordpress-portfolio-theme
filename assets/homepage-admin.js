jQuery(function ($) {
  const box = document.getElementById('devcanvas-homepage');
  function toggleBox() {
    const editor = window.wp?.data?.select('core/editor');
    const template = editor?.getEditedPostAttribute('template') ?? document.getElementById('page_template')?.value;
    if (box && template !== undefined) box.hidden = template !== 'template-homepage.php';
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
