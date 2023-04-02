<?php
get_header();
?>
<h1>Gamelounge assessment</h1>

<section class="mt-4">
	<div class="container">
		<div class="row">
		<?php
		// The Loop
		if ( have_posts() ){

			while ( have_posts() ){
				
				the_post();
				// Get post type
				$name_part = get_post_type(get_the_ID());
				
				// Load template part based on post type
				if( $name_part == 'post' ){ 
					get_template_part('template-parts/card');
				}
				else{
					get_template_part('template-parts/card', $name_part);
				}

			}

		}
		else{
			echo '<p>No posts found</p>';
		}

		?>
		</div>
	</div>
</section>
<?php
get_footer();