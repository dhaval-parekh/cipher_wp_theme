<?php
/**
 *	Template Name: Project List Template
 *	Author : Dhaval Parekh
 *
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
					<?php //if(has_post_thumbnail(get_the_Id())){ echo '<div class="page-feature-image banner"><a href="'.get_the_permalink().'" title="'.get_the_title().'" >'; the_post_thumbnail();echo '</a></div>'; } ?>
					<div class="page-content">
						<?php
							$post_per_page = 5;
							$query_args = array('post_type'=>'project','posts_per_page'=>$post_per_page,);
							render_blog_list($query_args);
						?>
					</div>
				</div>
				<!-- Right Sidebar -->
				<?php echo '<div class="four columns sidebar offset-by-one content">'; get_template_part('sidebar'); echo '</div>'; ?>
			<?php
			endwhile;
		endif;
	?>
	<div class="sixteen columns bottomadjust"></div>
<?php get_footer(); ?>