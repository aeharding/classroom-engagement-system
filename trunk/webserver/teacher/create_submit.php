<?php
$con=mysqli_connect("localhost","appcooki_voteadm","trace","appcooki_vote");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql="INSERT INTO sessions (id, email, pass)
VALUES
('$_POST[sid]','$_POST[email]','$_POST[pass]')";

if (!mysqli_query($con,$sql)) {
  die('Error: ' . mysqli_error());
}
echo "1 record added";

mysqli_close($con);
?>