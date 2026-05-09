<?php
/**
 * Footer global del sitio.
 */
?>
</main>

<aside class="newsletter-inline">
  <h3><?php esc_html_e( 'Suscribite al newsletter', 'accesonorte' ); ?></h3>
  <p><?php esc_html_e( 'Resumen diario en tu inbox.', 'accesonorte' ); ?></p>
  <p><em><?php esc_html_e( 'Próximamente.', 'accesonorte' ); ?></em></p>
</aside>

<footer class="site-footer">
  <p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?> — <?php esc_html_e( 'Todos los derechos reservados.', 'accesonorte' ); ?></p>
  <p>
    <a href="<?php echo esc_url( home_url( '/feed/' ) ); ?>">RSS</a> ·
    <a href="<?php echo esc_url( home_url( '/?sitemap=1' ) ); ?>">Sitemap</a>
  </p>
</footer>

<?php wp_footer(); ?>
</body>
</html>
