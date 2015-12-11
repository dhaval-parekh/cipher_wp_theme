<?php
function cipher_register_search_widget(){
	if(function_exists('register_widget')){
		register_widget('cipher_search_widget');
	}
}
add_action('widgets_init','cipher_register_search_widget');

class cipher_search_widget extends Wp_Widget{
	
	public function  __construct(){
		$this->WP_Widget('cipher_search_widget','Cipher Search');
	}
	
	public function form($instance){
		$domain = 'cipher_search';
		if(isset($instance['title'])){
			$title = $instance['title'];
		}else{
			$title = __('',$domain);	
		}
		echo '<p><label><b>Title :</b></label>';
			echo '<input type="text" name="'.$this->get_field_name('title').'" value = "'.esc_attr($title).'"  style="width:100%;" placeholder="Enter Title" >';
		echo '</p>';
	}
	
	public function update($new_instance, $old_instance){
		//return $new_instance;
		$instance = $old_instance;
		$instance['title'] = (isset($new_instance['title']))?strip_tags($new_instance['title']):'Site Search';
		return $instance;
	}

	public function widget($args,$instance){
		echo $args['before_widget'];
			echo $args['before_title'].$instance['title'].$args['after_title'];
			echo '<div id="search">';
				echo '<form class="searchform" action="'. get_site_url().'" method="get">';
					echo '<input type="text" name="s" id="s" value="Enter Search..." onblur="if(this.value == \'\') { this.value = \'Enter Search...\'; }" onfocus="if(this.value == \'Enter Search...\') { this.value = \'\'; }" >';
				echo '</form>';
			echo '</div>';
		echo $args['after_widget'];
	}
}
