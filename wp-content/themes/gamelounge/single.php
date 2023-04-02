<?php
get_header();
global $post;
?>
<section>
	<div class="container">
		<h1><?php echo $post->post_title; ?></h1>
		<p><?php echo $post->post_content; ?></p>
	</div>
</section>

<?php
get_footer();