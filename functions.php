<?php
define('THEME_DIR', get_template_directory());
define('THEME_URL', get_template_directory_uri());
define('DS',DIRECTORY_SEPARATOR);

define('THEME_CSS_DIR', THEME_DIR.DS.'css'.DS);
define('THEME_CSS_URL', THEME_URL.'/css');

define('THEME_JS_DIR', THEME_DIR.DS.'js'.DS);
define('THEME_JS_URL', THEME_URL.'/js');

define('THEME_INC_DIR', THEME_DIR.DS.'inc'.DS);
define('THEME_INC_URL', THEME_URL.'/inc');

define('THEME_ADMIN_DIR', THEME_DIR.DS.'inc'.DS.'admin'.DS);
define('THEME_ADMIN_URL', THEME_URL.'/inc/admin');

define('THEME_STYLESHEET_URL', get_bloginfo('stylesheet_url'));
define('THEME_STYLESHEET_FILE', THEME_DIR . DS. 'style.css');

if(!function_exists('cipher_theme_setup')):
	function cipher_theme_setup(){
		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		//add_theme_support( 'post-formats', array( 'image', 'video',  'link', 'gallery', ) );
		//wp_enqueue_style( 'cipher-admin', get_template_directory_uri() . '/css/admin.css', array(), '1.0' );
		//wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/font-awesome-4.2.0/css/font-awesome.min.css', array(), '1.0' );
		
		$background_option = array(
						'default-color'          => '#343434',
						'default-image'          => get_template_directory_uri()."/images/bg.jpg",
						//'default-repeat'         => '',
						//'default-position-x'     => '',
						//'default-attachment'     => '',
						//'wp-head-callback'       => '_custom_background_cb',
						//'admin-head-callback'    => '',
						//'admin-preview-callback' => ''
					);
		add_theme_support( 'custom-background', $background_option );
		$header_option = array(
						'default-image'          => '',
						'width'                  => 1980,
						'height'                 => 256,
						//'flex-height'            => false,
						//'flex-width'             => false,
						//'uploads'                => true,
						//'random-default'         => false,
						//'header-text'            => true,
						//'default-text-color'     => '',
						//'wp-head-callback'       => '',
						//'admin-head-callback'    => '',
						//'admin-preview-callback' => '',
					);
		//add_theme_support( 'custom-header', $header_option );
		//var_dump(get_header_image()); // Get This header image use this function 
		
	}
endif;
add_action('after_setup_theme','cipher_theme_setup');

// New User Role For Client
function cipher_add_user_role_client(){
	$result = add_role( 'client', 'Client', array( 'read' => true,'upload_files' => true, 'level_0' => true ) );	
	if( $result !== NULL ){ return true; }
	return false;
}
register_activation_hook( __FILE__, 'cipher_add_user_role_client' );

// Thumbanail suport
if (function_exists('add_theme_support')):
	add_theme_support('post-thumbnails');	 
endif;
if(function_exists('add_image_size')):
	add_image_size('project-post-thumbnail',100,100,true);
	add_image_size('full-page-image',940,350,true);
	add_image_size('sidebar-page-image',700,350,true);
	add_image_size('portfolio-thumbnail',460,272,true);
endif;

// Regirsted Navigation Menu
if(function_exists('register_nav_menu')):
	register_nav_menus(array('header'=>'Header Navigation'));
endif;

// Register Widget Area
if(function_exists('register_sidebar')):
	register_sidebar(array(
			'name'=>'Home Slider Area',
			'id'=>'home-slider-area',
			'before_widget' => '<div class="sixteen columns row">',
			'after_widget' =>'<div class="clearfix"></div></div>',
		)
	);
	register_sidebar(array(
			'name'=>'Footer widget Area',
			'id'=>'footer-widgets',
			'before_widget' => '<div class="four columns widget ">',
			'after_widget' =>'</div>',
			'before_title' => '<h5 class="footer-widget-title">',
			'after_title' => '</h5>'
		)
	);
	register_sidebar(array(
			'name'=>'Sidebar Widget Area',
			'id'=>'sidebar-widgets',
			'before_widget'=>'<div class="widget">',
			'after_widget'=>'</div>',
			'before_title'=>'<h5 class="sidebar-widget-title">',
			'after_title'=>'</h5>',
		)
	);
endif;


//cipher_add_user_role_client();
//register_activation_hook( __FILE__, 'cipher_add_user_role_client' );

/**
 *	Function : cropText
 *	@param: $str => String
 *	@param: $limit => Int => limit of text After is append ...
 *	@return => string
 */
function cropText($str, $limit){
	$str = preg_replace('/\[.*\]/', '', $str);
	return strlen($str)<$limit?$str:substr($str,0,$limit).'...';
}


// Import Library
require_once(THEME_INC_DIR.'lib/class.form.php');
require_once(THEME_INC_DIR.'frontend.helper.php');

// Import Files
require_once('inc/post-type/project.php');
require_once('inc/post-type/service.php');

// Import Short code File
require_once('inc/short-code/portfolio.php');

// Import widgets
require_once('inc/widgets/print_shortcode.php');
require_once('inc/widgets/search_widget.php');
require_once('inc/widgets/latest_post_widget.php');

// Import Admin 
require_once(THEME_ADMIN_DIR.'index.php');

// helper function
function display($obj){ echo '<pre style="overflow:auto:max-height:256px;clear:both;">'; print_r($obj); echo '</pre>'; }
