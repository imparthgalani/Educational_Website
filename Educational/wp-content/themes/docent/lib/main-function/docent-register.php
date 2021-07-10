<?php
/* -------------------------------------------- *
 * Themeum Widget
 * -------------------------------------------- */
if(!function_exists('docent_widdget_init')):

    function docent_widdget_init() {
        
        register_sidebar(array(
                'name'          => esc_html__( 'Sidebar', 'docent' ),
                'id'            => 'sidebar',
                'description'   => esc_html__( 'Widgets in this area will be shown on Sidebar.', 'docent' ),
                'before_title'  => '<h3 class="widget_title">',
                'after_title'   => '</h3>',
                'before_widget' => '<div id="%1$s" class="widget %2$s" >',
                'after_widget'  => '</div>'
            )
        );

        register_sidebar(array(
                'name'          => esc_html__( 'Bottom 1', 'docent' ),
                'id'            => 'bottom1',
                'description'   => esc_html__( 'Widgets in this area will be shown before Bottom 1.' , 'docent'),
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
                'before_widget' => '<div class="bottom-widget"><div id="%1$s" class="widget %2$s" >',
                'after_widget'  => '</div></div>'
            )
        );

        register_sidebar(array(
            'name'          => esc_html__( 'Bottom 2', 'docent' ),
            'id'            => 'bottom2',
            'description'   => esc_html__( 'Widgets in this area will be shown before Bottom 2.' , 'docent'),
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
            'before_widget' => '<div class="bottom-widget"><div id="%1$s" class="widget %2$s" >',
            'after_widget'  => '</div></div>'
            )
        );

        register_sidebar(array(
            'name'          => esc_html__( 'Bottom 3', 'docent' ),
            'id'            => 'bottom3',
            'description'   => esc_html__( 'Widgets in this area will be shown before Bottom 3.' , 'docent'),
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
            'before_widget' => '<div class="bottom-widget"><div id="%1$s" class="widget %2$s" >',
            'after_widget'  => '</div></div>'
            )
        );
        register_sidebar(array(
            'name'          => esc_html__( 'Bottom 4', 'docent' ),
            'id'            => 'bottom4',
            'description'   => esc_html__( 'Widgets in this area will be shown before Bottom 4.' , 'docent'),
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
            'before_widget' => '<div class="bottom-widget"><div id="%1$s" class="widget %2$s" >',
            'after_widget'  => '</div></div>'
            )
        );
    }

    add_action('widgets_init','docent_widdget_init');

endif;

/* -------------------------------------------- *
* Themeum Style
* --------------------------------------------- */
if(!function_exists('docent_style')):

    function docent_style(){

        wp_enqueue_media();
        # CSS
        wp_enqueue_style( 'bootstrap.min', DOCENT_CSS . 'bootstrap.min.css',false,'all');
        wp_enqueue_style( 'woocommerce-css', DOCENT_CSS . 'woocommerce.css',false,'all');
        wp_enqueue_style( 'fontawesome.min', DOCENT_CSS . 'fontawesome.min.css',false,'all');
        wp_enqueue_style( 'docent-main', DOCENT_CSS . 'main.css',false,'all');
        wp_enqueue_style( 'docent-responsive', DOCENT_CSS . 'responsive.css',false,'all');
        wp_enqueue_style( 'docent-style',get_stylesheet_uri());
        wp_add_inline_style( 'docent-style', docent_css_generator() );

        # JS
        wp_enqueue_script( 'bootstrap',DOCENT_JS.'bootstrap.min.js',array(),false,true);
        wp_enqueue_script('docent-main', DOCENT_JS.'main.js',array(),false,true);
    
        # Single Comments
        if ( is_singular() ) { wp_enqueue_script( 'comment-reply' ); }
        
    }
    add_action('wp_enqueue_scripts','docent_style');

endif;


# Control JS
function docent_customize_control_js() {
    wp_enqueue_script( 'thmc-customizer', DOCENT_URI.'lib/customizer/assets/js/customizer.js', array('jquery', 'jquery-ui-datepicker'), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'docent_customize_control_js' );

# Enqueue Block Editor
add_action('enqueue_block_editor_assets', 'docent_action_enqueue_block_editor_assets');
function docent_action_enqueue_block_editor_assets() {
    wp_enqueue_style( 'bootstrap-grid.min', DOCENT_CSS . 'bootstrap-grid.min.css',false,'all');
    wp_enqueue_style( 'docent-style', get_stylesheet_uri() );
    wp_enqueue_style( 'docent-gutenberg-editor-styles', get_template_directory_uri() . '/css/style-editor.css', null, 'all' );
    wp_add_inline_style( 'docent-style', docent_css_backend_generator() );
}


/* -------------------------------------------- *
* TGM for Plugin activation
* -------------------------------------------- */
add_action( 'tgmpa_register', 'docent_plugins_include');

if(!function_exists('docent_plugins_include')):
    function docent_plugins_include(){
        $plugins = array(
            array(
                'name'                  => esc_html__( 'Qubely', 'docent' ),
                'slug'                  => 'qubely',
                'required'              => false,
                'version'               => '',
                'force_activation'      => false,
                'force_deactivation'    => false,
                'external_url'          => esc_url('https://downloads.wordpress.org/plugin/qubely.zip'),
            ),
            array(
                'name'                  => esc_html__( 'Tutor Ultimate WordPress LMS plugin', 'docent' ),
                'slug'                  => 'tutor',
                'required'              => false,
                'version'               => '',
                'force_activation'      => false,
                'force_deactivation'    => false,
                'external_url'          => esc_url('https://downloads.wordpress.org/plugin/tutor.zip'),
            ),
        
            array(
                'name'                  => esc_html__( 'MailChimp for WordPress', 'docent' ),
                'slug'                  => 'mailchimp-for-wp',
                'required'              => false,
            ),
            array(
                'name'                  => esc_html__('WooCommerce', 'docent'),
                'slug'                  => 'woocommerce',
                'required'              => false,
                'version'               => '',
                'force_activation'      => false,
                'force_deactivation'    => false,
                'external_url'          => 'https://downloads.wordpress.org/plugin/woocommerce.3.1.1.zip', 
            ),     
        );

        $config = array(
            'domain'            => 'docent',
            'default_path'      => '',
            'menu'              => 'install-required-plugins',
            'has_notices'       => true,
            'dismissable'       => true, 
            'dismiss_msg'       => '', 
            'is_automatic'      => false,
            'message'           => ''
        );

        tgmpa( $plugins, $config );
    }

endif;
