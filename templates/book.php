<?php
/**
 * /book/ — meeting booking (same flow as kemarq.net).
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
get_header();
$bk = kf_get( 'book' );
?>
<section class="phero phero--book">
	<div class="wrap">
		<?php kf_part( 'crumbs' ); ?>
		<div class="book" data-book>
			<div class="book__main">
				<span class="eyebrow reveal"><?php echo esc_html( $bk['eyebrow'] ); ?></span>
				<h1 class="h1 reveal" style="--d:.05s"><?php echo esc_html( $bk['title'] ); ?></h1>
				<p class="lead reveal" style="--d:.1s"><?php echo esc_html( $bk['sub'] ); ?></p>

				<form class="book__form reveal" style="--d:.15s" data-book-form novalidate>
					<fieldset class="book__step">
						<legend><span dir="ltr">1</span><?php echo esc_html( $bk['type_t'] ); ?></legend>
						<div class="book__types">
							<?php foreach ( $bk['types'] as $i => $t ) : ?>
								<label class="opt">
									<input type="radio" name="meeting" value="<?php echo esc_attr( $t[0] ); ?>" <?php checked( 0, $i ); ?>>
									<span class="opt__box"><?php echo kf_icon( 'meet' === $t[0] ? 'video' : 'whatsapp' ); // phpcs:ignore ?><b><?php echo esc_html( $t[1] ); ?></b><small><?php echo esc_html( $t[2] ); ?></small></span>
								</label>
							<?php endforeach; ?>
						</div>
					</fieldset>

					<fieldset class="book__step">
						<legend><span dir="ltr">2</span><?php echo esc_html( $bk['day_t'] ); ?></legend>
						<div class="book__days" data-days role="radiogroup" aria-label="<?php echo esc_attr( $bk['day_t'] ); ?>"></div>
					</fieldset>

					<fieldset class="book__step">
						<legend><span dir="ltr">3</span><?php echo esc_html( $bk['time_t'] ); ?> <small>(<?php echo esc_html( $bk['tz'] ); ?>)</small></legend>
						<div class="book__times" data-times role="radiogroup" aria-label="<?php echo esc_attr( $bk['time_t'] ); ?>"><p class="muted"><?php echo esc_html( $bk['pick_day'] ); ?></p></div>
					</fieldset>

					<fieldset class="book__step">
						<legend><span dir="ltr">4</span><?php echo esc_html( $bk['details_t'] ); ?></legend>
						<div class="hp" aria-hidden="true"><label>Website<input type="text" name="website_hp" tabindex="-1" autocomplete="off"></label></div>
						<div class="form__row">
							<label class="field"><span><?php kf_e( 'contact.name' ); ?> *</span><input name="name" type="text" required autocomplete="name"></label>
							<label class="field"><span><?php kf_e( 'contact.email' ); ?> *</span><input name="email" type="email" required autocomplete="email" dir="ltr"></label>
						</div>
						<div class="form__row">
							<label class="field"><span><?php kf_e( 'contact.phone' ); ?></span><input name="phone" type="tel" autocomplete="tel" dir="ltr" inputmode="tel"></label>
							<label class="field"><span><?php kf_e( 'contact.company' ); ?></span><input name="company" type="text" autocomplete="organization"></label>
						</div>
						<label class="field"><span><?php echo esc_html( $bk['service'] ); ?></span>
							<select name="service">
								<?php foreach ( (array) kf_get( 'contact.interests' ) as $opt ) : ?><option><?php echo esc_html( $opt ); ?></option><?php endforeach; ?>
							</select>
						</label>
						<label class="field"><span><?php echo esc_html( $bk['topic'] ); ?></span><textarea name="topic" rows="3"></textarea></label>
					</fieldset>

					<button class="btn btn--shimmer btn--block" type="submit" data-book-submit><span class="btn__shine" aria-hidden="true"></span><?php echo kf_icon( 'check' ); // phpcs:ignore ?><span class="btn__label" data-label><?php echo esc_html( $bk['confirm'] ); ?></span></button>
					<p class="form__status" role="status" aria-live="polite" data-book-status></p>
				</form>
			</div>

			<aside class="book__side reveal" style="--d:.2s" aria-label="<?php echo esc_attr( $bk['summary_t'] ); ?>">
				<div class="book__card">
					<p class="book__card-t"><?php echo esc_html( $bk['summary_t'] ); ?></p>
					<dl class="book__sum">
						<div><dt><?php echo kf_icon( 'clock' ); // phpcs:ignore ?></dt><dd><?php echo esc_html( $bk['duration'] ); ?></dd></div>
						<div><dt><?php echo kf_icon( 'video' ); // phpcs:ignore ?></dt><dd data-sum-type><?php echo esc_html( $bk['types'][0][1] ); ?></dd></div>
						<div><dt><?php echo kf_icon( 'calendar' ); // phpcs:ignore ?></dt><dd data-sum-when>—</dd></div>
					</dl>
					<p class="book__card-t"><?php echo esc_html( $bk['agenda_t'] ); ?></p>
					<ol class="book__agenda">
						<?php foreach ( $bk['agenda'] as $a ) : ?><li><?php echo esc_html( $a ); ?></li><?php endforeach; ?>
					</ol>
					<a class="link-arrow" href="<?php echo esc_url( kf_whatsapp_url( $bk['title'] ) ); ?>" target="_blank" rel="noopener"><?php echo kf_icon( 'whatsapp' ); // phpcs:ignore ?><?php kf_e( 'hero.cta2' ); ?></a>
				</div>
			</aside>
		</div>
	</div>
</section>
<?php
get_footer();
