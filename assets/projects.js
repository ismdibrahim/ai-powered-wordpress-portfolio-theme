document.querySelectorAll('[data-project-section]').forEach(section => {
  const filters = section.querySelector('.dc-project-filters');
  if (!filters) return;
  const cards = [...section.querySelectorAll('[data-project-categories]')];
  const limit = section.dataset.projectLimit === '0' ? Infinity : 4;
  filters.hidden = false;
  filters.addEventListener('click', event => {
    const button = event.target.closest('[data-project-filter]');
    if (!button || !filters.contains(button)) return;
    const selected = button.dataset.projectFilter;
    filters.querySelectorAll('button').forEach(item => {
      const active = item === button;
      item.classList.toggle('active', active);
      item.setAttribute('aria-pressed', String(active));
    });
    let visibleCount = 0;
    cards.forEach(card => {
      const matches = selected === 'all' || card.dataset.projectCategories.split(' ').includes(selected);
      const show = matches && visibleCount < limit;
      card.hidden = !show;
      if (show) visibleCount++;
    });
    section.querySelector('.dc-project-empty').hidden = cards.some(card => !card.hidden);
  });
});

