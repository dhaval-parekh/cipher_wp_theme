<?php
/** Short Code For NBA Form  **/
	// CODE : [nba_form]
add_action('init',function (){
		add_shortcode('nba_form','add_nba_membershipform');
	} 	
);
/**
 *	code that is run when is find the nba_form tag
 *	This function Ganarate Form at page and store data in the database
 */
function add_nba_membershipform(){
	global $wpdb;
	echo '<div class="form">';
	echo '<form name="frmNBA" id="frmNBA" method="post" enctype="multipart/form-data" >';
	//Some Inputs Here
		wp_nonce_field('nba_membership_form','nba_membership_info_nonce',true,true);
		nba_table_check();	
	?>
			<table>
				<tr>
					<td><label>Business Name</label></td>
					<td><input type="text" name="txtBusinessName" id="txtBusinessName" required placeholder="Enter Business Name"></td>
				</tr>
				<tr>
					<td><label>Business Address</label></td>
					<td><input type="text" name="txtBusinessAddress" id="txtBusinessAddress"  placeholder="Enter Business Address"></td>
				</tr>
				<tr>
					<td><label>Mailling Address</label>
						<br>
						[ if different ]</td>
					<td><input type="text" name="txtMaillingAddress" id="txtMaillingAddress"  placeholder="Enter Mailling Address"></td>
				</tr>
				<tr>
					<td><label>Contact Name</label></td>
					<td><input type="text" name="txtContactName" id="txtContactName" placeholder="Enter Contact Name" required></td>
				</tr>
				<tr>
					<td><label>Business Phone</label></td>
					<td><input type="tel" name="txtBusinessPhone" id="txtBusinessPhone" placeholder="Enter Business Phone No." required></td>
				</tr>
				<tr>
					<td><label>Email Address</label></td>
					<td><input type="email" name="txtEmailAddress" id="txtEmailAddress" placeholder="Enter Email Address" required></td>
				</tr>
				<tr>
					<td><label>Business Url</label></td>
					<td><input type="url" name="txtBusinessUrl" id="txtBusinessUrl" placeholder="Enter Business URL" ></td>
				</tr>
				<tr>
					<td><label>Image </label></td>
					<td><input type="file" name="txtImage" id="txtImage" placeholder="Upload a Image" required ></td>
				</tr>
				<tr>
					<td colspan="2"><label style="width:auto;">Description of your business (for Niwot’s NEW website) </label>
						<br/>
						<textarea name="txtDescription" id="txtDescription" cols="40" rows="5" style="resize:vertical;width:747px;" placeholder="Enter Description of your Business"></textarea> </td>
				</tr>
				<tr>
					<th colspan="2">Other Opportunities to Help</th>
				</tr>
				<tr>
					<td style="width:55px;"><span><input type="radio" id="rdiHelp1" name="rdiHelp1" value="1">Yes</span><br/><span><input type="radio" id="rdiHelp1" name="rdiHelp1" value="0" checked>No</span></td>
					<td style="width:365px;">I am interested in sponsoring the Rhythm on the Rails Concert Series. Please contact me with further information.</td>
				</tr>
				<tr>
					<td style="width:55px;"><span><input type="radio" id="rdiHelp2" name="rdiHelp2" value="1">Yes</span><br/><span><input type="radio" id="rdiHelp2" name="rdiHelp2" value="0" checked>No</span></td>
					<td style="width:365px;">I am interested in joining a committee and getting more involved. Please contact me with further information.</td>
				</tr>
				<tr>
					<td style="width:55px;"><span><input type="radio" id="rdiHelp3" name="rdiHelp3" value="1" >Yes</span><br/><span><input type="radio" id="rdiHelp3" name="rdiHelp3" value="0" checked>No</span></td>
					<td style="width:365px;">I am interested in serving as an executive team member in the future. Please contact me with further information.</td>
				</tr>
				<tr>
					<td style="width:55px;"><span><input type="radio" id="rdiHelp4" name="rdiHelp4" value="1" >Yes</span><br/><span><input type="radio" id="rdiHelp4" name="rdiHelp4" value="0" checked>No</span></td>
					<td style="width:365px;">I am interested in volunteering for projects when time and energy allow. Please feel free to contact me as those projects arise.</td>
				</tr>
				<tr>
					<td/>
					<td><input type="submit" name="btnSubmit" id="btnSubmit" value="Submit"></td>
				</tr>
			</table>
<?php
	echo '</form>';
	if(isset( $_REQUEST['nba_membership_info_nonce']) && isset($_REQUEST['btnSubmit']) &&  wp_verify_nonce($_REQUEST['nba_membership_info_nonce'],'nba_membership_form')){
		
		if(! function_exists('wp_handle_upload')){ require_once(ABSPATH.'wp-admin/includes/file.php'); }
		$uploadFile=$_FILES['txtImage'];
		$uploadOverrides = array('test_form' => false);
		//echo ABSPATH."<br>";
		$moveFile = wp_handle_upload($uploadFile,$uploadOverrides);
		//.print_r($moveFile);
		$imageUrl='';
		if($moveFile){
			$imageUrl=$moveFile['url'];
			//var_dump($movefile);
		}else{
			echo '<script> alert(" can\'t Upload File");</script>';
		}
	  	
		$qryInsert="INSERT INTO ".$wpdb->prefix."Niwot_NBA_Form 
			(BusinessName,BusineeAddress,MaillingAddress,ContactName,BusinessPhone,EmailAddress,BusinessUrl,ImageUrl,Description,Help1,Help2,Help3,Help4) 
			VALUES(
					'".$_REQUEST['txtBusinessName']."',
					'".$_REQUEST['txtBusinessAddress']."',
					'".$_REQUEST['txtMaillingAddress']."',
					'".$_REQUEST['txtContactName']."',
					".$_REQUEST['txtBusinessPhone'].",
					'".$_REQUEST['txtEmailAddress']."',
					'".$_REQUEST['txtBusinessUrl']."',
					'".$imageUrl."',
					'".$_REQUEST['txtDescription']."',
					".$_REQUEST['rdiHelp1'].",
					".$_REQUEST['rdiHelp2'].",
					".$_REQUEST['rdiHelp3'].",
					".$_REQUEST['rdiHelp4']."
				)";
		echo $qryInsert."<br>"; 
		if($wpdb->query($qryInsert)){
			echo '<script> alert("Your Request has Been Submited"); </script>';		
		}else{
			echo '<script> alert("Please Re-Enter the Data"); </script>';
		}
	}
	echo '</div>';
}
/**
 *	This function will fire when NBA Form will ganarate
 *	and will create table '[wordpress database prefix]Niwot_NBA_Form' if it is not exist
 */
function nba_table_check(){
	global $wpdb;
	$qryCreateTable="CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."Niwot_NBA_Form
					(
					FormId INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
					BusinessName VARCHAR(50) NOT NULL,
					BusineeAddress VARCHAR(1024),
					MaillingAddress VARCHAR(1024),
					ContactName VARCHAR(50),
					BusinessPhone NUMERIC(10) NOT NULL,
					EmailAddress VARCHAR(50) NOT NULL,
					BusinessUrl VARCHAR(512) ,
					ImageUrl VARCHAR(512),
					Description VARCHAR(512) ,
					Help1 INT DEFAULT 0,
					Help2 INT DEFAULT 0,
					Help3 INT DEFAULT 0,
					Help4 INT DEFAULT 0,
					IsActive INT DEFAULT 0,
					IsGolden INT DEFAULT 0
					);
				";
	return  $wpdb->query($qryCreateTable);
}


/***************** The code is For Admin Panal  *****************/

function nba_form_admin(){
	include('nba_form_admin.php');
}

function nba_form_admin_action(){
	//add_options_page('Request For Member','Request For Member',1,'NBAMemberRequest','nba_form_admin');
	  add_menu_page( 'Request For Member','Member Request', 'manage_options', 'NiwotOp', 'nba_form_admin', '',6); 
	//add_submenu_page( 'NiwotOp', 'Members', 'Members', 1,'Members', 'nba_form_admin');
}
add_action('admin_menu','nba_form_admin_action');
?>