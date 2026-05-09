<?php
/**
 * Card de artículo. Reutilizado en home, archives, search.
 *
 * Variables esperadas vía $args (set_query_var / get_template_part):
 *   - size: 'xl' | 'lg' | 'md' | 'sm' (default 'md')
 */

$size = $args['size'] ?? 'md';
$cat  = an_primary_category();
?>
<a href="<?php the_permalink(); ?>" class="card card--<?php echo esc_attr( $size ); ?>" data-reveal>
  <?php if ( has_post_thumbnail() ) : ?>
    <div class="card__image">
      <?php
      the_post_thumbnail(
          'an-card',
          [
              'loading' => 'lazy',
              'sizes'   => '(max-width: 600px) 100vw, 600px',
              'alt'     => esc_attr( get_the_title() ),
          ]
      );
      ?>
    </div>
  <?php endif; ?>
  <div class="card__body">
    <?php if ( $cat ) : ?>
      <span class="kicker"><?php echo esc_html( $cat->name ); ?></span>
    <?php endif; ?>
    <h3 class="card__title"><?php the_title(); ?></h3>
    <?php if ( in_array( $size, [ 'xl', 'lg' ], true ) && has_excerpt() ) : ?>
      <p class="card__subtitle"><?php echo esc_html( get_the_excerpt() ); ?></p>
    <?php endif; ?>
    <p class="card__meta">
      <span><?php the_author(); ?></span>
      <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
        <?php echo esc_html( get_the_date( 'Y-m-d' ) ); ?>
      </time>
    </p>
  </div>
</a>
