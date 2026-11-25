<?php
/**
 * KeFamily theme bootstrap.
 *
 * @package KeFamily
 */

defined( 'ABSPATH' ) || exit;

define( 'KF_VERSION', '1.4.4' );
define( 'KF_DIR', get_template_directory() );
define( 'KF_URI', get_template_directory_uri() );

require_once KF_DIR . '/inc/content.php';
require_once KF_DIR . '/inc/content-pages.php';
require_once KF_DIR . '/inc/helpers.php';
require_once KF_DIR . '/inc/icons.php';
require_once KF_DIR . '/inc/blog.php';
require_once KF_DIR . '/inc/routes.php';
require_once KF_DIR . '/inc/booking.php';
require_once KF_DIR . '/inc/setup.php';
require_once KF_DIR . '/inc/seo.php';
require_once KF_DIR . '/inc/contact.php';
require_once KF_DIR . '/inc/customizer.php';
