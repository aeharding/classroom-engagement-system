<?php
	// Comes from admin.php
	session_start();
	
	include '../setup/connect.php';
	
	if ($_POST['ces_submitted'] == 1) {
		$description = $_POST['description'];
		$answerType = $_POST['answerType'];
		$corrAnswer = $_POST['corrAnswer'];
		$con = new mysqli($config_server, $config_user, $config_pass, $config_table);
		
		$query = "SELECT PID FROM `sessions` WHERE s_sid='" . $_SESSION['session'] . "'";
		
		$result=$con->query($query);
		$row = $result->fetch_array(MYSQLI_NUM);
		$session_id = $row[0];
		
		$description = $con->real_escape_string($description);
		
		$query = "INSERT INTO questions (s_sid,s_qtype,s_correct,s_qdesc) 
							VALUES($session_id,'$answerType','$corrAnswer','$description')";
		$result = $con->query($query);
	}
	
	// Go back to admin control panel
	header("location:admin.php");
?>