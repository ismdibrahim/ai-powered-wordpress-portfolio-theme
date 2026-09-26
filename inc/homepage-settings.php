<?php
/** Homepage page settings, stored separately for each page. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
require_once __DIR__ . '/services-repeater.php';

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
    $fields['projects_show'] = array( 'Show projects section', 'checkbox', '1', 'Projects overview' );
    $fields['projects_eyebrow'] = array( 'Section label', 'text', '02 / SELECTED WORK', 'Projects overview' );
    $fields['projects_heading'] = array( 'Section heading', 'text', 'A few things I’ve built.', 'Projects overview' );
    $fields['projects_all_label'] = array( 'All categories filter label', 'text', 'All work', 'Projects overview' );
    $fields['projects_empty'] = array( 'Empty state text', 'text', 'No projects to show yet.', 'Projects overview' );
    $fields['projects_note'] = array( 'Text below the projects', 'textarea', 'A glimpse of what’s possible. These projects showcase my approach to design and development.', 'Projects footer' );
    $fields['projects_button_text'] = array( 'Button text', 'text', 'View all projects', 'Projects footer' );
    $fields['projects_button_url'] = array( 'Button URL (leave blank to hide)', 'url', '', 'Projects footer' );
    $fields['about_show'] = array( 'Show About section', 'checkbox', '1', 'About introduction' );
    $fields['about_eyebrow'] = array( 'Section label', 'text', '03 / THE PERSON BEHIND THE PIXELS', 'About introduction' );
    $fields['about_heading'] = array( 'Heading (one line per row)', 'textarea', "Your developer.\nYour creative partner.", 'About introduction' );
    $fields['about_intro'] = array( 'First paragraph', 'textarea', 'Hi again, I’m Alex — an independent developer with a soft spot for clean design and websites that just work.', 'About introduction' );
    $fields['about_description'] = array( 'Second paragraph', 'textarea', 'I work with small businesses, creatives, and ambitious people to build their little corner of the internet. You bring the vision. I bring the curiosity, the code, and a very hands-on approach.', 'About introduction' );
    $fields['about_points'] = array( 'Highlights (one per line)', 'textarea', "Clear communication\nCare in every detail", 'About links' );
    $fields['about_link_text'] = array( 'Link text', 'text', 'Let’s make something good together', 'About links' );
    $fields['about_link_url'] = array( 'Link URL', 'url', '#contact', 'About links' );
    $fields['about_code_name'] = array( 'Name in the code card', 'text', 'Alex', 'About artwork' );
    $fields['about_code_power'] = array( 'Powered by', 'text', 'coffee', 'About artwork' );
    $fields['about_code_values'] = array( 'Cares about (one per line)', 'textarea', "the little details\nyour big picture", 'About artwork' );
    $fields['about_sticker'] = array( 'Sticker text (one line per row)', 'textarea', "A real human.\nWho loves the web.", 'About artwork' );
    $fields['contact_show'] = array( 'Show Contact section', 'checkbox', '1', 'Contact introduction' );
    $fields['contact_eyebrow'] = array( 'Section label', 'text', '04 / YOUR NEXT CHAPTER', 'Contact introduction' );
    $fields['contact_heading'] = array( 'Heading (one line per row)', 'textarea', "Have something\ngood in mind", 'Contact introduction' );
    $fields['contact_accent'] = array( 'Orange ending text', 'text', '?', 'Contact introduction' );
    $fields['contact_description'] = array( 'Description', 'textarea', 'A new website, a better store, or an idea on a napkin. I’d love to hear about it.', 'Contact introduction' );
    $fields['contact_email'] = array( 'Email address', 'text', 'hello@example.com', 'Contact details' );
    $fields['contact_copy_label'] = array( 'Copy email button label', 'text', 'Copy email', 'Contact details' );
    $fields['contact_availability'] = array( 'Availability text', 'text', 'Open for new collaborations', 'Contact details' );
    $fields['contact_form_heading'] = array( 'Form panel heading', 'text', 'Let’s talk about your project.', 'Contact form' );
    $fields['contact_form_intro'] = array( 'Form panel introduction (optional)', 'textarea', '', 'Contact form' );
    $fields['contact_shortcode'] = array( 'Form shortcode — paste JetFormBuilder, Contact Form 7, or another form shortcode', 'textarea', '', 'Contact form' );
    $fields['contact_form_note'] = array( 'Note below the form (optional)', 'textarea', '', 'Contact form' );
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
        'Projects overview' => array( 'Projects', 'Visibility, Heading & Filters' ),
        'Projects footer' => array( 'Projects', 'Supporting Text & Button' ),
        'About introduction' => array( 'About', 'Visibility & Introduction' ),
        'About links' => array( 'About', 'Highlights & Link' ),
        'About artwork' => array( 'About', 'Code Card & Sticker' ),
        'Contact introduction' => array( 'Contact', 'Visibility & Introduction' ),
        'Contact details' => array( 'Contact', 'Email & Availability' ),
        'Contact form' => array( 'Contact', 'Form Shortcode & Text' ),
    );
    for ( $i = 1; $i <= 5; $i++ ) {
        $groups[ 'Toolkit item ' . $i ] = array( 'Toolkit', 'Tool ' . $i . ' — Logo & Link' );
    }
    for ( $i = 1; $i <= 3; $i++ ) {
        $groups[ 'Service card ' . $i ] = array( 'Services', 'Service ' . $i . ' — Content, Icon & Tags' );
    }
    foreach ( devcanvas_homepage_fields() as $key => $field ) {
        if ( 0 === strpos( $key, 'service_' ) ) { continue; }
        if ( $group !== $field[3] ) {
            if ( $group ) { echo '</div></details>'; }
            $group = $field[3];
            $group_info = $groups[ $group ];
            if ( $section !== $group_info[0] ) {
                if ( 'Services' === $section ) { devcanvas_services_repeater( $post->ID ); }
                if ( $section ) { echo '</div></details>'; }
                $section = $group_info[0];
                $descriptions = array( 'Hero' => 'Manage your introduction, calls to action, and artwork.', 'Toolkit' => 'Manage the toolkit strip and individual tool logos.', 'Services' => 'Manage the introduction and add, remove, or reorder service cards.' );
                $descriptions['Projects'] = 'Displays the latest four published projects. Edit cards and categories in the Projects dashboard menu.';
                $descriptions['About'] = 'Manage your biography, highlights, decorative code card, and contact link.';
                $descriptions['Contact'] = 'Edit the contact section and paste the shortcode from your form plugin. Configure fields and delivery in that plugin.';
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
    echo '</div></details>';
    if ( 'Services' === $section ) { devcanvas_services_repeater( $post->ID ); }
    echo '</div></details>';
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
    // Preserve legacy card values for older pages until repeatable rows are saved.
    foreach ( devcanvas_homepage_data( $post_id ) as $key => $value ) {
        if ( 0 === strpos( $key, 'service_' ) ) { $clean[ $key ] = $value; }
    }
    update_post_meta( $post_id, '_devcanvas_homepage', $clean );
    if ( isset( $_POST['devcanvas_services_present'] ) ) {
        $rows = isset( $_POST['devcanvas_services'] ) && is_array( $_POST['devcanvas_services'] ) ? wp_unslash( $_POST['devcanvas_services'] ) : array();
        update_post_meta( $post_id, '_devcanvas_services', devcanvas_sanitize_service_rows( $rows ) );
    }
} );

add_action( 'admin_enqueue_scripts', function ( $hook ) {
    if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) || 'page' !== get_current_screen()->post_type ) { return; }
    wp_enqueue_media();
    wp_enqueue_script( 'devcanvas-homepage-admin', get_theme_file_uri( '/assets/homepage-admin.js' ), array( 'jquery', 'wp-data' ), (string) filemtime( get_theme_file_path( '/assets/homepage-admin.js' ) ), true );
    wp_enqueue_style( 'devcanvas-homepage-admin', get_theme_file_uri( '/assets/homepage-admin.css' ), array(), (string) filemtime( get_theme_file_path( '/assets/homepage-admin.css' ) ) );
} );
