<?php
	session_start();
	
	if(isset($_SESSION['student'])) {
		header('location:vote/index.php');
	}
	
	include '../php/Mobile_Detect.php';
	$detect = new Mobile_Detect();
	$autofocus = true;
	if ($detect->isMobile() || $detect->isTablet()) {
    $autofocus = false;
	}

	$invalid['ces_session'] = false;
	$invalid['ces_student'] = false;
	
	if ($_POST['ces_submitted'] == 1 && !isset($_SESSION['session'])) {
		include '../setup/connect.php';
		$con = new mysqli($config_server, $config_user, $config_pass, $config_table);
		// Check connection
		if ($con->connect_errno) {
				printf("Connect failed: %s\n", $con->connect_error);
				exit();
		}
		
		$session = $_POST['ces_session'];
		$student = $_POST['ces_student'];
		
		$error = false;
		$errorMsg = '';
		
		
		if(strlen($student) > 4) {
		
			// Prevent SQL Injections
			$session = $con->real_escape_string($session);
			$student = $con->real_escape_string($student);
			
			$sql="SELECT count(1) FROM sessions WHERE s_sid='" . $session . "'";

			if (!mysqli_query($con,$sql)) {
				die('Error: ' . mysqli_error());
			}


			$result = $con->query($sql);
			$row = $result->fetch_array(MYSQLI_NUM);
			$total = $row[0];
			if($row[0] == 1) {
				$_SESSION['student'] = $student;
				$_SESSION['studentSession'] = $session;
				header("location:vote/index.php");
			}	else {
				$error = true;
				$invalid['ces_session'] = true;
				$session = "";
				$errorMsg .= '<br>The session does not exist.';
			}
			mysqli_close($con);
		} else {
			$error = true;
			$invalid['ces_student'] = true;
			$student = "";
			$errorMsg .= '<br>Please use a student ID longer than four characters.';
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
								<li class="active"><a href="index.php">Join Session</a></li>
								<li><a href="../teacher/create.php">Create Session</a></li>
								<?php if(!isset($_SESSION['session'])) {
									echo '<li><a href="../teacher/admin.php">Administrate Session</a></li>';
								} else {
									echo '
										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">Administrate Session <b class="caret"></b></a>
											<ul class="dropdown-menu">
												<li><a href="../teacher/admin.php"><i class="icon-quote-left"></i> Lecture panel</a></li>
												<li><a href="../teacher/old.php"><i class="icon-bar-chart"></i> Results &amp; Old Questions</a></li>
												<li class="divider"></li>
												<li><a href="../teacher/settings.php"><i class="icon-cogs"></i> Settings</a></li>
											</ul>
										</li>
									';
								}
								?>
							</ul>
							<?php if(isset($_SESSION['session'])) echo '
							<div style="display:inline-block" class="navbar-pull-right">
								<ul class="nav">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-book"></i> '.$_SESSION['session'].' <b class="caret"></b></a>
										<ul class="dropdown-menu pull-right">
											<li><a href="../teacher/logout.php"><i class="icon-user"></i> Log out</a></li>
											<li><a href="../teacher/settings.php"><i class="icon-cogs"></i> Settings</a></li>
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
				<div class="row-fluid">
					<div class="span6 offset3" style="text-align:center">
						<?php
						if(isset($_SESSION['session'])) {
							echo '<div class="alert alert-error">
											<button type="button" class="close" data-dismiss="alert">&times;</button><strong>Logged into session.</strong> Please <a href="../teacher/logout.php?to=student/index.php">log out</a> of your current session.
										</div>';
						}	else if($error) {
							echo '<div class="alert alert-error">
											<button type="button" class="close" data-dismiss="alert">&times;</button><strong>Unable to join session.</strong> ' . $errorMsg . '
										</div>';
						}
						?>
						<form action="index.php" method="post">
							<h2>Enter details</h2>
							<div style="max-width:300px;" class="center">
								<div class="input-prepend<?php if($invalid['ces_session']) echo ' control-group warning';?>" style="width:100%">
									<label for="ces_session" style="display:inline"><span class="add-on"><i class="icon-book"></i></span></label>
									<input type="text" name="ces_session" id="ces_session" autocomplete="off" maxlength="30" value="<?php echo $session; ?>" <?php if($autofocus && ($invalid['ces_session'] || !$invalid['ces_student'])) echo 'autofocus'; ?> style="width:80%" placeholder="Class session name">
								</div>
								<div class="input-prepend<?php if($invalid['ces_student']) echo ' control-group warning';?>" style="width:100%">
									<label for="ces_student" style="display:inline"><span class="add-on"><i class="icon-user"></i></span></label>
									<input type="text" name="ces_student" id="ces_student" autocomplete="off" maxlength="30" value="<?php echo $student; ?>" <?php if($autofocus && $invalid['ces_student']) echo 'autofocus'; ?> style="width:80%" placeholder="Your student ID">
								</div>
								<input type="hidden" name="ces_submitted" value="1">
							</div>
							<button class="btn btn-large btn-primary" type="submit" id="submit-loader" data-loading-text="Loading...">Join session</button>
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