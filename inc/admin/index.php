<?php
add_action('admin_menu', 'cipher_admin_dashboard_menu');

if(!function_exists('cipher_admin_dashboard_menu')):
	function cipher_admin_dashboard_menu() {
		add_theme_page('Theme Options', 'Theme Options', 'edit_theme_options', 'cipher_theme_option', 'cipher_admin_option');
	}
endif;

if(!function_exists('cipher_admin_option')):
	function cipher_admin_option(){
		
		require_once(THEME_ADMIN_DIR.'dashboard/index.php');
	}
endif;

// Admin Theme Enqueue
if(!function_exists('cipher_admin_enqueue')):
	function cipher_admin_enqueue(){
		//wp_enqueue_style('cipher-bootstrap', get_template_directory_uri().'/css/bootstrap.min.css');
		wp_enqueue_style('cipher-bootstrap', get_template_directory_uri().'/css/admin.css');	
	}
endif;
add_action( 'admin_enqueue_scripts', 'cipher_admin_enqueue' );
