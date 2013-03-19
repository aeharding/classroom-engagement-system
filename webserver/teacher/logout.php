<?php

	session_start(); 
	if(isset($_SESSION['sessionActive']) && $_SESSION['sessionActive']) {
		$con = new mysqli("localhost","appcooki_voteadm","trace","appcooki_vote");
		$query = "UPDATE sessions SET s_isOpen='0' WHERE s_sid='" . $_SESSION['session'] . "'";
		$result = $con->query($query);
	}
	session_destroy();
	header("location:login.php");
	
?>