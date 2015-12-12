<?php
/**	Add Custome Taxonomy Type for Custome Posts Type	**/
if(! function_exists('cipher_project_custom_taxonomy')):
	// Project Taxobomy
	function cipher_project_custom_taxonomy(){
		$labels = array(
			'name'                       => _x( 'Project Type', 'taxonomy general name' ),
			'singular_name'              => _x( 'Project Type', 'taxonomy singular name' ),
			'search_items'               => __( 'Search Project' ),
			'popular_items'              => __( 'Popular' ),
			'all_items'                  => __( 'All Project Type' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Project Type' ),
			'update_item'                => __( 'Update Project Type' ),
			'add_new_item'               => __( 'Add New Project Type' ),
			'new_item_name'              => __( 'New Project Type Name' ),
			'separate_items_with_commas' => __( 'Separate Project Type with commas' ),
			'add_or_remove_items'        => __( 'Add or Remove Project Type' ),
			'choose_from_most_used'      => __( 'Choose from the most used Project Type' ),
			'not_found'                  => __( 'No Project Type found.' ),
			'menu_name'                  => __( 'Project Type' )
		);
		$args = array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'project_type' ),
		);
		register_taxonomy( 'project_type', 'project', $args );
	}
	
endif;
add_action( 'init', 'cipher_project_custom_taxonomy');

/**	Custome Post Type 	**/
if(!function_exists('cipher_project_post_type')):
	// Project Type Post
	function cipher_project_post_type(){
		$labels = array(
			'name'               => _x( 'project', 'post type general name' ),
			'singular_name'      => _x( 'project', 'post type singular name' ),
			'add_new'            => _x( 'Add New', 'Project' ),
			'add_new_item'       => __( 'Add New Project' ),
			'edit_item'          => __( 'Edit Project' ),
			'new_item'           => __( 'New Project' ),
			'all_items'          => __( 'All Project' ),
			'view_item'          => __( 'View Projects' ),
			'search_items'       => __( 'Search Project' ),
			'not_found'          => __( 'No Project found' ),
			'not_found_in_trash' => __( 'No Project found in the Trash' ), 
			'parent_item_colon'  => '',
			'menu_name'          => 'Projects'
		);
		$args = array(
			'labels'        => $labels,
			'description'   => 'Holds our Project and Project specific data',
			'public'        => true,
			'menu_position' => 20,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
			'has_archive'   => true,
			'taxonomies'=>array('project_type')
		);
		register_post_type( 'project', $args );	
	}
endif;

add_action( 'init', 'cipher_project_post_type');

/**	Add Meta box to 	**/

add_action('add_meta_boxes', 'our_project_meta_box');
function our_project_meta_box(){
	add_meta_box('our_project', __('Project Information', 'cipher'), 'project_meta_action', 'project', 'side', 'high' );
}
function project_meta_action($post) {  
    		$project = array();
		$project['price'] = get_post_meta($post->ID, 'price', true); 
		$project['client'] = get_post_meta($post->ID, 'client', true); 
		$project['demolink'] = get_post_meta($post->ID, 'demolink', true);
		$project['status'] = get_post_meta($post->ID, 'status', true);
	?>
	<div class="row">
		<div class="form-group">
			<label class="form-label">Prices</label>
			<div class="form-control-container"><input type="number" name="price" class="form-control" value="<?php echo $project['price']; ?>"></div><div class="clear"></div>
		</div>
		<div class="form-group">
		<?php
			// References = https://codex.wordpress.org/Function_Reference/get_users
			$user_args = array('role'=> 'client',);
			$user_list = get_users($user_args);
			$users = array();
			foreach($user_list as $user):
				$users[$user->ID]['id'] = $user->ID;
				$users[$user->ID]['name'] = $user->data->display_name;
				$users[$user->ID]['email'] = $user->data->user_email;
			endforeach
			
			
		?>
			<label class="form-label">Client</label>
			<div class="form-control-container">
				<select name="client" required class="form-control">
					<option selected disabled>Select Client</option>
					<?php
						foreach($users as $user):
							$selected = $user['id']==$project['client']?' selected ':'';
							echo '<option value="'.$user['id'].'" title="'.$user['email'].'" '.$selected.'>'.$user['name'].'</option>';
						endforeach;
					?>
				</select>
				<?php /* ?><input type="text" name="client" class="form-control" value="<?php echo $project['client']; ?>"><?php */ ?>
			</div>	
			<div class="clear">
		</div>
		</div>
		<div class="form-group">
			<label class="form-label">Demo Link</label>
			<div class="form-control-container"><input type="url" name="demolink" class="form-control" value="<?php echo $project['demolink']; ?>"></div>	<div class="clear"></div>
		</div>
		<div class="form-group">
			<label class="form-label">Status</label>
			<div class="form-control-container">
				<?php $status = ['Pendding','Running','Hold','Revision','Complated','Cancled']; ?>
				<select name="status" class="form-control">
					<?php
						foreach($status as $option):
							if($project['status'] == $option):
								echo '<option value="'.$option.'" selected >'.$option.'</option>';	
							else:
								echo '<option value="'.$option.'">'.$option.'</option>';	
							endif;
						endforeach;
					?>
				</select> 
			</div><div class="clear"></div>
		</div>
	</div>
<?php 

}


add_action( 'save_post', 'save_project_info' );
function save_project_info($post_ID)
{
    global $post;
    if(isset($_POST))
    {
        if(isset($_POST['price']) && is_numeric($_POST['price']))
        {
            update_post_meta( $post_ID, 'price', strip_tags($_POST['price']) );
        }
        if(isset($_POST['client']))
        {
            update_post_meta( $post_ID, 'client', strip_tags($_POST['client']) );
        }
        if(isset($_POST['demolink']))
        {
            update_post_meta( $post_ID, 'demolink', strip_tags($_POST['demolink']) );
        }
        if(isset($_POST['status']))
        {
            update_post_meta( $post_ID, 'status', strip_tags($_POST['status']) );
        }
    }
}