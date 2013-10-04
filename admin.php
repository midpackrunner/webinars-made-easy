<?php

namespace B0334315817D4E03A27BEED307E417C8;

require_once(dirname(__FILE__).'/wme-plugin-helpers.php');

class WebinarsMadeEasyPluginAdmin {
  private $webinar;
  
  /*
   * Description: 
   */
  public function __construct($webinar_instance){
   $this->webinar =  $webinar_instance;
   
   add_action('admin_enqueue_scripts', array($this, 'load_admin_scripts'));
   add_action('admin_enqueue_scripts', array($this, 'load_admin_styles'));
   add_action('admin_init', array($this, 'configure_webinar_metaboxes'));
   add_action('admin_head', array($this, 'register_admin_icons'));
   
   add_action('save_post', array($this, 'on_save_post'), 10, 2);
  }
  
  /* Creates the css necessary to display the proper icons in the webinar admin area */
  function register_admin_icons() {
    $post_slug = $this->webinar->get_post_type();
    ?>
    <style type="text/css" media="screen">
      #menu-posts-<?php echo $post_slug; ?> .wp-menu-image {
        background: url(<?php echo plugins_url('img/webinar-16x16.png', __FILE__); ?>) no-repeat 6px 6px !important;
      }
      #menu-posts-<?php echo $post_slug; ?>:hover .wp-menu-image, #menu-posts-<?php echo $post_slug; ?> .wp-has-current-submenu .wp-menu-image {
        background-position:6px -17px !important;
      }
      #icon-edit.icon32-posts-<?php echo $post_slug; ?> {
        background: url( <?php echo plugins_url('img/webinar-32x32.png', __FILE__); ?> ) no-repeat;
      }
    </style>
  <?php }
  
  function load_admin_scripts() {
    // load vendor scripts
    wp_register_script('jquery_star_rating', plugins_url('vendor/jquery.rating/jquery.rating.pack.js', __FILE__), false, false, true);
    wp_register_script('jquery_timepicker', plugins_url('vendor/jquery.timepicker/jquery-ui-timepicker-addon.js', __FILE__), array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'jquery-ui-slider'), false, true);
    wp_register_script('jquery_slideraccess', plugins_url('vendor/jquery.timepicker/jquery-ui-slideraccess.js', __FILE__), array('jquery_timepicker', 'jquery-ui-button'), false, true);
    
    //load base scripts
    wp_register_script('wme_admin_scripts', plugins_url('scripts/wme-admin.js', __FILE__), array('jquery_star_rating','jquery_slideraccess'), false, true);
    wp_enqueue_script('wme_admin_scripts');
  }
  
  function load_admin_styles() {
    // load base styles
    wp_enqueue_style('wme_admin_styles', plugins_url('styles/wme-admin.css', __FILE__));
    
    // load vendor styles
    wp_enqueue_style('jquery-ui', 'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css', false, false, false);
    wp_enqueue_style('jquery_star_rating_styles', plugins_url('vendor/jquery.rating/jquery.rating.css', __FILE__));
    wp_enqueue_style('jquery_timepicker_styles', plugins_url('vendor/jquery.timepicker/jquery-ui-timepicker-addon.css',__FILE__));
  }
  
  function on_save_post($webinar_id, $webinar) {
    if ($webinar->post_type === $this->webinar->get_post_type()) {
     $webinar_date = $_POST['webinardate'];
      if (isset($webinar_date) && $webinar_date != '') {
        update_post_meta($webinar_id, 'wme_webinar_date', $webinar_date);
      }
      
      $webinar_start = $_POST['webinarstart'];
      if (isset($webinar_start) && $webinar_start != ''){
        update_post_meta($webinar_id, 'wme_webinar_start', $webinar_start);
      }
      
      $webinar_end = $_POST['webinarend'];
      if (isset($webinar_end) && $webinar_end != ''){
        update_post_meta($webinar_id, 'wme_webinar_end', $webinar_end);
      }
      
      $webinar_timezone = $_POST['webinartimezone'];
      if(isset($webinar_timezone) && $webinar_timezone != '') {
        update_post_meta($webinar_id, 'wme_webinar_timezone', $webinar_timezone);
      }
      
      $webinar_difficulty = $_POST['webinardifficulty'];
      if (isset($webinar_difficulty) && $webinar_difficulty != '') {
        update_post_meta($webinar_id, 'wme_webinar_difficulty', $webinar_difficulty);
      }
    }
  }
  
  /*************/
  /* Metaboxes */
  /*************/
  function configure_webinar_metaboxes() {
    add_meta_box('wme_webinar_details_meta_box',
      'Webinar Details',
      array($this, 'display_webinar_details_meta_box'),
      $this->webinar->get_post_type(), 'normal', 'high'
    );
  }
  
  function display_webinar_details_meta_box( $webinar ) {
    // Get current webinar details by ID
    $post_slug = $this->webinar->get_post_type();
    
    $webinar_date = esc_html( get_post_meta( $webinar->ID, 'wme_webinar_date', true) );
    $webinar_start = esc_html( get_post_meta( $webinar->ID, 'wme_webinar_start', true) );
    $webinar_end = esc_html( get_post_meta( $webinar->ID, 'wme_webinar_end', true) );;
    $webinar_timezone = esc_html( get_post_meta( $webinar->ID, 'wme_webinar_timezone', true) );
    
    $webinar_difficulty = esc_html( get_post_meta( $webinar->ID, 'wme_webinar_difficulty', true) );
    $webinar_difficulty = $webinar_difficulty ? $webinar_difficulty : 0;
    
    $webinar_description = $webinar->post_content;
    
    ?>
    <div id="<?php echo $post_slug.'-meta'; ?>">
      <fieldset id="<?php echo $post_slug.'-meta-schedule'; ?>">
        <legend>Scheduling</legend>
        <div>
          <div class="field-label">Date</div>
          <div><input type="text" size="30" id="wme-webinar-date" name="webinardate" value="<?php WME_OutputHelper::echo_if_set($webinar_date); ?>"></input></div>
        </div>
        <div class="top-margin">
          <div id="time-change-notify">Your start time has been automatically adjusted. Please verify before saving this webinar.</div>
          <div class="inline-section">
            <div class="field-label">From</div>
            <div><div id="start-changed"><input type="text" size="6" id="wme-webinar-start" name="webinarstart" value="<?php WME_OutputHelper::echo_if_set($webinar_start); ?>"></input></div></div>
          </div>
          <div class="inline-section">
            <div class="field-label">To</div>
            <div><div id="end-changed"><input type="text" size="6" id="wme-webinar-end" name="webinarend" value="<?php WME_OutputHelper::echo_if_set($webinar_end); ?>"></input></div></div>
          </div>
          <div class="inline-section">
            <div class="field-label">Timezone <a href="http://www.timeanddate.com/worldclock/" rel="nofollow" target="_timez">(find your timezone)</a></div>
            <div><input type="text" size="9" id="wme-webinar-timezone" name="webinartimezone" value="<?php WME_OutputHelper::echo_if_set($webinar_timezone); ?>"></input></div>
          </div>
        </div>
      </fieldset>
      <fieldset id="<?php echo $post_slug.'-meta-details'; ?>">
        <legend>Advanced Details</legend>
        <div class="field-label">Difficulty</div>
        <div>
        <?php for($i = 0; $i < 5; ++$i) { ?>
          <input type="radio" name="webinardifficulty" class="star required" value="<?php echo $i ?>" <?php if($i == $webinar_difficulty) { echo 'checked="checked"'; } ?>></input>
        <?php } ?>
        </div>
      </fieldset>
      <fieldset id="<?php echo $post_slug.'-meta-content'; ?>">
        <legend>Webinar Page Copy</legend>
        <div>
          <div>
            <div class="field-label">Webinar Description</div>
            <div class="flavor-text">The webinar description will appear at the top of your page, above the signup form. This is your opportunity to explain to your audience what they can expect to learn from your webinar &mdash; how it will help them. This is also your opportunity to overcome any of their objections. Why should I, as an audience member, choose to attend this webinar over any other thing on which I may spend my time?</div>
          </div>
          <div><?php wp_editor($webinar_description, 'webinardesc') ?></div>
        </div>
      </fieldset>
    </div>
  <?php }
    
}

?>