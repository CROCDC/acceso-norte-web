<?php
/**
 * 404 — página no encontrada.
 */
get_header();
?>

<section class="simple-page">
  <span class="kicker">404</span>
  <h1><?php esc_html_e( 'No encontramos esta página', 'accesonorte' ); ?></h1>
  <p><?php esc_html_e( 'El enlace puede haber cambiado o la nota fue removida. Probá buscar lo que necesitás:', 'accesonorte' ); ?></p>

  <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search" class="simple-search">
    <input type="search" name="s" placeholder="<?php esc_attr_e( '¿Qué buscás?', 'accesonorte' ); ?>" autofocus>
    <button type="submit"><?php esc_html_e( 'Buscar', 'accesonorte' ); ?></button>
  </form>

  <p>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="meta">
      ← <?php esc_html_e( 'Volver al inicio', 'accesonorte' ); ?>
    </a>
  </p>
</section>

<?php get_footer(); ?>
