<?php
/**
 * Header global del sitio.
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'rss2_url' ); ?>">
  <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
  <meta name="theme-color" content="#0b0b0c" media="(prefers-color-scheme: dark)">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
  <div class="site-header__inner">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo">
      <?php bloginfo( 'name' ); ?>
    </a>
    <nav class="site-nav">
      <?php
      wp_nav_menu(
          [
              'theme_location' => 'primary',
              'container'      => false,
              'menu_class'     => 'site-nav__menu',
              'fallback_cb'    => static function (): void {
                  // Fallback: lista las categorías top-level si no hay menú definido.
                  $cats = get_categories( [ 'parent' => 0, 'hide_empty' => false ] );
                  foreach ( $cats as $cat ) {
                      printf(
                          '<a href="%s">%s</a>',
                          esc_url( get_category_link( $cat ) ),
                          esc_html( $cat->name )
                      );
                  }
              },
          ]
      );
      ?>
    </nav>
    <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="site-search" role="search">
      <input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>"
             placeholder="<?php esc_attr_e( 'Buscar...', 'accesonorte' ); ?>"
             aria-label="<?php esc_attr_e( 'Buscar', 'accesonorte' ); ?>">
    </form>
  </div>
</header>
<main>
