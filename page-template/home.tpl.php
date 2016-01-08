<?php
/**
 *
 *	Template Name: Home Page Template
 *	Author : Dhaval Parekh
 *
 */
?>
<?php get_header(); ?>
<?php if(have_posts()):?>
<?php while(have_posts()): the_post();?>
	<?php if(function_exists('dynamic_sidebar')){ dynamic_sidebar('home-slider-area'); }?>
	<?php echo do_shortcode('[cipher_portfolio title="Latest Project" post_type="project" ]'); //ancher="See All" ancher_href="http://www.google.com" ?> 
	<?php //do_shortcode('[cipher_portfolio title="Our Services" post_type="service" ]'); //ancher="See All" ancher_href="http://www.google.com" ?> 
	<?php $pattern = "/<p[^>]*><\\/p[^>]*>/"; echo preg_replace($pattern, '', get_the_content()); ?>
<?php endwhile;  ?>
<?php endif;?>
<?php get_footer(); 

