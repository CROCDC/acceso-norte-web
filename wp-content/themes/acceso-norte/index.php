<?php
/**
 * Fallback — usado cuando no hay un template más específico.
 */
get_header();
?>

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
      <?php esc_html_e( 'No hay contenido todavía.', 'accesonorte' ); ?>
    </p>
  <?php endif; ?>
</section>

<?php get_footer(); ?>
