<?php
add_action('init',add_shortcode('cipher_contact','cipher_contact'));

if(! function_exists('cipher_contact')):
	function cipher_contact(){
		ob_start();
		?>
			 <div id="contactus">
				 <form id="contactform" method="post" action="#">
					<input type="text" name="name" id="reply_name" class="requiredfield" onFocus="if(this.value == 'Name *') { this.value = ''; }" onBlur="if(this.value == '') { this.value = 'Name *'; }" value="<?php echo isset($_POST['name'])?$_POST['name']:'Name *'?>"/>
					<input type="text" name="email" id="reply_email" class="requiredfield last" onFocus="if(this.value == 'Email *') { this.value = ''; }" onBlur="if(this.value == '') { this.value = 'Email *'; }" value="<?php echo isset($_POST['email'])?$_POST['email']:'Email *'?>"/>
					<input type="text" name="skype" id="reply_address" class="requiredfield" onFocus="if(this.value == 'Skype *') { this.value = ''; }" onBlur="if(this.value == '') { this.value = 'Skype *'; }" value="<?php echo isset($_POST['skype'])?$_POST['skype']:'Skype *'?>"/>
					
					<input type="text" name="phone" id="reply_website" class="last " onFocus="if(this.value == 'Phone') { this.value = ''; }" onBlur="if(this.value == '') { this.value = 'Phone'; }" value="<?php echo isset($_POST['phone'])?$_POST['phone']:'Phone'?>"/>
					<textarea name="message" id="reply_message" class="requiredfield" style="resize:vertical;" onFocus="if(this.value == 'Message *') { this.value = ''; }" onBlur="if(this.value == '') { this.value = 'Message *'; }"><?php echo isset($_POST['message'])?$_POST['message']:'Message *'?></textarea>
					<button type="submit" name="send">Send Message</button>
					<span class="customerrormessage"></span>
					<span class="errormessage">Error! Please correct marked fields.</span>
					<span class="successmessage">Message send successfully!</span>
					<span class="sendingmessage">Sending...</span>  
				 </form>
			  </div>
			  <div class="clear"></div>
		<?php
		$content = ob_get_contents();
		ob_end_clean();
		return $content;;
	}
endif;


// Footer Contact Short code 
add_action('init',add_shortcode('cipher_sidebar_contact','cipher_sidebar_contact'));


if(! function_exists('cipher_sidebar_contact')){
	function cipher_sidebar_contact(){
		ob_start();
		?>
			<form id="quickcontact" method="post" action="#">
				<input type="text" name="name" id="quickcontact_name" class="requiredfield" onFocus="if(this.value == 'Name *') { this.value = ''; }" onBlur="if(this.value == '') { this.value = 'Name *'; }" value='<?php echo isset($_POST['name'])?$_POST['name']:'Name *'?>'/>
				<input type="text" name="skype" id="quickcontact_email" class="requiredfield" onFocus="if(this.value == 'Skype *') { this.value = ''; }" onBlur="if(this.value == '') { this.value = 'Skype *'; }" value='<?php echo isset($_POST['skype'])?$_POST['skype']:'Skype *'?>'/>
				<textarea name="message" id="quickcontact_message" class="requiredfield" style="resize:vertical;" onFocus="if(this.value == 'Message *') { this.value = ''; }" onBlur="if(this.value == '') { this.value = 'Message *'; }"><?php echo isset($_POST['message'])?$_POST['message']:'Message *'?></textarea>
				<button type="submit" name="send">Send</button>
				<span class="customerrormessage"></span>
				<span class="errormessage">Error! Please correct marked fields.</span>
				<span class="successmessage">Message send successfully!</span>
				<span class="sendingmessage">Sending...</span>      
			</form>
		<?php	
		$content = ob_get_contents();
		ob_end_clean();
		//echo $content;
		return $content;
	}	
}



add_action('wp_ajax_nopriv_cipher_contact_form_submit','cipher_contact_form_submit');
add_action('wp_ajax_cipher_contact_form_submit','cipher_contact_form_submit');
if(! function_exists('cipher_contact_form_submit')):
	function cipher_contact_form_submit(){
		global $wpdb;
		$table_name = $wpdb->prefix.'cipher_contact_request_master';
		$response = array();
		cipher_create_contact_form_table();
		header('Content-type: application/json');
		$post = $_POST;
		$response['status'] = 200;
		$response['message'] = 'Request has been submited.! We will reach you shortlly';

		$requvired = array(array('name','text'),array('skype','text'),array('message','text'));
		if(! validateParam($requvired,$post)){
			$response['status'] = 400;
			$response['message'] = 'Please check your information fields.';
			header('HTTP/1.1 400 Please check your information fields.');
			die(json_encode($response));	
		}
		$post['name'] = mysql_real_escape_string($post['name']);
		$post['email'] = isset($post['email'])?$post['email']:'';
		$post['phone'] = isset($post['phone'])&&is_numeric($post['phone'])?$post['phone']:'';
		$post['message'] = mysql_real_escape_string($post['message']);
		
		$query = "INSERT INTO ".$table_name." (contact_id,name,email,skype,phone,message,request_date) VALUES
				(DEFAULT,'".$post['name']."','".$post['email']."','".$post['skype']."','".$post['phone']."','".$post['message']."',DEFAULT)";
		if(!$wpdb->query($query)){
			$response['status'] = 420;
			$response['message'] = 'Please Resubmit data.';
			header('HTTP/1.1 400 Please Resubmit data.');
			die(json_encode($response));	
		}
		
		//$response['payload'] = $post;
		die(json_encode($response));
	}
endif;

if(! function_exists('cipher_create_contact_form_table')):
	function cipher_create_contact_form_table(){
		global $wpdb;
		$table_name = $wpdb->prefix.'cipher_contact_request_master';
		$query  = "CREATE TABLE IF NOT EXISTS ".$table_name." ( ";
		$query .= "contact_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, ";
		$query .= "name VARCHAR(256), ";
		$query .= "email VARCHAR(256), ";
		$query .= "skype VARCHAR(256), ";
		$query .= "phone NUMERIC(15), ";
		$query .= "message VARCHAR(1024),";
		$query .= "request_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ";
		$query .= "";
		$query .= " );";
		return  $wpdb->query($query);
	}
endif;