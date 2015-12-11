<link href="<?php bloginfo( 'template_url' ); ?>/css/admin.css" rel="stylesheet" type="text/css" media="all">
<div class="wrap">
<div style="margin:10px;padding:5px 10px;">
<label for="code">Code For NBA Form  :</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label><input id="code" type="text" readonly value="[nba_form]"></label>
</div>
<?php
global $wpdb;
if(!(isset($_REQUEST['edit']) || isset($_REQUEST['del']))){
	$qryGetMembers="SELECT * FROM ".$wpdb->prefix."Niwot_NBA_Form";
	$result = $wpdb->get_results($qryGetMembers);
	foreach($result as $Data){ print_r($Data); echo "<br>"; }
	echo '<table class="nba-detail" cellspacing="5px">';
	echo '<tr>
			<th>Id</th>
			<th>Business Name</th>
			<th>Business Address</th>
			<th>Malling Address</th>
			<th>Contect Name</th>
			<th>Business Phone</th>
			<th>Email Address</th>
			<th>Is Active</th>
			<th>Is Golden</th>
			<th>Action</th>
		</tr>';
	foreach($result as $data){
		$editUrl=$_SERVER['REQUEST_URI']."&edit=".$data->FormId."";
		$delUrl=$_SERVER['REQUEST_URI']."&del=".$data->FormId."";
		echo "<tr>";
			echo '<td>'.$data->FormId.'</td>';
			echo '<td>'.$data->BusinessName.'</td>';
			echo '<td>'.$data->BusineeAddress.'</td>';
			echo '<td>'.$data->MaillingAddress.'</td>';
			echo '<td>'.$data->ContactName.'</td>';
			echo '<td>'.$data->BusinessPhone.'</td>';
			echo '<td>'.$data->EmailAddress.'</td>';
			echo '<td>';?><input type="checkbox" disabled <?php echo $data->IsActive==1?'checked ':'';?>  > <?php echo '</td>';
			echo '<td>';?><input type="checkbox" disabled <?php echo $data->IsGolden==1?'checked ':'';?>  > <?php echo '</td>';
			echo '<td>
					<a href="'.$editUrl.'" ><img src="'. get_template_directory_uri() .'/img/edit.png" alt="U" class="action-btn"></a>
					<a href="'.$delUrl.'"><img src="'. get_template_directory_uri() .'/img/delete.png" alt="D" class="action-btn"></a>
				</td>';
		echo "</tr>";
	}
	echo '</table>';
	
/** Member UPDATE Process **/	
}elseif(isset($_REQUEST['edit'])){
	/** FORM Update Process Start **/
	if(isset($_REQUEST['btnUpdate']) && $_REQUEST['btnUpdate']=='Update' ){
		
		$isActive=isset($_REQUEST['isActive'])?1:0;
		$isGoldan=isset($_REQUEST['isGoldan'])?1:0;
		$qryUpdate="UPDATE ".$wpdb->prefix."Niwot_NBA_Form SET
					BusinessName='".$_REQUEST['txtBusinessName']."',
					BusineeAddress='".$_REQUEST['txtBusinessAddress']."',
					MaillingAddress='".$_REQUEST['txtMaillingAddress']."',
					ContactName='".$_REQUEST['txtContactName']."',
					BusinessPhone=".$_REQUEST['txtBusinessPhoneNo'].",
					EmailAddress='".$_REQUEST['txtEmail']."',
					BusinessUrl='".$_REQUEST['txtBusinessUrl']."',
					Description='".$_REQUEST['txtDecription']."',
					IsActive=".$isActive.",
					IsGolden=".$isGoldan."
				WHERE FormId=".$_REQUEST['edit']."";
		if($wpdb->query($qryUpdate)){
			echo '<div class="updated"><p><strong>Form has been Updated</strong></p></div>';
		}else{
			echo '<div class="updated" style="border-left:4px solid #d9534f;"><p><strong>Can not Update form</strong></p></div>';
		}
	}
	/** FORM Update Process Over **/
	$qryGetMembers='SELECT * FROM '.$wpdb->prefix.'Niwot_NBA_Form WHERE FormId='.$_REQUEST['edit'].';';
	$result = $wpdb->get_results($qryGetMembers);
	$data=$result[0];	
	?>
<div class="form">
		<form id="frmMemberUpdate" name="frmMemberUpdate" method="post" >
		<div class="half-form" style="float:left">
				<table class="nba-update-form">
				<tr>
						<td><label for="txtFormId">Id</label></td>
						<td><input type="text" name="txtFormId" id="txtFormId" disabled value="<?php echo $data->FormId;?>"></td>
					</tr>
				<tr>
						<td><label for="txtBusinessName" >Business Name</label></td>
						<td><input type="text" id="txtBusinessName" name="txtBusinessName" value="<?php echo $data->BusinessName;?>"></td>
					</tr>
				<tr>
						<td><label for="txtBusinessAddress">Business Address</label></td>
						<td><textarea name="txtBusinessAddress" id="txtBusinessAddress" placeholder="Business Address Of Member" ><?php echo $data->BusineeAddress; ?></textarea></td>
					</tr>
				<tr>
						<td><label for="txtMaillingAddress">Mailling Address</label></td>
						<td><input type="text" name="txtMaillingAddress" id="txtMaillingAddress" value="<?php echo $data->MaillingAddress;?>"></td>
					</tr>
				<tr>
						<td><label for="txtContactName">Contact Name</label></td>
						<td><input type="text" name="txtContactName" id="txtContactName" value="<?php echo $data->ContactName;?>"></td>
					</tr>
				<tr>
						<td><label for="txtBusinessPhoneNo">Business Phone No </label></td>
						<td><input type="text" name="txtBusinessPhoneNo" id="txtBusinessPhoneNo" value="<?php echo $data->BusinessPhone;?>"></td>
					</tr>
				<tr>
						<td><label for="txtEmail">Email Address</label></td>
						<td><input type="text" name="txtEmail" id="txtEmail" value="<?php echo $data->EmailAddress;?>"></td>
					</tr>
				<tr>
						<td><label for="txtBusinessUrl">Busniess URL</label></td>
						<td><input type="text" name="txtBusinessUrl" id="txtBusinessUrl" value="<?php echo $data->BusinessUrl;?>"></td>
					</tr>
				<tr>
						<td><label for="txtDecription">Description</label></td>
						<td><textarea name="txtDecription" id="txtDecription"><?php echo $data->Description; ?></textarea></td>
					</tr>
			</table>
			</div>
		<div class="half-form" style="float:right">
				<table class="nba-update-form">
				<tr>
						<td ><span>
							<input type="radio" id="rdiHelp1" name="rdiHelp1" disabled checked  value="1">
							Yes</span>&nbsp; <span>
							<input type="radio" id="rdiHelp1" name="rdiHelp1" disabled <?php echo $data->Help1==0?'checked':'';?> value="0">
							No</span></td>
						<td><label>I am interested in sponsoring the Rhythm on the Rails Concert Series. Please contact me with further information.</label></td>
					</tr>
				<tr>
						<td ><span>
							<input type="radio" id="rdiHelp2" name="rdiHelp2" disabled checked value="1">
							Yes</span>&nbsp; <span>
							<input type="radio" id="rdiHelp2" name="rdiHelp2" disabled <?php echo $data->Help2==0?'checked':'';?> value="0">
							No</span></td>
						<td><label>I am interested in joining a committee and getting more involved. Please contact me with further information.</label></td>
					</tr>
				<tr>
						<td ><span>
							<input type="radio" id="rdiHelp3" name="rdiHelp3" disabled checked value="1">
							Yes</span>&nbsp; <span>
							<input type="radio" id="rdiHelp3" name="rdiHelp3" disabled <?php echo $data->Help3==0?'checked':'';?> value="0" >
							No</span></td>
						<td><label>I am interested in serving as an executive team member in the future. Please contact me with further information.</label></td>
					</tr>
				<tr>
						<td ><span>
							<input type="radio" id="rdiHelp4" name="rdiHelp4" disabled checked value="1">
							Yes</span>&nbsp; <span>
							<input type="radio" id="rdiHelp4" name="rdiHelp4" disabled <?php echo $data->Help4==0?'checked':'';?> value="0" >
							No</span></td>
						<td><label>I am interested in volunteering for projects when time and energy allow. Please feel free to contact me as those projects arise.</label></td>
					</tr>
				<tr>
						<td ><label for="isActive">Is Active</label></td>
						<td><input type="checkbox" id="isActive" name="isActive" <?php echo $data->IsActive==1?'checked ':''; ?>  value="1"></td>
					</tr>
				<tr>
						<td ><label for="isGoldan">Is Goldan</label></td>
						<td><input type="checkbox" id="isGoldan" name="isGoldan" <?php echo $data->IsGolden==1?'checked ':''; ?> value="1"></td>
					</tr>
				<tr>
						<td/>
						<td><input type="submit" name="btnUpdate"  value="Update">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="reset" value="Reset"></td>
					</tr>
			</table>
			</div>
	</form>
	</div>
	<a href="options-general.php?page=NiwotOp" >Back</a>
	<?php
	
/** Member DELETE Process **/	
}elseif(isset($_REQUEST['del'])){
	$qryDelete='DELETE FROM '.$wpdb->prefix.'Niwot_NBA_Form WHERE FormId='.$_REQUEST['del'].';';
	echo $qryDelete.'<br>';
	if($wpdb->query($qryDelete)){
		echo '<script> alert("Member has been Deleted"); </script>';	
	}else{
		echo '<script> alert("Can Not Delete Member"); </script>';
	}
	echo '<a href="options-general.php?page=NiwotOp" >Back</a>';
}
?>
</div>