<?php
/**
 * Contact page (slug: contact).
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<section class="phero phero--contact">
	<div class="phero__glow" aria-hidden="true"></div>
	<div class="hero__grid" aria-hidden="true"></div>
	<div class="wrap contact">
		<div class="contact__info">
			<span class="eyebrow reveal"><?php kf_e( 'contact.eyebrow' ); ?></span>
			<h1 class="h1 reveal" style="--d:.06s"><?php kf_e( 'contact.title' ); ?></h1>
			<p class="lead reveal" style="--d:.12s"><?php kf_e( 'contact.sub' ); ?></p>

			<ul class="contact__list reveal" style="--d:.18s">
				<li>
					<span class="contact__ico contact__ico--wa"><?php echo kf_icon( 'whatsapp' ); // phpcs:ignore ?></span>
					<div><small><?php kf_e( 'contact.whatsapp_t' ); ?></small><a href="<?php echo esc_url( kf_whatsapp_url() ); ?>" target="_blank" rel="noopener" dir="ltr"><?php echo esc_html( kf_whatsapp_display() ); ?></a></div>
				</li>
				<li>
					<span class="contact__ico"><?php echo kf_icon( 'clock' ); // phpcs:ignore ?></span>
					<div><small><?php kf_e( 'contact.hours_t' ); ?></small><span><?php kf_e( 'contact.hours' ); ?></span></div>
				</li>
			</ul>
		</div>

		<form class="form spotlight reveal" style="--d:.1s" data-spotlight data-contact-form novalidate>
			<span class="beam" aria-hidden="true"></span>
			<input type="hidden" name="action" value="kf_contact">
			<input type="hidden" name="kf_nonce" value="<?php echo esc_attr( wp_create_nonce( 'kf_contact' ) ); ?>">
			<input type="hidden" name="lang" value="<?php echo esc_attr( kf_lang() ); ?>">
			<input type="hidden" name="page" value="contact">
			<div class="hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>

			<div class="form__row">
				<label class="field"><span><?php kf_e( 'contact.name' ); ?> *</span><input name="name" type="text" required autocomplete="name"></label>
				<label class="field"><span><?php kf_e( 'contact.company' ); ?></span><input name="company" type="text" autocomplete="organization"></label>
			</div>
			<div class="form__row">
				<label class="field"><span><?php kf_e( 'contact.email' ); ?></span><input name="email" type="email" autocomplete="email" dir="ltr"></label>
				<label class="field"><span><?php kf_e( 'contact.phone' ); ?></span><input name="phone" type="tel" autocomplete="tel" dir="ltr" inputmode="tel"></label>
			</div>
			<fieldset class="field field--chips">
				<legend><?php kf_e( 'contact.interest' ); ?></legend>
				<div class="chips">
					<?php foreach ( (array) kf_get( 'contact.interests' ) as $i => $opt ) : ?>
						<label class="chip"><input type="radio" name="interest" value="<?php echo esc_attr( $opt ); ?>" <?php checked( 0, $i ); ?>><span><?php echo esc_html( $opt ); ?></span></label>
					<?php endforeach; ?>
				</div>
			</fieldset>
			<label class="field"><span><?php kf_e( 'contact.message' ); ?></span><textarea name="message" rows="4"></textarea></label>

			<button class="btn btn--shimmer btn--block" type="submit" data-magnetic>
				<span class="btn__shine" aria-hidden="true"></span><span class="btn__label" data-label><?php kf_e( 'contact.send' ); ?></span><?php echo kf_icon( 'arrow', 'flip-rtl' ); // phpcs:ignore ?>
			</button>
			<p class="form__note"><?php echo kf_icon( 'shield' ); // phpcs:ignore ?><?php kf_e( 'contact.privacy' ); ?></p>
			<p class="form__status" role="status" aria-live="polite" data-status></p>
		</form>
	</div>
</section>
<?php
get_footer();
