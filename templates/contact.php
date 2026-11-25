<?php
/**
 * Contact — /contact/
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<section class="phero">
	<div class="wrap">
		<?php kf_part( 'crumbs' ); ?>
		<div class="contact" style="margin-top:20px">
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
			<?php kf_part( 'form', array( 'page' => 'contact' ) ); ?>
		</div>
	</div>
</section>
<?php
get_footer();
