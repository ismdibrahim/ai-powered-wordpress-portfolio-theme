<?php
/** Homepage page settings, stored separately for each page. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function devcanvas_homepage_fields() {
    $fields = array(
        'eyebrow' => array( 'Availability text', 'text', 'INDEPENDENT DEVELOPER · AVAILABLE FOR WORK', 'Hero text' ),
        'heading' => array( 'Heading (one line per row)', 'textarea', "Good websites.\nBetter business.", 'Hero text' ),
        'accent_heading' => array( 'Orange heading', 'text', 'Built with care.', 'Hero text' ),
        'description' => array( 'Introduction', 'textarea', 'Hey, I’m Alex. A WordPress & WooCommerce developer turning big ideas into websites that feel right — and work even better.', 'Hero text' ),
        'primary_text' => array( 'Primary button text', 'text', 'Explore my work', 'Links and note' ),
        'primary_url' => array( 'Primary button link', 'url', '#projects', 'Links and note' ),
        'secondary_text' => array( 'Secondary link text', 'text', 'Have a project in mind?', 'Links and note' ),
        'secondary_url' => array( 'Secondary link URL', 'url', '#contact', 'Links and note' ),
        'note' => array( 'Small note below buttons', 'text', 'Thoughtful design. Clean code. Zero headaches.', 'Links and note' ),
        'hero_image' => array( 'Hero image', 'image', get_theme_file_uri( '/assets/hero-store.svg' ), 'Hero artwork' ),
        'hero_alt' => array( 'Hero image description', 'text', 'Form and Field ecommerce website preview with a ceramic vase and warm neutral colors.', 'Hero artwork' ),
        'wp_badge' => array( 'WordPress label', 'text', 'WordPress, done right.', 'Floating labels' ),
        'wp_badge_icon' => array( 'WordPress badge icon (blank uses default)', 'image', '', 'Floating labels' ),
        'score' => array( 'Performance score', 'text', '98', 'Floating labels' ),
        'performance_icon' => array( 'Performance badge icon (replaces score; blank uses score)', 'image', '', 'Floating labels' ),
        'performance_title' => array( 'Performance title', 'text', 'Fast feels good.', 'Floating labels' ),
        'performance_detail' => array( 'Performance description', 'text', 'Built for performance', 'Floating labels' ),
        'woo_badge' => array( 'WooCommerce label', 'text', 'Ready to sell.', 'Floating labels' ),
        'woo_badge_icon' => array( 'WooCommerce badge icon (blank uses default)', 'image', '', 'Floating labels' ),
        'toolkit_show' => array( 'Show toolkit strip', 'checkbox', '1', 'Toolkit' ),
        'toolkit_intro' => array( 'Toolkit introduction', 'textarea', "A small toolkit.\nA whole lot of possibilities.", 'Toolkit' ),
    );
    $tools = array(
        array( 'WordPress', 'wordpress', 'https://wordpress.org/', 'WordPress' ),
        array( 'WooCommerce', 'woocommerce', 'https://woocommerce.com/', '' ),
        array( 'Elementor', 'elementor', 'https://elementor.com/', 'Elementor' ),
        array( 'PHP', 'php', 'https://www.php.net/', '' ),
        array( 'Figma', 'figma', 'https://www.figma.com/', 'Figma' ),
    );
    foreach ( $tools as $index => $tool ) {
        $prefix = 'tool_' . $index . '_';
        $group = 'Toolkit item ' . ( $index + 1 );
        $fields[ $prefix . 'show' ] = array( 'Show this item', 'checkbox', '1', $group );
        $fields[ $prefix . 'name' ] = array( 'Accessible name', 'text', $tool[0], $group );
        $fields[ $prefix . 'text' ] = array( 'Visible text beside logo (optional)', 'text', $tool[3], $group );
        $fields[ $prefix . 'image' ] = array( 'Logo image', 'image', get_theme_file_uri( '/assets/logos/' . $tool[1] . '.svg' ), $group );
        $fields[ $prefix . 'url' ] = array( 'Link (optional)', 'url', $tool[2], $group );
    }
    $fields['services_show'] = array( 'Show services section', 'checkbox', '1', 'Services overview' );
    $fields['services_eyebrow'] = array( 'Section label', 'text', '01 / WHAT I BRING TO THE TABLE', 'Services overview' );
    $fields['services_heading'] = array( 'Section heading', 'text', 'Built around your needs.', 'Services overview' );
    $fields['services_description'] = array( 'Section description', 'textarea', "From the first wireframe to the final click.\nI take care of the details, so you don’t have to.", 'Services overview' );
    $services = array(
        array( 'WordPress development', 'Custom websites that look like you, load quickly, and are a joy to manage. No unnecessary complexity.', "Custom themes\nElementor\nACF", 'W' ),
        array( 'WooCommerce stores', 'Shopping experiences that turn browsing into buying. Thoughtful storefronts, smooth checkouts, happy customers.', "Store setup\nCustom checkout", '' ),
        array( 'Speed & ongoing care', 'A healthy website is a growing website. Keep yours fast, secure, and working beautifully, long after launch.', "Core Web Vitals\nMaintenance", '↗' ),
    );
    foreach ( $services as $index => $service ) {
        $prefix = 'service_' . $index . '_';
        $group = 'Service card ' . ( $index + 1 );
        $fields[ $prefix . 'show' ] = array( 'Show this card', 'checkbox', '1', $group );
        $fields[ $prefix . 'title' ] = array( 'Service title', 'text', $service[0], $group );
        $fields[ $prefix . 'description' ] = array( 'Description', 'textarea', $service[1], $group );
        $fields[ $prefix . 'number' ] = array( 'Card number (optional)', 'text', sprintf( '%02d', $index + 1 ), $group );
        $fields[ $prefix . 'icon' ] = array( 'Icon image (blank uses text or default icon)', 'image', '', $group );
        $fields[ $prefix . 'symbol' ] = array( 'Icon text or symbol (blank uses default icon)', 'text', $service[3], $group );
        $fields[ $prefix . 'tags' ] = array( 'Tags (one per line)', 'textarea', $service[2], $group );
    }
    return $fields;
}

function devcanvas_homepage_data( $post_id ) {
    $saved = get_post_meta( $post_id, '_devcanvas_homepage', true );
    $saved = is_array( $saved ) ? $saved : array();
    $data = array();
    foreach ( devcanvas_homepage_fields() as $key => $field ) {
        $data[ $key ] = isset( $saved[ $key ] ) && is_string( $saved[ $key ] ) ? $saved[ $key ] : $field[2];
    }
    return $data;
}

add_action( 'add_meta_boxes_page', function () {
    add_meta_box( 'devcanvas-homepage', 'Homepage — Section Settings', 'devcanvas_homepage_metabox', 'page', 'normal', 'high' );
} );

function devcanvas_homepage_metabox( $post ) {
    wp_nonce_field( 'devcanvas_save_homepage', 'devcanvas_homepage_nonce' );
    $data = devcanvas_homepage_data( $post->ID );
    echo '<p>Select the <strong>Homepage</strong> template in the page settings to display this section. Save or update the page after editing. Blank text hides optional content. Replace the default button links with your page URLs or existing section anchors.</p>';
    $group = '';
    $section = '';
    $groups = array(
        'Hero text' => array( 'Hero', 'Heading & Introduction' ),
        'Links and note' => array( 'Hero', 'Buttons & Supporting Text' ),
        'Hero artwork' => array( 'Hero', 'Image & Accessibility' ),
        'Floating labels' => array( 'Hero', 'Floating Badges' ),
        'Toolkit' => array( 'Toolkit', 'Visibility & Introduction' ),
        'Services overview' => array( 'Services', 'Visibility & Introduction' ),
    );
    for ( $i = 1; $i <= 5; $i++ ) {
        $groups[ 'Toolkit item ' . $i ] = array( 'Toolkit', 'Tool ' . $i . ' — Logo & Link' );
    }
    for ( $i = 1; $i <= 3; $i++ ) {
        $groups[ 'Service card ' . $i ] = array( 'Services', 'Service ' . $i . ' — Content, Icon & Tags' );
    }
    foreach ( devcanvas_homepage_fields() as $key => $field ) {
        if ( $group !== $field[3] ) {
            if ( $group ) { echo '</div></details>'; }
            $group = $field[3];
            $group_info = $groups[ $group ];
            if ( $section !== $group_info[0] ) {
                if ( $section ) { echo '</div></details>'; }
                $section = $group_info[0];
                $descriptions = array( 'Hero' => 'Manage your introduction, calls to action, and artwork.', 'Toolkit' => 'Manage the toolkit strip and individual tool logos.', 'Services' => 'Manage the section introduction and three service cards.' );
                $description = $descriptions[ $section ];
                echo '<details class="dc-settings-section"><summary><span class="dc-section-title">' . esc_html( $section ) . '</span><span class="dc-section-description">' . esc_html( $description ) . '</span></summary><div class="dc-section-body">';
            }
            echo '<details class="dc-settings-group"><summary>' . esc_html( $group_info[1] ) . '</summary><div>';
        }
        $id = 'dc-home-' . $key;
        $name = 'devcanvas_homepage[' . $key . ']';
        echo '<p><label for="' . esc_attr( $id ) . '"><strong>' . esc_html( $field[0] ) . '</strong></label><br>';
        if ( 'textarea' === $field[1] ) {
            echo '<textarea class="widefat" rows="3" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '">' . esc_textarea( $data[ $key ] ) . '</textarea>';
        } elseif ( 'checkbox' === $field[1] ) {
            echo '<input type="checkbox" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="1" ' . checked( $data[ $key ], '1', false ) . '>';
        } else {
            // Text inputs allow relative URLs and anchors as well as full URLs.
            echo '<input class="widefat" type="text" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $data[ $key ] ) . '">';
            if ( 'image' === $field[1] ) {
                echo '<span class="dc-image-actions"><button type="button" class="button dc-pick-image" data-input="' . esc_attr( $id ) . '">Choose image</button> <button type="button" class="button dc-clear-image" data-input="' . esc_attr( $id ) . '">Remove image</button></span>';
                echo '<img class="dc-image-preview" alt="" src="' . esc_url( $data[ $key ] ) . '" ' . ( '' === $data[ $key ] ? 'hidden' : '' ) . '>';
            }
        }
        echo '</p>';
    }
    echo '</div></details></div></details>';
}

add_action( 'save_post_page', function ( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE || wp_is_post_revision( $post_id ) ) { return; }
    if ( ! isset( $_POST['devcanvas_homepage_nonce'] ) || ! is_string( $_POST['devcanvas_homepage_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['devcanvas_homepage_nonce'] ) ), 'devcanvas_save_homepage' ) || ! current_user_can( 'edit_post', $post_id ) ) { return; }
    if ( ! isset( $_POST['devcanvas_homepage'] ) || ! is_array( $_POST['devcanvas_homepage'] ) ) { return; }
    $input = wp_unslash( $_POST['devcanvas_homepage'] );
    $clean = array();
    foreach ( devcanvas_homepage_fields() as $key => $field ) {
        $value = isset( $input[ $key ] ) && is_string( $input[ $key ] ) ? $input[ $key ] : '';
        if ( 'checkbox' === $field[1] ) { $clean[ $key ] = '1' === $value ? '1' : ''; }
        elseif ( in_array( $field[1], array( 'url', 'image' ), true ) ) { $clean[ $key ] = esc_url_raw( $value ); }
        elseif ( 'textarea' === $field[1] ) { $clean[ $key ] = sanitize_textarea_field( $value ); }
        else { $clean[ $key ] = sanitize_text_field( $value ); }
    }
    update_post_meta( $post_id, '_devcanvas_homepage', $clean );
} );

add_action( 'admin_enqueue_scripts', function ( $hook ) {
    if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) || 'page' !== get_current_screen()->post_type ) { return; }
    wp_enqueue_media();
    wp_enqueue_script( 'devcanvas-homepage-admin', get_theme_file_uri( '/assets/homepage-admin.js' ), array( 'jquery', 'wp-data' ), '1.0', true );
    wp_enqueue_style( 'devcanvas-homepage-admin', get_theme_file_uri( '/assets/homepage-admin.css' ), array(), (string) filemtime( get_theme_file_path( '/assets/homepage-admin.css' ) ) );
} );
