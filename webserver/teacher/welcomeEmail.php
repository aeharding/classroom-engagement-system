<?php
	// Biiiggg TODO
	include '../setup/connect.php';
	$con = new mysqli($config_server, $config_user, $config_pass, $config_table);
	$sql="SELECT count(1) FROM sessions WHERE s_sid='" . $session . "' AND s_pass='" . $pass . "'";
	if (!mysqli_query($con,$sql)) {
		die('Error: ' . mysqli_error());
	}
	
	$result=$con->query($sql);
	$row = $result->fetch_array(MYSQLI_NUM);
	$total = $row[0];
	if($total == 1) {
	}


?>