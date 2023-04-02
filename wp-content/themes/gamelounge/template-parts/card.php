<div class="col-4">
	<div class="card">
		<div class="card-body">
			<h5 class="card-title"><?php the_title(); ?></h5>
			<a class="btn btn-primary target-post-type target-post-type-post"><?php echo get_post_type(get_the_ID()); ?></a>
			<p class="mt-2"><?php the_excerpt(); ?></p>
			<a class="btn btn-primary" href="<?php the_permalink(); ?>">Go somewhere</a>
		</div>	
	</div>
</div>