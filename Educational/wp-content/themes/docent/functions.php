<?php
define( 'DOCENT_CSS', get_template_directory_uri().'/css/' );
define( 'DOCENT_JS', get_template_directory_uri().'/js/' );
define( 'DOCENT_DIR', get_template_directory() );
define( 'DOCENT_URI', trailingslashit(get_template_directory_uri()) );

/* -------------------------------------------- *
 * Guttenberg for Themeum Themes
* -------------------------------------------- */
add_theme_support( 'align-wide' );
add_theme_support( 'wp-block-styles' );

/* -------------------------------------------- *
 * Include TGM Plugins
* -------------------------------------------- */
get_template_part('lib/class-tgm-plugin-activation');

/* -------------------------------------------- *
 * Register Navigation
* -------------------------------------------- */
register_nav_menus( array(
	'primary' 	=> esc_html__( 'Primary Menu', 'docent' )
	) 
);

/* -------------------------------------------- *
* Navwalker
* -------------------------------------------- */
get_template_part('lib/mobile-navwalker');

/* -------------------------------------------- *
 * Themeum Core
 * -------------------------------------------- */
get_template_part('lib/main-function/docent-core');
get_template_part('lib/main-function/docent-register');

/* -------------------------------------------- *
 * Customizer
 * -------------------------------------------- */
get_template_part('lib/customizer/libs/googlefonts');
get_template_part('lib/customizer/customizer');

/* -------------------------------------------- *
 * Custom Excerpt Length
 * -------------------------------------------- */
if(!function_exists('docent_excerpt_max_charlength')):
	function docent_excerpt_max_charlength($charlength) {
		$excerpt = get_the_excerpt();
		$charlength++;

		if ( mb_strlen( $excerpt ) > $charlength ) {
			$subex = mb_substr( $excerpt, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
			if ( $excut < 0 ) {
				return mb_substr( $subex, 0, $excut );
			} else {
				return $subex;
			}
		} else {
			return $excerpt;
		}
	}
endif;

/* -------------------------------------------- *
* Custom body class
* -------------------------------------------- */
add_filter( 'body_class', 'docent_body_class' );
function docent_body_class( $classes ) {
    $docent_pro_layout = get_theme_mod( 'boxfull_en', 'fullwidth' );
    $classes[] = $docent_pro_layout.'-bg'.' body-content';
	return $classes;
}

/* ------------------------------------------- *
* Logout Redirect Home
* ------------------------------------------- */
add_action( 'wp_logout', 'docent_auto_redirect_external_after_logout');
function docent_auto_redirect_external_after_logout(){
  wp_redirect( home_url('/') );
  exit();
}

/* ------------------------------------------- *
* wp_body_open
* ------------------------------------------- */
function docent_skip_link() {
	echo '<a class="skip-link screen-reader-text" href="#content">' . esc_html__( 'Skip to the content', 'docent' ) . '</a>';
}
add_action( 'wp_body_open', 'docent_skip_link', 5 );

/* ------------------------------------------- *
* Add a pingback url auto-discovery header for 
* single posts, pages, or attachments
* ------------------------------------------- */
function docent_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'docent_pingback_header' );



