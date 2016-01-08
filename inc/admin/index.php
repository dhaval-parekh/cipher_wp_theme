<?php
add_action('admin_menu', 'cipher_admin_dashboard_menu');

if(!function_exists('cipher_admin_dashboard_menu')):
	function cipher_admin_dashboard_menu() {
		add_menu_page('Theme Options', 'Theme Options', 'manage_options', 'cipher_theme', 'cipher_admin_option_index');
		add_submenu_page('cipher_theme','Contact Request','Contact Request','manage_options','cipher_contact_request','cipher_admin_option_contact_request');
	}
endif;

if(!function_exists('cipher_admin_option_index')):
	function cipher_admin_option_index(){
		require_once(THEME_ADMIN_DIR.'dashboard/index.php');
	}
endif;

if(! function_exists('cipher_admin_option_contact_request')){
	function cipher_admin_option_contact_request(){
		require_once(THEME_ADMIN_DIR.'dashboard/contact-request.php');
	}	
}


// Admin Theme Enqueue
if(!function_exists('cipher_admin_enqueue')):
	function cipher_admin_enqueue(){
		wp_enqueue_style('cipher-bootstrap', get_template_directory_uri().'/css/bootstrap.min.css');
		wp_enqueue_style('cipher-admin', get_template_directory_uri().'/css/admin.css');	
	}
endif;
add_action( 'admin_enqueue_scripts', 'cipher_admin_enqueue' );
