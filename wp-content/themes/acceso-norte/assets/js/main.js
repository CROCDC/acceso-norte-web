/* Acceso Norte — JS del front.
 *
 * Funcionalidad:
 *  - Reading progress bar en páginas de artículo (barra fina arriba con scroll)
 *  - Reveal-on-scroll progresivo para [data-reveal]
 *  - Botón "Copiar link" en share
 *  - Toggle de búsqueda inline en el masthead
 */

(function () {
  'use strict';

  /* ---- Reveal on scroll ---- */
  const reveals = document.querySelectorAll('[data-reveal]');
  if (reveals.length && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      },
      { rootMargin: '0px 0px -8% 0px', threshold: 0.05 }
    );
    reveals.forEach((el) => observer.observe(el));
  } else {
    // Fallback: si no hay IntersectionObserver, mostramos todo de una.
    reveals.forEach((el) => el.classList.add('is-visible'));
  }

  /* ---- Reading progress bar (solo en artículos) ---- */
  const article = document.querySelector('.article-body');
  if (article) {
    const bar = document.createElement('div');
    bar.className = 'reading-progress';
    document.body.appendChild(bar);

    const update = () => {
      const rect = article.getBoundingClientRect();
      const total = rect.height + window.innerHeight;
      const scrolled = window.innerHeight - rect.top;
      const pct = Math.max(0, Math.min(100, (scrolled / total) * 100));
      bar.style.width = pct + '%';
    };
    update();
    window.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update, { passive: true });
  }

  /* ---- Botón "Copiar link" ---- */
  document.querySelectorAll('.js-share-copy').forEach((btn) => {
    btn.addEventListener('click', () => {
      const url = btn.dataset.url;
      if (!url || !navigator.clipboard) return;
      navigator.clipboard.writeText(url).then(() => {
        const original = btn.textContent;
        btn.textContent = 'Copiado ✓';
        btn.disabled = true;
        setTimeout(() => {
          btn.textContent = original;
          btn.disabled = false;
        }, 2000);
      });
    });
  });

  /* ---- Toggle de búsqueda inline en el masthead ---- */
  const searchToggle = document.querySelector('.js-search-toggle');
  if (searchToggle) {
    searchToggle.addEventListener('click', (e) => {
      e.preventDefault();
      const overlay = document.createElement('div');
      overlay.style.cssText = `
        position: fixed; inset: 0;
        background: rgba(20,17,13,0.92);
        z-index: 200;
        display: flex; align-items: flex-start; justify-content: center;
        padding-top: 12vh;
        backdrop-filter: blur(8px);
      `;
      overlay.innerHTML = `
        <form role="search" method="get" action="${location.origin}/" style="width: min(640px, 90vw); display: flex; gap: 8px;">
          <input type="search" name="s" placeholder="¿Qué buscás?" autofocus
                 style="flex:1; padding: 16px 20px; font-family: 'Source Serif 4', serif; font-size: 20px; border: 0; background: #f5f2ec; color: #14110d; outline: 0;">
          <button type="submit"
                  style="padding: 16px 24px; background: #f5f2ec; color: #14110d; border: 0; font-family: 'IBM Plex Mono', monospace; font-size: 12px; letter-spacing: 0.18em; text-transform: uppercase; cursor: pointer;">
            Buscar
          </button>
        </form>
      `;
      overlay.addEventListener('click', (ev) => {
        if (ev.target === overlay) overlay.remove();
      });
      document.addEventListener('keydown', function escClose(ev) {
        if (ev.key === 'Escape') {
          overlay.remove();
          document.removeEventListener('keydown', escClose);
        }
      });
      document.body.appendChild(overlay);
    });
  }
})();
