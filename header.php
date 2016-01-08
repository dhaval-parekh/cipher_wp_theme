<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<title><?php wp_title( '|',true,'right'); bloginfo( 'name' ); ?>	</title>
	<meta name="description" content="ciphersoul">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="robots" content="index,follow">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	<link rel="shortcut icon" href="images/favicon.ico">
	<!--<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
		<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
		-->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<?php wp_head();?>
	<!-- Fonts ================================================== -->
	<link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/base.css" />
	<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie7.css" />
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/skeleton.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/screen.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style.css" />
	<script type="text/javascript">
		var template_dir = <?php echo "'".get_template_directory_uri()."';"; ?>
		var ajaxurl = <?php echo "'".admin_url('admin-ajax.php')."';"; ?>; 
	</script>
</head>
<body <?php body_class(); ?>>
	<!-- Site Backgrounds	================================================== --> 
	<!-- Change to class="poswrapheaderline wide" and class="headerline full" for a full-width header line -->
	<div class="poswrapheaderline"><div class="headerline"></div></div>
	<!-- Remove or uncomment depending on if you want a background image or tile --> 
	<!--<div class="tiledbackground"></div>--> 
	<?php 
		$background_image = get_background_image();
		$background_image = (!empty($background_image))?get_background_image():get_template_directory_uri().'/images/bg.jpg'; 
	?>
	<img src="<?php echo $background_image ?>" alt="" id="background" /> 
	<!-- Change to class="poswrapper wide" and class="whitebackground full" for a full-width site background -->
	<div class="poswrapper"><div class="whitebackground "></div></div>

<!-- site  start here-->
<div class="container main portfolio4column"> 
	<!-- Header | Logo, Menu ================================================== -->
	<div class="sixteen columns header">
		<div class="logo"><a href="<?php echo bloginfo('url'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt=" <?php echo bloginfo('name'); ?>" /></a></div>
		<div class="logotext">a responsive minimal portfolio template.</div>
		<div class="mainmenu">
			<div id="mainmenu" class="ddsmoothmenu">
				<?php  wp_nav_menu(array('theme_location'  => 'header','container'=>false,'menu_id'=>'','menu_class'=>''));?>
				<br style="clear: left" />
			</div>
			<!-- Responsive Menu -->
			<form id="responsive-menu" action="#" method="post">
				<select>
					<option value="">Navigation</option>
				</select>
			</form>
		</div>
		<div class="headerdivider"></div>
	</div>
