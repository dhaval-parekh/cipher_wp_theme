<?php
	function reset_database(){
		global $wpdb;
		$wpdb->show_errors();
	
		if(isset($_REQUEST['btnDropUserMaster']) && $_REQUEST['btnDropUserMaster']=='Drop UserMaster'){
			$qryDrop="DROP TABLE  IF EXISTS ".$wpdb->prefix."UserMaster";
			if($wpdb->query($qryDrop)){
				echo '<div class="updated"><p><strong>UserMaster Table has been Droped</strong></p></div>';	
			}else{
				echo '<div class="updated" style="border-left:4px solid #d9534f;"><p><strong>Error In dropping of UserMaster (Please try Custome Query)</strong></p></div>';
			}
		}elseif(isset($_REQUEST['btnDropMembersMaster']) && $_REQUEST['btnDropMembersMaster']=='Drop MemberMaster'){
			$qryDrop="DROP TABLE IF EXISTS ".$wpdb->prefix."Niwot_NBA_Form";
			if($wpdb->query($qryDrop)){
				echo '<div class="updated"><p><strong>UserMaster Table has been Droped</strong></p></div>';	
			}else{
				echo '<div class="updated" style="border-left:4px solid #d9534f;"><p><strong>Error In dropping of UserMaster (Please try Custome Query)</strong></p></div>';
			}
		}elseif(isset($_REQUEST['btnDropPropertyMaster']) && $_REQUEST['btnDropPropertyMaster']=='Drop PropertyMaster'){
			
			$qryDrop="DROP TABLE IF EXISTS ".$wpdb->prefix."PropertyTypeDetail";
			$flag1=$wpdb->query($qryDrop);
			
			$qryDrop="DROP TABLE IF EXISTS ".$wpdb->prefix."PropertyFeatureDetail";
			$flag2=$wpdb->query($qryDrop);
			
			$qryDrop="DROP TABLE IF EXISTS ".$wpdb->prefix."PropertyMaster";
			$flag3=$wpdb->query($qryDrop);
			
			if($flag1 && $flag2 && $flag3){
				echo '<div class="updated"><p><strong>PropertyMaster Table has been Droped</strong></p></div>';	
			}else{
				echo '<div class="updated" style="border-left:4px solid #d9534f;"><p><strong>Error In dropping of UserMaster (Please try Custome Query)</strong></p></div>';
			}
		}elseif(isset($_REQUEST['btnSubmitSql']) && $_REQUEST['btnSubmitSql']=='Submit'){
			if(isset($_REQUEST['txtCustomeQuery']) && $_REQUEST['txtCustomeQuery']!=''){
				$Query=$_REQUEST['txtCustomeQuery'];
				
				
				if($wpdb->query($Query)){
					echo '<div class="updated" ><p><strong>Query has been Succesfully Executed</strong></p></div>';
				}else{
					echo '<div class="updated" style="border-left:4px solid #d9534f;"><p><strong>Error In Custome Query:</strong></p></div>';
					
				}
			}else{
				echo '<div class="updated" style="border-left:4px solid #d9534f;"><p><strong>Please Enter Query</strong></p></div>';
			}
			
		}elseif(isset($_REQUEST['btnSubmitSelect']) && $_REQUEST['btnSubmitSelect']=='Select'){
			// SELECT * Statment 
			if(isset($_REQUEST['txtCustomeQuery']) && $_REQUEST['txtCustomeQuery']!=''){
				$Query=$_REQUEST['txtCustomeQuery'];
				$Result=$wpdb->get_results($Query,ARRAY_A);
				
				if(count($Result)!=0){
					echo'<table style="width:100% !important;margin-top:10px;" border=1 cellspacing="0" cellpadding="5px"> ';
					//Display header
					$KeyAry=$Result[0];
					echo "<tr>";
					foreach($KeyAry as $key=>$text){
						echo "<th>".$key."</th>";
					}
					echo "</tr>";	
					
					//Display data
					foreach($Result as $row){
						echo '<tr>';
						foreach ($row as $key=>$col){
							echo '<td style="text-align:center;">'.$col.'</td>';	
						}
						echo '</tr>';
					}
					
					echo "</table>";
				}else{
					echo "Result is Empty<br>";	
				}
				
			}else{
				echo '<div class="updated" style="border-left:4px solid #d9534f;"><p><strong>Please Enter Query</strong></p></div>';
			}
			
		}
		$wpdb->hide_errors();
		?>
			<div style="margin:10px;padding:5px 10px;">
				<label for="code">Table Prefix :</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label><input id="code" type="text" readonly value="<?php echo  $wpdb->prefix; ?>"></label>
			</div>

			<form name="frmResetDb" method="post"  onSubmit="return confirm('Are sure about your Action ?');">
				<table class="nba-detail" cellspacing="5px" style="width:100%" >
					<tr>
						<td colspan="4">
							<textarea name="txtCustomeQuery" placeholder="Enter Query" style="width:100%;height:128px;resize:vertical;" ></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" name="btnSubmitSql" value="Submit" style="margin-right:10px">
							<input type="submit" name="btnSubmitSelect" Value="Select">
						</td>
						<td>
							<input type="submit" name="btnDropUserMaster" tabindex="-1" value="Drop UserMaster">
						</td>
						<td>
							<input type="submit" name="btnDropMembersMaster" tabindex="-1" value="Drop MemberMaster">
						</td>
						<td>
							<input type="submit" name="btnDropPropertyMaster" tabindex="-1" value="Drop PropertyMaster">
						</td>
						
					</tr>
				</table>
			</form>
		<?php
		
	}
?>
<?php
	function reset_db_admin_action(){
		add_submenu_page( 'NiwotOp', 'Reset Database', 'Reset Database', 'manage_options','ResetDatabase', 'reset_database');	
	}
	add_action('admin_menu','reset_db_admin_action');
	
	
?>