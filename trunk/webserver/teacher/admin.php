<?php

	session_start();
	if(!isset($_SESSION['session'])) {
		session_destroy();
		header("location:login.php");
	}

?>