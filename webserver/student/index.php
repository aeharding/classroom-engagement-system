<?php
	if ($_POST['submitted'] == 1) {
		include '../setup/connect.php';
		$con = new mysqli($config_server, $config_user, $config_pass, $config_table);
		// Check connection
		if ($con->connect_errno) {
				printf("Connect failed: %s\n", $con->connect_error);
				exit();
		}
		
		$session = $_POST['session'];
		$student = $_POST['student'];
		
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
			if($total == 1) {
				$sql="SELECT count(1) FROM sessions WHERE s_sid='" . $session . "' AND s_isOpen='1'";
				if (!mysqli_query($con,$sql)) {
					die('Error: ' . mysqli_error());
				}
				$result = $con->query($sql);
				$row = $result->fetch_array(MYSQLI_NUM);
				$total = $row[0];
				if($total == 1) {
					session_start();
					$_SESSION['student'] = $student;
					$_SESSION['studentOfSession'] = $session;
					header("location:vote/index.php");
				} else {
					$error = true;
					$errorMsg .= '<br>The session is not currently open.';
				}
			} else {
				$error = true;
				$errorMsg .= '<br>The session does not exist.';
			}
			mysqli_close($con);
		} else {
			$error = true;
			$errorMsg .= '<br>Please use a student ID longer than four characters.';
		}
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
          <a class="brand" href="../index.php">CES</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="index.php">Join Session</a></li>
              <li><a href="../teacher/admin.php">Administer Session</a></li>
              <li><a href="../teacher/create.php">Create Session</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">
			<div class="row-fluid">
				<div class="span6 offset3" style="text-align:center">
					<?php
					if($error) {
						echo '<div class="alert alert-error">
										<button type="button" class="close" data-dismiss="alert">&times;</button><strong>Unable to join session.</strong> ' . $errorMsg . '
									</div>';
					}
					?>
					<form action="index.php" method="post">
						<h2>Enter details</h2>
						<div style="max-width:300px;" class="center">
							<div class="input-prepend" style="width:100%">
								<span class="add-on"><i class="icon-user"></i></span>
								<input id="inputIcon" type="text" name="student" style="width:80%" placeholder="Your student ID">
							</div>
							<div class="input-prepend" style="width:100%">
								<span class="add-on"><i class="icon-book"></i></span>
								<input id="inputIcon" type="text" name="session" style="width:80%" placeholder="Class session ID">
							</div>
							<input type="hidden" name="submitted" value="1">
						</div>
						<button class="btn btn-large btn-primary" type="submit">Join session</button>
					</form>
				</div>
			</div>
		</div> <!-- /container -->
  </body>
</html>