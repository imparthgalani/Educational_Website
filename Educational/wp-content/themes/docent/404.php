<?php get_header();
/*
*Template Name: 404 Page Template
*/
?>

<div class="docent-error">
	<div class="docent-error-wrapper" style="background-image: url(<?php echo esc_url( get_theme_mod('error_404', '')); ?>)">
		<div class="row">
		    <div class="col-md-12 info-wrapper">
		    	<p class="error-message">
					<?php echo esc_html(get_theme_mod( '404_description', __('The Page you are looking for does not exit', 'docent'))); ?>
				</p>
	            <a href="<?php echo esc_url( home_url('/') ); ?>" class="btn btn-secondary">
	            	<?php echo esc_html(get_theme_mod( '404_btn_text', __('Go Home', 'docent'))); ?>
	            </a>
		    </div>
	    </div>
	</div>
</div>
<?php get_footer();
