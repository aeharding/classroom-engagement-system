<?php
// Create connection
$con = new mysqli("localhost","appcooki_voteadm","trace","appcooki_vote");

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
s_isOpen TINYINT(1) NOT NULL DEFAULT 'F',
s_pass CHAR(30)
)";

// Execute query
if (!$con->query($sql)) {
	printf("Error message: %s\n", $con->error);
} else {
	printf("Created table 'sessions' successfully.");
}

$con->close();
?>