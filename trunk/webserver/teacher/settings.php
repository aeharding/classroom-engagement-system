<?php
	session_start();
	if(!isset($_SESSION['session'])) {
		header("location:login.php");
	}
	
	$passmismatch = false;
	$invalidOldPass = false;
	$badPassLen = false;
	$errorMsg = "";
	
	if($_POST['pass_submitted'] == 1) {
		$oldPass = $_POST['ces_pass_old'];
		$newPass = $_POST['ces_pass_new'];
		$newPassConf = $_POST['ces_pass_new_conf'];
		
		include '../setup/connect.php';
		$con = new mysqli($config_server, $config_user, $config_pass, $config_table);

		// Prevent SQL Injections
		$newPass = $con->real_escape_string($newPass);
		
		$query = "SELECT s_pass FROM sessions WHERE s_sid='" . $_SESSION['session'] . "'";
		$result = $con->query($query);
		$row = $result->fetch_array(MYSQLI_NUM);
		
		if(md5($oldPass) == $row[0]) {
			if($newPass == $_POST['ces_pass_new_conf']) {
				if(strlen($newPass) > 4) {
					$query = "UPDATE sessions SET s_pass='" . md5($newPass) . "' WHERE s_sid='" . $_SESSION['session'] . "'";
					$result = $con->query($query);
					$oldPass = "";
					$newPass = "";
					$newPassConf = "";
				} else {
					$badPassLen = true;
					$newPass = "";
					$newPassConf = "";
				}
			} else {
				$passmismatch = true;
				$newPass = "";
				$newPassConf = "";
			}
		} else {
			$invalidOldPass = true;
			$oldPass = "";
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
								<li class="active dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">Administrate Session <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a href="admin.php"><i class="icon-quote-left"></i> Lecture panel</a></li>
										<li><a href="old.php"><i class="icon-bar-chart"></i> Results &amp; Old Questions</a></li>
										<li class="divider"></li>
										<li><a href="settings.php"><i class="icon-cogs"></i> Settings</a></li>
									</ul>
								</li>
							</ul>
							<?php if(isset($_SESSION['session'])) echo '
							<div style="display:inline-block" class="navbar-pull-right">
								<ul class="nav">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-book"></i> '.$_SESSION['session'].' <b class="caret"></b></a>
										<ul class="dropdown-menu pull-right">
											<li><a href="logout.php"><i class="icon-user"></i> Log out</a></li>
											<li><a href="settings.php"><i class="icon-cogs"></i> Settings</a></li>
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
					<div class="span8 offset2" style="text-align:center">
						<h3>Settings</h3>
						<?php 
						if($badPassLen) { echo '
							<div class="alert alert-error">
								<button type="button" class="close" data-dismiss="alert">&times;</button><strong>Houston, we have a problem.</strong> Enter a new password longer than 4 characters.
							</div>
						'; } else if($passmismatch) { echo '
							<div class="alert alert-error">
								<button type="button" class="close" data-dismiss="alert">&times;</button><strong>Houston, we have a problem.</strong> Make sure your new password confirmation matches.
							</div>
						'; } else if($invalidOldPass) { echo '
							<div class="alert alert-error">
								<button type="button" class="close" data-dismiss="alert">&times;</button><strong>Houston, we have a problem.</strong> Your old password was not entered correctly.
							</div>
						'; } else if($_POST['pass_submitted']) { echo '
							<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert">&times;</button><strong>Looks good to me!</strong> Your password was successfully changed.
							</div>
						'; }
						?>
						<form action="settings.php" method="post">
							<h2>Enter details</h2>
							<div style="max-width:300px;" class="center">
								<div class="input-prepend<?php if($invalidOldPass) echo ' control-group warning';?>" style="width:100%">
									<label for="ces_pass_old" style="display:inline"><span class="add-on"><i class="icon-key"></i></span></label>
									<input type="password" name="ces_pass_old" id="ces_pass_old" autocomplete="off" style="width:80%" placeholder="Old password" value="<?php echo $oldPass; ?>">
								</div>
								<div class="input-prepend<?php if($passmismatch || $badPassLen) echo ' control-group warning';?>" style="width:100%">
									<label for="ces_pass_new" style="display:inline"><span class="add-on"><i class="icon-key"></i></span></label>
									<input type="password" name="ces_pass_new" id="ces_pass_new" autocomplete="off" style="width:80%" placeholder="New password" value="<?php echo $newPass; ?>">
								</div>
								<div class="input-prepend<?php if($passmismatch || $badPassLen) echo ' control-group warning';?>" style="width:100%">
									<label for="ces_pass_new_conf" style="display:inline"><span class="add-on"><i class="icon-repeat"></i></span></label>
									<input type="password" name="ces_pass_new_conf" id="ces_pass_new_conf" autocomplete="off" style="width:80%" placeholder="New password confirmation" value="<?php echo $newPassConf; ?>">
								</div>
								<input type="hidden" name="pass_submitted" value="1">
								<button class="btn btn-large btn-info" type="submit" id="submit-loader" data-loading-text="Loading...">Change</button>
							</div>
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