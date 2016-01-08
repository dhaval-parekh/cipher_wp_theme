<?php
// Addinting  Action hook widget_init 
add_action('widgets_init','register_custom_widget');

/**
 *	Register New Custome Widget
 */
function register_custom_widget(){
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
			$shortCode=$instance['shortcode'];		
		}else{
			$domain='cipher_print_shortcode';
			$shortCode=__('',$domain);
		}
		
		echo '<p><label>Enter Short Code = </label>';
			echo '<input type="text" name="'.$this->get_field_name('shortcode').'" id="'.$this->get_field_name('shortcode').'" value="'.esc_attr($shortCode).'" placeholder="Enter ShortCode">';
		echo '</p>';
	}
	
	//widget update
		// function to update information
	public function update($new_instance,$old_instance){
		$instance=$old_instance;
		$instance['shortcode']=(! empty($new_instance['shortcode']))? strip_tags($new_instance['shortcode']) :'';
		return $new_instance;
	}
	
	//widget Display
		//function to tall how to dispaly information in webpage 
	public function widget($args,$instance){
		$shortcode=$instance['shortcode'];
		echo $args['before_widget'];
		echo do_shortcode($shortcode);
		echo $args['after_widget'];
	}
}

?>