<?php
/**
 * Resultados de búsqueda.
 */
get_header();
?>

<section class="simple-page">
  <span class="kicker"><?php esc_html_e( 'Búsqueda', 'accesonorte' ); ?></span>
  <h1>
    <?php
    if ( get_search_query() ) {
        printf(
            esc_html__( 'Resultados para %s', 'accesonorte' ),
            '<em>' . esc_html( get_search_query() ) . '</em>'
        );
    } else {
        esc_html_e( '¿Qué buscás?', 'accesonorte' );
    }
    ?>
  </h1>

  <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search" class="simple-search">
    <input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>"
           placeholder="<?php esc_attr_e( 'Buscar...', 'accesonorte' ); ?>" autofocus>
    <button type="submit"><?php esc_html_e( 'Buscar', 'accesonorte' ); ?></button>
  </form>
</section>

<?php if ( get_search_query() ) : ?>
  <section class="section-list">
    <?php if ( have_posts() ) : ?>
      <div class="section-list__grid">
        <?php while ( have_posts() ) : the_post(); ?>
          <?php get_template_part( 'template-parts/card', null, [ 'size' => 'md' ] ); ?>
        <?php endwhile; ?>
      </div>
      <div class="pagination">
        <?php the_posts_pagination( [ 'mid_size' => 1 ] ); ?>
      </div>
    <?php else : ?>
      <p style="text-align: center; padding: 4rem 0; color: var(--an-ink-soft);">
        <?php esc_html_e( 'Sin resultados.', 'accesonorte' ); ?>
      </p>
    <?php endif; ?>
  </section>
<?php endif; ?>

<?php get_footer(); ?>
