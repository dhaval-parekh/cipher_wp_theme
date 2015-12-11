<?php
// Add Short Code
add_action('init',function(){ add_shortcode('cipher_portfolio','cipher_protfolio'); });

if(! function_exists('cipher_protfolio')):
	function cipher_protfolio($args){
			$post_types = get_post_types();
			$args['post_type'] = trim($args['post_type']);
			if(!( isset($args['post_type']) && (! empty($args['post_type'])) && in_array($args['post_type'],$post_types) )){ return false; }
			
			$terms_args = array('orderby'=> 'id', 'order'=> 'ASC');
			
			//$terms =  get_terms('service_type',$terms_args); 			
		?>
			<?php if(isset($args['title']) && (!empty($args['title']))) : ?>
			<div class="sixteen columns row divide">
				<h3 class="titledivider"><?php echo $args['title']; ?></h3>
				<?php if(isset($args['ancher'],$args['ancher_href']) && (!empty($args['ancher'])) && (!empty($args['ancher_href'])) ): ?>
					<div class="rightlink"><a href="<?php echo $args['ancher_href']; ?>" class="titlelink">&raquo; <?php echo $args['ancher']; ?></a></div>
				<?php endif; ?>
				<div class="dividerline"></div>
			</div>
			<?php endif; ?>
			<?php $args = ['post_type'=>$args['post_type']]; $query = new WP_Query($args); ?>
			<?php 
				$nav_lists = array();
				while($query->have_posts()): $query->the_post();
					$catagories = (array) get_the_category(get_the_ID()); 
					foreach($catagories as $cat):
						$nav_lists[$cat->slug] = $cat->name;
					endforeach;
				endwhile;
			?>
			<!-- Portfolio Item Label -->
				<div class="sixteen columns row portfolio_filter">
				<?php //var_dump($post_types); ?>
					<ul>
						<li><a class="portfolio_selector" data-group="all-group" href="#">All Projects</a><span>|</span></li>
						<?php 
							foreach($nav_lists as $key=>$item):
								echo '<li><a class="portfolio_selector" data-group="'.$key.'" href="#">'.$item.'</a><span>|</span></li>';
							endforeach;
						?>
					</ul>
				</div>
			<!-- Portfolio Item -->
			<div class="sixteen columns row teasers portfolio">
				<?php $args = ['post_type'=>$args['post_type']]; $query = new WP_Query($args); ?>
				<?php if($query->have_posts()): ?>
					<?php 
						while($query->have_posts()): $query->the_post(); 
							$catagories = (array) get_the_category(get_the_ID()); 
							$subline = '';
							$class = '';
							foreach($catagories as $cat){ $class.=' '.$cat->slug.' '; $subline.=$cat->name.', '; }
							?>
							<div class="four columns teaser all-group <?php echo $class; ?> ">
								<?php if(has_post_thumbnail(get_the_ID())): ?>
									<a href="<?php the_permalink(); ?>" data-text="» Read More" class="hovering"><?php the_post_thumbnail('portfolio-thumbnail'); ?></a>
								<?php else: ?>
									<a href="<?php the_permalink(); ?>" data-text="» Read More" class="hovering"><img src="<?php echo get_template_directory_uri(); ?>/images/thumbs/project-holder.png" alt="<?php the_title(); ?>" class="scale-with-grid" /></a>
								<?php endif; ?>
								<div class="pluswrap"> <a href="<?php the_permalink(); ?>" class="bigplus"></a>
									<div class="topline"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
									<div class="subline"><?php echo $subline; ?></div>
								</div>
							</div>
					<?php endwhile; ?>
				<?php endif; ?>
				
			</div>
		<?php
		wp_reset_query();
	}
endif;
