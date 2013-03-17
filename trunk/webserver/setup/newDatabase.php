<?php
// Create connection
$con=mysqli_connect("localhost","appcooki_voteadm","trace","appcooki_vote");

// Check connection
if (mysqli_connect_errno($con)) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Create status
$sql = "CREATE TABLE sessions 
(
PID INT NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(PID),
id CHAR(30),
desc CHAR(150),
email CHAR(150),
isOpen TINYINT(1),
pass CHAR(30)
)";

// Execute query
if (mysqli_query($con,$sql)) {
  echo "Table sessions created successfully";
} else {
  echo "Error creating table: " . mysqli_error();
}



mysqli_close($con);
?>