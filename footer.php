<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<footer class="site-footer">
    <?php devcanvas_logo( 'footer' ); ?>
    <p class="footer-copyright"><?php echo esc_html( str_replace( '{year}', wp_date( 'Y' ), get_theme_mod( 'devcanvas_copyright', '© {year} Alex Morgan. Built with purpose & a little coffee.' ) ) ); ?></p>
    <a class="back-to-top" href="#site-top"><?php esc_html_e( 'Back to top ↑', 'devcanvas' ); ?></a>
</footer>
<?php wp_footer(); ?>
</body>
</html>
