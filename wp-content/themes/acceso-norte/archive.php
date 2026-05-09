<?php
/**
 * Archive — listados de categoría, tag, autor, fecha.
 */
get_header();
?>

<header class="section-header">
  <span class="kicker">
    <?php
    if ( is_category() ) {
        esc_html_e( 'Sección', 'accesonorte' );
    } elseif ( is_tag() ) {
        esc_html_e( 'Tag', 'accesonorte' );
    } elseif ( is_author() ) {
        esc_html_e( 'Autor', 'accesonorte' );
    } else {
        esc_html_e( 'Archivo', 'accesonorte' );
    }
    ?>
  </span>
  <h1><?php echo wp_kses_post( get_the_archive_title() ); ?></h1>
  <?php
  $description = get_the_archive_description();
  if ( $description ) {
      echo '<p>' . wp_kses_post( $description ) . '</p>';
  }
  ?>
</header>

<?php if ( have_posts() ) : ?>
  <div class="grid">
    <?php while ( have_posts() ) : the_post(); ?>
      <?php get_template_part( 'template-parts/card', null, [ 'size' => 'md' ] ); ?>
    <?php endwhile; ?>
  </div>

  <?php the_posts_pagination( [ 'mid_size' => 1 ] ); ?>
<?php else : ?>
  <p style="padding: 4rem 0; text-align: center; color: var(--muted);">
    <?php esc_html_e( 'No hay notas en esta sección todavía.', 'accesonorte' ); ?>
  </p>
<?php endif; ?>

<?php get_footer(); ?>
