<?php
	$count = 0;
	session_start();
	if(isset($_SESSION['session'])) {
		header("location:admin.php");
	}
	if ($_POST['submitted'] == 1) {
		$con = new mysqli("localhost","appcooki_voteadm","trace","appcooki_vote");
		// Check connection
		if ($con->connect_errno) {
				printf("Connect failed: %s\n", $con->connect_error);
				exit();
		}
		
		$session = $_POST['sid'];
		$pass = $_POST['pass'];

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <div class="navbar navbar-inverse navbar-fixed-top" id="nav-ref">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="../index.php">CAS</a>
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
						} else if($_POST['submitted']) {
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
								<input id="inputIcon" type="text" name="sid" style="width:80%" placeholder="Class session ID">
							</div>
							<div class="input-prepend" style="width:100%">
								<span class="add-on"><i class="icon-eye-close"></i></span>
								<input id="inputIcon" type="password" name="pass" style="width:80%" placeholder="Password">
							</div>
							<input type="hidden" name="submitted" value="1">
						</div>
						<button class="btn btn-large btn-primary" type="submit">Administrate</button>
					</form>
				</div>
			</div>
		</div> <!-- /container -->
  </body>
</html>