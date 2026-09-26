<?php
/** Repeatable service cards with fallback to the original three-card settings. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
function devcanvas_service_rows( $post_id ) {
    if ( metadata_exists( 'post', $post_id, '_devcanvas_services' ) ) {
        $rows = get_post_meta( $post_id, '_devcanvas_services', true );
        return is_array( $rows ) ? $rows : array();
    }
    $legacy = devcanvas_homepage_data( $post_id );
    $rows = array();
    foreach ( array( 'wordpress', 'cart', 'arrow' ) as $i => $fallback ) {
        $row = array( 'fallback' => $fallback );
        foreach ( array( 'show', 'title', 'description', 'number', 'icon', 'symbol', 'tags' ) as $key ) {
            $row[ $key ] = $legacy[ 'service_' . $i . '_' . $key ];
        }
        $rows[] = $row;
    }
    return $rows;
}
function devcanvas_service_row_control( $index, $row ) {
    $row = wp_parse_args( $row, array( 'show' => '1', 'title' => '', 'description' => '', 'number' => '', 'icon' => '', 'symbol' => '', 'tags' => '', 'fallback' => 'arrow' ) );
    echo '<details class="dc-settings-group dc-service-row"><summary class="dc-service-row-title">' . esc_html( $row['title'] ?: 'New service' ) . '</summary><div>';
    echo '<p class="dc-row-actions"><button type="button" class="button dc-service-up">Move up</button> <button type="button" class="button dc-service-down">Move down</button> <button type="button" class="button dc-service-remove">Remove service</button></p>';
    echo '<input type="hidden" name="devcanvas_services[' . esc_attr( $index ) . '][fallback]" value="' . esc_attr( $row['fallback'] ) . '">';
    foreach ( array( 'show' => 'Show this card', 'title' => 'Service title', 'description' => 'Description', 'number' => 'Card number (optional)', 'icon' => 'Icon image (optional)', 'symbol' => 'Icon text or symbol (blank uses default)', 'tags' => 'Tags (one per line)' ) as $key => $label ) {
        $id = 'dc-service-' . $index . '-' . $key;
        $name = 'devcanvas_services[' . $index . '][' . $key . ']';
        echo '<p><label for="' . esc_attr( $id ) . '"><strong>' . esc_html( $label ) . '</strong></label><br>';
        if ( 'show' === $key ) {
            echo '<input type="checkbox" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="1" ' . checked( $row[$key], '1', false ) . '>';
        } elseif ( in_array( $key, array( 'description', 'tags' ), true ) ) {
            echo '<textarea class="widefat" rows="3" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '">' . esc_textarea( $row[$key] ) . '</textarea>';
        } else {
            echo '<input class="widefat" type="text" id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $row[$key] ) . '">';
            if ( 'icon' === $key ) {
                echo '<span class="dc-image-actions"><button type="button" class="button dc-pick-image" data-input="' . esc_attr( $id ) . '">Choose image</button> <button type="button" class="button dc-clear-image" data-input="' . esc_attr( $id ) . '">Remove image</button></span><img class="dc-image-preview" alt="" ' . ( $row[$key] ? 'src="' . esc_url( $row[$key] ) . '"' : 'hidden' ) . '>';
            }
        }
        echo '</p>';
    }
    echo '</div></details>';
}
function devcanvas_services_repeater( $post_id ) {
    echo '<div id="dc-services-repeater"><h4>Service Cards</h4><p>Add services and arrange them in the order you want. Save the page to apply changes.</p><input type="hidden" name="devcanvas_services_present" value="1"><div class="dc-service-rows">';
    foreach ( devcanvas_service_rows( $post_id ) as $index => $row ) { devcanvas_service_row_control( $index, $row ); }
    echo '</div><button type="button" class="button button-primary dc-service-add">Add service</button><p class="dc-service-status" role="status" aria-live="polite"></p><template id="dc-service-template">';
    devcanvas_service_row_control( '__INDEX__', array() );
    echo '</template></div>';
}
function devcanvas_sanitize_service_rows( $rows ) {
    $clean = array();
    foreach ( $rows as $row ) {
        if ( ! is_array( $row ) ) { continue; }
        $item = array();
        foreach ( array( 'show', 'title', 'description', 'number', 'icon', 'symbol', 'tags', 'fallback' ) as $key ) {
            $value = isset( $row[$key] ) && is_string( $row[$key] ) ? $row[$key] : '';
            if ( 'show' === $key ) { $item[$key] = '1' === $value ? '1' : ''; }
            elseif ( 'icon' === $key ) { $item[$key] = esc_url_raw( $value ); }
            elseif ( 'fallback' === $key ) { $item[$key] = in_array( $value, array( 'wordpress', 'cart', 'arrow' ), true ) ? $value : 'arrow'; }
            elseif ( in_array( $key, array( 'description', 'tags' ), true ) ) { $item[$key] = sanitize_textarea_field( $value ); }
            else { $item[$key] = sanitize_text_field( $value ); }
        }
        $clean[] = $item;
    }
    return $clean;
}
