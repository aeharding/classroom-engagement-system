<?php
	session_start();
	
	$problem = false;
	
	include '../../php/Mobile_Detect.php';
	$detect = new Mobile_Detect();
	$autofocus = true;
	if ($detect->isMobile() || $detect->isTablet()) {
    $autofocus = false;
	}
	
	if ($_POST['ces_submitted'] == 1) {
		include '../../setup/connect.php';
		$con = new mysqli($config_server, $config_user, $config_pass, $config_table);
		// Check connection
		if ($con->connect_errno) {
				printf("Connect failed: %s\n", $con->connect_error);
				exit();
		}
		
		$email = $_POST['ces_email'];
		$id = $_POST['ces_sid'];
		
		// Prevent SQL Injections
		$email = $con->real_escape_string($email);
		$id = $con->real_escape_string($id);

		$sql="SELECT count(1) FROM sessions WHERE s_sid='" . $id . "' AND s_email='" . $email . "'";

		if (!mysqli_query($con,$sql)) {
			die('Error: ' . mysqli_error());
		}
		
		$result = $con->query($sql);
		$row = $result->fetch_array(MYSQLI_NUM);
		$total = $row[0];
		if($total == 1) {
			
			$password = md5(uniqid(rand()));
			$password=substr($password, 0, 8);
			
			$encodedPassword = md5(utf8_encode($password));
			
			$sql="UPDATE sessions SET s_pass='" . $encodedPassword . "' WHERE s_sid='" . $id . "'";

			if (!mysqli_query($con,$sql)) {
				die('Error: ' . mysqli_error());
			}
			
			$result = $con->query($sql);

			
			$subject = '[requested] Your new CAS session password';

			$headers = "From: " . $mail_sender . "\r\n";
			$headers .= "Reply-To: ". $mail_replyto . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			$message  = '<h3>You requested a password for your CAS session.</h3><br>';
			$message .= 'You can login <a href="' . $base_URL . '/teacher/login.php">here</a>.';
			$message .= '<h2>Temporary password: ' . $password . '</h2>';
			$message .= '<h5>You will only recieve email when you request. Cheers for less email spam!</h5>';

			mail($email, $subject, $message, $headers);
		} else {
			$email = "";
			$id = "";
			$problem = true;
		}
		
		mysqli_close($con);
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Classroom Engagement System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <link href="../../css/bootstrap.css" rel="stylesheet">
    
    <link rel="stylesheet" href="../../css/font-awesome.min.css">

    <script type="text/javascript" src="../../js/ie-mobile-fix.js"></script>
    
    <link href="../../css/bootstrap-responsive.css" rel="stylesheet">
    
		<link href="../../css/navbar.css" rel="stylesheet">
    
    <link href="../../css/cas.css" rel="stylesheet">

    <script type="text/javascript" src="../../js/jquery-1.9.1.js"></script>

    <script type="text/javascript" src="../../js/bootstrap.js"></script>
    
		<script type="text/javascript">
			$(document).ready(function() {
				$('#submit-loader')
				.click(function () {
						var btn = $(this)
						btn.button('loading')
				});
			});
    </script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

  </head>

  <body>

		<div id="wrap">
			<div id="spacer-nav-fix"></div>
			<div class="navbar navbar-fixed-top" id="nav-ref">
				<div class="navbar-inner">
					<div class="container-fluid">
						<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="brand" href="../../index.php">CES</a>
						<div class="nav-collapse collapse">
							<ul class="nav">
								<li><a href="../../student/index.php">Join Session</a></li>
								<li><a href="../create.php">Create Session</a></li>
								<li class="active"><a href="../admin.php">Administrate Session</a></li>
							</ul>
						</div><!--/.nav-collapse -->
					</div>
				</div>
			</div>

			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span6 offset3" style="text-align:center">
						<?php
							if($problem) {
								echo '<div class="alert alert-error">
												<button type="button" class="close" data-dismiss="alert">&times;</button><strong>Looks like a problem.</strong> No session names associated with this email address were found.
											</div>';
							} else if($_POST['ces_submitted'] == 1) {
								echo '<div class="alert alert-success">
												<button type="button" class="close" data-dismiss="alert">&times;</button><strong>Email\'s away!</strong> Please check your inbox, and <a href="../login.php">login here</a>.
											</div>';
							}
						?>
						<form action="password.php" method="post">
							<h2>Enter details</h2>
							<div style="max-width:300px;" class="center">
								<div class="input-prepend<?php if($problem) echo ' control-group warning';?>" style="width:100%">
									<label for="ces_email" style="display:inline"><span class="add-on"><i class="icon-envelope"></i></span></label>
									<input type="email" name="ces_email" id="ces_email" autocomplete="off" value="<?php echo $email; ?>" <?php if($autofocus) echo 'autofocus'; ?> style="width:80%" placeholder="Associated email address">
								</div>
								<div class="input-prepend<?php if($problem) echo ' control-group warning';?>" style="width:100%">
									<label for="ces_sid" style="display:inline"><span class="add-on"><i class="icon-book"></i></span></label>
									<input type="text" name="ces_sid" id="ces_sid" autocomplete="off" value="<?php echo $id; ?>" style="width:80%" placeholder="Class session name">
								</div>
								<input type="hidden" name="ces_submitted" value="1">
							</div>
							<button class="btn btn-large btn-primary" type="submit" id="submit-loader" data-loading-text="Loading...">Email me</button>
						</form>
					</div>
				</div>
			</div> <!-- /container -->
			<div id="push"></div> <!-- Footer pusher -->
		</div> <!-- /wrap -->
		
		<div id="footer">
      <div class="container-fluid">
        <p class="muted credit" style="text-align:center">&copy; 2013 <a href="http://wiki.gpii.net/index.php/R2R" target="_blank">R2R</a> and <a href="http://trace.wisc.edu" target="_blank">Trace R&amp;D Center</a></p>
      </div>
    </div>

  </body>
</html>