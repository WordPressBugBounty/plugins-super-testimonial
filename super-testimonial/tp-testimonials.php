<?php
	/*
	Plugin Name: Super Testimonial
	Plugin URI: https://themepoints.com/testimonials/
	Description: Super Testimonials is a component ready to use on mobile devices and desktop devices. Super Testimonial are easy to use the plugin that allows users to add Testimonials to the sidebar, as a widget, or to embed testimonials into a Page or Post using the shortcode.
	Version: 4.0.0
	Author: Themepoints
	Author URI: https://themepoints.com
	TextDomain: ktsttestimonial
	License: GPLv2
	*/

	if ( ! defined( 'ABSPATH' ) ) {
	    exit;
	}

	/**
	 * Defining plugin constants
	 */
	
	if ( !defined( 'TPS_TESTIMONIAL_VERSION' ) ) {
	    define( 'TPS_TESTIMONIAL_VERSION', '4.0.0' );
	}

	if ( !defined( 'TPS_TESTIMONIAL_PLUGIN_DIR' ) ) {
	    define( 'TPS_TESTIMONIAL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	}

	if ( !defined( 'TPS_TESTIMONIAL_PLUGIN_URI' ) ) {
	    define( 'TPS_TESTIMONIAL_PLUGIN_URI', plugins_url( '', __FILE__ ) );
	}

	if ( !defined( 'TPS_REVIEW_REMIND_TIME' ) ) {
		define( 'TPS_REVIEW_REMIND_TIME', 604800); // 7 days in seconds
	}

	// Enable shortcodes in widget_text
	add_filter('widget_text', 'do_shortcode');

	// Include necessary files
	require_once TPS_TESTIMONIAL_PLUGIN_DIR . 'admin/tp-testimonials-admin.php';
	require_once TPS_TESTIMONIAL_PLUGIN_DIR . 'includes/metabox/tp-testimonials-metabox.php' ;
	require_once TPS_TESTIMONIAL_PLUGIN_DIR . 'includes/shortcodes/tp-testimonial-pro-shortcode.php' ;
	require_once TPS_TESTIMONIAL_PLUGIN_DIR . 'includes/shortcodes/tp-custom-shortcode.php' ;
	require_once TPS_TESTIMONIAL_PLUGIN_DIR . 'admin/users-form-options.php';

	// Load translation for the plugin
	function tps_super_testimonials_load_textdomain(){
		load_plugin_textdomain('ktsttestimonial', false, dirname( plugin_basename( __FILE__ ) ) .'/languages/' );
	}
	add_action('plugins_loaded', 'tps_super_testimonials_load_textdomain');

	// Enqueue scripts and styles for the frontend	
	function tps_super_testimonials_enqueue_script(){
		wp_enqueue_style( 'tps-super-font-awesome-css', plugins_url( 'frontend/css/font-awesome.css' , __FILE__ ) );
		wp_enqueue_style( 'tps-super-owl.carousel-css', plugins_url( 'frontend/css/owl.carousel.min.css' , __FILE__ ) );
		wp_enqueue_style( 'tps-super-style-css', plugins_url( 'frontend/css/theme-style.css' , __FILE__ ) );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'imagesloaded' );
	    // Register the JS file
		wp_register_script( 'testimonial-slider', plugins_url('frontend/js/testimonial-slider.js', __FILE__), array('jquery'), '1.0.0', true);
	    wp_enqueue_script( 'testimonial-slider' );
		wp_enqueue_script('tps-super-star-js', plugins_url('frontend/js/jquery.raty-fa.js', __FILE__), array('jquery'), '2.4', true);
		wp_enqueue_script('tps-super-owl-js', plugins_url('frontend/js/owl.carousel.js', __FILE__), array('jquery'), '2.4', true);
	}
	add_action('wp_enqueue_scripts', 'tps_super_testimonials_enqueue_script');

	// Add a link to upgrade to the Pro version in the plugin's action links
	function tps_super_testimonialspro_version_link( $links ) {
	   $links[] = '<a style="color:red;font-weight:bold;" href="https://www.themepoints.com/shop/super-testimonial-pro/" target="_blank">Upgrade to Pro!</a>';
	   return $links;
	}
	add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'tps_super_testimonialspro_version_link' );

	// Enqueue scripts and styles for the admin area
	function tps_super_testimonials_admin_enqueue_scripts(){
		global $typenow;
		if(($typenow == 'ktsprotype')){
			wp_enqueue_style( 'tps-super-font-awesome-css', plugins_url( 'frontend/css/font-awesome.css' , __FILE__ ) );
			wp_enqueue_style( 'tps-super-admin-css', plugins_url( 'admin/css/tp-testimonial-admin.css' , __FILE__ ) );		
			wp_enqueue_style('wp-color-picker');	
			wp_enqueue_script( 'testimonial_pro_color_picker', plugins_url('/frontend/js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
		}
	}
	add_action('admin_enqueue_scripts', 'tps_super_testimonials_admin_enqueue_scripts');

	// Enqueue scripts and styles for the admin shortcode page
	function tps_super_testimonials_pro_color_scripts() {
		global $typenow;
		if ( is_admin() ) {
			if ( ( $typenow == 'tptscode' ) ) {
				wp_enqueue_style( 'tps-super-admin-shortcode-style', plugins_url( 'admin/css/tps-shortcode-admin.css' , __FILE__ ) );
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script( 'testimonial_pro_color_picker', plugins_url( '/admin/js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
				wp_enqueue_script( 'tps-super-pro-admin-scripts-js', plugins_url( 'admin/js/tp-testimonial-admin.js', __FILE__ ), array( 'jquery' ), '1.0', true );
			}
		}
	}
	add_action( 'admin_enqueue_scripts', 'tps_super_testimonials_pro_color_scripts' );

	/*==========================================================================
		Super Testimonials Shortcode Page
	============================================================================*/

	// Function to add a submenu page under the custom post type 'ktsprotype'
	function tps_super_testimonials_custom_submenu_page() {
		if (current_user_can('manage_options')) {
			add_submenu_page(
			    'edit.php?post_type=ktsprotype',     // Parent menu slug
			    __('Help & Usage', 'ktsttestimonial'), // Page title
			    __('Help & Usage', 'ktsttestimonial'), // Menu title
			    'manage_options',                     // Capability required to access
			    'testimonial_pro_shortcode',          // Menu slug
			    'tps_super_testimonials_custom_shortcode_callback' // Callback function
			);
		}
	}

	// Callback function for the custom submenu page
	function tps_super_testimonials_custom_shortcode_callback() {
		// Include the file containing the shortcode options
		require_once TPS_TESTIMONIAL_PLUGIN_DIR . 'includes/tps_super_testimonial_options.php';
	}
	add_action('admin_menu', 'tps_super_testimonials_custom_submenu_page');

	// Activation hook actions for the frontend
	function tp_activation_actions_for_frontend(){
		do_action( 'tp_create_options' );
	}
	register_activation_hook( __FILE__, 'tp_activation_actions_for_frontend' );

	// Set default values for the frontend options
	function tp_create_options_for_frontend(){
		// Array of default options
	    $options = array(
		    0 => "Title",
		    1 => "Name",
		    2 => "Designation",
		    3 => "Company Name",
		    4 => "Company URL",
		    5 => "Link Target",
		    6 => "Rating",
		    7 => "Testimonial Message",
		    8 => "Categories",
		    9 => "User's Image/Logo",
		    10 => "Calculate"
		);
		// Save selected options in the database
		update_option( 'st_user_fields', $options );
	}
	add_action( 'tp_create_options', 'tp_create_options_for_frontend' );