<?php
/** Editable Projects page content. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
function devcanvas_projects_page_fields() {
    return array(
        'back' => array('Back link text','text','← Back to home','Introduction'),
        'eyebrow' => array('Section label','text','THE PROJECT COLLECTION','Introduction'),
        'heading' => array('Heading','textarea','Good ideas.','Introduction'),
        'accent' => array('Orange heading','text','Brought to life.','Introduction'),
        'description' => array('Introduction','textarea','Explore my WordPress websites and WooCommerce stores. Thoughtful design, considered details, and a little personality in every project.','Introduction'),
        'count' => array('Project count label — use {count}','text','{count} PROJECTS','Collection'),
        'collection' => array('Collection heading','text','All projects.','Collection'),
        'all' => array('All categories label','text','All work','Collection'),
        'empty' => array('Empty state','text','No projects to show yet.','Collection'),
        'note' => array('Text below projects','textarea','These concept projects showcase my approach to design and development.','Collection'),
        'cta_label' => array('Contact section label','text','LET’S MAKE YOUR NEXT CHAPTER','Contact'),
        'cta_heading' => array('Contact heading','text','Your project could be next.','Contact'),
        'cta_description' => array('Contact description','textarea','Have a website or store in mind? Let’s talk about it.','Contact'),
        'cta_button' => array('Button text','text','Start a conversation','Contact'),
        'cta_url' => array('Button URL','url',home_url('/#contact'),'Contact'),
    );
}
function devcanvas_projects_page_data($id) {
    $saved=get_post_meta($id,'_devcanvas_projects_page',true);
    $data=array();
    foreach(devcanvas_projects_page_fields() as $key=>$field) {
        $data[$key]=is_array($saved) && isset($saved[$key]) && is_string($saved[$key]) ? $saved[$key] : $field[2];
    }
    return $data;
}
add_action('add_meta_boxes_page',function(){
    add_meta_box('devcanvas-projects-page','Projects — Page Settings',function($post){
        wp_nonce_field('devcanvas_projects_page','devcanvas_projects_page_nonce');
        $data=devcanvas_projects_page_data($post->ID);
        echo '<p>Choose the Projects page template to use these settings. Project cards are managed under Projects. Save the page after editing.</p>';
        $group='';
        foreach(devcanvas_projects_page_fields() as $key=>$field){
            if($group!==$field[3]){
                if($group) echo '</div></details>';
                $group=$field[3];
                echo '<details class="dc-settings-group"><summary>'.esc_html($group).'</summary><div>';
            }
            $id='dc-projects-page-'.$key;
            echo '<p><label for="'.esc_attr($id).'"><strong>'.esc_html($field[0]).'</strong></label><br>';
            if($field[1]==='textarea') echo '<textarea class="widefat" rows="3" id="'.esc_attr($id).'" name="devcanvas_projects_page['.esc_attr($key).']">'.esc_textarea($data[$key]).'</textarea>';
            else echo '<input type="text" class="widefat" id="'.esc_attr($id).'" name="devcanvas_projects_page['.esc_attr($key).']" value="'.esc_attr($data[$key]).'">';
            echo '</p>';
        }
        echo '</div></details>';
    },'page','normal','high');
});
add_action('save_post_page',function($id){
    if((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || wp_is_post_revision($id)) return;
    if(!isset($_POST['devcanvas_projects_page_nonce']) || !is_string($_POST['devcanvas_projects_page_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['devcanvas_projects_page_nonce'])),'devcanvas_projects_page') || !current_user_can('edit_post',$id)) return;
    if(!isset($_POST['devcanvas_projects_page']) || !is_array($_POST['devcanvas_projects_page'])) return;
    $input=wp_unslash($_POST['devcanvas_projects_page']); $clean=array();
    foreach(devcanvas_projects_page_fields() as $key=>$field){
        $value=isset($input[$key]) && is_string($input[$key]) ? $input[$key] : '';
        $clean[$key]=$field[1]==='url' ? esc_url_raw($value) : ($field[1]==='textarea' ? sanitize_textarea_field($value) : sanitize_text_field($value));
    }
    update_post_meta($id,'_devcanvas_projects_page',$clean);
});
