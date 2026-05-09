<?php
/**
 * Fallback genérico. WP usa este template cuando no encuentra uno más específico.
 *
 * Cubre: páginas estáticas no-front, archives sin template propio, etc.
 */
get_header();
?>

<?php if ( have_posts() ) : ?>
  <div class="grid">
    <?php while ( have_posts() ) : the_post(); ?>
      <?php get_template_part( 'template-parts/card', null, [ 'size' => 'md' ] ); ?>
    <?php endwhile; ?>
  </div>

  <?php the_posts_pagination( [ 'mid_size' => 1 ] ); ?>
<?php else : ?>
  <p style="padding: 4rem 0; text-align: center; color: var(--muted);">
    <?php esc_html_e( 'No hay contenido todavía.', 'accesonorte' ); ?>
  </p>
<?php endif; ?>

<?php get_footer(); ?>
