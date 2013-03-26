<?php
	session_start();
	if(!isset($_SESSION['session'])) {
		header("location:login.php");
	}
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
						<h3>Old questions</h3>
						<button class="btn btn-info btn-small dropdown-toggle"><i class="icon-download-alt icon-white"></i> Download all in .csv</button>
						<br><br>
						<table class="table table-striped">
							<tr>
								<td><strong>Date</strong></td>
								<td><strong>Type</strong></td>
								<td><strong>Correct Answer</strong></td>
								<td><strong>Description</strong></td>
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