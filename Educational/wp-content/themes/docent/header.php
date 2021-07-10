<!DOCTYPE html> 
<html <?php language_attributes(); ?>> 
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>  
    <?php if ( function_exists( 'wp_body_open' ) ) {
	    wp_body_open();
    } ?>
	<?php 
		$docent_layout = get_theme_mod( 'boxfull_en', 'fullwidth' );
	?> 
	<div id="page" class="hfeed site <?php echo esc_attr($docent_layout); ?>">
	<?php get_template_part( 'lib/header', 'none' ); ?>
		

	

	