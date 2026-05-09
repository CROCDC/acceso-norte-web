<?php
/**
 * Helpers reutilizables del tema.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Año fundacional del diario (para "Año II", "Año III", etc.).
 * Cambiar a la fecha real cuando el sitio salga a producción.
 */
const AN_FOUNDED_YEAR = 2026;

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
 * Categoría principal del post (la primera). En sitios de noticias un artículo
 * pertenece conceptualmente a una sola sección aunque WP permita varias.
 */
function an_primary_category( ?int $post_id = null ): ?WP_Term {
    $cats = get_the_category( $post_id ?? get_the_ID() );
    return $cats[0] ?? null;
}

/**
 * Fecha larga estilo broadsheet: "Sábado 9 de mayo de 2026".
 */
function an_today_long(): string {
    // Locale español: "l j \\d\\e F \\d\\e Y" → "sábado 9 de mayo de 2026"
    $raw = wp_date( 'l j \\d\\e F \\d\\e Y' );
    return mb_convert_case( mb_substr( $raw, 0, 1 ), MB_CASE_UPPER ) . mb_substr( $raw, 1 );
}

/**
 * Fecha mono estilo masthead: "Sáb · 09 · 05 · 2026".
 */
function an_today_mono(): string {
    $day_short = wp_date( 'l' );  // "sábado"
    $day_short = mb_convert_case( mb_substr( $day_short, 0, 3 ), MB_CASE_TITLE );  // "Sáb"
    return sprintf( '%s · %s', $day_short, wp_date( 'd · m · Y' ) );
}

/**
 * Año del diario en romanos: "Año II" si fundado hace 1 año, etc.
 */
function an_year_roman(): string {
    $diff   = max( 1, (int) wp_date( 'Y' ) - AN_FOUNDED_YEAR + 1 );
    $romans = [ 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X' ];
    return 'Año ' . ( $romans[ $diff - 1 ] ?? (string) $diff );
}

/**
 * Tagline corto del diario (debajo del wordmark).
 */
function an_tagline(): string {
    $custom = get_bloginfo( 'description' );
    if ( $custom && 'Otro sitio realizado con WordPress' !== $custom ) {
        return $custom;
    }
    return 'Política · Economía · Empresas — Buenos Aires Norte';
}

/**
 * Edición — placeholder. El día que tengamos un contador real, lo cambiamos.
 */
function an_edition_number(): string {
    return apply_filters( 'an_edition_number', 'Edición Nº 1' );
}

/**
 * Renderiza una <picture> con tamaños responsive a partir del thumbnail
 * del post actual. Usa los tamaños custom registrados en functions.php.
 */
function an_post_thumbnail( string $size = 'an-card', array $attrs = [] ): void {
    if ( ! has_post_thumbnail() ) {
        return;
    }
    $defaults = [
        'loading' => 'lazy',
        'sizes'   => '(max-width: 600px) 100vw, 600px',
        'alt'     => esc_attr( get_the_title() ),
    ];
    the_post_thumbnail( $size, array_merge( $defaults, $attrs ) );
}
