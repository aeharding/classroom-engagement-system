<?php
	session_start();
	
	if(!isset($_SESSION['student'])) {
		header('location:../index.php');
	}
	
	include '../../setup/connect.php';
	$con = new mysqli($config_server, $config_user, $config_pass, $config_table);
	// Check connection
	if ($con->connect_errno) {
			printf("Connect failed: %s\n", $con->connect_error);
			exit();
	}
	
	$query = "SELECT PID FROM questions WHERE s_sid='" . $_SESSION['studentSession'] . "' AND s_open=1";
	$result = $con->query($query);
	if (!$result) {
		die('Error: ' . mysqli_error());
	}
	$row = $result->fetch_array();
	$qid = $row[0];
	
	if($qid == $_GET['id']) {
		// Get (any) previous answer
		$query = "SELECT s_vote FROM votes WHERE s_student='" . $_SESSION['student'] . "' AND s_qnum='" . $qid . "'";
		$result = $con->query($query);
		if (!$result) {
			die('Error: ' . mysqli_error());
		}
		$row = $result->fetch_array();
		
		if(empty($row)) {
			$query = "INSERT INTO votes (s_sid, s_student, s_qnum, s_vote) VALUES ('". $_SESSION['studentSession'] . "', '" . $_SESSION['student'] . "' , '" . $qid . "','" . $_GET['vote'] . "')";
			$result = $con->query($query);
			if (!$result) {
				die('Error: ' . mysqli_error());
			}
		} else {
			// Not empty; update previous answer
			$query = "UPDATE votes SET s_vote='" . $_GET['vote'] . "' WHERE s_student='" . $_SESSION['student'] . "' AND s_qnum='" . $qid . "'";
			$result = $con->query($query);
			if (!$result) {
				die('Error: ' . mysqli_error());
			}
			header('location:index.php');
		}
	} else {
		header('location:index.php?followup=syncError');
	}
	
	mysqli_close($con);
?>