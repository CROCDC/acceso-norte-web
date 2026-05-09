<?php
/**
 * Archive — listados de categoría, tag, autor, fecha.
 *
 * Section masthead enorme estilo broadsheet (Playfair italic 96px).
 */
get_header();

$kicker = '';
if ( is_category() ) {
    $kicker = __( 'Sección', 'accesonorte' );
} elseif ( is_tag() ) {
    $kicker = __( 'Etiqueta', 'accesonorte' );
} elseif ( is_author() ) {
    $kicker = __( 'Autor', 'accesonorte' );
} else {
    $kicker = __( 'Archivo', 'accesonorte' );
}
?>

<header class="section-masthead" data-reveal>
  <span class="kicker"><?php echo esc_html( $kicker ); ?></span>
  <h1 class="section-masthead__title"><?php echo wp_kses_post( get_the_archive_title() ); ?></h1>
  <?php
  $description = get_the_archive_description();
  if ( $description ) :
  ?>
    <p class="section-masthead__dek"><?php echo wp_kses_post( $description ); ?></p>
  <?php endif; ?>
</header>

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
      <?php esc_html_e( 'No hay notas en esta sección todavía.', 'accesonorte' ); ?>
    </p>
  <?php endif; ?>
</section>

<?php get_footer(); ?>
