<?php get_header(); ?>
	<?php //get_template_part('sidebar'); ?>
	<?php
		if(have_posts()):
			while(have_posts()): the_post();
			?>
			<div class="sixteen columns row divide notop">
				<h3 class="titledivider"><?php the_title();?></h3>
				<div class="dividerline"></div>
			</div>
			<div class="sixteen columns row content">
				<?php //if(has_post_thumbnail(get_the_Id())){ echo '<div class="page-feature-image banner"><a href="'.get_parmalink.'" title="'.get_the_title().'" >'; the_post_thumbnail('full-page-image');echo '</a></div>'; } ?>
				<?php if(has_post_thumbnail(get_the_Id())){ echo '<div class="page-feature-image banner"><a href="'.get_the_permalink().'" title="'.get_the_title().'" >'; the_post_thumbnail();echo '</a></div>'; } ?>
				<div class="content"><?php the_content();?></div>
			</div>
			<?php
			endwhile;
		endif;
	?>
<?php get_footer(); ?>