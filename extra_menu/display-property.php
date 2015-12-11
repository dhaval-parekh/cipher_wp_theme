<?php
/**  New Short Code For Manage Property  **/
/**  For User Login, Sign Up, Display Property  **/
add_action('init',function(){
	add_shortcode('display-property','displayProperty');
});

function displayProperty(){
	global $wpdb,$url,$queryStrStart;
	
	if(! isset($_GET['pid'])):
		$PropertyTypeAry=array('SALE','LEASE','Sublease');
		foreach($PropertyTypeAry as $type):
		
			$qryGetProperty="SELECT * FROM ".$wpdb->prefix."PropertyMaster WHERE Catagory='".$type."' AND isActive=true AND isDelete=false  ORDER BY PropertyId DESC";	
			$rsGetProperty=$wpdb->get_results($qryGetProperty);
			// DISPLAY PORPERTIES SALES
			echo '
				<div class="row"><h6 style="text-align:left;">Properties For '.$type.'</h6></div>
			';
			if(count($rsGetProperty)!=0){
				foreach($rsGetProperty as $item):
					?>
						<div class="event-post-container">
							<div class="event-detail">
								<a href="<?php echo $url.$queryStrStart.'pid='.$item->PropertyId; ?>">
								<div class="row-1"><?php echo $item->PropertyTitle; ?></p></div></a>
							</div>
							
						</div>
						
						<?php /*?><div class="event-post-container">
							<a class="img-container small" title="<?php echo $item->PropertyTitle; ?>" href="Javascript:">
								<img src="<?php echo $item->ImageUrl; ?>" alt="<?php echo $item->PropertyTitle; ?>">
							</a>
							<div class="event-detail">
								<div class="row-1"><label>Title</label><p><?php echo $item->PropertyTitle; ?></p></div>
								<div class="row-1"><label>Sale Price</label><p><?php echo $item->SalePrice; ?></p></div>
								<div class="row-1"><label>Description</label><p style="display:inline;"><?php echo $item->ShortDescription; ?></p></div>
							</div>
							<div class="row-1" style="text-align:right"><a href="<?php echo $url.$queryStrStart.'pid='.$item->PropertyId; ?>">Detail</a></div>
						</div><?php */?>
					<?php
				endforeach;
				echo "<br clear='all'>";
			}else{
				echo '<div class="row-1"><p>Coming soon! Properties for Display </p></div>';	
			}
			
		endforeach;
	elseif(isset($_GET['pid'])):
		
		$qryGetProperty="SELECT * FROM ".$wpdb->prefix."PropertyMaster WHERE isActive=true AND isDelete=false AND PropertyId=".$_GET['pid']."  ";	
		$rsGetProperty=$wpdb->get_results($qryGetProperty);
		
		$qryGetPropertyDetailType="SELECT TypeName FROM  ".$wpdb->prefix."PropertyTypeDetail WHERE PropertyId=".$_GET['pid']."";
		$rsGetPropertyDetailType=$wpdb->get_results($qryGetPropertyDetailType);
		$propertyType='';
		foreach($rsGetPropertyDetailType as $type){
			$propertyType.=$type->TypeName.' ,  ';	
		}
			
		$qryPopertyDetailFeature="SELECT * FROM ".$wpdb->prefix."PropertyFeatureDetail   WHERE PropertyId=".$_GET['pid']."";
		$rsPopertyDetailFeature=$wpdb->get_results($qryPopertyDetailFeature);
		
		foreach($rsGetProperty as $item){
		?>
			<div class="event-post-container">
				
				<a class="img-container" title="<?php echo $item->PropertyTitle; ?>" href="Javascript:">
					<img src="<?php echo $item->ImageUrl; ?>" alt="<?php echo $item->PropertyTitle; ?>">
				</a>
				<div class="event-detail">
					<div class="row-1"><label>Title</label><p><?php echo '<a href="'.$item->PropertyWebsite.'">'.$item->PropertyTitle.'</a>'; ?></p></div>
					<div class="row-1"><label>Address</label><p><?php echo $item->Address.', '.$item->City.', '.$item->State.', '.$item->Zipcode; ?></p></div>
					<div class="row-1"><label>Catagory</label><p><?php echo $item->Catagory; ?></p></div>
					<div class="row-1"><label>Type</label><p><?php echo $propertyType; ?></p></div>
					<div class="row-1"><label>Available SF</label><p><?php echo $item->AvailableSF; ?></p></div>
					<div class="row-1"><label>MLS</label><p><?php echo $item->MLS; ?></p></div>
					<div class="row-1"><label>Sale Price</label><p><?php echo $item->SalePrice; ?></p></div>
					<div class="row-1"><label>Lease Rate</label><p><?php echo $item->LeaseRate; ?></p></div>
				</div>
				<div>
					<div class="row-1"><label style="text-align:left;">Lease Tearms</label><p><?php echo $item->LeaseTerms; ?></p></div>
				</div>
				<div>
					<div class="row-1"><label style="text-align:left;">Features</label></div>
					<?php
						foreach($rsPopertyDetailFeature as $Data){
							echo '<div class="row-1"><label>'.$Data->FeatureLabel.'</label><p> '.$Data->FeatureValue.'</p></div>';	
						}
					?>
				</div>
				<div><p><?php echo $item->ShortDescription; ?></p></div>
				<div>
					<div class="row-1"><label style="text-align:left;">Contact Detail</label></div>
					<div class="row-1"><label>Contact Person</label><p><?php echo $item->ContactFirstName.' '.$item->ContactLastName; ?></p></div>
					
					<div class="row-1"><label>Office Phone</label><p><?php echo $item->ContactOfficePhone; ?></p></div>
					<div class="row-1"><label>Cell Phone</label><p><?php echo $item->ContactCellPhone; ?></p></div>
					<div class="row-1"><label>Email</label><p><?php echo $item->ContactEmail; ?></p></div>
				</div>
				
				<div class="row-1" style="text-align:right"><a href="<?php echo $url; ?>" >Back</a></div>
			</div>
		<?php
	}
	endif;
}

?>