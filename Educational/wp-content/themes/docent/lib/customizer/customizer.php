<?php

/**
 * Themeum Customizer
 */


if (!class_exists('DOCENT_PRO_THMC_Framework')):

	class DOCENT_PRO_THMC_Framework
	{
		/**
		 * Instance of WP_Customize_Manager class
		 */
        public $wp_customize;
        
		private $docent_pro_fields_class = array();

		private $google_fonts = array();

		/**
		 * Constructor of 'DOCENT_PRO_THMC_Framework' class
		 *
		 * @wp_customize (WP_Customize_Manager) Instance of 'WP_Customize_Manager' class
		 */
		function __construct( $wp_customize )
		{
			$this->wp_customize = $wp_customize;

			$this->fields_class = array(
				'text'            => 'WP_Customize_Control',
				'checkbox'        => 'WP_Customize_Control',
				'textarea'        => 'WP_Customize_Control',
				'radio'           => 'WP_Customize_Control',
				'select'          => 'WP_Customize_Control',
				'email'           => 'WP_Customize_Control',
				'url'             => 'WP_Customize_Control',
				'number'          => 'WP_Customize_Control',
				'range'           => 'WP_Customize_Control',
				'hidden'          => 'WP_Customize_Control',
				'date'            => 'DOCENT_PRO_THMC_Date_Control',
				'color'           => 'WP_Customize_Color_Control',
				'upload'          => 'WP_Customize_Upload_Control',
				'image'           => 'WP_Customize_Image_Control',
				'radio_button'    => 'DOCENT_PRO_THMC_Radio_Button_Control',
				'checkbox_button' => 'DOCENT_PRO_THMC_Checkbox_Button_Control',
				'switch'          => 'DOCENT_PRO_THMC_Switch_Button_Control',
				'multi_select'    => 'DOCENT_PRO_THMC_Multi_Select_Control',
				'radio_image'     => 'DOCENT_PRO_THMC_Radio_Image_Control',
				'checkbox_image'  => 'DOCENT_PRO_THMC_Checkbox_Image_Control',
				'color_palette'   => 'DOCENT_PRO_THMC_Color_Palette_Control',
				'rgba'            => 'DOCENT_PRO_THMC_Rgba_Color_Picker_Control',
				'title'           => 'DOCENT_PRO_THMC_Switch_Title_Control',
			);

			$this->load_custom_controls();

			add_action( 'customize_controls_enqueue_scripts', array( $this, 'customizer_scripts' ), 100 );
		}

		public function customizer_scripts()
		{
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( 'thmc-select2', DOCENT_URI.'lib/customizer/assets/select2/css/select2.min.css' );
			wp_enqueue_style( 'thmc-customizer', DOCENT_URI.'lib/customizer/assets/css/customizer.css' );

			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'thmc-select2', DOCENT_URI.'lib/customizer/assets/select2/js/select2.min.js', array('jquery'), '1.0', true );
			wp_enqueue_script( 'thmc-rgba-colorpicker', DOCENT_URI.'lib/customizer/assets/js/thmc-rgba-colorpicker.js', array('jquery', 'wp-color-picker'), '1.0', true );
			wp_enqueue_script( 'thmc-customizer', DOCENT_URI.'lib/customizer/assets/js/customizer.js', array('jquery', 'jquery-ui-datepicker'), '1.0', true );

			wp_localize_script( 'thmc-customizer', 'thm_customizer', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'import_success' => __('Success! Your theme data successfully imported. Page will be reloaded within 2 sec.', 'docent'),
				'import_error' => __('Error! Your theme data importing failed.', 'docent'),
				'file_error' => __('Error! Please upload a file.', 'docent')
			) );
		}

		private function load_custom_controls(){
			get_template_part('lib/customizer/controls/radio-button');
            get_template_part('lib/customizer/controls/radio-image');
            get_template_part('lib/customizer/controls/checkbox-button');
            get_template_part('lib/customizer/controls/checkbox-image');
            get_template_part('lib/customizer/controls/switch');
            get_template_part('lib/customizer/controls/date');
            get_template_part('lib/customizer/controls/multi-select');
            get_template_part('lib/customizer/controls/color-palette');
            get_template_part('lib/customizer/controls/rgba-colorpicker');
            get_template_part('lib/customizer/controls/title');

            // Load Sanitize class
            get_template_part('lib/customizer/libs/sanitize');
		}

		public function add_option( $options ){
			if (isset($options['sections'])) {
				$this->panel_to_section($options);
			}
		}

		private function panel_to_section( $options )
		{
			$panel = $options;
			$panel_id = $options['id'];

			unset($panel['sections']);
			unset($panel['id']);

			// Register this panel
			$this->add_panel($panel, $panel_id);

			$sections = $options['sections'];

			if (!empty($sections)) {
				foreach ($sections as $section) {
					$docent_pro_fields = $section['fields'];
					$section_id = $section['id'];

					unset($section['fields']);
					unset($section['id']);

					$section['panel'] = $panel_id;

					$this->add_section($section, $section_id);

					if (!empty($docent_pro_fields)) {
						foreach ($docent_pro_fields as $field) {
							if (!isset($field['settings'])) {
								var_dump($field);
							}
							$field_id = $field['settings'];

							$this->add_field($field, $field_id, $section_id);
						}
					}
				}
			}
		}

		private function add_panel($panel, $panel_id){
			$this->wp_customize->add_panel( $panel_id, $panel );
		}

		private function add_section($section, $section_id)
		{
			$this->wp_customize->add_section( $section_id, $section );
		}

		private function add_field($field, $field_id, $section_id){



			$setting_args = array(
				'default'        => isset($field['default']) ? $field['default'] : '',
				'type'           => isset($field['setting_type']) ? $field['setting_type'] : 'theme_mod',
				'transport'     => isset($field['transport']) ? $field['transport'] : 'refresh',
				'capability'     => isset($field['capability']) ? $field['capability'] : 'edit_theme_options',
			);

			if (isset($field['type']) && $field['type'] == 'switch') {
				$setting_args['sanitize_callback'] = array('DOCENT_PRO_THMC_Sanitize', 'switch_sntz');
			} elseif (isset($field['type']) && ($field['type'] == 'checkbox_button' || $field['type'] == 'checkbox_image')) {
				$setting_args['sanitize_callback'] = array('DOCENT_PRO_THMC_Sanitize', 'multi_checkbox');
			} elseif (isset($field['type']) && $field['type'] == 'multi_select') {
				$setting_args['sanitize_callback'] = array('DOCENT_PRO_THMC_Sanitize', 'multi_select');
				$setting_args['sanitize_js_callback'] = array('DOCENT_PRO_THMC_Sanitize', 'multi_select_js');
			}

			$control_args = array(
				'label'       => isset($field['label']) ? $field['label'] : '',
				'section'     => $section_id,
				'settings'    => $field_id,
				'type'        => isset($field['type']) ? $field['type'] : 'text',
				'priority'    => isset($field['priority']) ? $field['priority'] : 10,
			);

			if (isset($field['choices'])) {
				$control_args['choices'] = $field['choices'];
			}

			// Register the settings
			$this->wp_customize->add_setting( $field_id, $setting_args );
			$control_class = isset($this->fields_class[$field['type']]) ? $this->fields_class[$field['type']] : 'WP_Customize_Control';
			// Add the controls
			$this->wp_customize->add_control( new $control_class( $this->wp_customize, $field_id, $control_args ) );
		}
	}

endif;

/**
*
*/
class THM_Customize
{
	public $google_fonts = array();

	function __construct( $options )
	{
		$this->options = $options;

		add_action('customize_register', array($this, 'customize_register'));
		add_action('wp_enqueue_scripts', array($this, 'get_google_fonts_data'));

	}

	public function customize_register( $wp_customize )
	{
		$docent_pro_framework = new DOCENT_PRO_THMC_Framework( $wp_customize );

		$docent_pro_framework->add_option( $this->options );

	}

	public function get_google_fonts_data()
	{
		if (isset($this->options['sections']) && !empty($this->options['sections'])) {
			foreach ($this->options['sections'] as $section) {
				if (isset($section['fields']) && !empty($section['fields'])) {
					foreach ($section['fields'] as $field) {
						if (isset($field['google_font']) && $field['google_font'] == true) {
							$this->google_fonts[$field['settings']] = array();

							if (isset($field['default']) && !empty($field['default'])) {
								$this->google_fonts[$field['settings']]["default"] = $field['default'];
							}

							if (isset($field['google_font_weight']) && !empty($field['google_font_weight'])) {
								$this->google_fonts[$field['settings']]["weight"] = $field['google_font_weight'];
							}

							if (isset($field['google_font_weight_default']) && !empty($field['google_font_weight_default'])) {
								$this->google_fonts[$field['settings']]["weight_default"] = $field['google_font_weight_default'];
							}
						}
					}
				}
			}
		}

		$all_fonts = array();

		if (!empty($this->google_fonts)) {
			foreach ($this->google_fonts as $font_id => $font_data) {
				$font_family_default = isset($font_data['default']) ? $font_data['default'] : '';
				$font_family = get_theme_mod( $font_id, $font_family_default );

				if (!isset($all_fonts[$font_family])) {
					$all_fonts[$font_family] = array();
				}

				if (isset($font_data['weight']) && !empty($font_data['weight'])) {
					$font_weight_default = isset($font_data['weight_default']) ? $font_data['weight_default'] : '';

					$font_weight = get_theme_mod( $font_data['weight'], $font_weight_default );

					$all_fonts[$font_family][] = $font_weight;
				}

			}
		}

		$font_url = "//fonts.googleapis.com/css?family=";

		if (!empty($all_fonts)) {

			$i = 0;

			foreach ($all_fonts as $font => $weights) {

				if ($i) {
					$font_url .= "%7C";
				}

				$font_url .= str_replace(" ", "+", $font);

				if (!empty($weights)) {
					$font_url .= ":";
					$font_url .= implode(",", $weights);
				}

				$i++;
			}

			wp_enqueue_style( "tm-google-font", $font_url );
		}
	}
}



// Customizer Section
$docent_pro_panel_to_section = array(
	'id'           => 'languageschool_panel_options',
	'title'        => __( 'Docent Options', 'docent' ),
	'description'  => __( 'Docent Theme Options', 'docent' ),
	'priority'     => 10,
	
	'sections'     => array(
		array(
			'id'              => 'header_setting',
			'title'           => __( 'Header Settings', 'docent' ),
			'description'     => __( 'Header Settings', 'docent' ),
			'priority'        => 10,
			'fields'         => array(
				array(
					'settings' => 'header_padding_top',
					'label'    => __( 'Header Top Padding', 'docent' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 13,
				),
				array(
					'settings' => 'header_padding_bottom',
					'label'    => __( 'Header Bottom Padding', 'docent' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 13,
				),
				array(
					'settings' => 'header_margin_bottom',
					'label'    => __( 'Header Bottom Margin', 'docent' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 0,
				),
				array(
					'settings' => 'header_fixed',
					'label'    => __( 'Sticky Header', 'docent' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => false,
				),
				array(
					'settings' => 'progress_en',
					'label'    => __( 'Progress Bar Enable', 'docent' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => false,
                ),
                array(
					'settings' => 'header_bg',
					'label'    => __( 'header background Color', 'docent' ),
					'type'     => 'rgba',
					'priority' => 10,
					'default'  => '#fff',
				),
				array(
					'settings' => 'sticky_header_color',
					'label'    => __( 'Sticky background Color', 'docent' ),
					'type'     => 'rgba',
					'priority' => 10,
					'default'  => '#fff',
				),
				
			) # Fields
		), # Header_setting

		# Logo Settings
		array(
			'id'              => 'logo_setting',
			'title'           => __( 'Logo Options', 'docent' ),
			'description'     => __( 'Logo Options', 'docent' ),
			'priority'        => 10,
			// 'active_callback' => 'is_front_page',
			'fields'         => array(
				array(
					'settings' => 'logo_width',
					'label'    => __( 'Logo Width', 'docent' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 90,
				),
				array(
					'settings' => 'logo_height',
					'label'    => __( 'Logo Height', 'docent' ),
					'type'     => 'number',
					'priority' => 10,
				),	
			) # Fields
		), #logo_setting
		
		# Sub Header Banner.
		array(
			'id'              => 'sub_header_banner',
			'title'           => __( 'Sub Header Banner', 'docent' ),
			'description'     => __( 'sub header banner', 'docent' ),
			'priority'        => 10,
			// 'active_callback' => 'is_front_page',
			'fields'         => array(

				array(
					'settings' => 'sub_header_padding_top',
					'label'    => __( 'Sub-Header Padding Top', 'docent' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 80,
				),
				array(
					'settings' => 'sub_header_padding_bottom',
					'label'    => __( 'Sub-Header Padding Bottom', 'docent' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 80,
				),
				array(
					'settings' => 'sub_header_banner_img',
					'label'    => __( 'Sub-Header Background Image', 'docent' ),
					'type'     => 'upload',
					'priority' => 10,
					'default' 	=> '',
				),
				array(
					'settings' => 'sub_header_title',
					'label'    => __( 'Title Settings', 'docent' ),
					'type'     => 'title',
					'priority' => 10,
				),
				array(
					'settings' => 'sub_header_title_size',
					'label'    => __( 'Header Title Font Size', 'docent' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => '34',
				),
				array(
					'settings' => 'sub_header_title_color',
					'label'    => __( 'Header Title Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1f2949',
				),
			)//fields
		),//sub_header_banner


		array(
			'id'              => 'typo_setting',
			'title'           => __( 'Typography Setting', 'docent' ),
			'description'     => __( 'Typography Setting', 'docent' ),
			'priority'        => 10,
			'fields'         => array(

				array(
					'settings' => 'font_title_body',
					'label'    => __( 'Body Font Options', 'docent' ),
					'type'     => 'title',
					'priority' => 10,
				),
				//body font
				array(
					'settings' => 'body_google_font',
					'label'    => __( 'Select Google Font', 'docent' ),
					'type'     => 'select',
					'default'  => 'Taviraj',
					'choices'  => docent_get_google_fonts(),
					'google_font' 					=> true,
					'google_font_weight' 			=> 'body_font_weight',
					'google_font_weight_default' 	=> '400'
				),
				array(
					'settings' => 'body_font_size',
					'label'    => __( 'Body Font Size', 'docent' ),
					'type'     => 'number',
					'default'  => '14',
				),
				array(
					'settings' => 'body_font_height',
					'label'    => __( 'Body Font Line Height', 'docent' ),
					'type'     => 'number',
					'default'  => '24',
				),
				array(
					'settings' => 'body_font_weight',
					'label'    => __( 'Body Font Weight', 'docent' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '400',
					'choices'  => array(
						'' => __( 'Select', 'docent' ),
						'100' => __( '100', 'docent' ),
						'200' => __( '200', 'docent' ),
						'300' => __( '300', 'docent' ),
						'400' => __( '400', 'docent' ),
						'500' => __( '500', 'docent' ),
						'600' => __( '600', 'docent' ),
						'700' => __( '700', 'docent' ),
						'800' => __( '800', 'docent' ),
						'900' => __( '900', 'docent' ),
					)
				),
				array(
					'settings' => 'body_font_color',
					'label'    => __( 'Body Font Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#535967',
				),
				array(
					'settings' => 'font_title_menu',
					'label'    => __( 'Menu Font Options', 'docent' ),
					'type'     => 'title',
					'priority' => 10,
                ),
                
				//Menu font
				array(
					'settings' => 'menu_google_font',
					'label'    => __( 'Select Google Font', 'docent' ),
					'type'     => 'select',
					'default'  => 'Montserrat',
					'choices'  => docent_get_google_fonts(),
					'google_font' => true,
					'google_font_weight' => 'menu_font_weight',
					'google_font_weight_default' => '700'
				),
				array(
					'settings' => 'menu_font_size',
					'label'    => __( 'Menu Font Size', 'docent' ),
					'type'     => 'number',
					'default'  => '14',
				),
				array(
					'settings' => 'menu_font_height',
					'label'    => __( 'Menu Font Line Height', 'docent' ),
					'type'     => 'number',
					'default'  => '54',
				),
				array(
					'settings' => 'menu_font_weight',
					'label'    => __( 'Menu Font Weight', 'docent' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '700',
					'choices'  => array(
						'' => __( 'Select', 'docent' ),
						'100' => __( '100', 'docent' ),
						'200' => __( '200', 'docent' ),
						'300' => __( '300', 'docent' ),
						'400' => __( '400', 'docent' ),
						'500' => __( '500', 'docent' ),
						'600' => __( '600', 'docent' ),
						'700' => __( '700', 'docent' ),
						'800' => __( '800', 'docent' ),
						'900' => __( '900', 'docent' ),
					)
				),
				array(
					'settings' => 'menu_font_color',
					'label'    => __( 'Menu Font Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1f2949',
				),

				array(
					'settings' => 'font_title_h1',
					'label'    => __( 'Heading 1 Font Options', 'docent' ),
					'type'     => 'title',
					'priority' => 10,
				),
				//Heading 1
				array(
					'settings' => 'h1_google_font',
					'label'    => __( 'Google Font', 'docent' ),
					'type'     => 'select',
					'default'  => 'Montserrat',
					'choices'  => docent_get_google_fonts(),
					'google_font' => true,
					'google_font_weight' => 'menu_font_weight',
					'google_font_weight_default' => '700'
				),
				array(
					'settings' => 'h1_font_size',
					'label'    => __( 'Font Size', 'docent' ),
					'type'     => 'number',
					'default'  => '46',
				),
				array(
					'settings' => 'h1_font_height',
					'label'    => __( 'Font Line Height', 'docent' ),
					'type'     => 'number',
					'default'  => '48',
				),
				array(
					'settings' => 'h1_font_weight',
					'label'    => __( 'Font Weight', 'docent' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '700',
					'choices'  => array(
						'' => __( 'Select', 'docent' ),
						'100' => __( '100', 'docent' ),
						'200' => __( '200', 'docent' ),
						'300' => __( '300', 'docent' ),
						'400' => __( '400', 'docent' ),
						'500' => __( '500', 'docent' ),
						'600' => __( '600', 'docent' ),
						'700' => __( '700', 'docent' ),
						'800' => __( '800', 'docent' ),
						'900' => __( '900', 'docent' ),
					)
				),
				array(
					'settings' => 'h1_font_color',
					'label'    => __( 'Font Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1f2949',
				),

				array(
					'settings' => 'font_title_h2',
					'label'    => __( 'Heading 2 Font Options', 'docent' ),
					'type'     => 'title',
					'priority' => 10,
				),
				//Heading 2
				array(
					'settings' => 'h2_google_font',
					'label'    => __( 'Google Font', 'docent' ),
					'type'     => 'select',
					'default'  => 'Montserrat',
					'choices'  => docent_get_google_fonts(),
					'google_font' => true,
					'google_font_weight' => 'menu_font_weight',
					'google_font_weight_default' => '600'
				),
				array(
					'settings' => 'h2_font_size',
					'label'    => __( 'Font Size', 'docent' ),
					'type'     => 'number',
					'default'  => '30',
				),
				array(
					'settings' => 'h2_font_height',
					'label'    => __( 'Font Line Height', 'docent' ),
					'type'     => 'number',
					'default'  => '36',
				),
				array(
					'settings' => 'h2_font_weight',
					'label'    => __( 'Font Weight', 'docent' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '600',
					'choices'  => array(
						'' => __( 'Select', 'docent' ),
						'100' => __( '100', 'docent' ),
						'200' => __( '200', 'docent' ),
						'300' => __( '300', 'docent' ),
						'400' => __( '400', 'docent' ),
						'500' => __( '500', 'docent' ),
						'600' => __( '600', 'docent' ),
						'700' => __( '700', 'docent' ),
						'800' => __( '800', 'docent' ),
						'900' => __( '900', 'docent' ),
					)
				),
				array(
					'settings' => 'h2_font_color',
					'label'    => __( 'Font Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1f2949',
				),

				array(
					'settings' => 'font_title_h3',
					'label'    => __( 'Heading 3 Font Options', 'docent' ),
					'type'     => 'title',
					'priority' => 10,
				),
				//Heading 3
				array(
					'settings' => 'h3_google_font',
					'label'    => __( 'Google Font', 'docent' ),
					'type'     => 'select',
					'default'  => 'Montserrat',
					'choices'  => docent_get_google_fonts(),
					'google_font' => true,
					'google_font_weight' => 'menu_font_weight',
					'google_font_weight_default' => '400'
				),
				array(
					'settings' => 'h3_font_size',
					'label'    => __( 'Font Size', 'docent' ),
					'type'     => 'number',
					'default'  => '24',
				),
				array(
					'settings' => 'h3_font_height',
					'label'    => __( 'Font Line Height', 'docent' ),
					'type'     => 'number',
					'default'  => '28',
				),
				array(
					'settings' => 'h3_font_weight',
					'label'    => __( 'Font Weight', 'docent' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '600',
					'choices'  => array(
						'' => __( 'Select', 'docent' ),
						'100' => __( '100', 'docent' ),
						'200' => __( '200', 'docent' ),
						'300' => __( '300', 'docent' ),
						'400' => __( '400', 'docent' ),
						'500' => __( '500', 'docent' ),
						'600' => __( '600', 'docent' ),
						'700' => __( '700', 'docent' ),
						'800' => __( '800', 'docent' ),
						'900' => __( '900', 'docent' ),
					)
				),
				array(
					'settings' => 'h3_font_color',
					'label'    => __( 'Font Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1f2949',
				),

				array(
					'settings' => 'font_title_h4',
					'label'    => __( 'Heading 4 Font Options', 'docent' ),
					'type'     => 'title',
					'priority' => 10,
				),
				//Heading 4
				array(
					'settings' => 'h4_google_font',
					'label'    => __( 'Heading4 Google Font', 'docent' ),
					'type'     => 'select',
					'default'  => 'Montserrat',
					'choices'  => docent_get_google_fonts(),
					'google_font' => true,
					'google_font_weight' => 'menu_font_weight',
					'google_font_weight_default' => '600'
				),
				array(
					'settings' => 'h4_font_size',
					'label'    => __( 'Heading4 Font Size', 'docent' ),
					'type'     => 'number',
					'default'  => '18',
				),
				array(
					'settings' => 'h4_font_height',
					'label'    => __( 'Heading4 Font Line Height', 'docent' ),
					'type'     => 'number',
					'default'  => '28',
				),
				array(
					'settings' => 'h4_font_weight',
					'label'    => __( 'Heading4 Font Weight', 'docent' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '600',
					'choices'  => array(
						'' => __( 'Select', 'docent' ),
						'100' => __( '100', 'docent' ),
						'200' => __( '200', 'docent' ),
						'300' => __( '300', 'docent' ),
						'400' => __( '400', 'docent' ),
						'500' => __( '500', 'docent' ),
						'600' => __( '600', 'docent' ),
						'700' => __( '700', 'docent' ),
						'800' => __( '800', 'docent' ),
						'900' => __( '900', 'docent' ),
					)
				),
				array(
					'settings' => 'h4_font_color',
					'label'    => __( 'Heading4 Font Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1f2949',
				),

				array(
					'settings' => 'font_title_h5',
					'label'    => __( 'Heading 5 Font Options', 'docent' ),
					'type'     => 'title',
					'priority' => 10,
				),

				//Heading 5
				array(
					'settings' => 'h5_google_font',
					'label'    => __( 'Heading5 Google Font', 'docent' ),
					'type'     => 'select',
					'default'  => 'Montserrat',
					'choices'  => docent_get_google_fonts(),
					'google_font' => true,
					'google_font_weight' => 'menu_font_weight',
					'google_font_weight_default' => '600'
				),
				array(
					'settings' => 'h5_font_size',
					'label'    => __( 'Heading5 Font Size', 'docent' ),
					'type'     => 'number',
					'default'  => '14',
				),
				array(
					'settings' => 'h5_font_height',
					'label'    => __( 'Heading5 Font Line Height', 'docent' ),
					'type'     => 'number',
					'default'  => '24',
				),
				array(
					'settings' => 'h5_font_weight',
					'label'    => __( 'Heading5 Font Weight', 'docent' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '600',
					'choices'  => array(
						'' => __( 'Select', 'docent' ),
						'100' => __( '100', 'docent' ),
						'200' => __( '200', 'docent' ),
						'300' => __( '300', 'docent' ),
						'400' => __( '400', 'docent' ),
						'500' => __( '500', 'docent' ),
						'600' => __( '600', 'docent' ),
						'700' => __( '700', 'docent' ),
						'800' => __( '800', 'docent' ),
						'900' => __( '900', 'docent' ),
					)
				),
				array(
					'settings' => 'h5_font_color',
					'label'    => __( 'Heading5 Font Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1f2949',
				),

			)//fields
		),//typo_setting

		array(
			'id'              => 'layout_styling',
			'title'           => __( 'Layout & Styling', 'docent' ),
			'description'     => __( 'Layout & Styling', 'docent' ),
			'priority'        => 10,
			'fields'         => array(
				array(
					'settings' => 'boxfull_en',
					'label'    => __( 'Select BoxWidth of FullWidth', 'docent' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => 'fullwidth',
					'choices'  => array(
						'boxwidth' => __( 'BoxWidth', 'docent' ),
						'fullwidth' => __( 'FullWidth', 'docent' ),
					)
				),

				array(
					'settings' => 'body_bg_color',
					'label'    => __( 'Body Background Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#fff',
				),
				array(
					'settings' => 'body_bg_img',
					'label'    => __( 'Body Background Image', 'docent' ),
					'type'     => 'image',
					'priority' => 10,
				),
				array(
					'settings' => 'body_bg_attachment',
					'label'    => __( 'Body Background Attachment', 'docent' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => 'fixed',
					'choices'  => array(
						'scroll' 	=> __( 'Scroll', 'docent' ),
						'fixed' 	=> __( 'Fixed', 'docent' ),
						'inherit' 	=> __( 'Inherit', 'docent' ),
					)
				),
				array(
					'settings' => 'body_bg_repeat',
					'label'    => __( 'Body Background Repeat', 'docent' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => 'no-repeat',
					'choices'  => array(
						'repeat' => __( 'Repeat', 'docent' ),
						'repeat-x' => __( 'Repeat Horizontally', 'docent' ),
						'repeat-y' => __( 'Repeat Vertically', 'docent' ),
						'no-repeat' => __( 'No Repeat', 'docent' ),
					)
				),
				array(
					'settings' => 'body_bg_size',
					'label'    => __( 'Body Background Size', 'docent' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => 'cover',
					'choices'  => array(
						'cover' => __( 'Cover', 'docent' ),
						'contain' => __( 'Contain', 'docent' ),
					)
				),
				array(
					'settings' => 'body_bg_position',
					'label'    => __( 'Body Background Position', 'docent' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => 'left top',
					'choices'  => array(
						'left top' => __('left top', 'docent'),
						'left center' => __('left center', 'docent'),
						'left bottom' => __('left bottom', 'docent'),
						'right top' => __('right top', 'docent'),
						'right center' => __('right center', 'docent'),
						'right bottom' => __('right bottom', 'docent'),
						'center top' => __('center top', 'docent'),
						'center center' => __('center center', 'docent'),
						'center bottom' => __('center bottom', 'docent'),
					)
				),
				array(
					'settings' => 'custom_preset_en',
					'label'    => __( 'Set Custom Color', 'docent' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'major_color',
					'label'    => __( 'Major Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1b52d8',
				),
				array(
					'settings' => 'hover_color',
					'label'    => __( 'Hover Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#333',
				),
			
				# navbar color section start.
				array(
					'settings' => 'menu_color_title',
					'label'    => __( 'Menu Color Settings', 'docent' ),
					'type'     => 'title',
					'priority' => 10,
				),
				array(
					'settings' => 'navbar_text_color',
					'label'    => __( 'Text Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1f2949',
				),
				array(
					'settings' => 'navbar_hover_text_color',
					'label'    => __( 'Hover Text Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1b52d8',
				),

				array(
					'settings' => 'navbar_active_text_color',
					'label'    => __( 'Active Text Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1b52d8',
				),

				array(
					'settings' => 'sub_menu_color_title',
					'label'    => __( 'Sub-Menu Color Settings', 'docent' ),
					'type'     => 'title',
					'priority' => 10,
				),
				array(
					'settings' => 'sub_menu_bg',
					'label'    => __( 'Background Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#f8f8f8',
				),
				array(
					'settings' => 'sub_menu_text_color',
					'label'    => __( 'Text Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#7e879a',
				),
				array(
					'settings' => 'sub_menu_text_color_hover',
					'label'    => __( 'Hover Text Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1b52d8',
				),
				#End of the navbar color section
			)//fields
		),//Layout & Styling

		# 404 Page.
		array(
			'id'              => '404_settings',
			'title'           => __( '404 Page', 'docent' ),
			'description'     => __( '404 page background and text settings', 'docent' ),
			'priority'        => 10,
			'fields'         => array(

				array(
					'settings' => 'error_404',
					'label'    => __( 'Background Image', 'docent' ),
					'type'     => 'upload',
					'priority' => 10,
                ),

				array(
					'settings' => '404_description',
					'label'    => __( '404 Page Description', 'docent' ),
					'type'     => 'textarea',
					'priority' => 10,
					'default'  => __('The Page you are looking for does not exits', 'docent'),
				),
			)
		),

		# Blog Settings.
		array(
			'id'              => 'blog_setting',
			'title'           => __( 'Blog Setting', 'docent' ),
			'description'     => __( 'Blog Setting', 'docent' ),
			'priority'        => 10,
			'fields'         => array(
				array(
					'settings' => 'blog_column',
					'label'    => __( 'Select Blog Column', 'docent' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '4',
					'choices'  => array(
						'12' 	=> __( 'Column 1', 'docent' ),
						'6' 	=> __( 'Column 2', 'docent' ),
						'4' 	=> __( 'Column 3', 'docent' ),
						'3' 	=> __( 'Column 4', 'docent' ),
					)
				),
				array(
					'settings' => 'en_blog_date',
					'label'    => __( 'Enable Blog Date', 'docent' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'blog_author',
					'label'    => __( 'Enable Blog Author', 'docent' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => false,
				),
				array(
					'settings' => 'blog_category',
					'label'    => __( 'Enable Blog Category', 'docent' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => false,
				),
				array(
					'settings' => 'blog_intro_en',
					'label'    => __( 'Enable Blog Content', 'docent' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),				

			)//fields
		),//blog_setting

		array(
			'id'              => 'blog_single_setting',
			'title'           => __( 'Blog Single Page Setting', 'docent' ),
			'description'     => __( 'Blog Single Page Setting', 'docent' ),
			'priority'        => 10,
			'fields'         => array(
				
				array(
					'settings' => 'enable_sidebar',
					'label'    => __( 'Enable Sidebar', 'docent' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'blog_date_single',
					'label'    => __( 'Enable Blog Date', 'docent' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'blog_author_single',
					'label'    => __( 'Enable Blog Author', 'docent' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'blog_category_single',
					'label'    => __( 'Enable Blog Category', 'docent' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => false,
				),
				array(
					'settings' => 'blog_hit_single',
					'label'    => __( 'Enable Hit Count', 'docent' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => false,
				),
				array(
					'settings' => 'blog_comment_single',
					'label'    => __( 'Enable Comment', 'docent' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'blog_tags_single',
					'label'    => __( 'Blog Tag Enable', 'docent' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
					 		
			) #Fields
		), # Blog Single Page Setting

		array(
			'id'              => 'bottom_setting',
			'title'           => __( 'Bottom Setting', 'docent' ),
			'description'     => __( 'Bottom Setting', 'docent' ),
			'priority'        => 10,
			'fields'         => array(
				array(
					'settings' => 'bottom_en',
					'label'    => __( 'Enable Bottom Area', 'docent' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => false,
				),
				array(
					'settings' => 'bottom_column',
					'label'    => __( 'Select Bottom Column', 'docent' ),
					'type'     => 'select',
					'priority' => 10,
					'default'  => '4',
					'choices'  => array(
						'12' => __( 'Column 1', 'docent' ),
						'6' => __( 'Column 2', 'docent' ),
						'4' => __( 'Column 3', 'docent' ),
						'3' => __( 'Column 4', 'docent' ),
					)
				),
				array(
					'settings' => 'bottom_color',
					'label'    => __( 'Bottom background Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#fbfbfc',
				),
				array(
					'settings' => 'bottom_title_color',
					'label'    => __( 'Bottom Title Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1f2949',
				),	
				array(
					'settings' => 'bottom_link_color',
					'label'    => __( 'Bottom Link Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#535967',
				),				
				array(
					'settings' => 'bottom_hover_color',
					'label'    => __( 'Bottom link hover color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#1b52d8',
				),
				array(
					'settings' => 'bottom_text_color',
					'label'    => __( 'Bottom Text color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#535967',
				),
				array(
					'settings' => 'bottom_padding_top',
					'label'    => __( 'Bottom Top Padding', 'docent' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 80,
				),	
				array(
					'settings' => 'bottom_padding_bottom',
					'label'    => __( 'Bottom Padding Bottom', 'docent' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 45,
				),					
			)//fields
		),//bottom_setting	


		# Footer Settings.	
		array(
			'id'              => 'footer_setting',
			'title'           => __( 'Footer Setting', 'docent' ),
			'description'     => __( 'Footer Setting', 'docent' ),
			'priority'        => 10,
			'fields'         => array(
				array(
					'settings' => 'footer_en',
					'label'    => __( 'Disable Copyright Area', 'docent' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'footer_logo',
					'label'    => __( 'Upload Logo', 'docent' ),
					'type'     => 'upload',
					'priority' => 10,
				),
				array(
					'settings' => 'copyright_en',
					'label'    => __( 'Disable copyright text', 'docent' ),
					'type'     => 'switch',
					'priority' => 10,
					'default'  => true,
				),
				array(
					'settings' => 'copyright_text',
					'label'    => __( 'Copyright Text', 'docent' ),
					'type'     => 'textarea',
					'priority' => 10,
					'default'  => __( '2020 Docent Pro. All Rights Reserved.', 'docent' ),
				),
				array(
					'settings' => 'copyright_text_color',
					'label'    => __( 'Footer Text Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#6c6d8b',
				),				
				array(
					'settings' => 'copyright_link_color',
					'label'    => __( 'Footer Link Color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#6c6d8b',
				),				
				array(
					'settings' => 'copyright_hover_color',
					'label'    => __( 'Footer link hover color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#fff',
				),
				array(
					'settings' => 'copyright_bg_color',
					'label'    => __( 'Footer background color', 'docent' ),
					'type'     => 'color',
					'priority' => 10,
					'default'  => '#fbfbfc',
				),
				array(
					'settings' => 'copyright_padding_top',
					'label'    => __( 'Footer Top Padding', 'docent' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 20,
				),	
				array(
					'settings' => 'copyright_padding_bottom',
					'label'    => __( 'Footer Bottom Padding', 'docent' ),
					'type'     => 'number',
					'priority' => 10,
					'default'  => 20,
				),					
			)//fields
		),//footer_setting.
		
	),
);//wpestate-core_panel_options

$docent_pro_framework = new THM_Customize( $docent_pro_panel_to_section );

