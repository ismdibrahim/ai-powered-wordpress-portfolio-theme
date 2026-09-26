<?php
/**
 * Template Name: Projects
 * Template Post Type: page
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$page_data = devcanvas_projects_page_data(get_queried_object_id());
?>
<main id="main-content" tabindex="-1" class="dc-projects-page">
    <section class="dc-projects-intro">
        <?php if($page_data['back']): ?><a class="dc-projects-back" href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html($page_data['back']); ?></a><?php endif; ?>
        <p class="dc-services-eyebrow"><?php echo esc_html($page_data['eyebrow']); ?></p>
        <h1><?php echo nl2br(esc_html($page_data['heading'])); ?><span><?php echo esc_html($page_data['accent']); ?></span></h1>
        <p class="dc-projects-intro-description"><?php echo nl2br(esc_html($page_data['description'])); ?></p>
    </section>
    <?php get_template_part('inc/homepage-projects',null,array('collection_page'=>true,'page_data'=>$page_data)); ?>
    <?php if($page_data['cta_heading'] || $page_data['cta_description'] || $page_data['cta_button']): ?>
    <section class="dc-projects-contact"><div class="dc-projects-cta">
        <div><p class="dc-services-eyebrow"><?php echo esc_html($page_data['cta_label']); ?></p><h2><?php echo esc_html($page_data['cta_heading']); ?></h2><p><?php echo nl2br(esc_html($page_data['cta_description'])); ?></p></div>
        <?php if($page_data['cta_button'] && $page_data['cta_url']): ?><a class="dc-primary" href="<?php echo esc_url($page_data['cta_url']); ?>"><?php echo esc_html($page_data['cta_button']); ?><span aria-hidden="true">↗</span></a><?php endif; ?>
    </div></section>
    <?php endif; ?>
</main>
<?php get_footer(); ?>
