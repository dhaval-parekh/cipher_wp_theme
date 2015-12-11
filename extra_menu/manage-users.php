<?php
/**  New Short Code For Manage Client  **/
/**  For User Login, Sign Up, Manage Property  **/
add_action('init',function(){
	add_shortcode('manage-users','manageUsers');
});

$url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$url=truncateQueryString('action',$url);
$url=truncateQueryString('pid',$url);
//$url=truncateQueryString('search',$url);

if(count($_GET)==0){
	$queryStrStart="?";
}else{
	if(isset($_GET['action']) && count($_GET)==1){
		$queryStrStart="?";	
	}else{
		$queryStrStart="&";	
	}	
}

/** Property Manage File import **/
require('manage-property.php');
require('display-property.php');

/** Functional Area**/
function logOut(){
	global $url;

	if(isset($_REQUEST['action']) && $_REQUEST['action']=='logout' ){
		unset($_SESSION['UserId']);
		echo '<script>window.location="'.$url.'";</script>';
		//header('Location:'.$url);
	}
}
function manageUsers(){
	global $wpdb;
	global $url,$queryStrStart;
	?>
	<script type="text/javascript">
		function manageForm(e){
			var formName = jQuery(e).attr('for');
			jQuery('#signup').addClass('display-none');
			jQuery('#login').addClass('display-none');
			jQuery('#'+formName).removeClass('display-none');
		}
	</script>
	<?php
	createUserTable();
	// if User SESSION is not set than show LOGIN, and Sign Up Form 
	
	if(! isset($_SESSION['UserId'])){
		createSignUpForm();
		createLoginForm();
	}else{
		
		logOut();
		$userId=$_SESSION['UserId'];
		
		echo '<div class="row-1" style="text-align:right">
				<a href="'.$url.'">Profile</a> | 
				<a href="'.$url.$queryStrStart.'action=manage">Manage Property</a> | 
				<a href="'.$url.$queryStrStart.'action=add">Add Property</a> | 
				<a href="'.$url.$queryStrStart.'action=logout">Log Out</a>
			</div>';
		
		if(isset($_REQUEST['action']) && $_REQUEST['action']=="add"){
			proprty_manage_form();
			
		}elseif(isset($_REQUEST['action']) && $_REQUEST['action']=="manage"){
			user_property_display($_SESSION['UserId']);
			
		}elseif(isset($_REQUEST['action']) && $_REQUEST['action']=="update" && isset($_REQUEST['pid'])){
			proprty_manage_form($_REQUEST['pid']);
			
		}elseif(isset($_REQUEST['action']) && $_REQUEST['action']=="delete" && isset($_REQUEST['pid'])){
			user_property_delete($_REQUEST['pid']);
		}else{
			createSignUpForm( $userId);	
		}
	}
}
function createLoginForm(){
	global $wpdb,$url;
	echo '<div id="login" class="form display-none">';
	echo '<a href="javascript:"  for="signup" onClick="manageForm(this)">signup</a>';
		echo '<form name="frmLogin" id="frmLogin" method="post" enctype="multipart/form-data"><center>';
			wp_nonce_field('user-login','user-login-nonce',true,true);
		?>
			<table style="width:auto;">
				<tr>
					<td><label for="txtUserName">Email Address</label></td>
					<td><input type="text" name="txtUserName" required></td>
				</tr>
				<tr>
					<td><label for="txtPass">Password</label></td>
					<td><input type="password" name="txtPass" required></td>
				</tr>
				<tr>
					<td/>
					<td><input type="submit" name="btnLogin" value="Login"></td>
				</tr>
			</table>
		<?php
		echo '</center></form>';
		if(isset($_REQUEST['btnLogin']) && $_REQUEST['btnLogin']=='Login' && isset($_REQUEST['user-login-nonce']) && wp_verify_nonce($_REQUEST['user-login-nonce'],'user-login') ){
			$qrySelect="SELECT UserId, Email FROM ".$wpdb->prefix."UserMaster WHERE Email='".$_REQUEST['txtUserName']."' AND Password='".$_REQUEST['txtPass']."' ";
			//echo $qrySelect."<br>";
			$Result=$wpdb->get_results($qrySelect);
			if (count($Result)==1){
				$userDetail=$Result[0];
				$_SESSION['UserId']=$userDetail->UserId;
				echo '<script>window.location="'.$url.'";</script>';
				//header('Location: '.$url);
				
			}else{
				echo '<script> alert("Invalid User Name Or Password"); </script>';	
			}
		}
	echo '</div>';
}


function createSignUpForm( $userid=false){
	global $wpdb;
	createUserTable();
	if( isset($_REQUEST['btnUpdate']) && $_REQUEST['btnUpdate']="Update" && isset($_REQUEST['user_signup-form_nonce']) && wp_verify_nonce($_REQUEST['user_signup-form_nonce'],'user_signup-form')):
		
		$qryuserDetailUpdate="UPDATE ".$wpdb->prefix."UserMaster SET
							Email='".$_REQUEST['txtEmail']."',
							Password='".$_REQUEST['txtPassword']."',
							FirstName='".$_REQUEST['txtFirstName']."',
							LastName='".$_REQUEST['txtLastName']."',
							Agency='".$_REQUEST['txtAgency']."',
							AgencyAddress='".$_REQUEST['txtAgencyAddress']."',
							City='".$_REQUEST['txtCity']."',
							State='".$_REQUEST['drpState']."',
							Zipcode='".$_REQUEST['txtZipcode']."',
							OfficePhone='".$_REQUEST['txtOfficeNo']."',
							CellPhone='".$_REQUEST['txtCellNo']."',
							fax='".$_REQUEST['txtFaxNo']."'
						WHERE UserId=".$userid."";
		//echo $qryuserDetailUpdate."<br>";
		if($wpdb->query($qryuserDetailUpdate)){
			echo '<script> alert("Profile Has Been Updated") </script>';	
		}else{
			echo '<script> alert("Profile Can Not Be Updated") </script>';	
		}

	endif;//User Detail  Update Over;
	
	
	echo '<div id="signup" class="form " >';
	if($userid){
		$qryGetUserDetail="SELECT * FROM ".$wpdb->prefix."UserMaster WHERE UserId=".$userid."";
		$Result= $wpdb->get_results($qryGetUserDetail);
		//print_r($Result[0]);
		$UserDetail=$Result[0];
	}else{
		echo '<a href="javascript:"  for="login" onClick="manageForm(this)">Login </a>';
	}
	echo	'<form name="frmSignup" method="post" enctype="multipart/form-data">';
			wp_nonce_field('user_signup-form','user_signup-form_nonce',true,true);
			?>
			<script type="text/javascript">
				function validatePassword (p1, p2 ){
					 if (p1.value != p2.value || p1.value == '' || p2.value == '') {
						p2.setCustomValidity('Password incorrect');
					} else {
						p2.setCustomValidity('');
					}	
				}
			</script>
				<table style="width:auto;">
					<tr>
						<td><label for="txtFirstName">First Name</label></td>
						<td><input type="text" id="txtFirstName" name="txtFirstName" value="<?php echo $userid?$UserDetail->FirstName:'';?>" title="First Name" placeholder="Enter First Name" required></td>
					</tr>
					<tr>
						<td><label for="txtLastName">Last Name</label></td>
						<td><input type="text" id="txtLastName" name="txtLastName" title="Last Name" value="<?php echo $userid?$UserDetail->LastName:'';?>" placeholder="Enter Last Name" required></td>
					</tr>
					<tr>
						<td><label for="txtEmail">Email </label></td>
						<td><input type="email" id="txtEmail" name="txtEmail" title="Email Address" value="<?php echo $userid?$UserDetail->Email:'';?>" placeholder="Enter Email Address" required></td>
					</tr>
					<tr>
						<td><label for="txtPassword">Password</label></td>
						<td><input type="password" id="txtPassword" name="txtPassword" title="Password" value="<?php echo $userid?$UserDetail->Password:'';?>" placeholder="Enter Password" required></td>
					</tr>
					<tr>
						<td><label for="txtRePassword">Re-Enter Password</label></td>
						<td><input type="password" id="txtRePassword" name="txtRePassword" onBlur="validatePassword(document.getElementById('txtPassword'),this)" title="Re Type Password" placeholder="Re Enter Password" required></td>
					</tr>
					<tr>
						<td><label for="txtAgency">Agency </label></td>
						<td><input type="text" id="txtAgency" name="txtAgency" title="Agency Name" value="<?php echo $userid?$UserDetail->Agency:'';?>" placeholder="Enter Agency Name" required></td>
					</tr>
					<tr>
						<td><label for="txtAgencyAddress">Agency Address</label></td>
						<td><textarea id="txtAgencyAddress" name="txtAgencyAddress" title="Agency Address" placeholder="Enter Agency Address" style="resize:horizontal;" rows="7" ><?php echo $userid?$UserDetail->AgencyAddress:'';?></textarea></td>
					</tr>
					<tr>
						<td><label for="txtCity">City</label></td>
						<td><input type="text" id="txtCity" name="txtCity" title="City" value="<?php echo $userid?$UserDetail->City:'';?>" placeholder="Enter City"></td>
					</tr>
					<tr>
						<td><label for="drpState">State</label></td>
						<td>
							<?php if(! $userid):?>
							<select name="drpState" id="drpState">
								<optgroup label="U.S.A.">	
									<option value="AL">AL</option>
									<option value="AK">AK</option>
									<option value="AR">AR</option>
									<option value="AZ">AZ</option>
									<option value="CA">CA</option>
								</optgroup>
								<optgroup label="CANADA">
									<option value="BC">BC</option>
									<option value="MB">MB</option>
									<option value="NB">NB</option>
									<option value="NF">NF</option>
									<option value="NT">NT</option>
									<option value="NS">NS</option>
									<option value="NU">NU</option>
								</optgroup>
							</select>
							<?php else:?>
								<input type="text" id="drpState" name="drpState" title="State" value="<?php echo $userid?$UserDetail->State:'';?>" readonly  placeholder="Enter State">
							<?php endif;?>
						</td>
					</tr>
					<tr>
						<td><label for="txtZipcode">Zip Code</label></td>
						<td><input type="text" id="txtZipcode" name="txtZipcode" title="Zipcode" maxlength="6" value="<?php echo $userid?$UserDetail->Zipcode:'';?>" placeholder="Enter Zipcode"></td>
					</tr>
					<tr>
						<td><label for="txtOfficeNo">Office Phone</label></td>
						<td><input type="tel" id="txtOfficeNo" name="txtOfficeNo" title="Office Phone" value="<?php echo $userid?$UserDetail->OfficePhone:'';?>" placeholder="Enter Office Phone"></td>
					</tr>
					<tr>
						<td><label for="txtCellNo">cell Phone</label></td>
						<td><input type="tel" id="txtCellNo" name="txtCellNo" title="Cell Phone" value="<?php echo $userid?$UserDetail->CellPhone:'';?>" placeholder="Enter Cell Phone"></td>
					</tr>
					<tr>
						<td><label for="txtFaxNo">Fax No.</label></td>
						<td><input type="tel" id="txtFaxNo" name="txtFaxNo" title="Fax No" value="<?php echo $userid?$UserDetail->fax:'';?>" placeholder="Enter Fax No"></td>
					</tr>
					<tr>
						<td/>
						<td>
							<?php if(!$userid):?>
								<input type="submit" name="btnSubmit" value="SignUp">
							<?php else: ?>
								<input type="submit" name="btnUpdate" value="Update">
							<?php endif;?>
							<input type="reset">
						</td>
					</tr>
					
				</table>
			<?php
		echo '</form>';
	echo	'</div>';	
	if(isset($_REQUEST['btnSubmit']) && $_REQUEST['btnSubmit']=='SignUp' && isset($_REQUEST['user_signup-form_nonce']) && wp_verify_nonce($_REQUEST['user_signup-form_nonce'],'user_signup-form') ):
		$qryInsertUser="INSERT INTO ".$wpdb->prefix."UserMaster VALUES
					(
						default,
						'".$_REQUEST['txtEmail']."',
						'".$_REQUEST['txtPassword']."',
						'".$_REQUEST['txtFirstName']."',
						'".$_REQUEST['txtLastName']."',
						'".$_REQUEST['txtAgency']."',
						'".$_REQUEST['txtAgencyAddress']."',
						'".$_REQUEST['txtCity']."',
						'".$_REQUEST['drpState']."',
						'".$_REQUEST['txtZipcode']."',
						'".$_REQUEST['txtOfficeNo']."',
						'".$_REQUEST['txtCellNo']."',
						'".$_REQUEST['txtFaxNo']."'
					)";
		//echo $qryInsertUser."<br>";
		if($wpdb->query($qryInsertUser)){
			
		$to = "info@niwot.com";
		$subject = "User Sign UP";
		
		$txt = "
			<html>
			<body>
				<div style=\"width:100%;border:1px solid #222;border-radius:5px;\">
					<div  style=\"background-color:#222222;padding:10px;display: inline-flex;width: 100%;\"><a href=\"http://www.whiteorangesoftware.com/niwot/\"><img style=\"margin-bottom:-2px;\" src=\"http://www.whiteorangesoftware.com/niwot/wp-content/themes/niwot/img/logo.png\"></a>
					
				<h1 style=\"color: #fff;padding-left:60px;\"> Sign UP Request From ".$_REQUEST['txtFirstName'].$_REQUEST['txtLastName']."</h1>					
					</div>
					<div style=\"padding:24px;min-height:100px;background:#ddd;color: #6e321f;font-size: 20px;\">
					<div style=\"margin:5px 0px\"><label style=\"min-width:100px;display:inline-block;\">First Name : ".$_REQUEST['txtFirstName']." </label></div>
					<div style=\"margin:5px 0px\"><label style=\"min-width:100px;display:inline-block;\">Last Name : ".$_REQUEST['txtLastName']."</label></div>
					<div style=\"margin:5px 0px\"><label style=\"min-width:100px;display:inline-block;\">Email : ".$_REQUEST['txtEmail']."</label></div>					
					<div style=\"margin:5px 0px\"><label style=\"min-width:100px;display:inline-block;\">Agency Name : ".$_REQUEST['txtAgency']."</label></div>
					<div style=\"margin:5px 0px\"><label style=\"min-width:100px;display:inline-block;\">Agency Address : ".$_REQUEST['txtAgencyAddress']."</label></div>
					<div style=\"margin:5px 0px\"><label style=\"min-width:100px;display:inline-block;\">City : ".$_REQUEST['txtCity']."</label></div>
					<div style=\"margin:5px 0px\"><label style=\"min-width:100px;display:inline-block;\">State : ".$_REQUEST['drpState']."</label></div>
					<div style=\"margin:5px 0px\"><label style=\"min-width:100px;display:inline-block;\">ZipCode : ".$_REQUEST['txtZipcode']."</label></div>
					<div style=\"margin:5px 0px\"><label style=\"min-width:100px;display:inline-block;\">Office Number : ".$_REQUEST['txtOfficeNo']."</label></div>
					<div style=\"margin:5px 0px\"><label style=\"min-width:100px;display:inline-block;\">Cell Number : ".$_REQUEST['txtCellNo']."</label></div>
					<div style=\"margin:5px 0px\"><label style=\"min-width:100px;display:inline-block;\">Fax Number : ".$_REQUEST['txtFaxNo']."</label></div>					
			</div>
					<div style=\"background-color:#222222;padding:10px;\">
						<p style=\"margin:0px;font-size:16px;color:#fff;text-align:right;\">This e-mail was sent from <a href=\"http://www.whiteorangesoftware.com/niwot/\" style=\"color:#2BACE2;text-decoration:none;\">Niwot</a></p>
					</div>
					
				</div>
			</body>
			</html>
		
		
		";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: " .$_REQUEST['txtFirstName']. "\r\n" ;

			mail($to,$subject,$txt,$headers);
			
			echo '<script> alert("You have Success fully Sign id"); </script>';	
		}else{
			echo '<script> alert("Please Enter Proper Information"); </script>';
		}
	endif;//Insert Is Over
}


function createUserTable(){
	global $wpdb;
	$Query='CREATE TABLE IF NOT EXISTS '.$wpdb->prefix.'UserMaster
			(
			UserId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
			Email VARCHAR(50) NOT NULL UNIQUE KEY,
			Password VARCHAR(128) NOT NULL,
			FirstName VARCHAR(50) NOT NULL,
			LastName VARCHAR(50) NOT NULL,
			Agency VARCHAR(50) NOT NULL,
			AgencyAddress VARCHAR(1024),
			City VARCHAR(50),
			State VARCHAR(50),
			Zipcode NUMERIC(6) ,
			OfficePhone NUMERIC(10) NOT NULL,
			CellPhone NUMERIC(10),
			fax NUMERIC(10)
		);';	
	return $wpdb->query($Query);
			
}

/***************** The code is For Admin Panal  *****************/

function user_management_admin(){
	include('manage-user-admin.php');	
	//echo "Manage_proprty_admin<br>";
}
function user_management_admin_action(){
	//add_options_page('Niwot Users','Niwot Users',1,"NiwotUsers",'user_management_admin');	
	add_submenu_page( 'NiwotOp', 'Niwot Users', 'Niwot Users', 'manage_options','NiwotUsers', 'user_management_admin');
}

add_action('admin_menu','user_management_admin_action');
?>