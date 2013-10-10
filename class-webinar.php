<?php

namespace B0334315817D4E03A27BEED307E417C8\Webinars_Made_Easy;
use B0334315817D4E03A27BEED307E417C8 as Core;

/**
 * The base class for a WordPress custom post type.
 */
require_once( dirname( __FILE__ ) . '/com.timwoodbury.core/class-custom-post-type.php');

class Webinar extends Core\Custom_Post_Type {
	const KEYS_DATE       = 'wme_date';
	const KEYS_START_TIME = 'wme_start_time';
	const KEYS_END_TIME   = 'wme_end_time';
	const KEYS_TIME_ZONE  = 'wme_time_zone';
	const KEYS_DIFFICULTY = 'wme_difficulty';
	const KEYS_COPY_ABOVE_OPTIN = 'wme_copy_above_optin';
	const KEYS_OPTIN_FORM = 'wme_optin_form';

	/**
	 * The webinar id.
	 * 
	 * @since 1.0
	 * @access private
	 * @var int $id The webinar id.
	 */
	private $id = null;

	/**
	 * The webinar's date.
	 * 
	 * @since 1.0
	 * @access private
	 * @var string $date The webinar's date, formatted 'DD, MM dd, yy'.
	 */
	private $date = '';

	/**
	 * The webinar's start time.
	 * 
	 * @since 1.0
	 * @access private
	 * @var string $start_time The webinar's start time.
	 */
	private $start_time = '';

	/**
	 * The webinar's end time.
	 * 
	 * @since 1.0
	 * @access private
	 * @var string $end_time The webinar's end time.
	 */
	private $end_time = '';

	/**
	 * The webinar's time zone.
	 * 
	 * @since 1.0
	 * @access private
	 * @var string $time_zone The webinar's time zone as relative to
	 * $start_time and $end_time.
	 */
	private $time_zone = '';

	/**
	 * The webinar's difficulty.
	 * 
	 * @since 1.0
	 * @access private
	 * @var int $difficulty The webinar's difficulty.
	 */
	private $difficulty = 0;

	private $copy_above_optin = '';
	private $optin_form = '';

  /**
   * Initializes the webinar custom post type.
	 *
	 * @since 1.0
   */
	public function __construct() {
		parent::__construct();
		$this->set_post_type_data( 'wme_webinar', array( 
			'single_name'   => 'Webinar',
			'plural_name'   => 'Webinars',
			'public'        => true,
			'menu_position' => 20,
			'supports'      => array( 'title' ),
			'taxonomies'    => array( '' ),
			'has_archive'   => true,
			'rewrite'       => array( 'slug' => 'webinars' ),
			) );
	}
	
	/**
	 * Factory method loads an existing webinar by its id.
	 * 
	 * @since 1.0
	 * @param int $webinar_id The id of the webinar to load. 
	 * @return Webinar A new webinar instance, loaded with any existing data.
	 */
	public static function with_id( $webinar_id ) {
		$webinar = new self();
		
		$webinar->set_id( $webinar_id );
		$webinar->load();
		
		return $webinar;
	}
	
	/**
	 * Loads the webinar's data.
	 *
	 * @since 1.0
	 * @access private
	 * @return bool A value indicating whether this object was loaded.
	 */
	private function load() {
		$loaded = false;
		if ( isset( $this->id ) ) {
			$this->date       = get_post_meta( $this->id, self::KEYS_DATE, true );
			$this->start_time = get_post_meta( $this->id, self::KEYS_START_TIME, true );
			$this->end_time   = get_post_meta( $this->id, self::KEYS_END_TIME, true );
			$this->time_zone  = get_post_meta( $this->id, self::KEYS_TIME_ZONE, true );
			$this->difficulty = get_post_meta( $this->id, self::KEYS_DIFFICULTY, true );
			$this->copy_above_optin = get_post_meta( $this->id, self::KEYS_COPY_ABOVE_OPTIN, true );
			$this->optin_form = get_post_meta( $this->id, self::KEYS_OPTIN_FORM, true );

			$loaded = true;
		}
		return $loaded;
	}

	/**
	 * Accessor for the webinar id.
	 *
	 * @since 1.0
	 * @return int The unique ID of this webinar.
	 */
  public function get_id() { return $this->id; }

	/**
	 * Mutator for the webinar id.
	 *
	 * @since 1.0
	 * @param int $new_id The unique ID for this webinar.
	 */
	public function set_id( $new_id ) {
		if ( isset( $new_id ) && $new_id != '' && $new_id != $this->id ) {
			$this->id = intval( $new_id );
		}
	}

	/**
 	 * Accessor for the webinar date.
	 *
	 * @since 1.0
	 * @return string The date of the webinar.
	 */
	public function get_date() { return $this->date; }
	
	/**
	 * Displays or returns the date of the webinar.
	 *
	 * @since 1.0
	 * @param Boolean $echo Optional. Display the webinar date (true : default), or return it for use in PHP (false).
	 */
	public function the_date( $echo = true ) 
	{
		if ( $echo ) {
			echo esc_html( $this->date );
		} else {
			return $this->date;
		} 
	}

	/**
	 * Mutator for the webinar date.
	 *
	 * @since 1.0
	 * @param string $new_date The date of the webinar.
	 */
	public function set_date( $new_date ) {
		if ( isset( $new_date ) && $new_date != $this->date ) {
			$this->date = $new_date;
		}
	}

	/**
 	 * Accessor for the webinar's start time.
	 *
	 * @since 1.0
	 * @return string The time the webinar starts, in the format 'hh:mm TT'.
	 */
	public function get_start_time() { return $this->start_time; }
	
	/**
	 * Displays or returns the start time of the webinar.
	 *
	 * @since 1.0
	 * @param Boolean $echo Optional. Display the webinar start time (true : default), or return it for use in PHP (false).
	 */
	public function the_start_time( $echo = true ) 
	{
		if ( $echo ) {
			echo esc_html( $this->start_time );
		} else {
			return $this->start_time;
		} 
	}

	/**
 	 * Mutator for the webinar's start time.
	 *
	 * @since 1.0
	 * @param string $new_start_time The time the webinar starts, in the format 'hh:mm TT'.
	 */
	public function set_start_time( $new_start_time ) {
		if ( isset( $new_start_time ) && $new_start_time != $this->start_time ) {
			$this->start_time = $new_start_time;
		}
	}
  
	/**
	 * Accessor for the webinar's end time.
	 *
	 * @since 1.0
	 * @return string The time the webinar will end, in the format 'hh:mm TT'.
	 */
	public function get_end_time() { return $this->end_time; }

	/**
	 * Displays or returns the end time of the webinar.
	 *
	 * @since 1.0
	 * @param Boolean $echo Optional. Display the webinar end time (true : default), or return it for use in PHP (false).
	 */
	public function the_end_time( $echo = true ) 
	{
		if ( $echo ) {
			echo esc_html( $this->end_time );
		} else {
			return $this->end_time;
		} 
	}

	/**
 	 * Mutator for the webinar's end time.
	 *
	 * @since 1.0
	 * @param string $new_end_time The time the webinar will end, in the format 'hh:mm TT'.
	 */
	public function set_end_time( $new_end_time ) {
		if ( isset( $new_end_time ) && $new_end_time != $this->end_time ) {
			$this->end_time = $new_end_time;
		}
	}

	/**
	 * Accessor for the webinar's time zone.
	 *
	 * @since 1.0
	 * @return string The time zone for the webinar's start and end times.
	 */
	public function get_time_zone() { return $this->time_zone; }

	/**
	 * Displays or returns the time zone of the webinar.
	 *
	 * @since 1.0
	 * @param Boolean $echo Optional. Display the webinar time zone (true : default), or return it for use in PHP (false).
	 */
	public function the_time_zone( $echo = true ) 
	{
		if ( $echo ) {
			echo esc_html( $this->time_zone );
		} else {
			return $this->time_zone;
		} 
	}
	
	/**
 	 * Mutator for the webinar's time zone.
	 *
	 * @since 1.0
	 * @param string $new_time_zone The time zone for the webinar's start and end times.
	 */
	public function set_time_zone( $new_time_zone ) {
		if ( isset( $new_time_zone ) && $new_time_zone != $this->time_zone ) {
			$this->time_zone = $new_time_zone;
		}
	}

	/**
	 * Accessor for the webinar's difficulty.
	 *
	 * @since 1.0
	 * @return int The webinar's difficulty.
	 */
	public function get_difficulty() { return $this->difficulty; }

	/**
 	 * Mutator for the webinar's difficulty.
	 *
	 * @since 1.0
	 * @param int $new_difficulty The webinar's difficulty.
	 */
	public function set_difficulty( $new_difficulty ) {
		if ( isset( $new_difficulty ) && $new_difficulty != $this->difficulty ) {
			$this->difficulty = intval( $new_difficulty );
		}
	}
	
	public function get_copy_above_optin() { return $this->copy_above_optin; }
	public function the_copy_above_optin( $echo = true ) {
		if( $echo ) {
			echo $this->copy_above_optin;
		} else {
			return $this->copy_above_optin;
		}
	}
	public function set_copy_above_optin( $new_copy ) {
		if ( isset( $new_copy ) ) {
			$this->copy_above_optin = $new_copy;
		}
	}
	
	public function get_optin_form() { return $this->optin_form; }
	public function the_optin_form( $echo = true ) {
		if ( $echo ) {
			echo $this->optin_form;
		} else {
			return $this->optin_form;
		}
	}
	public function set_optin_form( $new_form ) {
		if ( isset( $new_form ) ) {
			$this->optin_form = $new_form;
		}
	}

	/**
	 * Save the webinar.
	 *
	 * @since 1.0
	 */
	public function save() { 
		if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
			if( isset( $this->id ) ) {
				update_post_meta( $this->id, self::KEYS_DATE,       $this->date );
				update_post_meta( $this->id, self::KEYS_START_TIME, $this->start_time );
				update_post_meta( $this->id, self::KEYS_END_TIME,   $this->end_time );
				update_post_meta( $this->id, self::KEYS_TIME_ZONE,  $this->time_zone );
				update_post_meta( $this->id, self::KEYS_DIFFICULTY, $this->difficulty );
				update_post_meta( $this->id, self::KEYS_COPY_ABOVE_OPTIN, $this->copy_above_optin );
				update_post_meta( $this->id, self::KEYS_OPTIN_FORM, $this->optin_form );
			}
		}
	}

}