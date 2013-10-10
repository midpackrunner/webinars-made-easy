<?php
namespace B0334315817D4E03A27BEED307E417C8\Webinars_Made_Easy; 

get_header(); ?>
<div id="primary">
	<div id="content" role="main">
		
	<!-- Loop through the posts -->
	<?php while( have_posts() ) :
		the_post();
		$webinar = Webinar::with_id( get_the_ID() ); ?>
	  
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<h1><?php the_title(); ?></h1>
			</header>
			<div class="entry-content">
				<div class="wme-content-above">
					<?php $webinar->the_copy_above_optin(); ?>
				</div>
				<div class="wme-signup">
					<h2>Register For This Webinar</h2>
					<div class="wme-webinar-details">
						<h3>What:</h3>
						<?php the_title(); ?>
						<h3>When:</h3>
						<?php $webinar->the_date() ?><br/>
						<?php echo $webinar->get_start_time() . ' ' . $webinar->get_time_zone(); ?>
					</div>
					<div class="wme-webinar-registration">
						<?php $webinar->the_optin_form(); ?>
					</div>
					<div class="wme-webinar-author">
						<h3>Presented By:</h3>
					</div>
				</div>
				<div class="wme-content-below">
					<?php the_content(); ?>
				</div>
			</div>
		</article>
	<?php endwhile; ?>
	</div>
</div>

<?php get_footer(); ?>