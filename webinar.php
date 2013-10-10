<?php

namespace B0334315817D4E03A27BEED307E417C8;

require_once(dirname(__FILE__).'/com.timwoodbury.core/custom-post-type.php');

class Webinar extends CustomPostType {
  const KEYS_DATE       = 'wme_date';
  const KEYS_START_TIME = 'wme_start_time';
  const KEYS_END_TIME   = 'wme_end_time';
  const KEYS_TIME_ZONE  = 'wme_time_zone';
  const KEYS_DIFFICULTY = 'wme_difficulty';
  
  private $id;
  private $post_meta = array();
  private $dirty_meta = array();
  
  /*
   * Description: Default constructor initializes CustomPostType settings and sets up any data required by the
   * plugin class.
   */
  function __construct() {
    // call required CustomPostType initializers
    parent::__construct();
    $this->init( 'wme_webinar',
                 array( 'single_name' => 'Webinar',
                        'plural_name' => 'Webinars',
                        'public' => true,
                        'menu_position' => 20,
                        'supports' =>
                          array('title'),
                        'taxonomies' =>
                          array(''),
                        'has_archive' => true,
                        'rewrite' => array('slug' => 'webinars')
    ));
  }
  
  /*
   * DESCRIPTION: Accessor method for the post/webinar id
   *
   * RETURNS: The ID associated with this webinar (if set by mutator method).
   */
  public function get_id() { return $this->id; }
  
  /*
   * DESCRIPTION: Mutator method for the webinar id. Sets the value of the id, and
   * initializes the post meta array.
   */
  public function set_id($new_id) {
    if (isset($new_id) && $new_id != '' && $new_id != $this->id) {
      $this->id = $new_id;
      $this->post_meta = get_post_meta($this->id);
    }
  }

  /*
   * DESCRIPTION: Accessor method for the webinar date
   *
   * RETURNS: The date of the webinar, or null if unset.
   */
  public function get_date() {
    $date = null;
    if (isset($this->post_meta[self::KEYS_DATE])) {
      $date = $this->post_meta[self::KEYS_DATE][0];
    }
    return $date; 
  }
  
  /*
   * DESCRIPTION: Mutator method for the webinar date
   */
  public function set_date($new_date) {
    $this->dirty(self::KEYS_DATE, $new_date);
  }
  
  /*
   * DESCRIPTION: Accessor method for the webinar start time
   *
   * RETURNS: The start time of the webinar, or null if unset.
   */
  public function get_start_time() {
    $start_time = null;
    if (isset($this->post_meta[self::KEYS_START_TIME])) {
      $start_time = $this->post_meta[self::KEYS_START_TIME][0];
    }
    return $start_time; 
  }
  
  /*
   * DESCRIPTION: Mutator method for the webinar start time
   */
  public function set_start_time($new_start_time) {
    $this->dirty(self::KEYS_START_TIME, $new_start_time);
  }
  
  /*
   * DESCRIPTION: Accessor method for the webinar end time
   *
   * RETURNS: The end time of the webinar, or null if unset.
   */
  public function get_end_time() {
    $end_time = null; 
    if (isset($this->post_meta[self::KEYS_END_TIME])) {
      $end_time = $this->post_meta[self::KEYS_END_TIME][0];
    }
    return $end_time;
  }
  
  /*
   * DESCRIPTION: Mutator method for the webinar end time
   */
  public function set_end_time($new_end_time) {
    $this->dirty(self::KEYS_END_TIME, $new_end_time);
  }
  
  /*
   * DESCRIPTION: Accessor method for the webinar time zone
   *
   * RETURNS: The time zone of the webinar, or null if unset.
   */
  public function get_time_zone() {
    $timezone = null;
    if(isset($this->post_meta[self::KEYS_TIME_ZONE])) {
      $timezone = $this->post_meta[self::KEYS_TIME_ZONE][0];
    } 
    return $timezone; 
  }
  
  /*
   * DESCRIPTION: Mutator method for the webinar timezone
   */
  public function set_time_zone($new_time_zone) {
    $this->dirty(self::KEYS_TIME_ZONE, $new_time_zone);
  }
  
  /*
   * DESCRIPTION: Accessor method for the webinar difficulty
   *
   * RETURNS: The difficulty of the webinar, or 0 if unset.
   */
  public function get_difficulty() { 
    $difficulty = 0;
    if (isset($this->post_meta[self::KEYS_DIFFICULTY])) {
      $difficulty = intval($this->post_meta[self::KEYS_DIFFICULTY][0]);
    }
    return $difficulty; 
  }
  
  /*
   * DESCRIPTION: Mutator method for the webinar difficulty
   */
  public function set_difficulty($new_difficulty) {
    $this->dirty(self::KEYS_DIFFICULTY, intval($new_difficulty));
  }
  
  /*
   * DESCRIPTION: Marks the specified field as needing to be saved and updates the
   * property value.
   */
  private function dirty($key, $value) {
    if (isset($value) && $value != $this->post_meta[$key]) {
      $this->post_meta[$key] = $value;
      
      if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX)) {
        $this->dirty_meta[$key] = $value;  
      }
    }
  }
  
  /*
   * DESCRIPTION: Saves the changes to the webinar to the database.
   */
  public function save() { 
    if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX)) {
      if(isset($this->id)) {
        foreach($this->dirty_meta as $key => $value) {
          update_post_meta($this->id, $key, $value);
        }
      }
      unset($this->dirty_meta);
      $this->dirty_meta = array();
    }
  }
  
}

?>