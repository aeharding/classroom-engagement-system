<?php
	session_start();

	include '../php/Mobile_Detect.php';
	$detect = new Mobile_Detect();
	$autofocus = true;
	if ($detect->isMobile() || $detect->isTablet()) {
    $autofocus = false;
	}
	
	$count = 0;
	
	$invalid = false;
	$id = "";
	
	if(isset($_SESSION['session'])) {
		header("location:admin.php");
	}
	if ($_POST['ces_submitted'] == 1) {
		include '../setup/connect.php';
		$con = new mysqli($config_server, $config_user, $config_pass, $config_table);
		// Check connection
		if ($con->connect_errno) {
				printf("Connect failed: %s\n", $con->connect_error);
				exit();
		}
		
		$session = $_POST['ces_sid'];
		$pass = $_POST['ces_pass'];
		
		// Prevent SQL Injections
		$session = $con->real_escape_string($session);
		$pass = $con->real_escape_string($pass);
		
		$pass = md5(utf8_encode($pass));
	
		$sql="SELECT count(1) FROM sessions WHERE s_sid='" . $session . "' AND s_pass='" . $pass . "'";

		if (!mysqli_query($con,$sql)) {
			die('Error: ' . mysqli_error());
		}
		
		$result=$con->query($sql);
		$row = $result->fetch_array(MYSQLI_NUM);
		$total = $row[0];
		if($total == 1) {
			$_SESSION['session'] = $session;
			header("location:admin.php");
		} else {
			$id = $_POST['ces_sid'];
			$invalid = true;
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
								<li><a href="create.php">Create Session</a></li>
								<li class="active"><a href="admin.php">Administer Session</a></li>
							</ul>
						</div><!--/.nav-collapse -->
						 <?php if(isset($_SESSION['student'])) echo '
							<div style="display:inline-block" class="navbar-pull-right">
								<ul class="nav">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> '.$_SESSION['student'].' <b class="caret"></b></a>
										<ul class="dropdown-menu pull-right">
											<li><a href="../student/logout.php"><i class="icon-stop"></i> Leave session</a></li>
										</ul>
									</li>
								</ul>
							</div>
							'; ?>
					</div>
				</div>
			</div>

			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span6 offset3" style="text-align:center">
						<?php
							if($_GET['created']) {
								echo '<div class="alert alert-success">
												<button type="button" class="close" data-dismiss="alert">×</button><strong>Success!</strong> Session created. Login to get started.
											</div>';
							} else if($_POST['ces_submitted']) {
								echo '<div class="alert alert-error">
												<button type="button" class="close" data-dismiss="alert">×</button><strong>Oops!</strong> Make sure you typed in the correct credentials.
											</div>';
							}
						?>
						<form action="login.php" method="post">
							<h2>Enter details</h2>
							<div style="max-width:300px;" class="center">
								<div class="input-prepend<?php if($invalid) echo ' control-group warning';?>" style="width:100%">
									<label for="ces_sid" style="display:inline"><span class="add-on"><i class="icon-book"></i></span></label>
									<input type="text" name="ces_sid" id="ces_sid" autocomplete="off" value="<?php echo $id; ?>" <?php if($autofocus && !$invalid) echo 'autofocus'; ?> style="width:80%" placeholder="Class session name">
								</div>
								<div class="input-prepend<?php if($invalid) echo ' control-group warning';?>" style="width:100%">
									<label for="ces_pass" style="display:inline"><span class="add-on"><i class="icon-key"></i></span></label>
									<input type="password" name="ces_pass" id="ces_pass" autocomplete="off" <?php if($autofocus && $invalid) echo 'autofocus'; ?> style="width:80%" placeholder="Password">
								</div>
								<input type="hidden" name="ces_submitted" value="1">
							</div>
							<button class="btn btn-large btn-danger" type="submit" id="submit-loader" data-loading-text="Loading...">Administrate</button>
						</form>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span6 offset3" style="text-align:center">
						<p>Forgot your <a href="forgot/session.php">session name</a> or <a href="forgot/password.php">password</a>?
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