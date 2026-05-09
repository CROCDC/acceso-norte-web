<?php
/**
 * Resultados de búsqueda.
 */
get_header();
?>

<h1><?php esc_html_e( 'Búsqueda', 'accesonorte' ); ?></h1>

<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
  <input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>"
         placeholder="<?php esc_attr_e( '¿Qué buscás?', 'accesonorte' ); ?>" autofocus>
  <button type="submit"><?php esc_html_e( 'Buscar', 'accesonorte' ); ?></button>
</form>

<?php if ( get_search_query() ) : ?>
  <p>
    <?php
    printf(
        /* translators: %s = query */
        esc_html__( 'Resultados para %s:', 'accesonorte' ),
        '<em>' . esc_html( get_search_query() ) . '</em>'
    );
    ?>
  </p>

  <?php if ( have_posts() ) : ?>
    <div class="grid">
      <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'template-parts/card', null, [ 'size' => 'md' ] ); ?>
      <?php endwhile; ?>
    </div>
    <?php the_posts_pagination( [ 'mid_size' => 1 ] ); ?>
  <?php else : ?>
    <p><?php esc_html_e( 'Sin resultados.', 'accesonorte' ); ?></p>
  <?php endif; ?>
<?php endif; ?>

<?php get_footer(); ?>
