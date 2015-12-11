<?php
// Taxomony Type for the Service
if(! function_exists('cipher_service_custom_taxonomy')):
	function cipher_service_custom_taxonomy(){
		$labels = array(
			'name'                       => _x( 'Service Type', 'taxonomy general name' ),
			'singular_name'              => _x( 'Service Type', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Service' ),
			'popular_items'              => __( 'Popular' ),
			'all_items'                  => __( 'All Service Type' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Service Type' ),
			'update_item'                => __( 'Update Service Type' ),
			'add_new_item'               => __( 'Add New Service Type' ),
			'new_item_name'              => __( 'New Service Type Name' ),
			'separate_items_with_commas' => __( 'Separate Service Type with commas' ),
			'add_or_remove_items'        => __( 'Add or Remove Service Type' ),
			'choose_from_most_used'      => __( 'Choose from the most used Service Type' ),
			'not_found'                  => __( 'No Service Type found.' ),
			'menu_name'                  => __( 'Service Type' )
		);
		$args = array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'service_type' ),
		);
		register_taxonomy( 'service_type', 'project', $args );
		
	}
endif;
add_action( 'init', 'cipher_service_custom_taxonomy');

/* Post Type */
if(! function_exists('cipher_service_post_type')){
	function cipher_service_post_type(){
		$labels = array(
			'name'               => _x( 'Service', 'post type general name' ),
			'singular_name'      => _x( 'Service', 'post type singular name' ),
			'add_new'            => _x( 'Add New', 'Service' ),
			'add_new_item'       => __( 'Add New Service' ),
			'edit_item'          => __( 'Edit Service' ),
			'new_item'           => __( 'New Service' ),
			'all_items'          => __( 'All Service' ),
			'view_item'          => __( 'View Service' ),
			'search_items'       => __( 'Search Service' ),
			'not_found'          => __( 'No Service found' ),
			'not_found_in_trash' => __( 'No Service found in the Trash' ), 
			'parent_item_colon'  => '',
			'menu_name'          => 'Services'
		);
		$args = array(
			'labels'        => $labels,
			'description'   => 'Holds our Service and Service specific data',
			'public'        => true,
			'menu_position' => 20,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
			'has_archive'   => true,
			'taxonomies'=>array('service_type')
		);
		register_post_type( 'service', $args );	
	}
}
add_action( 'init', 'cipher_service_post_type');

/* Meta Box */
add_action('add_meta_boxes','our_service_meta_box');

function our_service_meta_box(){
	 add_meta_box('our_service', __('Service Information', 'cipher'), 'service_meta_action', 'service', 'advanced', 'high' );//
}

function service_meta_action($post){
	$project = array();
	$project['price'] = get_post_meta($post->ID, 'price', true); 
	$project['duration'] = get_post_meta($post->ID, 'duration', true); 
	$project['description'] = get_post_meta($post->ID, 'description', true);
	$project['requirement'] = get_post_meta($post->ID, 'requirement', true);
	?>
	<div class="row">
		<div class="form-group">
			<label class="form-label">Prices</label>
			<div class="form-control-container"><input type="number" name="price" class="form-control" value="<?php echo $project['price']; ?>"></div>	<div class="clear"></div>
		</div>
		<div class="form-group">
			<label class="form-label">Duration</label>
			<div class="form-control-container"><input type="text" name="duration" class="form-control" value="<?php echo $project['duration']; ?>"></div><div class="clear"></div>
		</div>
		<div class="form-group">
			<label class="form-label">Description</label>
			<div class="form-control-container"><textarea name="description" class="form-control" ><?php echo $project['description']; ?></textarea></div><div class="clear"></div>
		</div>
		<div class="form-group">
			<label class="form-label">Requirement</label>
			<div class="form-control-container"><textarea name="requirement" class="form-control" ><?php echo $project['requirement']; ?></textarea></div><div class="clear"></div>
		</div>
	</div>
	<?php
}

// Save Post type 
add_action( 'save_post', 'save_service_info' );
function save_service_info($post_ID)
{
    global $post;
    if(isset($_POST))
    {
        if(isset($_POST['price']) && is_numeric($_POST['price']))
        {
            update_post_meta( $post_ID, 'price', strip_tags($_POST['price']) );
        }
        if(isset($_POST['duration']))
        {
            update_post_meta( $post_ID, 'duration', strip_tags($_POST['duration']) );
        }
        if(isset($_POST['description']))
        {
            update_post_meta( $post_ID, 'description', mysql_real_escape_string(strip_tags($_POST['description'])) );
        }
        if(isset($_POST['requirement']))
        {
            update_post_meta( $post_ID, 'requirement', mysql_real_escape_string(strip_tags($_POST['requirement'])) );
        }
    }
}