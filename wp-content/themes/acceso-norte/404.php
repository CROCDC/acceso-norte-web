<?php
/**
 * 404 — página no encontrada.
 */
get_header();
?>

<article class="article">
  <h1><?php esc_html_e( 'No encontramos esta página', 'accesonorte' ); ?></h1>
  <p><?php esc_html_e( 'El enlace puede haber cambiado o la nota fue removida. Probá buscar lo que necesitás:', 'accesonorte' ); ?></p>

  <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
    <input type="search" name="s" placeholder="<?php esc_attr_e( '¿Qué buscás?', 'accesonorte' ); ?>" autofocus>
    <button type="submit"><?php esc_html_e( 'Buscar', 'accesonorte' ); ?></button>
  </form>

  <p><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Volver al inicio', 'accesonorte' ); ?></a></p>
</article>

<?php get_footer(); ?>
