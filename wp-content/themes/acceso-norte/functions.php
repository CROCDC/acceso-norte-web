<?php
/**
 * Acceso Norte — bootstrap del tema.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'AN_THEME_VERSION', '0.1.0' );
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

    // Tamaños custom de imagen para tarjetas y notas.
    add_image_size( 'an-card', 600, 400, true );
    add_image_size( 'an-lead', 1200, 675, true );
    add_image_size( 'an-og', 1200, 630, true );
}
add_action( 'after_setup_theme', 'an_theme_setup' );

/**
 * Enqueue de CSS/JS del tema.
 */
function an_theme_assets(): void {
    wp_enqueue_style(
        'an-main',
        AN_THEME_URI . '/assets/css/main.css',
        [],
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

/**
 * Excerpt personalizado: punto suspensivo en lugar de "[…]".
 */
add_filter( 'excerpt_more', static fn(): string => '…' );

/**
 * Includes del tema.
 */
require_once AN_THEME_DIR . '/inc/helpers.php';
