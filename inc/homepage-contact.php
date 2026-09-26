<?php
/** Contact layout with a plugin-independent shortcode slot. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$contact = devcanvas_homepage_data( get_queried_object_id() );
if ( '1' !== $contact['contact_show'] ) { return; }
$email = sanitize_email( $contact['contact_email'] );
$shortcode = trim( $contact['contact_shortcode'] );
$form_html = '';
if ( $shortcode && preg_match( '/\[([A-Za-z0-9_-]+)/', $shortcode, $match ) && shortcode_exists( $match[1] ) ) {
    $form_html = do_shortcode( $shortcode );
}
?>
<section id="contact" class="dc-contact">
    <div class="dc-contact-panel">
        <div class="dc-contact-intro">
            <p class="dc-services-eyebrow"><?php echo esc_html( $contact['contact_eyebrow'] ); ?></p>
            <h2><?php echo nl2br( esc_html( $contact['contact_heading'] ) ); ?><span><?php echo esc_html( $contact['contact_accent'] ); ?></span></h2>
            <p class="dc-contact-description"><?php echo nl2br( esc_html( $contact['contact_description'] ) ); ?></p>
            <?php if ( $email ) : ?><div class="dc-contact-email"><a href="<?php echo esc_attr( 'mailto:' . $email ); ?>"><?php echo esc_html( $email ); ?></a><?php if ( $contact['contact_copy_label'] ) : ?><button type="button" data-copy-email="<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $contact['contact_copy_label'] ); ?></button><?php endif; ?><span class="dc-copy-status" role="status" aria-live="polite"></span></div><?php endif; ?>
            <?php if ( $contact['contact_availability'] ) : ?><p class="dc-contact-availability"><span class="availability-dot" aria-hidden="true"></span><?php echo esc_html( $contact['contact_availability'] ); ?></p><?php endif; ?>
            <span class="dc-contact-flower" aria-hidden="true">✳</span>
        </div>
        <div class="dc-contact-form-panel">
            <?php if ( $contact['contact_form_heading'] ) : ?><h3><?php echo esc_html( $contact['contact_form_heading'] ); ?></h3><?php endif; ?>
            <?php if ( $contact['contact_form_intro'] ) : ?><p class="dc-contact-form-note"><?php echo nl2br( esc_html( $contact['contact_form_intro'] ) ); ?></p><?php endif; ?>
            <div class="dc-contact-form-slot">
                <?php if ( $form_html ) : ?>
                    <?php echo $form_html; // Trusted plugin shortcode output includes required form markup and scripts. ?>
                <?php elseif ( current_user_can( 'edit_post', get_queried_object_id() ) ) : ?>
                    <p class="dc-form-placeholder"><?php esc_html_e( 'Add your form shortcode in Homepage → Contact → Form Shortcode & Text. The form plugin must be active.', 'devcanvas' ); ?></p>
                <?php elseif ( $email ) : ?>
                    <p><?php esc_html_e( 'Please get in touch by email.', 'devcanvas' ); ?> <a href="<?php echo esc_attr( 'mailto:' . $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
                <?php endif; ?>
            </div>
            <?php if ( $contact['contact_form_note'] ) : ?><p class="dc-contact-form-note"><?php echo nl2br( esc_html( $contact['contact_form_note'] ) ); ?></p><?php endif; ?>
        </div>
    </div>
</section>
