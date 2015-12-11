<?
/**
 *	Template Name: Page with Rigth Sidebar
 */
?>
<?php get_header(); ?>
	<?php
		if(have_posts()):
			while(have_posts()): the_post();
			?>
				<div class="sixteen columns row divide notop">
					<h3 class="titledivider"><?php the_title();?></h3>
					<div class="dividerline"></div>
				</div>
				<div class="eleven columns row content left">
					<?php //if(has_post_thumbnail(get_the_Id())){ echo '<div class="page-feature-image banner"><a href="'.get_the_permalink().'" title="'.get_the_title().'" >'; the_post_thumbnail('full-page-image');echo '</a></div>'; } ?>
					<?php if(has_post_thumbnail(get_the_Id())){ echo '<div class="page-feature-image banner"><a href="'.get_the_permalink().'" title="'.get_the_title().'" >'; the_post_thumbnail();echo '</a></div>'; } ?>
					<div class="page-content"><?php $pattern = "/<p[^>]*><\\/p[^>]*>/"; echo preg_replace($pattern, '', get_the_content()); ?></div>
				</div>
				<!-- Right Sidebar -->
				<?php echo '<div class="four columns sidebar offset-by-one content">'; get_template_part('sidebar'); echo '</div>'; ?>
			<?php
			endwhile;
		endif;
	?>
	<div class="sixteen columns bottomadjust"></div>
<?php get_footer(); ?>