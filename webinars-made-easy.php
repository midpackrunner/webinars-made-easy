<?php
/*
Plugin Name: Webinars Made Easy
Version: 1.0
Plugin URI: https://github.com/midpackrunner/webinars-made-easy
Description: Hosting a webinar is a great way to attract an audience to your site. Live instruction engages your audience in a way that static content cannot. However, if you regularly host webinars, managing your upcoming content and - if you offer it - on-demand replays of previously recorded webinars can quickly become a hassle. This plugin offers a clean way to handle your current and archived webinar content.
Author: Tim Woodbury
Author URI: http://timwoodbury.com/?utm_source=wme-plugin&utm_medium=referral
License: GPLv2
*/

namespace B0334315817D4E03A27BEED307E417C8\Webinars_Made_Easy;

/**
 * The Webinar custom type/model.
 */
require_once( dirname( __FILE__ ) . '/class-webinar.php' );

$webinar = new Webinar();

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
	/**
	 * The admin area functionality for the Webinars Made Easy plugin.
	 */
  require_once( dirname( __FILE__ ) . '/class-admin.php' );
  $plugin = new Admin( $webinar );
} else {
	/**
	 * The client facing functionality for the Webinars Made Easy plugin.
	 */
  require_once( dirname( __FILE__ ) . '/class-frontend.php' );
  $plugin = new Frontend( $webinar );
}