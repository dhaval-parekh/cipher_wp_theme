<?php
function proprty_manage_form($proprtyId=false){
	global $wpdb;
	create_property_tables();
	
	//********  INSERT SECTION  ********//
	if( isset($_POST['btnSubmit']) && $_POST['btnSubmit']=='Submit' && isset($_REQUEST['manage-property-form_nonce']) && wp_verify_nonce($_REQUEST['manage-property-form_nonce'],'manage-property-form')):
		// Image Uploadding
		if(! function_exists('wp_handle_upload')){ require_once(ABSPATH.'wp-admin/includes/file.php'); }
		$uploadFile=$_FILES['txtImage'];
		$uploadOverrides = array('test_form' => false);
		$moveFile = wp_handle_upload($uploadFile,$uploadOverrides);
		$imageUrl='';
		if($moveFile){
			$imageUrl=$moveFile['url'];
		}else{
			echo '<script> alert(" can\'\t Upload File");</script>';
		}
		// File Uploading is Complate
		$qryInsert="INSERT INTO ".$wpdb->prefix."PropertyMaster
				(
					UserId,
					PropertyTitle,
					Address,
					City,
					State,
					Zipcode,
					Catagory,
					PropertyWebsite,
					ImageUrl,
					AvailableSF,
					MLS,
					SalePrice,
					LeaseTerms,
					LeaseRate,
					ShortDescription,
					ContactFirstName,
					ContactLastName,
					ContactOfficePhone,
					ContactCellPhone,
					ContactEmail
				)
				VALUES
				(
					'".$_SESSION['UserId']."',
					'".$_POST['txtPropertyTitle']."',
					'".$_POST['txtAddress']."',
					'".$_POST['txtCity']."',
					'".$_POST['drpState']."',
					'".$_POST['txtZipcode']."',
					'".$_POST['drpCatagory']."',
					'".$_POST['txtWebUrl']."',
					'".$imageUrl."',
					'".$_POST['txtSf']."',
					'".$_POST['txtMls']."',
					'".$_POST['txtSalePrice']."',
					'".$_POST['txtLeaseTerms']."',
					'".$_POST['txtLeaseRate']."',
					'".$_POST['txtDescription']."',
					'".$_POST['txtFirstName']."',
					'".$_POST['txtLastName']."',
					'".$_POST['txtOfficePhone']."',
					'".$_POST['txtCellPhone']."',
					'".$_POST['txtEmail']."'
				)";
			
			
		if( $wpdb->query($qryInsert)){
			// get Insert Property Id
			$qryGetMaxId="SELECT max(PropertyId) FROM ".$wpdb->prefix."PropertyMaster";
			$Result=$wpdb->get_results($qryGetMaxId,ARRAY_A);
			$Result=$Result[0];
			$PropertyId=$Result['max(PropertyId)'];
			
			// Insert Property Type Detail
 			foreach($_POST['cbxType'] as $type){
				$qryInsertType="INSERT INTO ".$wpdb->prefix."PropertyTypeDetail VALUES(default,".$PropertyId.",'".$type."'); ";	
				if($wpdb->query($qryInsertType)){ $flagType =true;}else{$flagType =false;}
			}
			// Insert Property Features
			for($i=1;$i<=7;$i++){
				if($_POST['txtFeatureLabel'.$i]!=''){
					$qryinsertFeature="INSERT INTO ".$wpdb->prefix."PropertyFeatureDetail VALUES(default,".$PropertyId.",'".$_POST['txtFeatureLabel'.$i]."','".$_POST['txtFeatureValue'.$i]."')";
					if($wpdb->query($qryinsertFeature)){ $flagfeature=true; }else{$flagfeature=false;}
				}
			}
			// Alert 
			if( $flagfeature && $flagType ){
				echo '<script> alert("Prperty Has been Added"); </script>';
			}
		}else{
			echo '<script> alert("Error : 1"); </script>';
		}
	endif;
	//********  INSERT SECTION OVER ********//
	
	//********  UPDATE SECTION  ********//
	// Get Product Detail
	if($proprtyId!=false):
		
		// Update Property 
		if( isset($_POST['btnUpdate']) && $_POST['btnUpdate']=='Update' && isset($_REQUEST['manage-property-form_nonce']) && wp_verify_nonce($_REQUEST['manage-property-form_nonce'],'manage-property-form')):
			$qryUpdate="UPDATE  ".$wpdb->prefix."PropertyMaster SET 
						PropertyTitle='".$_POST['txtPropertyTitle']."',
						Address='".$_POST['txtAddress']."',
						City='".$_POST['txtCity']."',
						State='".$_POST['drpState']."',
						Zipcode='".$_POST['txtZipcode']."',
						Catagory='".$_POST['drpCatagory']."',
						PropertyWebsite='".$_POST['txtWebUrl']."',
						AvailableSF='".$_POST['txtSf']."',
						MLS='".$_POST['txtMls']."',
						SalePrice='".$_POST['txtSalePrice']."',
						LeaseTerms='".$_POST['txtLeaseTerms']."',
						LeaseRate='".$_POST['txtLeaseRate']."',
						ShortDescription='".$_POST['txtDescription']."',
						ContactFirstName='".$_POST['txtFirstName']."',
						ContactLastName='".$_POST['txtLastName']."',
						ContactOfficePhone='".$_POST['txtOfficePhone']."',
						ContactCellPhone='".$_POST['txtCellPhone']."',
						ContactEmail='".$_POST['txtEmail']."'
					WHERE PropertyId=".$proprtyId."
					";
			
			$flagDetail=$wpdb->query($qryUpdate);
			/*echo  ($wpdb->query($qryUpdate))?'<script> alert("[Update - Main] : sucess"); </script>':'<script> alert("Error[Update - Main] : 1"); </script>';
			*/	
				
			// Type Update
			$qryUpdateType="DELETE FROM  ".$wpdb->prefix."PropertyTypeDetail WHERE PropertyId=".$proprtyId."";
			/*if($wpdb->query($qryUpdateType)){echo '<script> alert("Success[Delete - Type] : "); </script>';}else{echo '<script> alert("Error[Delete - Type] : 1"); </script>';}
			*/
			$wpdb->query($qryUpdateType);
			foreach($_POST['cbxType'] as $type){
				$qryUpdateType="INSERT INTO ".$wpdb->prefix."PropertyTypeDetail VALUES(default,".$proprtyId.",'".$type."'); ";
				if($wpdb->query($qryUpdateType)){ $flagType =true;}else{$flagType =false;}
			}
			/*echo $flagType?'<script> alert("[Update - Type] : sucess"); </script>':'<script> alert("[Update - Type] : ERROR"); </script>';
			*/
			
			// Feature update
			$qryUpdateFeature="DELETE FROM  ".$wpdb->prefix."PropertyFeatureDetail WHERE PropertyId=".$proprtyId."";
			
			/*if($wpdb->query($qryUpdateFeature)){echo '<script> alert("Success[Delete - Type] : "); </script>';}else{echo '<script> alert("Error[Delete - Type] : 1"); </script>';}
			*/
			$wpdb->query($qryUpdateFeature);
			for($i=1;$i<=7;$i++){
				if($_POST['txtFeatureLabel'.$i]!=''){
					$qryUpdateFeature="INSERT INTO ".$wpdb->prefix."PropertyFeatureDetail VALUES(default,".$proprtyId.",'".$_POST['txtFeatureLabel'.$i]."','".$_POST['txtFeatureValue'.$i]."')";
					if($wpdb->query($qryUpdateFeature)){ $flagfeature=true; }else{$flagfeature=false;}
				}
			}
			/*echo $flagfeature?'<script> alert("[Update - Feature] : sucess"); </script>':'<script> alert("[Update - Feature] : ERROR"); </script>';
			*/	
			echo ( $flagDetail || $flagfeature || $flagType )?'<script> alert("property Updated"); </script>':'<script> alert("Can not update Property"); </script>';
				
			
		endif;
		// Update Property Finish
		
		// Get Property Detail
		$qryPopertyDetail="SELECT * FROM ".$wpdb->prefix."PropertyMaster WHERE PropertyId=".$proprtyId."";
		$PropertyDetail=$wpdb->get_results($qryPopertyDetail);
		$PropertyDetail=$PropertyDetail[0];
		
		$qryPopertyDetail_1="SELECT * FROM ".$wpdb->prefix."PropertyTypeDetail  WHERE PropertyId=".$proprtyId."";
		$PropertyDetail_1=$wpdb->get_results($qryPopertyDetail_1);
		echo '<script>jQuery(document).ready(function(e) {';
		foreach($PropertyDetail_1 as $item){
			echo 'jQuery("[value^='.$item->TypeName.']").attr("checked","true");';
		}
		echo '});</script>';
		
		$qryPopertyDetail_2="SELECT * FROM ".$wpdb->prefix."PropertyFeatureDetail  WHERE PropertyId=".$proprtyId."";
		$PropertyDetail_2=$wpdb->get_results($qryPopertyDetail_2);
		// Get Preperty Detail Over
		 
		
		
		
	endif;
	//********  UPDATE SECTION OVER  ********//
	echo '<div id="propertyManage" class="form"> ';
		if($proprtyId==false){echo "<h1>Add Property</h1>";}else{ echo "<h1>Edit Property</h1>"; }
		echo '<form id="frmManageProperty" method="post" enctype="multipart/form-data">';
			wp_nonce_field('manage-property-form','manage-property-form_nonce',true,true);
			
		?>
		<table style="width:auto">
			<tr><th colspan="2"><abbr>Prpperty Name/Address</abbr></th></tr>
			<tr>
				<td><label for="txtPropertyTitle">Property Title</label></td>
				<td><input type="text" id="txtPropertyTitle" name="txtPropertyTitle" value="<?php echo $proprtyId?$PropertyDetail->PropertyTitle:''; ?>" title="Property Title" placeholder="Enter Property Title" required ></td>
			</tr>
			<tr>
				<td><label for="txtAddress">Property Address</label></td>
				<td><textarea id="txtAddress" name="txtAddress" style="resize:horizontal" required title="Property Address" placeholder="Enter Property Address"><?php echo $proprtyId?$PropertyDetail->Address:''; ?></textarea></td>
			</tr>
			<tr>
				<td><label for="txtCity">City</label></td>
				<td><input type="text" id="txtCity" name="txtCity" value="<?php echo $proprtyId?$PropertyDetail->City:''; ?>" title="City" placeholder="Enter City" required ></td>
			</tr>
			<tr>
				<td><label for="drpState">State</label></td>
				<td>
					<?php if(! $proprtyId): ?>
					<select id="drpState" name="drpState" title="State" required>
						<optgroup label="--USA--">
							<option value="AL">AL</option>
							<option value="AK">AK</option>
							<option value="AR">AR</option>
							<option value="AZ">AZ</option>
							<option value="CA">CA</option>
							<option value="CO">CO</option>
							<option value="CT">CT</option>
							<option value="DC">DC</option>
						</optgroup>	
						<optgroup label="--CANADA--">
							<option value="AB">AB</option>
							<option value="BC">BC</option>
							<option value="MB">MB</option>
							<option value="NB">NB</option>
						</optgroup>
					</select>
					<?php else: ?>
					<input type="text" id="drpState" name="drpState"  value="<?php echo $proprtyId?$PropertyDetail->State:''; ?>"  readonly placeholder="Property State" title="State">
					<?php endif;?>
				</td>
			</tr>
			<tr>
				<td><label for="txtZipcode">Zipcode</label></td>
				<td><input type="text" id="txtZipcode" name="txtZipcode" title="Zipcode" value="<?php echo $proprtyId?$PropertyDetail->Zipcode:''; ?>" placeholder="Enter Zipcode" ></td>
			</tr>
			<tr><th colspan="2"><abbr>Prpperty Name/Address</abbr></th></tr>
			<tr>
				<td><label for="drpCatagory">Category</label></td>
				<td>
					<?php if(! $proprtyId): ?>
						<select id="drpCatagory" name="drpCatagory" title="Select Category" required>
							<option selected disabled>Select category</option>
							<option value="SALE">Sale</option>
							<option value="LEASE">Lease</option>
							<option value="SUBLEASE">Sublease</option>
						</select>
					<?php else: ?>
						<input type="text" id="drpCatagory" name="drpCatagory" readonly value="<?php echo $proprtyId?$PropertyDetail->Catagory:''; ?>" placeholder="Enter Catagory" title="Catagory">
					<?php endif;?>
				</td>
			</tr>
			<tr>
				<td><label for="cbxType[]">Property Type</label></td>
				<td>
					<input type="checkbox" id="cbxType[]" name="cbxType[]"  value="Industrial"><font class="lbl">Industrial</font>
					<input type="checkbox" id="cbxType[]" name="cbxType[]"  value="Land"><font class="lbl">Land</font>
					<input type="checkbox" id="cbxType[]" name="cbxType[]"  value="Office"><font class="lbl">Office</font><br/>
					<input type="checkbox" id="cbxType[]" name="cbxType[]"  value="Residential"><font class="lbl">Residential</font>
					<input type="checkbox" id="cbxType[]" name="cbxType[]"  value="Retail"><font class="lbl">Retail</font>
				</td>
			</tr>
			<tr>
				<td><label for="txtWebUrl">Property Website</label></td>
				<td><input type="url" id="txtWebUrl" name="txtWebUrl" title="Property Website" value="<?php echo $proprtyId?$PropertyDetail->PropertyWebsite:''; ?>" placeholder="Enter Property Website"></td>
			</tr>
			<tr>
				<td><label for="txtImage">Upload Image</label></td>
				<td><input type="file" id="txtImage" name="txtImage" title="Upload Image" placeholder="Upload Property Image"></td>
			</tr>
			<tr>
				<td><label for="txtSf">Available SF</label></td>
				<td><input type="text" id="txtSf" name="txtSf" title="Available SF" value="<?php echo $proprtyId?$PropertyDetail->AvailableSF:''; ?>" placeholder="Enter Available SF"></td>
			</tr>
			<tr>
				<td><label for="txtMls">MLS # </label></td>
				<td><input type="text" id="txtMls" name="txtMls" title="Property MLS " value="<?php echo $proprtyId?$PropertyDetail->MLS:''; ?>" placeholder="Enter MLS"></td>
			</tr>
			<tr>
				<td><label for="txtsalePrice">Sale Price</label></td>
				<td><input type="text" id="txtSalePrice" name="txtSalePrice" title="Sale Price " value="<?php echo $proprtyId?$PropertyDetail->SalePrice:''; ?>" placeholder="Enter Sale Price"></td>
			</tr>
			<tr>
				<td><label for="txtLeaseTerms">Lease Terms</label></td>
				<td><textarea id="txtLeaseTerms" name="txtLeaseTerms" style="resize:horizontal" title="Lease Terms" placeholder="Enter Lease Terms"><?php echo $proprtyId?$PropertyDetail->LeaseTerms:''; ?></textarea></td>
			</tr>
			<tr>
				<td><label for="txtLeaseRate">Lease Rate</label></td>
				<td><input type="text" id="txtLeaseRate" name="txtLeaseRate" title="Lease Rate" value="<?php echo $proprtyId?$PropertyDetail->LeaseRate:''; ?>" placeholder="Enter Lease Rate"></td>
			</tr>
			<tr><th colspan="2"><abbr>Property Features</abbr></th></tr>
			<tr>
				<th><label>Labels</label></th>
				<th><label>Features</label></th>
			</tr>
			<tr>
				<td><input type="text" id="txtFeatureLabel1" name="txtFeatureLabel1" value="<?php echo $proprtyId&&isset($PropertyDetail_2[0]->FeatureLabel)?$PropertyDetail_2[0]->FeatureLabel:''; ?>" class="full-width" title="Label 1" placeholder="Label 1"> </td>
				<td><input type="text" id="txtFeatureValue1" name="txtFeatureValue1" value="<?php echo $proprtyId&&isset($PropertyDetail_2[0]->FeatureValue)?$PropertyDetail_2[0]->FeatureValue:''; ?>" title="value 1" placeholder="value 1"></td>
			</tr>
			<tr>
				<td><input type="text" id="txtFeatureLabel2" name="txtFeatureLabel2" value="<?php echo $proprtyId&&isset($PropertyDetail_2[1]->FeatureLabel)?$PropertyDetail_2[1]->FeatureLabel:''; ?>" class="full-width" title="Label 2" placeholder="Label 2"> </td>
				<td><input type="text" id="txtFeatureValue2" name="txtFeatureValue2" value="<?php echo $proprtyId&&isset($PropertyDetail_2[1]->FeatureValue)?$PropertyDetail_2[1]->FeatureValue:''; ?>" title="value 2" placeholder="value 2"></td>
			</tr>
			<tr>
				<td><input type="text" id="txtFeatureLabel3" name="txtFeatureLabel3" value="<?php echo $proprtyId&&isset($PropertyDetail_2[2]->FeatureLabel)?$PropertyDetail_2[2]->FeatureLabel:''; ?>" class="full-width" title="Label 3" placeholder="Label 3"> </td>
				<td><input type="text" id="txtFeatureValue3" name="txtFeatureValue3" value="<?php echo $proprtyId&&isset($PropertyDetail_2[2]->FeatureValue)?$PropertyDetail_2[2]->FeatureValue:''; ?>" title="value 3" placeholder="value 3"></td>
			</tr>
			<tr>
				<td><input type="text" id="txtFeatureLabel4" name="txtFeatureLabel4" value="<?php echo $proprtyId&&isset($PropertyDetail_2[3]->FeatureLabel)?$PropertyDetail_2[3]->FeatureLabel:''; ?>" class="full-width" title="Label 4" placeholder="Label 4"> </td>
				<td><input type="text" id="txtFeatureValue4" name="txtFeatureValue4" value="<?php echo $proprtyId&&isset($PropertyDetail_2[3]->FeatureValue)?$PropertyDetail_2[3]->FeatureValue:''; ?>" title="value 4" placeholder="value 4"></td>
			</tr>
			<tr>
				<td><input type="text" id="txtFeatureLabel5" name="txtFeatureLabel5" value="<?php echo $proprtyId&&isset($PropertyDetail_2[4]->FeatureLabel)?$PropertyDetail_2[4]->FeatureLabel:''; ?>" class="full-width" title="Label 5" placeholder="Label 5"> </td>
				<td><input type="text" id="txtFeatureValue5" name="txtFeatureValue5" value="<?php echo $proprtyId&&isset($PropertyDetail_2[4]->FeatureValue)?$PropertyDetail_2[4]->FeatureValue:''; ?>" title="value 5" placeholder="value 5"></td>
			</tr>
			<tr>
				<td><input type="text" id="txtFeatureLabel6" name="txtFeatureLabel6" value="<?php echo $proprtyId&&isset($PropertyDetail_2[5]->FeatureLabel)?$PropertyDetail_2[5]->FeatureLabel:''; ?>" class="full-width" title="Label 6" placeholder="Label 6"> </td>
				<td><input type="text" id="txtFeatureValue6" name="txtFeatureValue6" value="<?php echo $proprtyId&&isset($PropertyDetail_2[5]->FeatureValue)?$PropertyDetail_2[5]->FeatureValue:''; ?>" title="value 6" placeholder="value 6"></td>
			</tr>
			<tr>
				<td><input type="text" id="txtFeatureLabel7" name="txtFeatureLabel7" value="<?php echo $proprtyId&&isset($PropertyDetail_2[6]->FeatureLabel)?$PropertyDetail_2[6]->FeatureLabel:''; ?>" class="full-width" title="Label 7" placeholder="Label 7"> </td>
				<td><input type="text" id="txtFeatureValue7" name="txtFeatureValue7" value="<?php echo $proprtyId&&isset($PropertyDetail_2[6]->FeatureValue)?$PropertyDetail_2[6]->FeatureValue:''; ?>" title="value 7" placeholder="value 7"></td>
			</tr>
			<tr>
				<td><label for="txtDescription">Property Description</label></td>
				<td><textarea id="txtDescription" name="txtDescription" style="resize:horizontal"  title="Property Description" placeholder="Enter Property Description"><?php echo $proprtyId?$PropertyDetail->ShortDescription:''; ?></textarea></td>
			</tr>
			<tr><th colspan="2"><abbr>Listing Contact</abbr></th></tr>
			<tr>
				<td><label for="txtFirstName">First Name</label></td>
				<td><input type="text" id="txtFirstName" name="txtFirstName" title="First Name" value="<?php echo $proprtyId?$PropertyDetail->ContactFirstName:''; ?>"  placeholder="Enter First Name" required></td>
			</tr>
			<tr>
				<td><label for="txtLastName">Last Name</label></td>
				<td><input type="text" id="txtLastName" name="txtLastName" title="Last Name" value="<?php echo $proprtyId?$PropertyDetail->ContactLastName:''; ?>"  placeholder="Enter Last Name" required></td>
			</tr>
			<tr>
				<td><label for="txtOfficePhone">Office Phone</label></td>
				<td><input type="tel" id="txtOfficePhone" name="txtOfficePhone" title="Office Phone" value="<?php echo $proprtyId?$PropertyDetail->ContactOfficePhone:''; ?>"  placeholder="Enter Pffice Phone" required></td>
			</tr>
			<tr>
				<td><label for="txtCellPhone">Cell Phone</label></td>
				<td><input type="tel" id="txtCellPhone" name="txtCellPhone" title="Cell Phone" value="<?php echo $proprtyId?$PropertyDetail->ContactCellPhone:''; ?>"  placeholder="Enter Cell Phone" required ></td>
			</tr>
			<tr>
				<td><label for="txtEmail">Email</label></td>
				<td><input type="email" id="txtEmail" name="txtEmail" title="Email" value="<?php echo $proprtyId?$PropertyDetail->ContactEmail:''; ?>"  placeholder="Enter Email Address" required></td>
			</tr>
			<tr>
				<td/>
				<td>
					<?php if($proprtyId): ?>
						<input type="submit" id="btnUpdate" name="btnUpdate" value="Update" title="Update">
					<?php else: ?>
						<input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" title="Submit">
					<?php endif; ?>
					<input type="reset">
				</td>
			</tr>
		</table>
		<?php
		echo '</form>';
	echo '</div>';
}

function user_property_display($userId){
	global $wpdb;
	global $url,$queryStrStart;
	$getPropertyList="SELECT * FROM ".$wpdb->prefix."PropertyMaster WHERE UserId=".$userId." AND isDelete=0";
	$Result=$wpdb->get_results($getPropertyList);
	foreach($Result as $item){
		?>
			<div class="event-post-container">
				
				<a class="img-container" title="<?php echo $item->PropertyTitle; ?>" href="Javascript:">
					<img src="<?php echo $item->ImageUrl; ?>" alt="<?php echo $item->PropertyTitle; ?>">
				</a>
				<div class="event-detail">
					<div class="row-1"><label>Title</label><p><?php echo $item->PropertyTitle; ?></p></div>
					<div class="row-1"><label>Address</label><p><?php echo $item->Address; ?></p></div>
					<div class="row-1"><label>City</label><p><?php echo $item->City; ?></p></div>
					<div class="row-1"><label>Zipcode</label><p><?php echo $item->Zipcode; ?></p></div>
					<div class="row-1"><label>Catagory</label><p><?php echo $item->Catagory; ?></p></div>
				</div>
				<div class="row-1" style="text-align:right"><a href="<?php echo $url.$queryStrStart."action=update&pid=".$item->PropertyId.""; ?>" >Edit</a>&nbsp;<a href="<?php echo $url.$queryStrStart."action=delete&pid=".$item->PropertyId.""; ?>" >Delete</a></div>
			</div>
		<?php
	}
}
function user_property_delete($propertyId){
	global $wpdb, $url,$queryStrStart;
	$qryPropertyDelete="UPDATE ".$wpdb->prefix."PropertyMaster SET isDelete=1 WHERE PropertyId=".$propertyId.";";
	if($wpdb->query($qryPropertyDelete)){
		echo "Property Deleted Successfully<br>";
		header('Location:'.$url.$queryStrStart.'action=manage');
	}else{
		echo "Can not Delete Property<br>";	
	}
	
	
}

function create_property_tables(){
	global $wpdb;
	$query1='
		CREATE TABLE IF NOT EXISTS '.$wpdb->prefix.'PropertyMaster
		(
		PropertyId INT AUTO_INCREMENT primary key,
		UserId INT NOT NULL,
		PropertyTitle VARCHAR(50) NOT NULL,
		Address VARCHAR(1024) NOT NULL,
		City VARCHAR(50) NOT NULL,
		State VARCHAR(50) NOT NULL,
		Zipcode NUMERIC(6),
		Catagory VARCHAR(50),
		PropertyWebsite VARCHAR(512),
		ImageUrl VARCHAR(512),
		AvailableSF NUMERIC(24),
		MLS VARCHAR(512),
		SalePrice NUMERIC(24),
		LeaseTerms VARCHAR(1024),
		LeaseRate NUMERIC(24),
		ShortDescription VARCHAR(1024),
		ContactFirstName VARCHAR(50) NOT NULL,
		ContactLastName VARCHAR(50) NOT NULL,
		ContactOfficePhone NUMERIC(10) ,
		ContactCellPhone NUMERIC(10),
		ContactEmail VARCHAR(50),
		isActive INT  DEFAULT 0,
		isDelete INT  DEFAULT 0,
		FOREIGN KEY(UserId) REFERENCES '.$wpdb->prefix.'UserMaster(UserId)
		);';
		$query2='
		CREATE TABLE IF NOT EXISTS '.$wpdb->prefix.'PropertyTypeDetail
		(
		TypeId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		PropertyId INT NOT NULL,
		TypeName VARCHAR(50) NOT NULL,
		FOREIGN KEY(PropertyId) REFERENCES '.$wpdb->prefix.'PropertyMaster(PropertyId)
		);';
		$query3='
		CREATE TABLE IF NOT EXISTS '.$wpdb->prefix.'PropertyFeatureDetail
		(
		FeatureId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		PropertyId INT NOT NULL,
		FeatureLabel VARCHAR(50) NOT NULL,
		FeatureValue VARCHAR(256),
		FOREIGN KEY(PropertyId) REFERENCES '.$wpdb->prefix.'PropertyMaster(PropertyId)
		);';

	return $wpdb->query($query1) && $wpdb->query($query2) && $wpdb->query($query3);
}

/***************** The code is For Admin Panal  *****************/

function property_management_admin(){
	include('manage-property-admin.php');	
	
}
function property_management_admin_action(){
	//add_options_page('Niwot Users','Niwot Users',1,"NiwotUsers",'user_management_admin');	
	add_submenu_page( 'NiwotOp', 'Property', 'Property', 'manage_options','NiwotProperty', 'property_management_admin');
}

add_action('admin_menu','property_management_admin_action');

?>