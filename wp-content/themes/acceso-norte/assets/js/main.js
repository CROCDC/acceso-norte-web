/* Acceso Norte — JS del front. Por ahora vacío, queda como placeholder. */
(function () {
  // Reveal-on-scroll progresivo (placeholder).
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    },
    { rootMargin: '0px 0px -10% 0px' }
  );
  document.querySelectorAll('[data-reveal]').forEach((el) => observer.observe(el));
})();
