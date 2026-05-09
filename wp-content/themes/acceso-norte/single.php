<?php
/**
 * Single post — detalle de una nota.
 */
get_header();

while ( have_posts() ) : the_post();
    $cat          = an_primary_category();
    $reading_time = an_reading_time();
    $share_url    = get_permalink();
    $share_title  = wp_strip_all_tags( get_the_title() );
?>

<article class="article">
    <?php if ( $cat ) : ?>
      <p class="article__category">
        <a href="<?php echo esc_url( get_category_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a>
      </p>
    <?php endif; ?>

    <h1 class="article__title"><?php the_title(); ?></h1>

    <?php if ( has_excerpt() ) : ?>
      <p class="article__subtitle"><?php echo esc_html( get_the_excerpt() ); ?></p>
    <?php endif; ?>

    <div class="article__meta">
      <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
        <?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
        <?php the_author(); ?>
      </a>
      <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
        <?php echo esc_html( get_the_date( 'Y-m-d' ) ); ?>
      </time>
      <span><?php echo esc_html( $reading_time ); ?> <?php esc_html_e( 'min de lectura', 'accesonorte' ); ?></span>
    </div>

    <?php if ( has_post_thumbnail() ) : ?>
      <figure class="article__lead">
        <?php
        the_post_thumbnail(
            'an-lead',
            [
                'sizes'         => '(max-width: 1200px) 100vw, 1200px',
                'fetchpriority' => 'high',
            ]
        );
        ?>
      </figure>
    <?php endif; ?>

    <div class="article__body">
      <?php the_content(); ?>
    </div>

    <?php if ( has_tag() ) : ?>
      <ul class="article__tags">
        <?php foreach ( get_the_tags() as $tag ) : ?>
          <li>
            <a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>">#<?php echo esc_html( $tag->name ); ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <aside class="share">
      <span class="share__label"><?php esc_html_e( 'Compartir:', 'accesonorte' ); ?></span>
      <a class="share__link share__link--whatsapp"
         href="https://wa.me/?text=<?php echo rawurlencode( $share_title . ' ' . $share_url ); ?>"
         target="_blank" rel="noopener">WhatsApp</a>
      <a class="share__link share__link--twitter"
         href="https://twitter.com/intent/tweet?text=<?php echo rawurlencode( $share_title ); ?>&url=<?php echo rawurlencode( $share_url ); ?>"
         target="_blank" rel="noopener">X</a>
      <a class="share__link share__link--facebook"
         href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode( $share_url ); ?>"
         target="_blank" rel="noopener">Facebook</a>
      <a class="share__link share__link--telegram"
         href="https://t.me/share/url?url=<?php echo rawurlencode( $share_url ); ?>&text=<?php echo rawurlencode( $share_title ); ?>"
         target="_blank" rel="noopener">Telegram</a>
    </aside>

    <?php
    if ( comments_open() || get_comments_number() ) {
        comments_template();
    }
    ?>
</article>

<?php endwhile; ?>

<?php get_footer(); ?>
