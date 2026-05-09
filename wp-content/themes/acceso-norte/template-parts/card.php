<?php
/**
 * Card de artículo. Variables vía $args:
 *   - size: 'xl' | 'lg' | 'md' | 'sm' (default 'md')
 *   - aspect: 'card' (3:2) o 'lead' (16:9)
 */

$size       = $args['size'] ?? 'md';
$image_size = ( in_array( $size, [ 'xl', 'lg' ], true ) ) ? 'an-lead' : 'an-card';
$cat        = an_primary_category();
?>
<a href="<?php the_permalink(); ?>" class="card card--<?php echo esc_attr( $size ); ?>" data-reveal>
  <?php if ( has_post_thumbnail() ) : ?>
    <div class="card__image">
      <?php
      the_post_thumbnail(
          $image_size,
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
      <span class="kicker kicker--small"><?php echo esc_html( $cat->name ); ?></span>
    <?php endif; ?>
    <h3 class="card__title"><?php the_title(); ?></h3>
    <?php if ( in_array( $size, [ 'xl', 'lg' ], true ) && has_excerpt() ) : ?>
      <p class="card__subtitle"><?php echo esc_html( get_the_excerpt() ); ?></p>
    <?php endif; ?>
    <p class="card__meta">
      <span class="meta"><?php the_author(); ?></span>
      <span class="meta">·</span>
      <time class="meta" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
        <?php echo esc_html( get_the_date( 'd · m · Y' ) ); ?>
      </time>
    </p>
  </div>
</a>
