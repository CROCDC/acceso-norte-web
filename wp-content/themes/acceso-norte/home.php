<?php
/**
 * Home / blog index — frente del diario.
 *
 * Layout: hero (1 destacada grande + 3 secundarias) + grid de últimas + más leídas.
 *
 * "Destacadas" se manejan con sticky posts nativos de WP (Posts → Edit → "Stick this post
 * to the front page"). Las primeras 4 sticky son el hero; el resto cae a "Últimas".
 */
get_header();

// Sticky posts (destacadas)
$sticky_ids = get_option( 'sticky_posts', [] );
$featured   = ! empty( $sticky_ids )
    ? get_posts(
        [
            'post__in'            => $sticky_ids,
            'posts_per_page'      => 4,
            'orderby'             => 'date',
            'order'               => 'DESC',
            'ignore_sticky_posts' => 1,
        ]
    )
    : [];

// Últimas (excluyendo las stickies para no repetir)
$latest = get_posts(
    [
        'posts_per_page'      => 12,
        'post__not_in'        => $sticky_ids,
        'ignore_sticky_posts' => 1,
    ]
);

// Más leídas — fallback a "más recientes" hasta que tengamos contador real.
$most_read = $latest;

$primary   = $featured[0] ?? ( $latest[0] ?? null );
$secondary = ! empty( $featured ) && count( $featured ) > 1
    ? array_slice( $featured, 1, 3 )
    : array_slice( $latest, 0, 3 );
?>

<?php if ( $primary ) : ?>
  <section class="hero">
    <div class="hero__primary">
      <?php
      $GLOBALS['post'] = $primary;
      setup_postdata( $primary );
      get_template_part( 'template-parts/card', null, [ 'size' => 'xl' ] );
      ?>
    </div>
    <aside class="hero__secondary">
      <?php foreach ( $secondary as $post ) :
          setup_postdata( $post );
          get_template_part( 'template-parts/card', null, [ 'size' => 'sm' ] );
      endforeach; ?>
    </aside>
  </section>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>

<?php if ( ! empty( $latest ) ) : ?>
  <h2 class="section-heading"><?php esc_html_e( 'Últimas', 'accesonorte' ); ?></h2>
  <div class="grid">
    <?php foreach ( $latest as $post ) :
        setup_postdata( $post );
        get_template_part( 'template-parts/card', null, [ 'size' => 'md' ] );
    endforeach; ?>
  </div>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>

<?php if ( ! empty( $most_read ) ) : ?>
  <h2 class="section-heading"><?php esc_html_e( 'Las más leídas', 'accesonorte' ); ?></h2>
  <ol class="ranked-list">
    <?php foreach ( array_slice( $most_read, 0, 6 ) as $post ) :
        setup_postdata( $post );
        $cat = an_primary_category();
        ?>
        <li data-reveal>
          <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
            <?php if ( $cat ) : ?>
              <small><?php echo esc_html( $cat->name ); ?></small>
            <?php endif; ?>
          </a>
        </li>
    <?php endforeach; ?>
  </ol>
  <?php wp_reset_postdata(); ?>
<?php endif; ?>

<?php if ( ! $primary && empty( $latest ) ) : ?>
  <p style="color: var(--muted); padding: 4rem 0; text-align: center;">
    <?php
    printf(
        wp_kses(
            __( 'Todavía no hay notas publicadas. Cargá la primera desde el <a href="%s">admin</a>.', 'accesonorte' ),
            [ 'a' => [ 'href' => [] ] ]
        ),
        esc_url( admin_url() )
    );
    ?>
  </p>
<?php endif; ?>

<?php get_footer(); ?>
