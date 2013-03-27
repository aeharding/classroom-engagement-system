<?php
	// Comes from admin.php
	session_start();
	include '../setup/connect.php';

	if(isset($_SESSION['session'])) {
		$con = new mysqli($config_server, $config_user, $config_pass, $config_table);
			
		$query = "UPDATE questions SET s_open=0 WHERE s_sid='{$_SESSION['session']}' AND s_open=1";
		$result = $con->query($query);
	}
	
	// Go back to admin control panel (will handle unauthorized user forwarding there)
	header("location:admin.php");
?>