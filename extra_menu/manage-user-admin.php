<link href="<?php bloginfo( 'template_url' ); ?>/css/admin.css" rel="stylesheet" type="text/css" media="all">
<div class="wrap">
<div style="margin:10px;padding:5px 10px;">
<label for="code">Code For User Managment  :</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label><input id="code" type="text" readonly value="[manage-users]"></label>
</div>
	<?php
	global $wpdb;
	$url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$url=truncateQueryString('userid',$url);
	if(count($_GET)==0){
		$startQue="?";
	}else{
		$startQue="&";
	}
	
	
	
	if(! isset($_REQUEST['userid'])){
	$qryGetuserDetail="SELECT * FROM ".$wpdb->prefix."UserMaster";
	$Result=$wpdb->get_results($qryGetuserDetail);
	
	echo '<table class="nba-detail" cellspacing="5px">';
	echo '<tr>
			<th>Id</th>
			<th>Name</th>
			<th>Email</th>
			<th>Agency</th>
			<th>Office Phone</th>
			<th>Cell Phone</th>
			<th>Action</th>
		</tr>';
	foreach($Result as $Data){
		echo '<tr>
				<td>'.$Data->UserId.'</td>
				<td>'.$Data->FirstName.'&nbsp;'.$Data->LastName.'</td>
				<td>'.$Data->Email.'</td>
				<td>'.$Data->Agency.'</td>
				<td>'.$Data->OfficePhone.'</td>
				<td>'.$Data->CellPhone.'</td>
				<td><a href="'.$url.$startQue.'userid='.$Data->UserId.'">Detail</a></td>
			</tr>';
	}
	echo '</table>';
	}elseif(isset($_REQUEST['userid'])){
		
		$qryGetuserDetail="SELECT * FROM ".$wpdb->prefix."UserMaster WHERE UserId=".$_REQUEST['userid']."";
		$Result=$wpdb->get_results($qryGetuserDetail);
		$Data=$Result[0];
		//print_r($Data);
		?>
			<div class="form">
				<div class="half-form" style="float:left">
					<table class="nba-update-form">
						<tr>
							<td><label>Id</label></td>
							<td><label><?php echo $Data->UserId; ?></label></td>
						</tr>
						<tr>
							<td><label>Name</label></td>
							<td><label><?php echo $Data->FirstName.'&nbsp;'.$Data->LastName; ?></label></td>
						</tr>
						<tr>
							<td><label>Email</label></td>
							<td><label><?php echo $Data->Email; ?></label></td>
						</tr>
						<tr>
							<td><label>Agency</label></td>
							<td><label><?php echo $Data->Agency; ?></label></td>
						</tr>
						<tr>
							<td><label>Agency Addresss</label></td>
							<td><label><?php echo $Data->AgencyAddress; ?></label></td>
						</tr>
					</table>
				</div>
				<div class="half-form" style="float:right">
					<table class="nba-update-form">
						<tr>
							<td><label>City</label></td>
							<td><label><?php echo $Data->City; ?></label></td>
						</tr>
						<tr>
							<td><label>State</label></td>
							<td><label><?php echo $Data->State; ?></label></td>
						</tr>
						<tr>
							<td><label>Zipcode</label></td>
							<td><label><?php echo $Data->Zipcode; ?></label></td>
						</tr>
						<tr>
							<td><label>Office Phone</label></td>
							<td><label><?php echo $Data->OfficePhone; ?></label></td>
						</tr>
						<tr>
							<td><label>Cell Phone</label></td>
							<td><label><?php echo $Data->CellPhone; ?></label></td>
						</tr>
						<tr>
							<td><label>Fax </label></td>
							<td><label><?php echo $Data->fax; ?></label></td>
						</tr>
					</table>
				</div>
			</div>
		<?php
		echo '<br><a href="'.$url.'">Back</a>';
	}
	?>
</div>