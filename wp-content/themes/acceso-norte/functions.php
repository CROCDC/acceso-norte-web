<?php
/**
 * Acceso Norte — bootstrap del tema.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'AN_THEME_VERSION', '0.2.0' );
define( 'AN_THEME_DIR', get_template_directory() );
define( 'AN_THEME_URI', get_template_directory_uri() );

/**
 * Setup básico: soporte de features de WP.
 */
function an_theme_setup(): void {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support(
        'html5',
        [ 'search-form', 'gallery', 'caption', 'style', 'script' ]
    );
    add_theme_support(
        'custom-logo',
        [
            'height'      => 80,
            'width'       => 240,
            'flex-height' => true,
            'flex-width'  => true,
        ]
    );

    register_nav_menus(
        [
            'primary' => __( 'Menú principal', 'accesonorte' ),
            'footer'  => __( 'Menú del footer', 'accesonorte' ),
        ]
    );

    // Tamaños custom — ratios pensados para cards y hero broadsheet.
    add_image_size( 'an-card', 600, 400, true );      // 3:2 cards estándar
    add_image_size( 'an-card-square', 280, 280, true ); // hero secundarios
    add_image_size( 'an-lead', 1200, 675, true );     // 16:9 hero artículo
    add_image_size( 'an-hero', 1280, 640, true );     // hero home full-bleed
    add_image_size( 'an-og', 1200, 630, true );       // Open Graph
}
add_action( 'after_setup_theme', 'an_theme_setup' );

/**
 * Enqueue de fuentes y assets.
 */
function an_theme_assets(): void {
    // Google Fonts: Playfair Display + Source Serif 4 + IBM Plex (Mono + Sans)
    wp_enqueue_style(
        'an-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,700&family=Source+Serif+4:ital,opsz,wght@0,8..60,300..700;1,8..60,400..700&family=IBM+Plex+Mono:wght@300;400;500;600&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'an-main',
        AN_THEME_URI . '/assets/css/main.css',
        [ 'an-fonts' ],
        AN_THEME_VERSION
    );

    wp_enqueue_script(
        'an-main',
        AN_THEME_URI . '/assets/js/main.js',
        [],
        AN_THEME_VERSION,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'an_theme_assets' );

// Preconnect a Google Fonts para el TTFB del CSS de fonts.
function an_resource_hints( array $hints, string $relation ): array {
    if ( 'preconnect' === $relation ) {
        $hints[] = [ 'href' => 'https://fonts.googleapis.com' ];
        $hints[] = [
            'href'        => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        ];
    }
    return $hints;
}
add_filter( 'wp_resource_hints', 'an_resource_hints', 10, 2 );

/**
 * Excerpt: terminador con "…" en lugar de "[…]".
 */
add_filter( 'excerpt_more', static fn(): string => '…' );

/**
 * Includes del tema.
 */
require_once AN_THEME_DIR . '/inc/helpers.php';
