<?php
function cipher_register_latest_post_widget(){
	if(function_exists('register_widget')){
		register_widget('cipher_latest_post_widget');
	}
}
add_action('widgets_init','cipher_register_latest_post_widget');

class cipher_latest_post_widget extends Wp_Widget{
	
	public function  __construct(){
		$this->WP_Widget('cipher_latest_post_widget','Cipher Latest Post');
	}
	
	public function form($instance){
		$domain = 'cipher_latestpost';
		$post_type_list = get_post_types();
		$title = isset($instance['title'])?$instance['title']:	$title = __('',$domain);
		$post_type = isset($instance['post_type'])?$instance['post_type']:$post_type = __('post',$domain);
		$number = isset($instance['number'])?$instance['number']:	$number = __('',$domain);
		
		echo '<p><label><b>Title :</b></label>';
			echo '<input type="text" name="'.$this->get_field_name('title').'" value = "'.esc_attr($title).'"  style="width:100%;" placeholder="Enter Title" >';
		echo '</p>';
		
		echo '<p><label><b>Post Type :</b></label>';
			echo '<select name="'.$this->get_field_name('post_type').'" style="width:100%;">';
				foreach($post_type_list as $post){
					if($post_type == $post){
						echo '<option value="'.$post.'" selected>'.$post.'</option>';
					}else{
						echo '<option value="'.$post.'">'.$post.'</option>';	
					}
				}
			echo '</select>';
			//echo '<input type="text" name="'.$this->get_field_name('title').'" value = "'.esc_attr($title).'"  style="width:100%;" placeholder="Enter Title" >';
		echo '</p>';
		
		echo '<p><label><b>Number :</b></label>';
			echo '<input type="number" min="0" step="3" name="'.$this->get_field_name('number').'" value = "'.esc_attr($number).'"  style="width:100%;" placeholder="Number of post" >';
		echo '</p>';
		
	}
	
	public function update($new_instance, $old_instance){
		
		$instance = $old_instance;
		$instance['title'] = (! empty($new_instance['title']))?strip_tags($new_instance['title']):'Latest Post';
		$instance['post_type'] = (! empty($new_instance['post_type']))?strip_tags($new_instance['post_type']):'post';
		$instance['number'] = (! empty($new_instance['number']))?strip_tags($new_instance['number']):'3';
		return $instance;
	}

	public function widget($args,$instance){
		echo $args['before_widget'];
		echo $args['before_title'].$instance['title'].$args['after_title'];
		
		$query_args = array('post_type'=>$instance['post_type'],'posts_per_page'=>$instance['number'],);
		$query = new WP_Query($query_args);
		if($query->have_posts()){
			echo '<div class="widget_portfolio">';
				echo '<ul>';
					while($query->have_posts()){ $query->the_post();
						echo '<li class="clearfix"><a href="'.get_the_permalink().'" title="'.get_the_title().'" class="borderhover">';
							if(has_post_thumbnail(get_the_ID())){
								the_post_thumbnail('project-post-thumbnail');
							}else{
								echo '<img src="'.get_template_directory_uri().'/images/thumbs/pop_folio6.jpg">';
							}
						echo '</a></li>';
					}
				echo '</ul>';
			echo '</div>';
		}
		wp_reset_query();
		echo $args['after_widget'];
	}
}
