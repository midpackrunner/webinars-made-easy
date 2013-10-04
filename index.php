<?php
/*
Plugin Name: Webinars Made Easy
Version: 1.0.1
Plugin URI: 
Description: Hosting a webinar is a great way to attract an audience to your site. Live instruction engages your audience in a way that static content cannot. However, if you regularly host webinars, managing your upcoming content and - if you offer it - on-demand replays of previously recorded webinars can quickly become a hassle. This plugin offers a clean way to handle your current and archived webinar content.
Author: Tim Woodbury
Author URI: http://timwoodbury.com/?utm_source=wme-plugin&utm_medium=referral
License: GPLv2
*/

namespace B0334315817D4E03A27BEED307E417C8;

require_once(dirname(__FILE__).'/webinar.php');

$webinar = new Webinar();

if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX)) {
  require(dirname(__FILE__).'/admin.php');
  $webinars_made_easy_plugin = new WebinarsMadeEasyPluginAdmin($webinar);
} 
else {
  require(dirname(__FILE__).'/frontend.php');
  $webinars_made_easy_plugin = new WebinarsMadeEasyPluginFrontend($webinar);
}

?>