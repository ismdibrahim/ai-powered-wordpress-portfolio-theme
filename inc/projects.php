<?php
/** Projects and their dedicated category and tag taxonomies. */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function devcanvas_register_projects() {
    register_post_type( 'devcanvas_project', array(
        'labels' => array(
            'name' => __( 'Projects', 'devcanvas' ),
            'singular_name' => __( 'Project', 'devcanvas' ),
            'menu_name' => __( 'Projects', 'devcanvas' ),
            'all_items' => __( 'All Projects', 'devcanvas' ),
            'add_new' => __( 'Add Project', 'devcanvas' ),
            'add_new_item' => __( 'Add New Project', 'devcanvas' ),
            'edit_item' => __( 'Edit Project', 'devcanvas' ),
            'new_item' => __( 'New Project', 'devcanvas' ),
            'view_item' => __( 'View Project', 'devcanvas' ),
            'search_items' => __( 'Search Projects', 'devcanvas' ),
            'not_found' => __( 'No projects found.', 'devcanvas' ),
            'not_found_in_trash' => __( 'No projects found in Trash.', 'devcanvas' ),
            'featured_image' => __( 'Project Featured Image', 'devcanvas' ),
            'set_featured_image' => __( 'Set project featured image', 'devcanvas' ),
            'remove_featured_image' => __( 'Remove project featured image', 'devcanvas' ),
            'use_featured_image' => __( 'Use as project featured image', 'devcanvas' ),
        ),
        'public' => true,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'show_in_nav_menus' => false,
        'query_var' => false,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-portfolio',
        'menu_position' => 21,
        'supports' => array( 'title', 'thumbnail', 'excerpt', 'revisions' ),
        'has_archive' => false,
        'rewrite' => false,
        'taxonomies' => array( 'project_category', 'project_tag' ),
    ) );

    register_taxonomy( 'project_category', array( 'devcanvas_project' ), array(
        'labels' => array(
            'name' => __( 'Project Categories', 'devcanvas' ),
            'singular_name' => __( 'Project Category', 'devcanvas' ),
            'search_items' => __( 'Search Project Categories', 'devcanvas' ),
            'all_items' => __( 'All Project Categories', 'devcanvas' ),
            'parent_item' => __( 'Parent Project Category', 'devcanvas' ),
            'parent_item_colon' => __( 'Parent Project Category:', 'devcanvas' ),
            'edit_item' => __( 'Edit Project Category', 'devcanvas' ),
            'update_item' => __( 'Update Project Category', 'devcanvas' ),
            'add_new_item' => __( 'Add New Project Category', 'devcanvas' ),
            'new_item_name' => __( 'New Project Category Name', 'devcanvas' ),
            'menu_name' => __( 'Project Categories', 'devcanvas' ),
        ),
        'hierarchical' => true,
        'public' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'rewrite' => array( 'slug' => 'project-category', 'with_front' => false ),
    ) );

    register_taxonomy( 'project_tag', array( 'devcanvas_project' ), array(
        'labels' => array(
            'name' => __( 'Project Tags', 'devcanvas' ),
            'singular_name' => __( 'Project Tag', 'devcanvas' ),
            'search_items' => __( 'Search Project Tags', 'devcanvas' ),
            'all_items' => __( 'All Project Tags', 'devcanvas' ),
            'edit_item' => __( 'Edit Project Tag', 'devcanvas' ),
            'update_item' => __( 'Update Project Tag', 'devcanvas' ),
            'add_new_item' => __( 'Add New Project Tag', 'devcanvas' ),
            'new_item_name' => __( 'New Project Tag Name', 'devcanvas' ),
            'separate_items_with_commas' => __( 'Separate project tags with commas', 'devcanvas' ),
            'add_or_remove_items' => __( 'Add or remove project tags', 'devcanvas' ),
            'choose_from_most_used' => __( 'Choose from the most used project tags', 'devcanvas' ),
            'menu_name' => __( 'Project Tags', 'devcanvas' ),
        ),
        'hierarchical' => false,
        'public' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'rewrite' => array( 'slug' => 'project-tag', 'with_front' => false ),
    ) );
}
add_action( 'init', 'devcanvas_register_projects' );

function devcanvas_project_link_metabox() {
    add_meta_box( 'devcanvas-project-link', __( 'Project Details', 'devcanvas' ), function ( $post ) {
        wp_nonce_field( 'devcanvas_save_project_link', 'devcanvas_project_link_nonce' );
        $url = get_post_meta( $post->ID, '_devcanvas_live_website_link', true );
        ?>
        <p>
            <label for="devcanvas-live-website-link"><strong><?php esc_html_e( 'Live Website Link', 'devcanvas' ); ?></strong></label>
        </p>
        <input type="text" class="widefat" id="devcanvas-live-website-link" name="devcanvas_live_website_link" value="<?php echo esc_attr( $url ); ?>" placeholder="https://example.com" aria-describedby="devcanvas-live-website-help">
        <p class="description" id="devcanvas-live-website-help"><?php esc_html_e( 'Enter the full website URL, including https://. Leave blank if there is no live website.', 'devcanvas' ); ?></p>
        <?php
    }, 'devcanvas_project', 'normal', 'high' );
}
add_action( 'add_meta_boxes_devcanvas_project', 'devcanvas_project_link_metabox' );

function devcanvas_save_project_link( $post_id ) {
    if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_revision( $post_id ) ) {
        return;
    }
    if ( ! isset( $_POST['devcanvas_project_link_nonce'] ) || ! is_string( $_POST['devcanvas_project_link_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['devcanvas_project_link_nonce'] ) ), 'devcanvas_save_project_link' ) || ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    if ( ! isset( $_POST['devcanvas_live_website_link'] ) || ! is_string( $_POST['devcanvas_live_website_link'] ) ) {
        return;
    }
    $url = esc_url_raw( trim( wp_unslash( $_POST['devcanvas_live_website_link'] ) ), array( 'http', 'https' ) );
    update_post_meta( $post_id, '_devcanvas_live_website_link', $url );
}
add_action( 'save_post_devcanvas_project', 'devcanvas_save_project_link' );

/** Refresh permalinks once after adding these routes to an active theme. */
function devcanvas_projects_rewrite_rules() {
    if ( current_user_can( 'manage_options' ) && '2' !== get_option( 'devcanvas_projects_rewrite_version' ) ) {
        flush_rewrite_rules( false );
        update_option( 'devcanvas_projects_rewrite_version', '2' );
    }
}
add_action( 'admin_init', 'devcanvas_projects_rewrite_rules' );
add_action( 'after_switch_theme', function () {
    delete_option( 'devcanvas_projects_rewrite_version' );
} );

