<?php
/**
 *
 *	Template Name: Contact Page Template
 *	Author : Dhaval Parekh
 *
 */
?>
<?php get_header(); ?>
	<?php
		if(have_posts()):
			while(have_posts()): the_post();
			$post_meta = get_post_meta(get_the_ID());
			
			$demo_url = isset($post_meta['demolink'])&&!empty($post_meta['demolink'])?$post_meta['demolink'][0]:get_the_permalink();
			?>
				<div class="sixteen columns row divide notop">
					<h3 class="titledivider"><?php the_title(); ?></h3>
					<div class="dividerline"></div>
				</div>
				<div class="eleven columns row alpha  content left">
					<?php //if(has_post_thumbnail(get_the_Id())){ echo '<div class="page-feature-image banner"><a href="'.get_the_permalink().'" title="'.get_the_title().'" >'; the_post_thumbnail();echo '</a></div>'; } ?>
					<div class="eleven columns row ">
						<?php the_content(); //$pattern = "/<p[^>]*><\\/p[^>]*>/"; echo preg_replace($pattern, '', get_the_content()); ?>
						<?php //do_shortcode('[cipher_portfolio title="Latest Project" post_type="project" ]');?>
						<?php //echo do_shortcode('[cipher_sidebar_contact]');?>
					</div>
				</div>
				<!-- Right Sidebar -->
				<?php echo '<div class="four columns sidebar offset-by-one content">'; get_template_part('sidebar','contact'); echo '</div>'; ?>
				<div class="sixteen columns bottomadjust"></div>
			<?php
			endwhile;
		endif;
	?>
<?php get_footer(); ?>
