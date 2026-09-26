<?php
/** Latest portfolio projects on the Homepage template. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$data = devcanvas_homepage_data( get_queried_object_id() );
$collection_page = ! empty( $args['collection_page'] );
if ( $collection_page ) {
    $settings = $args['page_data'];
    $data = array( 'projects_show' => '1', 'projects_eyebrow' => $settings['count'], 'projects_heading' => $settings['collection'], 'projects_all_label' => $settings['all'], 'projects_empty' => $settings['empty'], 'projects_note' => $settings['note'], 'projects_button_text' => '', 'projects_button_url' => '' );
}
if ( '1' !== $data['projects_show'] ) { return; }
$projects = get_posts( array( 'post_type' => 'devcanvas_project', 'post_status' => 'publish', 'posts_per_page' => -1, 'orderby' => array( 'date' => 'DESC', 'ID' => 'DESC' ), 'ignore_sticky_posts' => true ) );
$categories = array();
$project_terms = array();
foreach ( $projects as $project ) {
    $terms = get_the_terms( $project->ID, 'project_category' );
    $project_terms[ $project->ID ] = is_array( $terms ) ? $terms : array();
    foreach ( $project_terms[ $project->ID ] as $term ) { $categories[ $term->term_id ] = $term; }
}
uasort( $categories, function ( $a, $b ) { return strnatcasecmp( $a->name, $b->name ); } );
if ( $collection_page ) { $data['projects_eyebrow'] = str_replace( '{count}', (string) count( $projects ), $data['projects_eyebrow'] ); }
?>
<section id="projects" class="dc-projects" data-project-section data-project-limit="<?php echo $collection_page ? '0' : '4'; ?>">
    <div class="dc-projects-heading">
        <div><p class="dc-services-eyebrow"><?php echo esc_html( $data['projects_eyebrow'] ); ?></p><h2><?php echo esc_html( $data['projects_heading'] ); ?></h2></div>
        <?php if ( $categories ) : ?>
        <div class="dc-project-filters" role="group" aria-label="<?php esc_attr_e( 'Filter projects by category', 'devcanvas' ); ?>" hidden>
            <button type="button" class="active" data-project-filter="all" aria-pressed="true"><?php echo esc_html( $data['projects_all_label'] ); ?></button>
            <?php foreach ( $categories as $term ) : ?><button type="button" data-project-filter="<?php echo esc_attr( $term->term_id ); ?>" aria-pressed="false"><?php echo esc_html( $term->name ); ?></button><?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <div class="dc-project-grid">
        <?php foreach ( $projects as $project_index => $project ) :
            $terms = $project_terms[ $project->ID ];
            $url = esc_url( get_post_meta( $project->ID, '_devcanvas_live_website_link', true ), array( 'http', 'https' ) );
            $tags = get_the_terms( $project->ID, 'project_tag' );
            $tags = is_array( $tags ) ? $tags : array();
        ?>
        <article class="dc-project-card" <?php if ( ! $collection_page && $project_index >= 4 ) { echo 'hidden'; } ?> data-project-categories="<?php echo esc_attr( implode( ' ', wp_list_pluck( $terms, 'term_id' ) ) ); ?>">
            <?php if ( $url ) : ?><a class="dc-project-link" href="<?php echo $url; ?>"><?php endif; ?>
                <div class="dc-project-preview">
                    <?php echo get_the_post_thumbnail( $project->ID, 'large', array( 'class' => 'dc-project-image', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
                    <?php if ( $terms ) : ?><span class="dc-project-category"><?php echo esc_html( implode( ' · ', wp_list_pluck( $terms, 'name' ) ) ); ?></span><?php endif; ?>
                </div>
                <h3><?php echo esc_html( get_the_title( $project ) ); ?></h3>
                <?php if ( $project->post_excerpt ) : ?><p class="dc-project-excerpt"><?php echo esc_html( $project->post_excerpt ); ?></p><?php endif; ?>
                <?php if ( $tags ) : ?><ul class="dc-project-tags"><?php foreach ( $tags as $tag ) : ?><li><?php echo esc_html( $tag->name ); ?></li><?php endforeach; ?></ul><?php endif; ?>
            <?php if ( $url ) : ?></a><?php endif; ?>
        </article>
        <?php endforeach; ?>
    </div>
    <p class="dc-project-empty" <?php if ( $projects ) { echo 'hidden'; } ?>><?php echo esc_html( $data['projects_empty'] ); ?></p>
    <?php if ( $data['projects_note'] ) : ?><p class="dc-project-note"><?php echo esc_html( $data['projects_note'] ); ?></p><?php endif; ?>
    <?php if ( $data['projects_button_text'] && $data['projects_button_url'] ) : ?><a class="dc-primary" href="<?php echo esc_url( $data['projects_button_url'] ); ?>"><?php echo esc_html( $data['projects_button_text'] ); ?><span aria-hidden="true">↗</span></a><?php endif; ?>
</section>

