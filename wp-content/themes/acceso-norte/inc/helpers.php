<?php
/**
 * Helpers reutilizables del tema.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Tiempo de lectura estimado en minutos. ~200 palabras/min.
 */
function an_reading_time( ?int $post_id = null ): int {
    $post_id = $post_id ?? get_the_ID();
    if ( ! $post_id ) {
        return 1;
    }
    $word_count = str_word_count( wp_strip_all_tags( get_post_field( 'post_content', $post_id ) ) );
    return max( 1, (int) round( $word_count / 200 ) );
}

/**
 * Devuelve la categoría principal del post (la primera). Útil para news sites
 * donde un artículo conceptualmente pertenece a una sola sección aunque WP
 * permita varias.
 */
function an_primary_category( ?int $post_id = null ): ?WP_Term {
    $cats = get_the_category( $post_id ?? get_the_ID() );
    return $cats[0] ?? null;
}

/**
 * URL absoluta a una rendition específica del thumbnail. Si no hay imagen,
 * devuelve null.
 */
function an_thumbnail_src( string $size = 'an-card' ): ?string {
    $id = get_post_thumbnail_id();
    if ( ! $id ) {
        return null;
    }
    $img = wp_get_attachment_image_src( $id, $size );
    return $img[0] ?? null;
}
