<?php
/**
 *	Template Name: Blog Template
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
					<?php if(has_post_thumbnail(get_the_Id())){ echo '<div class="page-feature-image banner"><a href="'.get_the_permalink().'" title="'.get_the_title().'" >'; the_post_thumbnail();echo '</a></div>'; } ?>
					<div class="page-content">
						<?php
							$post_per_page = 5;
							$query_args = array('post_type'=>'post','posts_per_page'=>$post_per_page,);
							$query = new WP_Query($query_args);
							if($query->have_posts()):
								while($query->have_posts()): $query->the_post();
									?>
										<div class="eleven columns row alpha blogpost">
											<?php if(has_post_thumbnail(get_the_ID())): ?>
												<div class="eleven columns alpha blogimage">
													<a href="<?php the_permalink(); ?>" data-text="» Read More" class="hovering">
														<img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())); ?>" alt="" class="scale-with-grid" />
													</a>
												</div>
											<?php endif; ?>
											<div class="one column row alpha">
												<div class="blogdate">
													<div class="day"><?php the_time('d'); ?></div>
													<span><?php the_time('M Y')?></span></a></div>
											</div>
											<div class="nine columns row offset-by-one omega">
												<div class="blogtitle">
													<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
												</div>
												<?php $catagories = get_the_category(get_the_ID());   ?>
												<div class="postinfo">
													<span class="dateinfo"><?php the_date(); ?> &nbsp; | &nbsp; </span>
													<?php if(count($catagories)>=1): ?>
													in <?php foreach($catagories as $cat): ?><a href="<?php echo get_category_link($cat->term_id); ?>"><?php echo $cat->name; ?></a> ,<?php endforeach; ?>&nbsp; |
													<?php endif; ?>
													 &nbsp; by <?php the_author(); ?> &nbsp; | &nbsp; <?php comments_popup_link( 'Leave a Comment', '1 Comment', '% Comments' );?>
												</div>
												<div class="postcontent"><?php echo cropText(get_the_content(),256); ?><br/>
													<br/>
													<a href="<?php the_permalink(); ?>" class="link">&raquo; Read More</a></div>
											</div>
											<div class="clear"></div>
										</div>
									<?php
								endwhile;
							endif;
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