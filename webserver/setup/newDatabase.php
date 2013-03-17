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
sessionName CHAR(30),
sessionDesc CHAR(150),
sessionisOpen TINYINT(1),
loginPass CHAR(30)
)";

// Execute query
if (mysqli_query($con,$sql)) {
  echo "Table sessions created successfully";
} else {
  echo "Error creating table: " . mysqli_error();
}



mysqli_close($con);
?>