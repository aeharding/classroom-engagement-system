<?php

	include '../setup/connect.php';

	$con = new mysqli($config_server, $config_user, $config_pass, $config_table);


	$sql="SELECT s_vote FROM votes WHERE s_qnum='" . $_GET['id'] . "'";

	if (!mysqli_query($con,$sql)) {
		die('Error: ' . mysqli_error());
	}
	
	$result = $con->query($sql);
	
	$count = array();
	array_push($count,array("Value","Votes"));
	
	while($row = mysqli_fetch_array($result)) {
		for($pos = 0; $pos < count($count); $pos++) {
			if($count[$pos][0] == $row[0]) {
				break;
			}
		}
		if($pos != count($count)) {
			$count[$pos][1]++;
		} else {
			array_push($count,array($row[0],1));
		}
	}
	
	echo json_encode($count);
?>