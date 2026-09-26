<?php
/** Homepage About section. The code card is decorative text, never executable code. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$about = devcanvas_homepage_data( get_queried_object_id() );
if ( '1' !== $about['about_show'] ) { return; }
$values = array_values( array_filter( array_map( 'trim', explode( "\n", $about['about_code_values'] ) ), 'strlen' ) );
$points = array_filter( array_map( 'trim', explode( "\n", $about['about_points'] ) ), 'strlen' );
?>
<section id="about" class="dc-about">
    <div class="dc-about-panel">
        <div class="dc-about-art">
            <div class="dc-code-note">
                <div class="dc-code-dots" aria-hidden="true"><i></i><i></i><i></i></div>
                <div><span class="dc-code-keyword">const</span> developer = {</div>
                <div class="dc-code-indent">name: <span class="dc-code-value"><?php echo esc_html( wp_json_encode( $about['about_code_name'], JSON_UNESCAPED_UNICODE ) ); ?></span>,</div>
                <div class="dc-code-indent">poweredBy: <span class="dc-code-value"><?php echo esc_html( wp_json_encode( $about['about_code_power'], JSON_UNESCAPED_UNICODE ) ); ?></span>,</div>
                <div class="dc-code-indent">caresAbout: [</div>
                <?php foreach ( $values as $index => $value ) : ?><div class="dc-code-indent-deep dc-code-value"><?php echo esc_html( wp_json_encode( $value, JSON_UNESCAPED_UNICODE ) . ( $index < count( $values ) - 1 ? ',' : '' ) ); ?></div><?php endforeach; ?>
                <div class="dc-code-indent">]</div><div>};</div>
            </div>
            <?php if ( $about['about_sticker'] ) : ?><div class="dc-about-sticker"><?php echo nl2br( esc_html( $about['about_sticker'] ) ); ?><span aria-hidden="true">↗</span></div><?php endif; ?>
        </div>
        <div class="dc-about-copy">
            <p class="dc-services-eyebrow"><?php echo esc_html( $about['about_eyebrow'] ); ?></p>
            <h2><?php echo nl2br( esc_html( $about['about_heading'] ) ); ?></h2>
            <?php if ( $about['about_intro'] ) : ?><p class="dc-about-paragraph"><?php echo nl2br( esc_html( $about['about_intro'] ) ); ?></p><?php endif; ?>
            <?php if ( $about['about_description'] ) : ?><p class="dc-about-paragraph"><?php echo nl2br( esc_html( $about['about_description'] ) ); ?></p><?php endif; ?>
            <?php if ( $points ) : ?><ul class="dc-about-highlights"><?php foreach ( $points as $point ) : ?><li><span aria-hidden="true">✓</span><?php echo esc_html( $point ); ?></li><?php endforeach; ?></ul><?php endif; ?>
            <?php if ( $about['about_link_text'] && $about['about_link_url'] ) : ?><a class="dc-about-link" href="<?php echo esc_url( $about['about_link_url'] ); ?>"><?php echo esc_html( $about['about_link_text'] ); ?> <span aria-hidden="true">↗</span></a><?php endif; ?>
        </div>
    </div>
</section>
