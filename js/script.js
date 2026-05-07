// ── Count-Up Animation ──

function formatNumber(n) {
  return Math.floor(n).toLocaleString('de-DE');
}

function countUp(el, target, duration = 1800) {
  const start     = performance.now();
  const startVal  = 0;

  function update(now) {
    const elapsed  = now - start;
    const progress = Math.min(elapsed / duration, 1);

    // Easing: easeOutExpo
    const eased = progress === 1
      ? 1
      : 1 - Math.pow(2, -10 * progress);

    const current = Math.floor(startVal + (target - startVal) * eased);
    el.textContent = formatNumber(current);

    if (progress < 1) {
      requestAnimationFrame(update);
    } else {
      el.textContent = formatNumber(target);
    }
  }

  requestAnimationFrame(update);
}

// ── Intersection Observer — startet Animation wenn sichtbar ──

function initCountUps() {
  const elements = document.querySelectorAll('[data-target]');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const el     = entry.target;
        const target = parseInt(el.dataset.target, 10);
        const delay  = parseInt(el.dataset.delay || 0, 10);

        setTimeout(() => countUp(el, target), delay);
        observer.unobserve(el);
      }
    });
  }, { threshold: 0.2 });

  elements.forEach(el => observer.observe(el));
}

// ── Staggered delay für die Karten ──

document.querySelectorAll('.card-number[data-target]').forEach((el, i) => {
  el.dataset.delay = i * 120;
});

// ── Init ──

document.addEventListener('DOMContentLoaded', () => {
  initCountUps();
});
