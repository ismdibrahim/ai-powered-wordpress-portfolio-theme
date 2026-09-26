<?php
/** Theme setup and assets. */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
require_once get_theme_file_path( '/inc/homepage-settings.php' );
require_once get_theme_file_path( '/inc/projects.php' );
require_once get_theme_file_path( '/inc/projects-page-settings.php' );

function devcanvas_setup() {
    register_nav_menus( array( 'primary' => __( 'Header Menu', 'devcanvas' ) ) );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
}
add_action( 'after_setup_theme', 'devcanvas_setup' );

function devcanvas_enqueue_styles() {
    if ( is_page_template( 'templates/template-homepage.php' ) ) {
        wp_enqueue_script( 'devcanvas-contact', get_theme_file_uri( '/assets/contact.js' ), array(), (string) filemtime( get_theme_file_path( '/assets/contact.js' ) ), true );
    }
    if ( is_page_template( array( 'templates/template-homepage.php', 'templates/template-projects.php' ) ) ) {
        wp_enqueue_script( 'devcanvas-project-filters', get_theme_file_uri( '/assets/projects.js' ), array(), (string) filemtime( get_theme_file_path( '/assets/projects.js' ) ), true );
        wp_enqueue_style( 'devcanvas-homepage', get_theme_file_uri( '/assets/homepage.css' ), array( 'devcanvas-style' ), (string) filemtime( get_theme_file_path( '/assets/homepage.css' ) ) );
    }
    wp_enqueue_style( 'devcanvas-fonts', 'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap', array(), null );
    wp_enqueue_style( 'devcanvas-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
    wp_enqueue_script( 'devcanvas-navigation', get_theme_file_uri( '/navigation.js' ), array(), wp_get_theme()->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'devcanvas_enqueue_styles' );

function devcanvas_customize_register( $customizer ) {
    $customizer->add_section( 'devcanvas_header_footer', array(
        'title' => __( 'Header & Footer', 'devcanvas' ), 'priority' => 30,
    ) );
    foreach ( array( 'header_logo' => 'Header logo', 'footer_logo' => 'Footer logo' ) as $key => $label ) {
        $customizer->add_setting( 'devcanvas_' . $key, array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
        $customizer->add_control( new WP_Customize_Media_Control( $customizer, 'devcanvas_' . $key, array(
            'label' => $label, 'section' => 'devcanvas_header_footer', 'mime_type' => 'image',
        ) ) );
    }
    $fields = array(
        'button_text' => array( 'Header button text', 'Let’s talk', 'text', 'sanitize_text_field' ),
        'button_url' => array( 'Header button URL', home_url( '/#contact' ), 'url', 'esc_url_raw' ),
        'copyright' => array( 'Footer copyright', '© {year} Alex Morgan. Built with purpose & a little coffee.', 'textarea', 'sanitize_textarea_field' ),
    );
    foreach ( $fields as $key => $field ) {
        $customizer->add_setting( 'devcanvas_' . $key, array( 'default' => $field[1], 'sanitize_callback' => $field[3] ) );
        $customizer->add_control( 'devcanvas_' . $key, array(
            'label' => $field[0], 'section' => 'devcanvas_header_footer', 'type' => $field[2],
            'description' => 'copyright' === $key ? __( 'Use {year} for the current year. Leave blank to hide.', 'devcanvas' ) : __( 'Leave blank to hide the button.', 'devcanvas' ),
        ) );
    }
    if ( isset( $customizer->selective_refresh ) ) {
        foreach ( array( 'header', 'footer' ) as $location ) {
            $customizer->selective_refresh->add_partial( 'devcanvas_' . $location . '_logo', array(
                'selector' => '.brand-' . $location,
                'settings' => array( 'devcanvas_' . $location . '_logo' ),
                'container_inclusive' => true,
                'render_callback' => function () use ( $location ) {
                    devcanvas_logo( $location );
                },
            ) );
        }
        $customizer->selective_refresh->add_partial( 'devcanvas_header_button', array(
            'selector' => '.header-button',
            'settings' => array( 'devcanvas_button_text', 'devcanvas_button_url' ),
            'primary_setting' => 'devcanvas_button_text',
            'container_inclusive' => true,
            'render_callback' => 'devcanvas_header_button',
        ) );
        $customizer->selective_refresh->add_partial( 'devcanvas_copyright', array(
            'selector' => '.footer-copyright',
            'settings' => array( 'devcanvas_copyright' ),
            'render_callback' => function () {
                return esc_html( str_replace( '{year}', wp_date( 'Y' ), get_theme_mod( 'devcanvas_copyright', '© {year} Alex Morgan. Built with purpose & a little coffee.' ) ) );
            },
        ) );
    }
}
add_action( 'customize_register', 'devcanvas_customize_register' );

function devcanvas_logo( $location = 'header' ) {
    $logo = wp_get_attachment_image( absint( get_theme_mod( 'devcanvas_' . $location . '_logo', 0 ) ), 'full', false, array( 'class' => 'brand-image', 'alt' => get_bloginfo( 'name' ) ) );
    echo '<a class="brand brand-' . esc_attr( $location ) . '" href="' . esc_url( home_url( '/' ) ) . '" aria-label="' . esc_attr( get_bloginfo( 'name' ) . ' home' ) . '">';
    if ( $logo ) {
        echo $logo;
    } else {
        echo 'alex<span class="accent">.</span>morgan';
        if ( 'header' === $location ) {
            echo '<span class="brand-star" aria-hidden="true">✳</span>';
        }
    }
    echo '</a>';
}

function devcanvas_header_button() {
    $text = get_theme_mod( 'devcanvas_button_text', 'Let’s talk' );
    $url = get_theme_mod( 'devcanvas_button_url', home_url( '/#contact' ) );
    if ( $text && $url ) {
        echo '<a class="header-button" href="' . esc_url( $url ) . '">' . esc_html( $text ) . '<span aria-hidden="true">↗</span></a>';
    }
}
