<?php
	session_start();
	if(!isset($_SESSION['session'])) {
		session_destroy();
		header("location:login.php");
	} else {
		$sessionActive = false;
		if(isset($_SESSION['sessionActive'])) {
			$sessionActive = $_SESSION['sessionActive'];
		} else {
			$_SESSION['sessionActive'] = false;
		}
	}
	include '../setup/connect.php';
	$con = new mysqli($config_server, $config_user, $config_pass, $config_table);
	$query = "UPDATE sessions SET s_isOpen='" . $_SESSION['sessionActive'] . "' WHERE s_sid='" . $_SESSION['session'] . "'";
	$result = $con->query($query);
?>
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
    
    <script>
    function correctAnswerUpdate() {
			if(document.newQuestion.answerType.value == "mult") {
				document.getElementById('corrAnswerMod').innerHTML = 'Correct answer: <select class="span4"><option value="none">None</option><option value="a">A</option><option value="b">B</option><option value="c">C</option><option value="d">D</option><option value="e">E</option></select>';
			} else if(document.newQuestion.answerType.value == "bool") {
				document.getElementById('corrAnswerMod').innerHTML = 'Correct answer: <select class="span4"><option value="none">None</option><option value="true">True</option><option value="false">False</option></select>';
			} else if(document.newQuestion.answerType.value == "resp") {
				document.getElementById('corrAnswerMod').innerHTML = '';
			}
    }
    </script>

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
				<div class="span6 offset3 btn-group" style="text-align:center">
					<?php
						if($sessionActive) {
							echo '<a href="toggleSession.php" class="btn btn-medium btn-warning"><i class="icon-off icon-white"></i> Close session</a>
										<a href="logout.php" class="btn btn-medium btn-danger"><i class="icon-user icon-white"></i> Log out + close</a>';
						} else {
							echo '<a href="toggleSession.php" class="btn btn-medium btn-success"><i class="icon-off icon-white"></i> Open session</a>
										<a href="logout.php" class="btn btn-medium btn-danger"><i class="icon-user icon-white"></i> Log out</a>';
						}
					?>
					
				</div>
			</div>
			<hr>
			<div class="row-fluid">
				<div class="span6 offset3" style="text-align:center">
					<form action="admin.php" method="post" name="newQuestion">
						<h3>Create new question</h3>
						<div style="max-width:300px;" class="center">
							<input type="text" class="input-block-level" name="description" placeholder="Question description [optional]">
							<select class="span12" name="answerType" onchange="correctAnswerUpdate();">
								<option value="mult">Multiple choice [A-E]</option>
								<option value="bool">Boolean [true/false]</option>
								<option value="resp">Short answer</option>
							</select>
							<span id="corrAnswerMod">
								Correct answer:
								<select class="span4">
									<option value="none">None</option>
									<option value="a">A</option>
									<option value="b">B</option>
									<option value="c">C</option>
									<option value="d">D</option>
									<option value="e">E</option>
								</select>
							</span>
							<input type="hidden" name="submitted" value="1">
						</div>
						<button class="btn btn-large btn-primary" type="submit">Create question</button>
					</form>
				</div>
			</div>
			<hr>
			<div class="row-fluid">
				<div class="span6 offset3" style="text-align:center">
					<h3>Current question</h3>
				</div>
			</div>
			<hr>
			<div class="row-fluid">
				<div class="span6 offset3" style="text-align:center">
					<h3>Old questions</h3>
				</div>
			</div>
		</div> <!-- /container -->
  </body>
</html>