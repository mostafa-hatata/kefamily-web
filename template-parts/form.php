<?php
/**
 * Lead form (contact / careers / partners). Args: page (string), interests (bool).
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
$page      = isset( $args['page'] ) ? $args['page'] : 'contact';
$interests = ! isset( $args['interests'] ) || $args['interests'];
?>
<form class="form reveal" style="--d:.1s" data-contact-form novalidate>
	
	<input type="hidden" name="action" value="kf_contact">
	<input type="hidden" name="kf_nonce" value="<?php echo esc_attr( wp_create_nonce( 'kf_contact' ) ); ?>">
	<input type="hidden" name="lang" value="<?php echo esc_attr( kf_lang() ); ?>">
	<input type="hidden" name="page" value="<?php echo esc_attr( $page ); ?>">
	<?php if ( ! $interests ) : ?><input type="hidden" name="interest" value="<?php echo esc_attr( $page ); ?>"><?php endif; ?>
	<div class="hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

	<div class="form__row">
		<label class="field"><span><?php kf_e( 'contact.name' ); ?> *</span><input name="name" type="text" required autocomplete="name"></label>
		<label class="field"><span><?php kf_e( 'contact.company' ); ?></span><input name="company" type="text" autocomplete="organization"></label>
	</div>
	<div class="form__row">
		<label class="field"><span><?php kf_e( 'contact.email' ); ?></span><input name="email" type="email" autocomplete="email" dir="ltr"></label>
		<label class="field"><span><?php kf_e( 'contact.phone' ); ?></span><input name="phone" type="tel" autocomplete="tel" dir="ltr" inputmode="tel"></label>
	</div>
	<?php if ( $interests ) : ?>
		<fieldset class="field field--chips">
			<legend><?php kf_e( 'contact.interest' ); ?></legend>
			<div class="chips">
				<?php foreach ( (array) kf_get( 'contact.interests' ) as $i => $opt ) : ?>
					<label class="chip"><input type="radio" name="interest" value="<?php echo esc_attr( $opt ); ?>" <?php checked( 0, $i ); ?>><span><?php echo esc_html( $opt ); ?></span></label>
				<?php endforeach; ?>
			</div>
		</fieldset>
	<?php endif; ?>
	<label class="field"><span><?php kf_e( 'contact.message' ); ?></span><textarea name="message" rows="4"></textarea></label>

	<button class="btn btn--block" type="submit">
		<span class="btn__label" data-label><?php kf_e( 'contact.send' ); ?></span><?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?>
	</button>
	<p class="form__note"><?php echo kf_icon( 'shield' ); // phpcs:ignore ?><span><?php kf_e( 'contact.privacy' ); ?> <a href="<?php echo esc_url( kf_route_url( 'privacy' ) ); ?>" style="text-decoration:underline"><?php kf_e( 'nav.privacy' ); ?></a></span></p>
	<p class="form__status" role="status" aria-live="polite" data-status></p>
</form>
