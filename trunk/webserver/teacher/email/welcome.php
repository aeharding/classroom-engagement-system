<?php
	/* ONLY USED BY CREATE.PHP, expects:
			1. $email: Email of user
			2. $id:		 Class session name
			3. $pass:  Specified password for $id
	*/
	
	include '../setup/connect.php';
	
	$subject = 'Welcome to the Classroom Engagement System';

	$headers = "From: " . $mail_sender . "\r\n";
	$headers .= "Reply-To: ". $mail_replyto . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
	$message  = '<h3>Welcome to CES, the Classroom Engagement System!</h3><br>';
	$message .= 'You can login <a href="' . $base_URL . '/teacher/login.php">here</a> with the credentials below:<br>';
	$message .= 'Class session name: <b>' . $id . '</b><br>';
	$message .= 'Password: <b>' . $pass . '</b><br><br>';
	$message .= '<h5>You will only recieve email when you request from now on. Cheers for less email spam!</h5>';

	mail($email, $subject, $message, $headers);

?>