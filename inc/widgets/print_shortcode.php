<?php
// Addinting  Action hook widget_init 
add_action('widgets_init','cipher_register_custom_widget');

/**
 *	Register New Custome Widget
 */
function cipher_register_custom_widget(){
	if(function_exists('register_widget')){
			register_widget('cipher_print_shortcode');
	} 
}

// Main Widget Class
class cipher_print_shortcode extends WP_Widget{
	
	//Constructor
	public function __construct(){
		$this->WP_Widget('cipher_print_shortcode','Print Short Code');
	}
	
	//widget form creation
		// function to Disign widget with HTMl code
		// Display at admin side
	public function form($instance){
		
		if(isset($instance['shortcode'])){
			$title=$instance['title'];		
			$shortCode=$instance['shortcode'];		
		}else{
			$domain='cipher_print_shortcode';
			$shortCode=__('',$domain);
			$title = __('',$domain);
		}
		echo '<p><label>Title</label>';
			echo '<input type="text" class="widefat" name="'.$this->get_field_name('title').'" id="'.$this->get_field_name('title').'" value="'.esc_attr($title).'" placeholder="Enter Title">';
		echo '</p>';
		echo '<p><label>Enter Short Code</label>';
			echo '<input type="text" class="widefat" name="'.$this->get_field_name('shortcode').'" id="'.$this->get_field_name('shortcode').'" value="'.esc_attr($shortCode).'" placeholder="Enter ShortCode">';
		echo '</p>';
	}
	
	//widget update
		// function to update information
	public function update($new_instance,$old_instance){
		$instance=$old_instance;
		$instance['title']=(! empty($new_instance['title']))? strip_tags($new_instance['title']) :'';
		$instance['shortcode']=(! empty($new_instance['shortcode']))? strip_tags($new_instance['shortcode']) :'';
		return $instance;
	}
	
	//widget Display
		//function to tall how to dispaly information in webpage 
	public function widget($args,$instance){
		$title=$instance['title'];
		$shortcode=$instance['shortcode'];
		echo $args['before_widget'];
		if(isset($title)&& (!empty($title))){
			echo $args['before_title'];
			echo $title;
			echo $args['after_title'];
		}
		echo do_shortcode($shortcode);
		echo $args['after_widget'];
	}
}

?>