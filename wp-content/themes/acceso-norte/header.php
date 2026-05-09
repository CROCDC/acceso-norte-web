<?php
/**
 * Header global — masthead oscuro estilo broadsheet.
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'rss2_url' ); ?>">
  <meta name="theme-color" content="#14110d">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php $is_dense = is_singular( 'post' ) || is_archive() || is_search() || is_404(); ?>
<header class="masthead<?php echo $is_dense ? ' masthead--dense' : ''; ?>">
  <div class="masthead__inner">
    <div class="masthead__utility">
      <span><?php echo esc_html( an_today_long() ); ?></span>
      <span class="masthead__utility-blurb"><?php echo esc_html( an_edition_number() ); ?></span>
    </div>
    <div class="masthead__row">
      <div class="masthead__year">
        <?php echo esc_html( an_year_roman() ); ?> · <?php echo esc_html( an_today_mono() ); ?>
      </div>
      <div class="masthead__brand">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="masthead__wordmark"
           rel="home" aria-label="<?php bloginfo( 'name' ); ?>">
          <?php bloginfo( 'name' ); ?>
        </a>
        <div class="masthead__tagline">
          <?php echo esc_html( an_tagline() ); ?>
        </div>
      </div>
      <div class="masthead__actions">
        <a href="#" class="js-search-toggle" aria-label="<?php esc_attr_e( 'Buscar', 'accesonorte' ); ?>">↗ Buscar</a>
      </div>
    </div>
  </div>
</header>

<nav class="section-nav" aria-label="<?php esc_attr_e( 'Secciones', 'accesonorte' ); ?>">
  <div class="section-nav__inner">
    <?php
    if ( has_nav_menu( 'primary' ) ) {
        wp_nav_menu(
            [
                'theme_location' => 'primary',
                'container'      => false,
                'items_wrap'     => '%3$s',
                'fallback_cb'    => false,
            ]
        );
    } else {
        // Fallback: lista las categorías top-level si no hay menú asignado.
        $cats = get_categories(
            [
                'parent'     => 0,
                'hide_empty' => false,
                'number'     => 8,
                'orderby'    => 'name',
                'order'      => 'DESC',
            ]
        );
        foreach ( $cats as $cat ) {
            $is_current = ( is_category( $cat->term_id ) ) ? ' is-active' : '';
            printf(
                '<a href="%s" class="%s">%s</a>',
                esc_url( get_category_link( $cat ) ),
                esc_attr( trim( 'section-nav__link' . $is_current ) ),
                esc_html( $cat->name )
            );
        }
    }
    ?>
  </div>
</nav>

<main class="page">
