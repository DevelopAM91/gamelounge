<?php
/**
 * Template part: card-book
 *** print the postmeta tagline as excerpt if exists, else print the excerpt
**/
?>
<div class="col-4">
	<div class="card">
		<div class="card-body">
			<h5 class="card-title"><?php the_title(); ?></h5>
			<a class="btn btn-success target-post-type target-post-type-book"><?php echo get_post_type(get_the_ID()); ?></a>
			
			<?php if( get_post_meta(get_the_ID(), '_tagline', true) !== '' ): ?>
					<p class="mt-2"><?php echo get_post_meta(get_the_ID(), '_tagline', true); ?></p>
			<?php else: ?>
					<p class="mt-2"><?php the_excerpt(); ?></p>
			<?php endif; ?>	

			<a class="btn btn-success" href="<?php the_permalink(); ?>">Go somewhere</a>
		</div>	
	</div>
</div>