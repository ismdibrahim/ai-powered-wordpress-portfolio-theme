<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="screen-reader-text" href="#main-content"><?php esc_html_e( 'Skip to content', 'devcanvas' ); ?></a>
<header id="site-top" class="site-header">
    <div class="header-inner">
        <?php devcanvas_logo(); ?>
        <nav class="desktop-navigation" aria-label="<?php esc_attr_e( 'Main navigation', 'devcanvas' ); ?>">
            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'desktop-menu', 'menu_id' => 'desktop-menu', 'fallback_cb' => false ) ); ?>
        </nav>
        <div class="desktop-action"><?php devcanvas_header_button(); ?></div>
        <button id="menu-toggle" type="button" aria-expanded="false" aria-controls="mobile-menu" aria-haspopup="dialog" hidden>Menu <span class="menu-bars" aria-hidden="true"><span></span><span></span></span></button>
    </div>
    <dialog id="mobile-menu" aria-label="<?php esc_attr_e( 'Site menu', 'devcanvas' ); ?>">
        <div class="mobile-menu-shell">
            <div class="mobile-menu-top">
                <?php devcanvas_logo(); ?>
                <button id="menu-close" type="button" autofocus>Close <span aria-hidden="true">×</span></button>
            </div>
            <div class="mobile-menu-body">
                <p class="mobile-menu-kicker">A LITTLE LOOK AROUND</p>
                <nav aria-label="<?php esc_attr_e( 'Mobile navigation', 'devcanvas' ); ?>">
                    <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'mobile-menu-links', 'menu_id' => 'mobile-navigation', 'fallback_cb' => false ) ); ?>
                </nav>
            </div>
            <div class="mobile-menu-bottom">
                <p><span class="availability-dot" aria-hidden="true"></span> Available for new projects</p>
                <?php devcanvas_header_button(); ?>
                <span class="mobile-menu-signoff">Thoughtful websites. Built with care.</span>
            </div>
        </div>
    </dialog>
</header>
