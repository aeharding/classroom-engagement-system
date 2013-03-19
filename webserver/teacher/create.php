<?php
function checkID($id_check) {
	$con = new mysqli("localhost","appcooki_voteadm","trace","appcooki_vote");
	$query = "SELECT * FROM sessions WHERE s_sid='" . $id_check . "'";
	$result = $con->query($query);
	if(count($result->fetch_array(MYSQLI_NUM)) > 0) {
		return false;
	}
	return true;
}
$continue = true;
$reason_fail = "";
if ($_POST['submitted'] == 1) {
	$id = $_POST[sid];
	$email = $_POST[email];
	$pass = $_POST[pass];
	$pass_ver = $_POST[pass_ver];
	if((!filter_var($email, FILTER_VALIDATE_EMAIL))) {
		$continue = false;
		$reason_fail .= "<br>Your email address is invalid.";
	}
	if($pass != $pass_ver) {
		$continue = false;
		$reason_fail .= "<br>Your entered password does not match.";
	}
	if(strlen($pass) < 5) {
		$continue = false;
		$reason_fail .= "<br>Your entered password must be more than 5 characters.";
	}
	if(!checkID($id)) {
		$continue = false;
		$reason_fail .= "<br>The session ID is already taken.";
	}
	if(strlen($id) < 3) {
		$continue = false;
		$reason_fail .= "<br>The session ID must be greater than three characters.";
	}
	
	if($continue) {
		$con = new mysqli("localhost","appcooki_voteadm","trace","appcooki_vote");
		// Check connection
		if ($con->connect_errno) {
				printf("Connect failed: %s\n", $con->connect_error);
				exit();
		}

		$sql="INSERT INTO sessions (s_sid, s_email, s_pass)
		VALUES
		('$id','$email','$pass')";

		if (!mysqli_query($con,$sql)) {
			die('Error: ' . mysqli_error());
		}
		//echo "1 record added"; // Debugging; will break html

		mysqli_close($con);
		
		header( 'Location: admin.php?created=true' ) ;
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
          <a class="brand" href="../index.php">CAS</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="../student/index.php">Join Session</a></li>
              <li><a href="admin.php">Administer Session</a></li>
              <li class="active"><a href="create.php">Create Session</a></li>
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
							<input type="text" class="input-block-level" name="sid" placeholder="Class session ID name">
							<input type="text" class="input-block-level" name="email" placeholder="Your email">
							<input type="password" class="input-block-level" name="pass" placeholder="Password">
							<input type="password" class="input-block-level" name="pass_ver" placeholder="Retype password">
							<input type="hidden" name="submitted" value="1">
						</div>
						<button class="btn btn-large btn-primary" type="submit">Create + Administrate</button>
					</form>
				</div>
			</div>
		</div> <!-- /container -->
  </body>
</html>