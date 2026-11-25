<?php
/**
 * Animated mini-visual per company (decorative).
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;
$slug = isset( $args['slug'] ) ? $args['slug'] : '';

switch ( $slug ) :
	case 'kepixel':
		$events = array(
			array( 'Purchase', 'SAR 420', 'Meta' ),
			array( 'Lead', '—', 'Snapchat' ),
			array( 'AddToCart', 'SAR 180', 'TikTok' ),
			array( 'Purchase', 'SAR 960', 'Google Ads' ),
			array( 'Booking', '—', 'GA4' ),
		);
		?>
		<div class="vx vx--pixel" dir="ltr">
			<svg class="vx-chart" viewBox="0 0 400 120" preserveAspectRatio="none">
				<defs>
					<linearGradient id="vxpg" x1="0" x2="0" y1="0" y2="1"><stop offset="0" stop-color="var(--c)" stop-opacity=".45"/><stop offset="1" stop-color="var(--c)" stop-opacity="0"/></linearGradient>
				</defs>
				<path class="vx-chart__area" d="M0 96 C40 90 60 70 100 74 S160 40 200 50 S270 20 300 28 S370 8 400 6 V120 H0Z" fill="url(#vxpg)"/>
				<path class="vx-chart__line" d="M0 96 C40 90 60 70 100 74 S160 40 200 50 S270 20 300 28 S370 8 400 6" fill="none" stroke="var(--c)" stroke-width="2.2"/>
				<path class="vx-chart__ghost" d="M0 104 C50 100 80 92 120 94 S190 80 230 84 S300 70 340 72 S380 64 400 62" fill="none" stroke="rgba(255,255,255,.22)" stroke-width="1.4" stroke-dasharray="4 5"/>
			</svg>
			<ul class="vx-events">
				<?php foreach ( array_merge( $events, $events ) as $e ) : ?>
					<li><span class="vx-events__dot"></span><b><?php echo esc_html( $e[0] ); ?></b><em><?php echo esc_html( $e[1] ); ?></em><span class="vx-events__to">→ <?php echo esc_html( $e[2] ); ?></span><span class="vx-events__ok">✓ dedup</span></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
		break;

	case 'kemarq':
		$ads = array( 'Meta', 'Snapchat', 'TikTok', 'Google', 'X' );
		?>
		<div class="vx vx--marq" dir="ltr">
			<?php foreach ( $ads as $i => $a ) : ?>
				<div class="vx-ad" style="--i: <?php echo (int) $i; ?>; --o: <?php echo (int) ( abs( $i - 2 ) * 10 ); ?>px">
					<span class="vx-ad__img"></span>
					<span class="vx-ad__line"></span><span class="vx-ad__line vx-ad__line--s"></span>
					<span class="vx-ad__tag"><?php echo esc_html( $a ); ?></span>
				</div>
			<?php endforeach; ?>
			<div class="vx-roas"><small>ROAS</small><b>↑</b></div>
		</div>
		<?php
		break;

	case 'kechat':
		$msgs = kf_is_rtl()
			? array( array( 'in', 'مرحباً، هل يوجد موعد غداً؟' ), array( 'out', 'أهلاً! متاح 5:30 مساءً ✅' ), array( 'in', 'ممتاز، احجزه لي' ), array( 'out', 'تم الحجز، وسنذكّرك قبلها بساعة 🔔' ) )
			: array( array( 'in', 'Hi, any slot tomorrow?' ), array( 'out', 'Hello! 5:30 PM is free ✅' ), array( 'in', 'Perfect, book it' ), array( 'out', 'Booked — we\'ll remind you 1h before 🔔' ) );
		?>
		<div class="vx vx--chat">
			<div class="vx-phone">
				<div class="vx-phone__bar"><span class="vx-phone__av"></span><span class="vx-phone__name" dir="ltr">KeChat</span><span class="vx-phone__on"></span></div>
				<div class="vx-phone__msgs">
					<?php foreach ( $msgs as $i => $m ) : ?>
						<p class="msg msg--<?php echo esc_attr( $m[0] ); ?>" style="--i: <?php echo (int) $i; ?>"><?php echo esc_html( $m[1] ); ?></p>
					<?php endforeach; ?>
					<p class="msg msg--in msg--typing" style="--i: 4"><i></i><i></i><i></i></p>
				</div>
			</div>
		</div>
		<?php
		break;

	case 'keclinic':
		$booked = array( 2, 5, 6, 9, 11, 12, 15, 18, 19, 22, 24, 26 );
		?>
		<div class="vx vx--clinic" dir="ltr">
			<div class="vx-cal">
				<?php for ( $d = 0; $d < 28; $d++ ) : ?>
					<span class="<?php echo in_array( $d, $booked, true ) ? 'on' : ''; ?>" style="--i: <?php echo (int) $d; ?>"></span>
				<?php endfor; ?>
			</div>
			<div class="vx-pulse">
				<svg viewBox="0 0 200 40" preserveAspectRatio="none"><path d="M0 22 H60 L70 8 L82 34 L94 4 L104 22 H200" fill="none" stroke="var(--c)" stroke-width="2"/></svg>
			</div>
		</div>
		<?php
		break;
endswitch;
