<?
/**
 *	 Single Blog Page 
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
					<h3 class="titledivider">The Blog.</h3>
					<div class="dividerline"></div>
				</div>
				<div class="eleven columns row content left">
					<?php //if(has_post_thumbnail(get_the_Id())){ echo '<div class="page-feature-image banner"><a href="'.get_the_permalink().'" title="'.get_the_title().'" >'; the_post_thumbnail();echo '</a></div>'; } ?>
					<div class="eleven columns row alpha blogpost">
						<?php if(has_post_thumbnail(get_the_ID())): ?>
							<div class="eleven columns alpha blogimage">
								<a href="<?php echo $demo_url ?>" target="_blank" data-text="» View Live Demo" class="hovering">
									<img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())); ?>" alt="<?php the_title(); ?>" class="scale-with-grid" />
								</a>
							</div>
						<?php endif; ?>
						<div class="one column row alpha">
							<div class="blogdate">
								<div class="day"><?php the_time('d'); ?></div>
								<span><?php the_time('M Y'); ?></span>
							</div>
						</div>
						<div class="nine columns row offset-by-one omega">
							<div class="blogtitle">
								<h4><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h4>
							</div>
							<div class="postinfo">
								<span class="dateinfo"><?php the_date(); ?> &nbsp; | &nbsp; </span>
								<?php $catagories = get_the_category(get_the_ID());   ?>
								<?php if(count($catagories)>=1): ?>
									in <?php foreach($catagories as $cat): ?><a href="<?php echo get_category_link($cat->term_id); ?>"><?php echo $cat->name; ?></a> ,<?php endforeach; ?>&nbsp; |
								<?php endif; ?>
								 &nbsp; by <?php the_author(); ?> &nbsp; | &nbsp; <?php comments_popup_link( 'Leave a Comment', '1 Comment', '% Comments' );?>
							</div>
							<div class="postcontent">
								<?php $pattern = "/<p[^>]*><\\/p[^>]*>/"; echo preg_replace($pattern, '', get_the_content()); ?>
								<div class="clear"></div>
							</div>
						</div>
						<div class="clear"></div>
					</div>
				</div>
				<!-- Right Sidebar -->
				<?php echo '<div class="four columns sidebar offset-by-one content">'; get_template_part('sidebar'); echo '</div>'; ?>
				<div class="sixteen columns bottomadjust"></div>
			<?php
			endwhile;
		endif;
	?>
<?php get_footer(); ?>