<?php
	session_start();
	
	if(!isset($_SESSION['student'])) {
		header('location:../index.php');
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
		
		// Prevent SQL Injections
		$email = $con->real_escape_string($email);
			
		$query="SELECT s_sid FROM sessions WHERE s_email='" . $email . "'";

		$result = $con->query($query);
		
		if (!$result) {
			die('Error: ' . mysqli_error());
		}
		
		$sessions = '<ol>';
		for($numSessions = 0; $row = $result->fetch_array(); $numSessions++) {
			 $sessions .= '<li>' . $row[0] . '</li>';
		}
		$sessions .= '</ol>';
		
		if($numSessions != 0) {

		} else {
			$email = "";
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
								<li class="active"><a href="../index.php">Join Session</a></li>
								<li><a href="../../teacher/create.php">Create Session</a></li>
								<li><a href="../../teacher/admin.php">Administer Session</a></li>
							</ul>
							<?php if(isset($_SESSION['student'])) echo '
							<div style="display:inline-block" class="navbar-pull-right">
								<ul class="nav">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> '.$_SESSION['student'].' <b class="caret"></b></a>
										<ul class="dropdown-menu pull-right">
											<li><a href="../logout.php"><i class="icon-stop"></i> Leave session</a></li>
										</ul>
									</li>
								</ul>
							</div>
							'; ?>
						</div><!--/.nav-collapse -->
					</div>
				</div>
			</div>

			<div class="container-fluid">
				<div class="span6 offset3" style="text-align:center">
					<?php
						if($_POST['ces_submitted'] == 1 && $numSessions == 0) {
							echo '<div class="alert alert-error">
											<button type="button" class="close" data-dismiss="alert">&times;</button><strong>Looks like a problem.</strong> No session names associated with this email address were found.
										</div>';
						} else if($_POST['ces_submitted'] == 1) {
							echo '<div class="alert alert-success">
											<button type="button" class="close" data-dismiss="alert">&times;</button><strong>Email\'s away!</strong> Please check your inbox, and <a href="../login.php">login here</a>.
										</div>';
						}
					?>
					<div data-toggle="buttons-radio">
						<div class="btn-group btn-group-vertical multichoice-btn-group">
							<button class="btn btn-large btn-block multichoice-btn">A</button>
							<button class="btn btn-large btn-block multichoice-btn">B</button>
							<button class="btn btn-large btn-block multichoice-btn">C</button>
							<button class="btn btn-large btn-block multichoice-btn">D</button>
							<button class="btn btn-large btn-block multichoice-btn">E</button>
						</div>
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