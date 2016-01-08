<?php
global $wpdb;

$table_name = $wpdb->prefix.'cipher_contact_request_master';
$query = "SELECT contact_id as Id,name as Name ,email as Email ,skype as Skype ,phone as Phone,message as Message ,request_date as Date FROM ".$table_name;
$result = $wpdb->get_results($query);

echo '<div class="cipher_admin_container ">';
if(! count($result)){
	echo 'NO Data Found';
}else{
	$table_header = $result[0];
	echo '<table class="table">';
		echo '<tr>';
			foreach($table_header as $header=>$val){
				echo '<th>'.$header.'</th>';	
			}
		echo '</tr>';
		foreach($result as $row){
			$row = (array) $row;
			echo '<tr>';
				foreach($row as $col){
					echo '<td>'.$col.'</td>';
				}
			echo '</tr>';
		}
	echo '</table>';

}
echo '</div>';