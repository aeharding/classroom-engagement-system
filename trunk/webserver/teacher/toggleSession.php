<?php
	session_start();
	if(isset($_SESSION['session'])) {
		if($_SESSION['sessionActive']) {
			$_SESSION['sessionActive'] = false;
			header("location:admin.php");
		} else {
			$_SESSION['sessionActive'] = true;
			header("location:admin.php");
		}
		include '../setup/connect.php';
		$con = new mysqli($config_server, $config_user, $config_pass, $config_table);
		$query = "UPDATE sessions SET s_isOpen='" . $_SESSION['sessionActive'] . "' WHERE s_sid='" . $_SESSION['session'] . "'";
		$result = $con->query($query);
	} else {
		// User not supposed to be here
		header("location:login.php");
	}
?>