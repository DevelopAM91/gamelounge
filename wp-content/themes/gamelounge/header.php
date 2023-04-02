<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php wp_title('|', true, 'right'); ?><?php echo get_bloginfo('name') ?></title>
	
	<?php wp_head(); ?>
</head>
<?php
/**
 * Insert body_class
 *** useful for style
**/ 
?>
<body <?php body_class(); ?>>