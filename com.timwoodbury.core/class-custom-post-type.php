<?php

namespace B0334315817D4E03A27BEED307E417C8;

/**
 * Uses Array_Helper class to remove items from array.
 */
require_once( dirname( __FILE__ ) . '/class-array-helper.php' );

if ( ! class_exists( 'B0334315817D4E03A27BEED307E417C8\Custom_Post_Type' ) ) {

	/**
	 * Represents a WordPress custom post type
	 *
	 * The base class for an implementation of the WordPress custom post type.
	 * Encapsulates the functionality of creating a new custom type.
	 */
  class Custom_Post_Type {

		/**
		 * A value indicating whether the class has been initialized.
		 *
		 * @since 1.0
		 * @access private
		 * @var bool $is_initialized Has this class been given the info it needs to
		 * create the custom post type.
		 */
		private $is_initialized;

		/**
		 * The typename of the custom post instance.
		 *
		 * @since 1.0
		 * @access private
		 * @var string $post_type The typename used to register this custom post 
		 * type.
		 * @see register_post_type()
		 */
		private $post_type;

		/**
		* The arguments that specify how this post type should behave.
		*
		* @since 1.0
		* @access private
		* @var array $registration_args The parameters used to register this custom
		* post type.
		* @see register_post_type()
		*/
		private $registration_args;
    
		/**
		 * Custom_Post_Type class constructor.
		 *
		 * Constructor configures callbacks and declares type as undefined until
		 * init() is called by the subclass. For this class to work, subclass 
		 * constructors must call the superclass constructor, followed by init().
		 * 
		 * @since 1.0
		 */
		public function __construct() {
			$this->is_initialized = false;
			add_action( 'init' , array( $this, 'register_custom_type' ) );
		}

		/**
		 * Accessor method for the post_type property
		 *
		 * @since 1.0
		 * @return The value of the $post_type property
		 * @see $post_type
		 */
		public function get_post_type() {
			return $this->post_type;
		}

		/**
		 * Callback for WordPress core 'init' action.
		 *
		 * Called after WordPress core is finished, but before headers are sent.
		 * Guarantees the presence of the defined custom post type in the 
		 * WordPress type system.
		 *
		 * @since 1.0
		 */
		public function register_custom_type() {
			if ( $this->is_initialized ) {
				register_post_type( $this->post_type, $this->registration_args );
			}
		}

		/**
		 * Sets data required for this custom type to be registered.
		 *
		 * In order for this custom post type to be registered when WordPress' 
		 * 'init' action is called, subclasses must register the appropriate
		 * initializer data by calling this method on construction.
		 *
		 * @since 1.0
		 * @param string $type_name The unique id of the custom post type. <= 20 characters, no uppercase.
		 * @param array $atts An array of initializer values to be passed to the register_post_type() method.
		 * @see register_post_type()
		 */
		protected function set_post_type_data( $type_name, $atts ) {
			if ( ! $this->is_initialized ) {
				if ( isset( $type_name ) && $type_name != '' ) {
					$this->post_type = $type_name;

					$single_name = isset( $atts['single_name'] ) ? Array_Helper::remove( $atts, 'single_name' ) : $posttype;
					$plural_name = isset( $atts['plural_name'] ) ? Array_Helper::remove( $atts, 'plural_name' ) : $post_type . 's';

					if ( ! isset( $atts['labels'] ) ) {
						$atts['labels'] = self::get_labels( $single_name, $plural_name );
					}

					$this->registration_args = $atts;
					$this->is_initialized = true;
				}
			}
		}

		/**
		 * Constructs an array of labels for use in the WordPress UI.
		 *
		 * @since 1.0
		 * @access private
		 * @param string $singular The singular form of the friendly type name (e.g. Webinar, Meeting, Workout).
		 * @param string $plural The plural form of the friendly type name (e.g. Webinars, Meetings, Workouts).
		 * @return An array of values to be passed as the 'labels' param to register_post_type().
		 * @see register_post_type()
		 */
		private static function get_labels( $singular, $plural ) {
			return array(
				'name'               => $plural,
				'singular_name'      => $singular,
				'add_new'            => 'Add New',
				'add_new_item'       => 'Add New ' . $singular,
				'edit'               => 'Edit',
				'edit_item'          => 'Edit ' . $singular,
				'new_item'           => 'New ' . $singular,
				'view'               => 'View',
				'view_item'          => 'View ' . $singular,
				'search_items'       => 'Search ' . $plural,
				'not_found'          => 'No ' . $plural . ' Found',
				'not_found_in_trash' => 'No ' . $plural . ' Found in Trash',
				'parent'             => 'Parent ' . $singular,
				);
		}
	}

}