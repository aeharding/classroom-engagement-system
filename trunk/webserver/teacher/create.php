<?php
	
function checkID($con,$id_check) {
	$id_check = $con->real_escape_string($id_check); // Prevent SQL Injections
	$query = "SELECT * FROM sessions WHERE s_sid='" . $id_check . "'";
	$result = $con->query($query);
	if(count($result->fetch_array(MYSQLI_NUM)) > 0) {
		return false;
	}
	return true;
}

$continue = true;
$invalid['ces_sid'] = false;
$invalid['ces_email'] = false;
$invalid['ces_pass'] = false;
$invalid['ces_pass_ver'] = false;
$reason_fail = "";
$id = "";
$email = "";
$pass = "";
$pass_ver = "";

if ($_POST['ces_submitted'] == 1) {
	include '../setup/connect.php';
	$con = new mysqli($config_server, $config_user, $config_pass, $config_table);
	$id = $_POST['ces_sid'];
	$email = $_POST['ces_email'];
	$pass = $_POST['ces_pass'];
	$pass_ver = $_POST['ces_pass_ver'];
	if((!filter_var($email, FILTER_VALIDATE_EMAIL))) {
		$continue = false;
		$invalid['ces_email'] = true;
		$email = "";
		$reason_fail .= "<br>Your email address is invalid.";
	}
	if($pass != $pass_ver) {
		$continue = false;
		$invalid['ces_pass_ver'] = true;
		$pass_ver = "";
		$reason_fail .= "<br>Your entered password does not match.";
	}
	if(strlen($pass) < 5) {
		$continue = false;
		$invalid['ces_pass'] = true;
		$pass = "";
		$reason_fail .= "<br>Your entered password must be more than 5 characters.";
	}
	if(!checkID($con,$id)) {
		$continue = false;
		$invalid['ces_sid'] = true;
		$id = "";
		$reason_fail .= "<br>The session ID is already taken.";
	}
	if(strlen($id) < 3) {
		$continue = false;
		$invalid['ces_sid'] = true;
		$id = "";
		$reason_fail .= "<br>The session ID must be greater than three characters.";
	}
	
	if($continue) {
		// Check connection
		if ($con->connect_errno) {
				printf("Connect failed: %s\n", $con->connect_error);
				exit();
		}
		
		// Prevent SQL Injections
		$id = $con->real_escape_string($id);
		$email = $con->real_escape_string($email);
		$pass = $con->real_escape_string($pass);
		
		$pass = md5(utf8_encode($pass));
		
		$sql="INSERT INTO sessions (s_sid, s_email, s_pass)
		VALUES
		('$id','$email','$pass')";

		if (!mysqli_query($con,$sql)) {
			die('Error: ' . mysqli_error());
		}
		//echo "1 record added"; // Debugging; will break html

		mysqli_close($con);
		
		session_start();
		$_SESSION['session'] = $id; // Automatically login
		
		include 'email/welcome.php';
		
		header( 'Location: admin.php' ) ;
	}
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
    <link href="../css/bootstrap.css" rel="stylesheet">
    
    <link rel="stylesheet" href="../css/font-awesome.min.css">

    <script type="text/javascript" src="../js/ie-mobile-fix.js"></script>
    
    <link href="../css/bootstrap-responsive.css" rel="stylesheet">

    <link href="../css/navbar.css" rel="stylesheet">
    
    <link href="../css/cas.css" rel="stylesheet">

    <script type="text/javascript" src="../js/jquery-1.9.1.js"></script>

    <script type="text/javascript" src="../js/bootstrap.js"></script>
    
    <script type="text/javascript">
			$(document).ready(function() {
				$('#submit-loader')
				.click(function () {
						var btn = $(this)
						btn.button('loading')
						setTimeout(function () {
								btn.button('reset')
						}, 3000)
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
						<a class="brand" href="../index.php">CES</a>
						<div class="nav-collapse collapse">
							<ul class="nav">
								<li><a href="../student/index.php">Join Session</a></li>
								<li class="active"><a href="create.php">Create Session</a></li>
								<li><a href="admin.php">Administer Session</a></li>
							</ul>
						</div><!--/.nav-collapse -->
					</div>
				</div>
			</div>

			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span6 offset3" style="text-align:center">
						<?php
							if(!$continue) {
								echo '<div class="alert alert-error">
												<button type="button" class="close" data-dismiss="alert">×</button><strong>Form not submitted.</strong> ' . $reason_fail . '
											</div>';
							}
						?>
						<form action="create.php" method="post">
							<h2>Enter details</h2>
							
							<div style="max-width:300px;" class="center">
								<div class="input-prepend<?php if($invalid['ces_sid']) echo ' control-group warning';?>" style="width:100%">
									<span class="add-on"><i class="icon-book"></i></span>
									<input id="inputIcon" type="text" name="ces_sid" autocomplete="off" style="width:80%" placeholder="Class session name" value="<?php echo $id; ?>">
								</div>
								<div class="input-prepend<?php if($invalid['ces_email']) echo ' control-group warning';?>" style="width:100%">
									<span class="add-on"><i class="icon-envelope"></i></span>
									<input id="inputIcon" type="text" name="ces_email" autocomplete="off" style="width:80%" placeholder="Your email" value="<?php echo $email; ?>">
								</div>
								<div class="input-prepend<?php if($invalid['ces_pass']) echo ' control-group warning';?>" style="width:100%">
									<span class="add-on"><i class="icon-key"></i></span>
									<input id="inputIcon" type="password" name="ces_pass" autocomplete="off" style="width:80%" placeholder="Password" value="<?php echo $pass; ?>">
								</div>
								<div class="input-prepend<?php if($invalid['ces_pass_ver']||$invalid['ces_pass']) echo ' control-group warning';?>" style="width:100%">
									<span class="add-on"><i class="icon-repeat"></i></span>
									<input id="inputIcon" type="password" name="ces_pass_ver" autocomplete="off" style="width:80%" placeholder="Password verification" value="<?php echo $pass_ver; ?>">
								</div>
								<input type="hidden" name="ces_submitted" value="1">
							</div>
							<button class="btn btn-large btn-info" type="submit" id="submit-loader" data-loading-text="Loading...">Create + Administrate</button>
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