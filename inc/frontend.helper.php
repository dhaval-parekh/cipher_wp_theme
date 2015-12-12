<?php

// Used in blog.template.php file 
if(! function_exists('render_blog_list')):
	function render_blog_list($query_args){
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
	}
endif;