<?php

	echo '<h1>REMOVE THIS FILE</h1><h3>After initial configuration</h3>Detailed events:<br><hr>';
	
	include '../setup/connect.php';
		
	// Create connection
	$con = new mysqli($config_server, $config_user, $config_pass, $config_table);

	// Check connection
	if ($con->connect_errno) {
			printf("Connect failed: %s\n", $con->connect_error);
			exit();
	}

	// Create status
	$sql = "CREATE TABLE sessions 
	(
	PID INT NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY(PID),
	s_sid CHAR(30),
	s_desc CHAR(50),
	s_email CHAR(150),
	s_isOpen TINYINT(1) NOT NULL DEFAULT '0',
	s_pass CHAR(32)
	)";

	// Execute query
	if (!$con->query($sql)) {
		printf("Error message: %s\n", $con->error);
	} else {
		printf("Created table 'sessions' successfully.\n");
	}
	echo '<br>';

	// Create votes
	$sql = "CREATE TABLE votes 
	(
	PID INT NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY(PID),
	s_sid CHAR(30),
	s_qnum CHAR(50),
	s_vote CHAR(150)
	)";

	// Execute query
	if (!$con->query($sql)) {
		printf("Error message: %s\n", $con->error);
	} else {
		printf("Created table 'votes' successfully.\n");
	}
	echo '<br>';

	// Create questions
	/* Different types:
		1. mult [A-E answers]
		2. bool [true/false]
		3. resp [up to 150 characters]
	*/
	$sql = "CREATE TABLE questions 
	(
	PID INT NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY(PID),
	s_sid CHAR(30),
	s_qtype CHAR(4),
	s_correct CHAR(1),
	s_time CHAR(150),
	s_qdesc CHAR(150)
	)";

	// Execute query
	if (!$con->query($sql)) {
		printf("Error message: %s\n", $con->error);
	} else {
		printf("Created table 'questions' successfully.\n");
	}
	
	echo '<hr><h3>Done!</h3>';

	$con->close();
?>