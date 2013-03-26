<?php

	session_start(); 
	if(isset($_SESSION['sessionActive']) && $_SESSION['sessionActive']) {
		include '../setup/connect.php';
		$con = new mysqli($config_server, $config_user, $config_pass, $config_table);
		$query = "UPDATE sessions SET s_isOpen='0' WHERE s_sid='" . $_SESSION['session'] . "'";
		$result = $con->query($query);
	}
	session_destroy();
	
	$url = 'index.php';
	if(isset($_GET['to'])) {
		$url = $_GET['to'];
	}
	
	header("location:../".$url);
	
?>