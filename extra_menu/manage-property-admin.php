<link href="<?php bloginfo( 'template_url' ); ?>/css/admin.css" rel="stylesheet" type="text/css" media="all">
<div class="wrap">
	<div style="margin:10px;padding:5px 10px;">
		<label for="code">Code For Display  Property:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<label><input id="code" type="text" readonly value="[display-property]"></label>
	</div>
	<?php
		global $wpdb;
		$url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$url=truncateQueryString('edit',$url);
		$url=truncateQueryString('del',$url);
		if(count($_GET)==0){
			$startQue="?";
		}else{
			$startQue="&";
		}
		if(!( isset($_GET['edit']) || isset($_GET['del']) )):
			$qryGetPropertyDetail="SELECT * 
							FROM ".$wpdb->prefix."PropertyMaster AS pm, ".$wpdb->prefix."UserMaster AS um
							WHERE pm.UserId=um.UserId
						";
			$rsGetPreopertyDetail=$wpdb->get_results($qryGetPropertyDetail);
			//echo $qryGetPropertyDetail."<br>";
			echo '<table class="nba-detail" cellspacing="5px">';
			echo '<tr>
					<th>Id</th>
					<th>Property Title</th>
					<th>User Name</th>
					<th>Agency</th>
					<th>Office Phone</th>
					<th>Cell Phone</th>
					<th>Catagory</th>
					<th>Is Display</th>
					<th>Is Delete</th>
					<th>Action</th>
				</tr>';
			foreach($rsGetPreopertyDetail as $Data){
				$editUrl=$url.$startQue."edit=".$Data->PropertyId;
				$delUrl=$url.$startQue."del=".$Data->PropertyId;
				echo '<tr>
						<td>'.$Data->PropertyId.'</td>
						<td>'.$Data->PropertyTitle.'</td>
						<td>'.$Data->FirstName.'&nbsp;'.$Data->LastName.'</td>
						<td>'.$Data->Agency.'</td>
						<td>'.$Data->OfficePhone.'</td>
						<td>'.$Data->CellPhone.'</td>
						<td>'.$Data->Catagory.'</td>';
						echo '<td>';?><input type="checkbox" disabled  <?php echo  $Data->isActive?'checked':''; ?> ><?php echo '</td>
							 <td>';?><input type="checkbox" disabled  <?php echo  $Data->isDelete?'checked':''; ?> ><?php echo '</td>
						<td>
							<a href="'.$editUrl.'" ><img src="'. get_template_directory_uri() .'/img/edit.png" alt="U" class="action-btn"></a>
							<a href="'.$delUrl.'"><img src="'. get_template_directory_uri() .'/img/delete.png" alt="D" class="action-btn"></a>
						</td>
					</tr>';
			}
			echo '</table>';
		elseif(isset($_GET['edit'])): // Property UPDATE
			// update process
			if( isset($_POST['btnUpdate']) && $_POST['btnUpdate']=='Update' ):
				$isActive = isset($_POST['cbxIsActive'])?1:0;
				$qryUpdate="UPDATE ".$wpdb->prefix."PropertyMaster SET
							isActive=".$isActive."
							WHERE  PropertyId=".$_GET['edit']."
						";
					
				if($wpdb->query($qryUpdate)){
					echo '<div class="updated"><p><strong>Property has been Updated</strong></p></div>';	
				}else{
					echo '<div class="updated" style="border-left:4px solid #d9534f;"><p><strong>Can not Update Property</strong></p></div>';
				}
			endif;  // update process over
			$qryGetPropertyDetail="SELECT * 
							FROM ".$wpdb->prefix."PropertyMaster AS pm, ".$wpdb->prefix."UserMaster AS um
							WHERE pm.UserId=um.UserId AND PropertyId=".$_GET['edit']."
						"; 
			$rsGetPreopertyDetail=$wpdb->get_results($qryGetPropertyDetail);
			
			// get property type
			$qryGetPropertyDetailType="SELECT TypeName FROM  ".$wpdb->prefix."PropertyTypeDetail WHERE  PropertyId=".$_GET['edit']."";
			$rsGetPropertyDetailType=$wpdb->get_results($qryGetPropertyDetailType);
			$propertyType='';
			foreach($rsGetPropertyDetailType as $type){
				$propertyType.=$type->TypeName.', ';	
			}
			
			$rsGetPreopertyDetail=$rsGetPreopertyDetail[0];
			?>
				<div class="form">
					<div style="margin:10px;"><p><strong>User Detail</strong></p></div> 
					<div class="half-form" style="float:left">
						<table class="nba-update-form" >
							<tr>
								<td><label>User Id</label></td>
								<td><input type="text" readonly value="<?php echo $rsGetPreopertyDetail->UserId; ?>"></td>
							</tr>
							<tr>
								<td><label>User Name</label></td>
								<td><input type="text" readonly value="<?php echo $rsGetPreopertyDetail->FirstName.'&nbsp;'.$rsGetPreopertyDetail->LastName; ?>"></td>
							</tr>
							<tr>
								<td><label>Email</label></td>
								<td><input type="text" readonly value="<?php echo $rsGetPreopertyDetail->Email; ?>"></td>
							</tr>
							<tr>
								<td><label>Cell Phone</label></td>
								<td><input type="text" readonly value="<?php echo $rsGetPreopertyDetail->CellPhone; ?>"></td>
							</tr>
							<tr>
								<td><label>Office Phone</label></td>
								<td><input type="text" readonly value="<?php echo $rsGetPreopertyDetail->OfficePhone; ?>"></td>
							</tr>
						</table>
					</div>
					<div class="half-form" style="float:right">
						<table class="nba-update-form">
							<tr>
								<td><label>Agency</label></td>
								<td><input type="text" readonly value="<?php echo $rsGetPreopertyDetail->Agency; ?>"></td>
							</tr>
							<tr>
								<td><label>Agency Address</label></td>
								<td><textarea readonly><?php echo $rsGetPreopertyDetail->AgencyAddress; ?></textarea></td>
							</tr>
							<tr>
								<td><label>City</label></td>
								<td><input type="text" readonly value="<?php echo $rsGetPreopertyDetail->City; ?>"></td>
							</tr>
							<tr>
								<td><label>State</label></td>
								<td><input type="text" readonly value="<?php echo $rsGetPreopertyDetail->State; ?>"></td>
							</tr>
						</table>
					</div>
				</div>
				<br clear="all">
				<hr style="border:2px dashed #ccc">
				<div class="form">
					<div style="margin:10px;"><p><strong>Property Detail</strong></p></div> 
					<form id="frmMemberUpdate" name="frmMemberUpdate" method="post" >
						<div class="half-form" style="float:left">
							<table class="nba-update-form">
								<tr>
									<td><label>Property Id</label></td>
									<td><input type="text" readonly value="<?php echo $rsGetPreopertyDetail->UserId; ?>"></td>
								</tr>
								<tr>
									<td><label>Property Title</label></td>
									<td><input type="text" readonly value="<?php echo $rsGetPreopertyDetail->PropertyTitle; ?>"></td>
								</tr>
								<tr>
									<td><label>Address</label></td>
									<td><textarea readonly><?php echo $rsGetPreopertyDetail->Address.','.$rsGetPreopertyDetail->City.','.$rsGetPreopertyDetail->State.','.$rsGetPreopertyDetail->Zipcode; ?></textarea></td>
								</tr>
								<tr>
									<td><label>Catagory</label></td>
									<td><input type="text" readonly value="<?php echo $rsGetPreopertyDetail->Catagory; ?>"></td>
								</tr>
								<tr>
									<td><label>Type</label></td>
									<td><input type="text" readonly value="<?php echo $propertyType; ?>"></td>
								</tr>
								<tr>
									<td><label>Property Website</label></td>
									<td><input type="text" readonly value="<?php echo $rsGetPreopertyDetail->PropertyWebsite; ?>"></td>
								</tr>
								<tr>
									<td><label>Available SF</label></td>
									<td><input type="text" readonly value="<?php echo $rsGetPreopertyDetail->AvailableSF; ?>"></td>
								</tr>
								<tr>
									<td><label>MLS</label></td>
									<td><input type="text" readonly value="<?php echo $rsGetPreopertyDetail->MLS; ?>"></td>
								</tr>
								<tr>
									<td><label>Sale Price</label></td>
									<td><input type="text" readonly value="<?php echo $rsGetPreopertyDetail->SalePrice; ?>"></td>
								</tr>
							</table>
						</div>
						<div class="nba-update-form">
							<table class="nba-update-form">
								<tr>
									<td><label>Property Image</label></td>
									<td><img src="<?php echo $rsGetPreopertyDetail->ImageUrl; ?>" alt="<?php echo $rsGetPreopertyDetail->PropertyTitle; ?>" style="max-width:30%; height:auto"></td>
								</tr>
								<tr>
									<td><label>Contact Person</label></td>
									<td><input type="text" readonly value="<?php echo $rsGetPreopertyDetail->ContactFirstName.'&nbsp;'.$rsGetPreopertyDetail->ContactLastName; ?>"></td>
								</tr>
								<tr>
									<td><label>Office Phone</label></td>
									<td><input type="text" readonly value="<?php echo $rsGetPreopertyDetail->ContactOfficePhone; ?>"></td>
								</tr>
								<tr>
									<td><label>Cell Phone</label></td>
									<td><input type="text" readonly value="<?php echo $rsGetPreopertyDetail->ContactCellPhone; ?>"></td>
								</tr>
								<tr>
									<td><label>Email</label></td>
									<td><input type="text" readonly value="<?php echo $rsGetPreopertyDetail->ContactEmail; ?>"></td>
								</tr>
								<tr>
									<td><label>Is Display</label></td>
									<td><input type="checkbox" name="cbxIsActive" value="1" <?php echo $rsGetPreopertyDetail->isActive?'checked':''; ?> ></td>
								</tr>
								<tr>
									<td><label>Is Delete</label></td>
									<td><input type="checkbox" name="cbxIsActive[]" disabled <?php echo $rsGetPreopertyDetail->isDelete?'checked':''; ?>></td>
								</tr>
								<tr>
									<td/>
									<td>
										<input type="submit" name="btnUpdate" value="Update">
										<input type="reset">
										<a href="<?php echo $url;?>">Back</a>
 									</td>
								</tr>
								
							</table>
							
						</div>
					</form>
				</div>
			
			<?php
		
		elseif(isset($_GET['del'])): // Property DELETE
			$qryDeleteProperty="DELETE FROM ".$wpdb->prefix."PropertyTypeDetail WHERE PropertyId=".$_GET['del']."; ";
			$flag1=$wpdb->query($qryDeleteProperty);
			
			$qryDeleteProperty="DELETE FROM ".$wpdb->prefix."PropertyFeatureDetail WHERE PropertyId=".$_GET['del']."; ";
			$flag2=$wpdb->query($qryDeleteProperty);
			
			$qryDeleteProperty="DELETE FROM ".$wpdb->prefix."PropertyMaster WHERE PropertyId=".$_GET['del']."; ";
			$flag3=$wpdb->query($qryDeleteProperty);
			
			if($flag1 && $flag2 && $flag3){
				echo '<div class="updated"><p><strong>Property has been Deleted Parmenatly</strong></p></div>';	
			}else{
				echo '<div class="updated" style="border-left:4px solid #d9534f;"><p><strong>Can not Delete Property</strong></p></div>';
			}
			echo '<a href="'.$url.'">Back</a>';
		endif; 
		
		
	?>
</div>
