<?php
	// Comes from admin.php
	session_start();
	
	include '../setup/connect.php';
	
	if ($_POST['ces_submitted'] == 1) {
		$description = $_POST['description'];
		$answerType = $_POST['answerType'];
		$corrAnswer = $_POST['corrAnswer'];
		$con = new mysqli($config_server, $config_user, $config_pass, $config_table);
				
		$description = $con->real_escape_string($description);
		
		$date = date('Y-m-d H:i:s');
		
		$query = "INSERT INTO questions (s_sid,s_qtype,s_correct,s_qdesc,s_time) 
							VALUES('{$_SESSION['session']}','$answerType','$corrAnswer','$description','$date')";
		$result = $con->query($query);
	}
	
	// Go back to admin control panel
	header("location:admin.php");
?>