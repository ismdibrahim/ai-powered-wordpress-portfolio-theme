<?php
/**
 * Template Name: Homepage
 * Template Post Type: page
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$data = devcanvas_homepage_data( get_queried_object_id() );
?>
<main id="main-content" tabindex="-1" class="dc-homepage">
    <section id="home" class="dc-hero">
        <div class="dc-hero-grid">
            <div class="dc-hero-copy">
                <?php if ( $data['eyebrow'] ) : ?><p class="dc-eyebrow"><span class="availability-dot" aria-hidden="true"></span><?php echo esc_html( $data['eyebrow'] ); ?></p><?php endif; ?>
                <h1><?php echo nl2br( esc_html( $data['heading'] ) ); ?><?php if ( $data['accent_heading'] ) : ?><span><?php echo esc_html( $data['accent_heading'] ); ?></span><?php endif; ?></h1>
                <?php if ( $data['description'] ) : ?><p class="dc-description"><?php echo nl2br( esc_html( $data['description'] ) ); ?></p><?php endif; ?>
                <div class="dc-hero-actions">
                    <?php if ( $data['primary_text'] && $data['primary_url'] ) : ?><a class="dc-primary" href="<?php echo esc_url( $data['primary_url'] ); ?>"><?php echo esc_html( $data['primary_text'] ); ?><span aria-hidden="true">↗</span></a><?php endif; ?>
                    <?php if ( $data['secondary_text'] && $data['secondary_url'] ) : ?><a class="dc-secondary" href="<?php echo esc_url( $data['secondary_url'] ); ?>"><?php echo esc_html( $data['secondary_text'] ); ?></a><?php endif; ?>
                </div>
                <?php if ( $data['note'] ) : ?><p class="dc-hero-note"><span aria-hidden="true">⌘</span><?php echo esc_html( $data['note'] ); ?></p><?php endif; ?>
            </div>
            <div class="dc-hero-art">
                <?php if ( $data['hero_image'] ) : ?><img class="dc-hero-image" src="<?php echo esc_url( $data['hero_image'] ); ?>" alt="<?php echo esc_attr( $data['hero_alt'] ); ?>" width="640" height="560" fetchpriority="high" decoding="async"><?php endif; ?>
                <?php if ( $data['wp_badge'] ) : ?><div class="dc-floating dc-wordpress"><?php if ( $data['wp_badge_icon'] ) : ?><img class="dc-badge-icon" src="<?php echo esc_url( $data['wp_badge_icon'] ); ?>" alt="" width="26" height="26"><?php else : ?><span class="dc-wp-icon" aria-hidden="true">W</span><?php endif; ?><?php echo esc_html( $data['wp_badge'] ); ?></div><?php endif; ?>
                <?php if ( $data['performance_title'] || $data['performance_detail'] ) : ?><div class="dc-floating dc-performance"><?php if ( $data['performance_icon'] ) : ?><img class="dc-badge-icon dc-badge-icon-performance" src="<?php echo esc_url( $data['performance_icon'] ); ?>" alt="" width="40" height="40"><?php elseif ( $data['score'] ) : ?><span class="dc-score"><?php echo esc_html( $data['score'] ); ?></span><?php endif; ?><div><b><?php echo esc_html( $data['performance_title'] ); ?></b><span class="dc-performance-detail"><?php echo esc_html( $data['performance_detail'] ); ?></span></div><span class="dc-performance-arrow" aria-hidden="true">↗</span></div><?php endif; ?>
                <?php if ( $data['woo_badge'] ) : ?><div class="dc-floating dc-woocommerce"><?php if ( $data['woo_badge_icon'] ) : ?><img class="dc-badge-icon dc-badge-icon-woo" src="<?php echo esc_url( $data['woo_badge_icon'] ); ?>" alt="" width="42" height="26"><?php else : ?><span class="dc-woo-icon" aria-hidden="true">woo</span><?php endif; ?><?php echo esc_html( $data['woo_badge'] ); ?></div><?php endif; ?>
            </div>
        </div>
        <?php if ( '1' === $data['toolkit_show'] ) : ?>
            <div class="dc-toolkit" role="region" aria-label="<?php esc_attr_e( 'Development toolkit', 'devcanvas' ); ?>">
                <p class="dc-toolkit-intro"><?php echo nl2br( esc_html( $data['toolkit_intro'] ) ); ?></p>
                <ul class="dc-toolkit-list">
                    <?php for ( $i = 0; $i < 5; $i++ ) : $prefix = 'tool_' . $i . '_'; ?>
                        <?php if ( '1' !== $data[ $prefix . 'show' ] ) { continue; } ?>
                        <li class="dc-tool-<?php echo esc_attr( $i ); ?>">
                            <?php if ( $data[ $prefix . 'url' ] ) : ?><a class="dc-tool" href="<?php echo esc_url( $data[ $prefix . 'url' ] ); ?>" aria-label="<?php echo esc_attr( $data[ $prefix . 'name' ] ); ?>"><?php else : ?><span class="dc-tool" role="img" aria-label="<?php echo esc_attr( $data[ $prefix . 'name' ] ); ?>"><?php endif; ?>
                                <?php if ( $data[ $prefix . 'image' ] ) : ?><img src="<?php echo esc_url( $data[ $prefix . 'image' ] ); ?>" alt="" width="100" height="40" loading="lazy"><?php endif; ?>
                                <?php if ( $data[ $prefix . 'text' ] ) : ?><span><?php echo esc_html( $data[ $prefix . 'text' ] ); ?></span><?php endif; ?>
                            <?php echo $data[ $prefix . 'url' ] ? '</a>' : '</span>'; ?>
                        </li>
                    <?php endfor; ?>
                </ul>
            </div>
        <?php endif; ?>
    </section>
    <?php if ( '1' === $data['services_show'] ) : ?>
    <section id="expertise" class="dc-services" aria-label="<?php echo esc_attr( $data['services_heading'] ?: __( 'Services', 'devcanvas' ) ); ?>">
        <div class="dc-services-heading">
            <div>
                <?php if ( $data['services_eyebrow'] ) : ?><p class="dc-services-eyebrow"><?php echo esc_html( $data['services_eyebrow'] ); ?></p><?php endif; ?>
                <?php if ( $data['services_heading'] ) : ?><h2><?php echo esc_html( $data['services_heading'] ); ?></h2><?php endif; ?>
            </div>
            <?php if ( $data['services_description'] ) : ?><p class="dc-services-description"><?php echo nl2br( esc_html( $data['services_description'] ) ); ?></p><?php endif; ?>
        </div>
        <div class="dc-services-grid">
            <?php for ( $i = 0; $i < 3; $i++ ) : $prefix = 'service_' . $i . '_'; ?>
                <?php if ( '1' !== $data[ $prefix . 'show' ] ) { continue; } ?>
                <article class="dc-service-card">
                    <div class="dc-service-icon" aria-hidden="true">
                        <?php if ( $data[ $prefix . 'icon' ] ) : ?>
                            <img src="<?php echo esc_url( $data[ $prefix . 'icon' ] ); ?>" alt="" width="28" height="28" loading="lazy">
                        <?php elseif ( $data[ $prefix . 'symbol' ] ) : ?>
                            <?php echo esc_html( $data[ $prefix . 'symbol' ] ); ?>
                        <?php elseif ( 1 === $i ) : ?>
                            <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M3 4h2l3 12h11l2-9H6M9 20h.01M18 20h.01" stroke-linecap="round"/><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></svg>
                        <?php else : ?>
                            <?php echo 0 === $i ? 'W' : '↗'; ?>
                        <?php endif; ?>
                    </div>
                    <?php if ( $data[ $prefix . 'number' ] ) : ?><span class="dc-service-number"><?php echo esc_html( $data[ $prefix . 'number' ] ); ?></span><?php endif; ?>
                    <?php if ( $data[ $prefix . 'title' ] ) : ?><h3><?php echo esc_html( $data[ $prefix . 'title' ] ); ?></h3><?php endif; ?>
                    <?php if ( $data[ $prefix . 'description' ] ) : ?><p><?php echo nl2br( esc_html( $data[ $prefix . 'description' ] ) ); ?></p><?php endif; ?>
                    <?php $tags = array_filter( array_map( 'trim', explode( "\n", $data[ $prefix . 'tags' ] ) ), 'strlen' ); ?>
                    <?php if ( $tags ) : ?><ul class="dc-service-tags"><?php foreach ( $tags as $tag ) : ?><li><?php echo esc_html( $tag ); ?></li><?php endforeach; ?></ul><?php endif; ?>
                </article>
            <?php endfor; ?>
        </div>
    </section>
    <?php endif; ?>
</main>
<?php get_footer(); ?>

