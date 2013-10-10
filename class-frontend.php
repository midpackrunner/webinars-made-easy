<?php

namespace B0334315817D4E03A27BEED307E417C8\Webinars_Made_Easy;

class Frontend {
	private $webinar;

	public function __construct( $webinar_instance ) {
		$this->webinar = $webinar_instance;
		add_shortcode( 'webinars', array( $this, 'list_webinars' ) );
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