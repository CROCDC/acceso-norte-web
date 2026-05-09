<?php
/**
 * Footer global oscuro: 4 columnas + bottom strip.
 */
?>
</main>

<footer class="site-footer">
  <div class="site-footer__inner">
    <div>
      <div class="site-footer__brand-name"><?php bloginfo( 'name' ); ?></div>
      <div class="site-footer__brand-rule"></div>
      <div class="site-footer__brand-tagline">
        <?php echo esc_html( an_tagline() ); ?>. Edición digital.
      </div>
    </div>

    <div>
      <div class="site-footer__col-title"><?php esc_html_e( 'Secciones', 'accesonorte' ); ?></div>
      <ul class="site-footer__col-list">
        <?php
        $cats = get_categories( [ 'parent' => 0, 'hide_empty' => false, 'number' => 6 ] );
        foreach ( $cats as $cat ) :
        ?>
          <li><a href="<?php echo esc_url( get_category_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div>
      <div class="site-footer__col-title"><?php esc_html_e( 'Distritos', 'accesonorte' ); ?></div>
      <ul class="site-footer__col-list">
        <li>San Isidro</li>
        <li>Vicente López</li>
        <li>Tigre</li>
        <li>Pilar</li>
        <li>Campana</li>
      </ul>
    </div>

    <div>
      <div class="site-footer__col-title"><?php esc_html_e( 'Institucional', 'accesonorte' ); ?></div>
      <ul class="site-footer__col-list">
        <li><a href="<?php echo esc_url( home_url( '/quienes-somos/' ) ); ?>"><?php esc_html_e( 'Quiénes somos', 'accesonorte' ); ?></a></li>
        <li><a href="<?php echo esc_url( home_url( '/linea-editorial/' ) ); ?>"><?php esc_html_e( 'Línea editorial', 'accesonorte' ); ?></a></li>
        <li><a href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>"><?php esc_html_e( 'Contacto', 'accesonorte' ); ?></a></li>
        <li><a href="<?php echo esc_url( home_url( '/newsletter/' ) ); ?>"><?php esc_html_e( 'Newsletter', 'accesonorte' ); ?></a></li>
        <li><a href="<?php bloginfo( 'rss2_url' ); ?>">RSS</a></li>
      </ul>
    </div>
  </div>
  <div class="site-footer__bottom">
    <span>© <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?> · Buenos Aires</span>
    <span><?php esc_html_e( 'Términos · Privacidad · Aviso legal', 'accesonorte' ); ?></span>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
