<?php
/**
 * Single post — long-form editorial.
 *
 * Layout (handoff "Article with sidebar rail"):
 *   1. Breadcrumb
 *   2. Article header centrado (kicker, title, dek)
 *   3. Byline strip
 *   4. Hero photo con caption
 *   5. Body (drop cap automático en primer párrafo) + sidebar rail (relacionadas)
 *   6. Tags
 *   7. Share
 *   8. Footer
 */
get_header();

while ( have_posts() ) : the_post();
    $cat = an_primary_category();
?>

<div class="article-breadcrumb">
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Inicio', 'accesonorte' ); ?></a>
  <?php if ( $cat ) : ?>
    · <a href="<?php echo esc_url( get_category_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a>
  <?php endif; ?>
</div>

<header class="article-header" data-reveal>
  <?php if ( $cat ) : ?>
    <span class="kicker"><?php echo esc_html( $cat->name ); ?></span>
  <?php endif; ?>
  <h1 class="article-header__title"><?php the_title(); ?></h1>
  <?php if ( has_excerpt() ) : ?>
    <p class="article-header__dek"><?php echo esc_html( get_the_excerpt() ); ?></p>
  <?php endif; ?>
</header>

<div class="article-byline">
  <div class="article-byline__author">
    <div class="article-byline__avatar">
      <?php echo get_avatar( get_the_author_meta( 'ID' ), 44 ); ?>
    </div>
    <div>
      <div class="article-byline__name">
        <?php
        printf(
            esc_html__( 'Por %s', 'accesonorte' ),
            '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
        );
        ?>
      </div>
      <?php $desc = get_the_author_meta( 'description' ); ?>
      <?php if ( $desc ) : ?>
        <div class="article-byline__role"><?php echo esc_html( wp_trim_words( $desc, 6 ) ); ?></div>
      <?php endif; ?>
    </div>
  </div>
  <div class="article-byline__meta">
    <span class="meta">
      <?php echo esc_html( get_the_date( 'j M Y' ) ); ?> · <?php echo esc_html( get_the_date( 'H:i' ) ); ?>
    </span>
    <span class="meta">·</span>
    <span class="meta"><?php echo esc_html( an_reading_time() ); ?> min</span>
  </div>
</div>

<?php if ( has_post_thumbnail() ) : ?>
<figure class="article-hero" data-reveal>
  <?php
  the_post_thumbnail(
      'an-lead',
      [
          'sizes'         => '(max-width: 1200px) 100vw, 1200px',
          'fetchpriority' => 'high',
          'alt'           => esc_attr( get_the_title() ),
      ]
  );
  ?>
  <?php
  $thumb_id = get_post_thumbnail_id();
  $caption  = $thumb_id ? wp_get_attachment_caption( $thumb_id ) : '';
  if ( $caption ) :
  ?>
    <figcaption class="article-hero__caption"><?php echo esc_html( $caption ); ?></figcaption>
  <?php endif; ?>
</figure>
<?php endif; ?>

<div class="article-grid">
  <article class="article-body">
    <?php the_content(); ?>

    <?php if ( has_tag() ) : ?>
      <div class="article-tags">
        <?php foreach ( get_the_tags() as $tag ) : ?>
          <a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>"><?php echo esc_html( $tag->name ); ?></a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php
    $share_url   = get_permalink();
    $share_title = wp_strip_all_tags( get_the_title() );
    ?>
    <aside class="share">
      <span class="share__label"><?php esc_html_e( 'Compartir', 'accesonorte' ); ?></span>
      <a class="share__link" href="https://wa.me/?text=<?php echo rawurlencode( $share_title . ' ' . $share_url ); ?>"
         target="_blank" rel="noopener">WhatsApp</a>
      <a class="share__link" href="https://twitter.com/intent/tweet?text=<?php echo rawurlencode( $share_title ); ?>&url=<?php echo rawurlencode( $share_url ); ?>"
         target="_blank" rel="noopener">X</a>
      <a class="share__link" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode( $share_url ); ?>"
         target="_blank" rel="noopener">Facebook</a>
      <a class="share__link" href="https://t.me/share/url?url=<?php echo rawurlencode( $share_url ); ?>&text=<?php echo rawurlencode( $share_title ); ?>"
         target="_blank" rel="noopener">Telegram</a>
      <button class="share__link js-share-copy" type="button" data-url="<?php echo esc_attr( $share_url ); ?>">
        <?php esc_html_e( 'Copiar link', 'accesonorte' ); ?>
      </button>
    </aside>

    <?php
    if ( comments_open() || get_comments_number() ) {
        comments_template();
    }
    ?>
  </article>

  <aside class="article-rail">
    <div class="article-rail__inner">
      <?php
      // Relacionadas: 3 notas de la misma categoría, excluyendo esta.
      if ( $cat ) :
          $related = get_posts(
              [
                  'category'            => $cat->term_id,
                  'posts_per_page'      => 3,
                  'post__not_in'        => [ get_the_ID() ],
                  'ignore_sticky_posts' => 1,
              ]
          );
      endif;
      if ( ! empty( $related ) ) :
      ?>
        <div class="article-rail__related-head">
          <span class="kicker kicker--ink"><?php esc_html_e( 'Relacionadas', 'accesonorte' ); ?></span>
        </div>
        <div class="article-rail__related-list">
          <?php
          $current_id = get_the_ID();
          foreach ( $related as $post ) :
              setup_postdata( $post );
              $rcat = an_primary_category();
          ?>
            <div class="article-rail__related-item">
              <?php if ( $rcat ) : ?>
                <span class="kicker kicker--small"><?php echo esc_html( $rcat->name ); ?></span>
              <?php endif; ?>
              <h4 class="article-rail__related-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h4>
              <p class="card__meta" style="margin-top: 4px;">
                <span class="meta meta--small"><?php echo esc_html( get_the_date( 'd · m · Y' ) ); ?> · <?php echo esc_html( an_reading_time() ); ?> min</span>
              </p>
            </div>
          <?php
          endforeach;
          wp_reset_postdata();
          $GLOBALS['post'] = get_post( $current_id );
          setup_postdata( $GLOBALS['post'] );
          ?>
        </div>
      <?php endif; ?>
    </div>
  </aside>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
