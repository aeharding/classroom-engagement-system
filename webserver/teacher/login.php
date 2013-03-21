<?php
	$count = 0;
	session_start();
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

    <div class="navbar navbar-fixed-top" id="nav-ref">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="../index.php">CES</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="../student/index.php">Join Session</a></li>
              <li class="active"><a href="admin.php">Administer Session</a></li>
              <li><a href="create.php">Create Session</a></li>
            </ul>
          </div><!--/.nav-collapse -->
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
							<div class="input-prepend" style="width:100%">
								<span class="add-on"><i class="icon-book"></i></span>
								<input id="inputIcon" type="text" name="ces_sid" autocomplete="off" style="width:80%" placeholder="Class session name">
							</div>
							<div class="input-prepend" style="width:100%">
								<span class="add-on"><i class="icon-eye-close"></i></span>
								<input id="inputIcon" type="password" name="ces_pass" autocomplete="off" style="width:80%" placeholder="Password">
							</div>
							<input type="hidden" name="ces_submitted" value="1">
						</div>
						<button class="btn btn-large btn-danger" type="submit">Administrate</button>
					</form>
				</div>
			</div>
		</div> <!-- /container -->
  </body>
</html>