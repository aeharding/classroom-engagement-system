<?php
	session_start();
	
	if(isset($_SESSION['session'])) {
		include '../../setup/connect.php';
		$con = new mysqli($config_server, $config_user, $config_pass, $config_table);
		// Check connection
		if ($con->connect_errno) {
				printf("Connect failed: %s\n", $con->connect_error);
				exit();
		}
		$sql="SELECT s_qnum,s_student,s_vote FROM votes WHERE s_sid='" . $_SESSION['session'] . "'";

		if (!mysqli_query($con,$sql)) {
			die('Error: ' . mysqli_error());
		}
		
		$result=$con->query($sql);
		
		printf("Question #,Student ID,Answer\r\n");
		
		while($row = $result->fetch_array(MYSQLI_NUM)) {
			 printf($row[0].",".$row[1].",".$row[2]."\r\n");
		}
	}
?>