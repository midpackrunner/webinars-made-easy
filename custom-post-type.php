<?php

// All files must be included in this "vendor" specific namespace
namespace B0334315817D4E03A27BEED307E417C8;

require (dirname(__FILE__).'/array.php');

// Check class definition so that multiple plugins can use this class.
// ----
// NB: there's an issue of class versioning not addressed here. When this
// class is encountered, the first instance will be defined, but subsequent
// declarations will not be honored.
if (!class_exists('B0334315817D4E03A27BEED307E417C8\CustomPostType'))
{  
  /*
   * Class: CustomPostType
   *
   * Description: The base class for an implementation of the WordPress custom
   * post type. Encapsulates the functionality of creating a new custom type.
   *
   * Remarks: This class is meant to be used with the extends construct in PHP 4 
   * and onward.
   */
  class CustomPostType {
    private $is_initialized;
    
    // required parameters to init()
    private $post_type;
    private $registration_args;
    
    /*
     * Description: Default constructor configures callbacks and declares type
     * as undefined until init() is called by the subclass.
     * 
     * Remarks: For this class to work, subclass constructors must call the
     * superclass constructor, followed by init().
     */
    public function __construct() {
      $this->is_initialized = false;
      
      // add actions and filters
      add_action('init', array($this, 'register_custom_type'));
    }
    
    /*
     * Description: Accessor method for the post_type property
     *
     * Returns: The value of the post_type property
     */
    protected function get_post_type() {
      return $this->post_type;
    }
    
    /*
     * Description: Called after WordPress core is finished, but before headers are sent.
     * Guarantees the presence of the defined custom post type in the WordPress type system.
     */
    public function register_custom_type($atts) {
      if ($this->is_initialized == true) {
        register_post_type($this->post_type, $this->registration_args);
      }
    }
    
    /*
     * Description: Sets all data required for this custom type to be registered.
     *
     * Params:
     *   $posttype (required) - The unique id of the custom post type. <= 20 characters, no uppercase.
     *   $atts (required) - An array of initializer values to be passed to the register_post_type() method.
     * 
     * Remarks: Must be called in the subclass constructor prior to the WordPress
     * 'init' action.
     */
    protected function init($posttype, $atts){
      if (!$this->is_initialized)
      {
        if (isset($posttype) && $posttype != ''){
          $this->post_type = $posttype;
          
          $single_name = array_key_exists('single_name', $atts) ? ArrayHelper::remove($atts, 'single_name') : $posttype;
          $plural_name = array_key_exists('plural_name', $atts) ? ArrayHelper::remove($atts, 'plural_name') : $post_type.'s';
          
          if (!array_key_exists('labels', $atts)) {
            $atts['labels'] = $this->get_labels($single_name, $plural_name);
          }
          
          $this->registration_args = $atts;
          $this->is_initialized = true;
        }
      }
    }
    
    /*
     * Description: Constructs an array of labels for use in the WordPress UI.
     *
     * Params:
     *  $singular (required) - The singular form of the friendly type name (e.g. Webinar, Meeting, Workout)
     *  $plural (required) - The plural form of the friendly type name (e.g. Webinars, Meetings, Workouts)
     *
     * Returns: An array of values to be passed as the 'labels' param to register_post_type()
     */
    private static function get_labels($singular, $plural) {
      return array(
        'name' => $plural,
        'singular_name' => $singular,
        'add_new' => 'Add New',
        'add_new_item' => 'Add New '.$singular,
        'edit' => 'Edit',
        'edit_item' => 'Edit '.$singular,
        'new_item' => 'New '.$singular,
        'view' => 'View',
        'view_item' => 'View '.$singular,
        'search_items' => 'Search '.$plural,
        'not_found' => 'No '.$plural.' Found',
        'not_found_in_trash' => 'No '.$plural.' Found in Trash',
        'parent' => 'Parent '.$singular
      );
    }
  }
}

?>