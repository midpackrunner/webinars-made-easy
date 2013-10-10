<?php

namespace B0334315817D4E03A27BEED307E417C8\Webinars_Made_Easy;

class Frontend {
	private $webinar;

	public function __construct( $webinar_instance ) {
		$this->webinar = $webinar_instance;
		add_filter( 'template_include', array( $this, 'on_template_include' ) );
		add_shortcode( 'webinars', array( $this, 'list_webinars' ) );
	}

	/**
	 */
	public function on_template_include( $template_path ) {
		$type_slug = $this->webinar->get_post_type();
		if ( $type_slug == get_post_type() ) {
			if ( is_single() ) {
				$webinar_template = 'single-' . $type_slug . '.php';
				if ( $theme_file = locate_template( array( $webinar_template ) ) ) {
					$template_path = $theme_file;
				} else {
					$template_path = plugin_dir_path( __FILE__ ) . '/templates/' . $webinar_template;
				}
			}
		}
		return $template_path;
	}

	/**
	 * Lists all of the webinars from a given time period (future, past)
	 */
	function list_webinars( $atts ) {
		extract( shortcode_atts( array(
			'from_period' => 'future'
			), $atts ) );

		$webinar_query = new \WP_Query( array( 'post_type' => $this->webinar->get_post_type() ) );
?>
	<ul>
	<?php if ( $webinar_query->have_posts() ) :
		while ( $webinar_query->have_posts() ) : ?>
		<li>
		<?php $webinar_query->the_post();
			echo get_the_title(); ?>
		</li>
		<?php endwhile; 
		wp_reset_postdata();
		else : 
			/* TODO: What happens to the table if there really aren't any webinars?  */
			echo '<li>No Webinars</li>'; ?>
    </ul>
  <?php endif;
	}
}