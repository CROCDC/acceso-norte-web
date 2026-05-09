<?php
/**
 * Home — frente del diario.
 *
 * Layout (handoff "Editorial centered hero"):
 *   1. Hero centrado (la nota destacada principal)
 *   2. Two-column secundarias
 *   3. "Selección de la redacción" — 3 picks numerados
 *   4. Opinión strip (banda negra)
 *   5. Newsletter band
 *
 * Las "destacadas" se manejan con sticky posts. Stickeá una nota
 * desde el editor para que aparezca en el hero.
 */
get_header();

$sticky_ids = get_option( 'sticky_posts', [] );

$featured = ! empty( $sticky_ids )
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

$latest = get_posts(
    [
        'posts_per_page'      => 12,
        'post__not_in'        => $sticky_ids,
        'ignore_sticky_posts' => 1,
    ]
);

$primary   = $featured[0] ?? ( $latest[0] ?? null );
$secondary = ( ! empty( $featured ) && count( $featured ) > 1 )
    ? array_slice( $featured, 1, 3 )
    : array_slice( $latest, 0, 3 );

$picks_pool = ! empty( $featured ) ? array_slice( $featured, 1 ) : [];
$picks_pool = array_merge( $picks_pool, $latest );
$picks      = array_slice( $picks_pool, 0, 3 );
?>

<?php if ( $primary ) :
    $GLOBALS['post'] = $primary;
    setup_postdata( $primary );
    $cat = an_primary_category();
?>
<section class="home-hero" data-reveal>
  <div class="home-hero__inner">
    <?php if ( $cat ) : ?>
      <span class="kicker"><?php echo esc_html( $cat->name ); ?></span>
    <?php endif; ?>
    <h1 class="home-hero__title">
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h1>
    <?php if ( has_excerpt() ) : ?>
      <p class="home-hero__dek"><?php echo esc_html( get_the_excerpt() ); ?></p>
    <?php endif; ?>
    <div class="home-hero__byline">
      <span class="meta"><?php the_author(); ?></span>
      <span class="meta">·</span>
      <span class="meta"><?php echo esc_html( get_the_date( 'd · m · Y' ) ); ?></span>
      <span class="meta">·</span>
      <span class="meta"><?php echo esc_html( an_reading_time() ); ?> <?php esc_html_e( 'min de lectura', 'accesonorte' ); ?></span>
    </div>
  </div>
  <?php if ( has_post_thumbnail() ) : ?>
    <a class="home-hero__photo" href="<?php the_permalink(); ?>">
      <?php
      the_post_thumbnail(
          'an-hero',
          [
              'sizes'         => '100vw',
              'fetchpriority' => 'high',
              'alt'           => esc_attr( get_the_title() ),
          ]
      );
      ?>
    </a>
  <?php endif; ?>
</section>
<?php
    wp_reset_postdata();
endif;
?>

<?php if ( count( $secondary ) ) : ?>
<section class="home-secondary">
  <?php foreach ( array_slice( $secondary, 0, 2 ) as $post ) :
      setup_postdata( $post );
      get_template_part( 'template-parts/card', null, [ 'size' => 'lg' ] );
  endforeach; wp_reset_postdata(); ?>
</section>
<div class="home-divider"></div>
<?php endif; ?>

<?php if ( count( $picks ) ) : ?>
<section class="curated">
  <div class="curated__head">
    <h2 class="curated__title"><?php esc_html_e( 'Selección de la redacción', 'accesonorte' ); ?></h2>
    <div class="curated__rule"></div>
    <span class="meta"><?php echo esc_html( get_the_date( 'd · m · Y' ) ); ?></span>
  </div>
  <div class="curated__grid">
    <?php
    $i = 0;
    foreach ( $picks as $post ) :
        setup_postdata( $post );
        $i++;
        $cat = an_primary_category();
    ?>
      <article data-reveal>
        <div class="curated__item__num"><?php echo esc_html( str_pad( (string) $i, 2, '0', STR_PAD_LEFT ) ); ?></div>
        <div class="curated__item__rule"></div>
        <?php if ( $cat ) : ?>
          <span class="kicker kicker--small"><?php echo esc_html( $cat->name ); ?></span>
        <?php endif; ?>
        <h3 class="curated__item__title">
          <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <p class="card__meta" style="margin-top: 14px;">
          <span class="meta"><?php the_author(); ?></span>
          <span class="meta">·</span>
          <span class="meta"><?php echo esc_html( an_reading_time() ); ?> min</span>
        </p>
      </article>
    <?php endforeach; wp_reset_postdata(); ?>
  </div>
</section>
<?php endif; ?>

<?php
// Si la categoría "Opinión" existe, traemos las últimas 3 columnas.
$opinion_cat = get_term_by( 'slug', 'opinion', 'category' );
if ( $opinion_cat ) :
    $opinion = get_posts(
        [
            'category'       => $opinion_cat->term_id,
            'posts_per_page' => 3,
        ]
    );
endif;
if ( ! empty( $opinion ) ) :
?>
<section class="opinion" data-reveal>
  <div class="opinion__head">
    <h2 class="opinion__title"><?php esc_html_e( 'Opinión', 'accesonorte' ); ?></h2>
    <a href="<?php echo esc_url( get_term_link( $opinion_cat ) ); ?>" class="meta meta--paper opinion__see-all">
      <?php esc_html_e( 'Ver todas las columnas', 'accesonorte' ); ?> →
    </a>
  </div>
  <div class="opinion__grid">
    <?php foreach ( $opinion as $post ) : setup_postdata( $post ); ?>
      <div class="opinion__col">
        <span class="kicker kicker--gold kicker--small"><?php esc_html_e( 'Opinión', 'accesonorte' ); ?></span>
        <h3 class="opinion__col__title">
          <a href="<?php the_permalink(); ?>" style="color: inherit;"><?php the_title(); ?></a>
        </h3>
        <div class="opinion__col__author">
          <div class="opinion__col__avatar">
            <?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
          </div>
          <div>
            <div class="opinion__col__name"><?php the_author(); ?></div>
            <?php $role = get_the_author_meta( 'description' ); ?>
            <?php if ( $role ) : ?>
              <div class="opinion__col__role"><?php echo esc_html( wp_trim_words( $role, 8 ) ); ?></div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; wp_reset_postdata(); ?>
  </div>
</section>
<?php endif; ?>

<section class="newsletter-band" data-reveal>
  <div class="newsletter-band__inner">
    <div>
      <span class="kicker kicker--soft"><?php esc_html_e( 'El newsletter', 'accesonorte' ); ?></span>
      <h2 class="newsletter-band__title"><?php esc_html_e( 'Las 6 noticias del corredor norte que definen tu semana.', 'accesonorte' ); ?></h2>
      <p class="newsletter-band__dek"><?php esc_html_e( 'Cada lunes a las 7 AM. Curado por nuestra redacción. Para empresarios, dirigentes y vecinos informados.', 'accesonorte' ); ?></p>
    </div>
    <form action="<?php echo esc_url( home_url( '/newsletter/' ) ); ?>" method="post" class="newsletter-band__form">
      <input type="email" name="email" placeholder="<?php esc_attr_e( 'tu@email.com', 'accesonorte' ); ?>" class="newsletter-band__input" required>
      <button type="submit" class="newsletter-band__submit"><?php esc_html_e( 'Suscribirme', 'accesonorte' ); ?></button>
    </form>
  </div>
</section>

<?php if ( ! $primary && empty( $latest ) ) : ?>
  <section class="simple-page">
    <h1><?php esc_html_e( 'Bienvenido', 'accesonorte' ); ?></h1>
    <p>
      <?php
      printf(
          wp_kses(
              __( 'Todavía no hay notas publicadas. Cargá la primera desde el <a href="%s">admin de WordPress</a>.', 'accesonorte' ),
              [ 'a' => [ 'href' => [] ] ]
          ),
          esc_url( admin_url() )
      );
      ?>
    </p>
  </section>
<?php endif; ?>

<?php get_footer(); ?>
