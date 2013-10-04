<?php

namespace B0334315817D4E03A27BEED307E417C8;

require_once(dirname(__FILE__).'/com.timwoodbury.core/custom-post-type.php');

class Webinar extends CustomPostType {
 
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
}

?>