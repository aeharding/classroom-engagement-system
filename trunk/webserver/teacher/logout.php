<?php
	session_start();
	
	session_destroy();
	
	$url = 'index.php';
	if(isset($_GET['to'])) {
		$url = $_GET['to'];
	}
	
	header("location:../".$url);
	
?>