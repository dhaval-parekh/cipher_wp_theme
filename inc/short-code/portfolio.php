<?php
// Add Short Code
add_action('init',function(){ add_shortcode('cipher_portfolio','cipher_protfolio'); });

if(! function_exists('cipher_protfolio')):
	function cipher_protfolio($args){
			ob_start();
			$post_types = get_post_types();
			$args['post_type'] = trim($args['post_type']);
			if(!( isset($args['post_type']) && (! empty($args['post_type'])) && in_array($args['post_type'],$post_types) )){ return false; }
			$request_post_type = $args['post_type'];
			$terms = array();
			$taxonomies_list = array();
			$taxonomies_list = get_object_taxonomies($request_post_type);
			$terms_args = array('orderby'=> 'id', 'order'=> 'ASC');
			//$taxonomies_list = [$taxonomies_list[0]];
			foreach($taxonomies_list as $taxonomy):
				$terms =  array_merge($terms,get_terms('service_type',$terms_args)); 
			endforeach;
			
			// portfolio style 
			$portfolio_class = array();
			$portfolio_class['container'] =  'portfolio4column';
			$portfolio_class['teasers'] = 'teasers';
			$portfolio_class['columns'] = 'four';
			if( isset($args['type']) && $args['type'] == 'large'){
				$portfolio_class['container'] =  'portfolio2column';
				$portfolio_class['teasers'] = 'teasers_large';
				$portfolio_class['columns'] = 'eight';
			}
			
		?>
		<div class="row <?php echo $portfolio_class['container']; ?>">
			<?php if(isset($args['title']) && (!empty($args['title']))) : ?>
			<div class="sixteen columns row divide">
				<h3 class="titledivider"><?php echo $args['title']; ?></h3>
				<?php if(isset($args['ancher'],$args['ancher_href']) && (!empty($args['ancher'])) && (!empty($args['ancher_href'])) ): ?>
					<div class="rightlink"><a href="<?php echo $args['ancher_href']; ?>" class="titlelink">&raquo; <?php echo $args['ancher']; ?></a></div>
				<?php endif; ?>
				<div class="dividerline"></div>
			</div>
			<?php endif; ?>
			<?php 
				$nav_lists = array();
				foreach($terms as $cat):
					$nav_lists[$cat->slug] = $cat->name;
				endforeach;
			?>
			<!-- Portfolio Item Label -->
				<div class="sixteen columns row portfolio_filter">
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
			<div class="sixteen columns row <?php echo $portfolio_class['teasers']; ?> portfolio">
				<?php $args = ['post_type'=>$args['post_type']]; $query = new WP_Query($args); ?>
				<?php if($query->have_posts()): ?>
					<?php 
						while($query->have_posts()): $query->the_post(); 
							$catagories = array();
							foreach($taxonomies_list as $taxonomy):
								$catagories = array_merge($catagories, get_the_terms($post->ID,$taxonomy));
							endforeach;
							$subline = '';
							$class = '';
							
							foreach($catagories as $cat){ $class.=' '.$cat->slug.' '; $subline.=$cat->name.', '; }
							$subline = rtrim(trim($subline),',');
							?>
							<div class="<?php echo $portfolio_class['columns']; ?> columns teaser all-group <?php echo $class; ?> ">
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
		</div>
		<?php
		wp_reset_query();
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
		
	}
endif;
