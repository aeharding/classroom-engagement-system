<?php
	// Create connection
	include '../setup/connect.php';
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
	s_pass CHAR(30)
	)";

	// Execute query
	if (!$con->query($sql)) {
		printf("Error message: %s\n", $con->error);
	} else {
		printf("Created table 'sessions' successfully.");
	}

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
		printf("Created table 'votes' successfully.");
	}

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
	s_qdesc CHAR(150)
	)";

	// Execute query
	if (!$con->query($sql)) {
		printf("Error message: %s\n", $con->error);
	} else {
		printf("Created table 'questions' successfully.");
	}

	$con->close();
?>