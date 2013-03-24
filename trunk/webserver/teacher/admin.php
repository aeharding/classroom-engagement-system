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
    
    <link rel="stylesheet" href="../css/font-awesome.min.css">

    <script type="text/javascript" src="../js/ie-mobile-fix.js"></script>
    
    <link href="../css/bootstrap-responsive.css" rel="stylesheet">
    
    <link href="../css/navbar.css" rel="stylesheet">
    
    <link href="../css/cas.css" rel="stylesheet">

    <script type="text/javascript" src="../js/jquery-1.9.1.js"></script>

    <script type="text/javascript" src="../js/bootstrap.js"></script>
    
    <script>
    function correctAnswerUpdate() {
			if(document.newQuestion.answerType.value == "mult") {
				document.getElementById('corrAnswerMod').innerHTML = 'Correct answer: <select class="span4" name="corrAnswer"><option value="none">None</option><option value="a">A</option><option value="b">B</option><option value="c">C</option><option value="d">D</option><option value="e">E</option></select>';
			} else if(document.newQuestion.answerType.value == "bool") {
				document.getElementById('corrAnswerMod').innerHTML = 'Correct answer: <select class="span4" name="corrAnswer"><option value="none">None</option><option value="true">True</option><option value="false">False</option></select>';
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
							<div style="display:inline-block" class="navbar-pull-right">
								<ul class="nav">
									<li class="dropdown">
											<?php
												if($sessionActive) {
													echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-group" style="color:green"></i> '.$_SESSION['session'].' <b class="caret"></b></a>
																<ul class="dropdown-menu pull-right">
																	<li><a href="toggleSession.php"><i class="icon-off"></i> Close session</a></li>
																	<li><a href="logout.php"><i class="icon-user"></i> Log out + close</a></li>';
												} else {
													echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-group" style="color:red"></i> '.$_SESSION['session'].' <b class="caret"></b></a>
																<ul class="dropdown-menu pull-right">
																	<li><a href="toggleSession.php"><i class="icon-off"></i> Open session</a></li>
																	<li><a href="logout.php"><i class="icon-user"></i> Log out</a></li>';
												}
											?>
										</ul>
									</li>
								</ul>
							</div>
						</div><!--/.nav-collapse -->
					</div>
				</div>
			</div>

			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span4" style="text-align:center">
						<form action="newQuestion.php" method="post" name="newQuestion">
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
									<select class="span4" name="corrAnswer">
										<option value="none">None</option>
										<option value="a">A</option>
										<option value="b">B</option>
										<option value="c">C</option>
										<option value="d">D</option>
										<option value="e">E</option>
									</select>
								</span>
								<input type="hidden" name="ces_submitted" value="1">
							</div>
							<button class="btn btn-large btn-primary" type="submit">Create question</button>
						</form>
					</div>
					<hr class="visible-phone">
					<div class="span4" style="text-align:center">
						<h3>Current question</h3>
						<h4>Opened <strong class="text-warning">7</strong> minutes ago.<h4>
						<h4><strong class="text-warning">16</strong> students have answered.</h4>
						<button class="btn btn-danger btn-large"><i class="icon-stop icon-white"></i> Close question</button>
					</div>
					<hr class="visible-phone">
					<div class="span4" style="text-align:center">
						<h3>Old questions</h3>
						<button class="btn btn-info btn-small dropdown-toggle"><i class="icon-download-alt icon-white"></i> Download all in .csv</button>
						<br><br>
						<table class="table table-striped">
							<tr>
								<td><strong>Date</strong></td>
								<td><strong>Type</strong></td>
								<td><strong>More</strong></td>
							</tr>
							<?php include 'tabulate.php'; ?>
						</table>
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