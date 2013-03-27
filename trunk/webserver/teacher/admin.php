<?php
	session_start();
	if(!isset($_SESSION['session'])) {
		header("location:login.php");
	}
	
	include '../setup/connect.php';
	$con = new mysqli($config_server, $config_user, $config_pass, $config_table);
	
	$sql = "SELECT PID,s_time FROM questions WHERE s_sid='" . $_SESSION['session'] . "' AND s_open=1";
	if (!mysqli_query($con,$sql)) {
		die('Error: ' . mysqli_error());
	}
	
	$result=$con->query($sql);
	$row = $result->fetch_array(MYSQLI_NUM);
	$currQuestion = $row[0];
	$time = $row[1];
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
    
    <script type="text/javascript" src="../js/jquery.timeago.js"></script>
    
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		
    <script type="text/javascript">
			$(document).ready(function() {
				jQuery("abbr.timeago").timeago();
				updateChart();
				window.setInterval(function () { updateChart(); }, 5000);
			});
			var dataa;
			function updateAnswers(chart_arr) {
				var votes = 0;
				for(var i = 1; i < chart_arr.length; i++) { // Skip the chart labels
					votes += chart_arr[i][1];
				}
				document.getElementById('numAnswers').innerHTML = votes;
			}
			
			function updateChart() {
				$.getJSON("questionAnswers.php?id=" + <?php echo $currQuestion; ?>,
					function(data){
						dataa = data;
						updateAnswers(data);
						drawChart(data);
				});
			}
			
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart(chart_arr) {
        var data = google.visualization.arrayToDataTable(chart_arr);

        var options = {
          title: 'Current votes',
          legend: {position: 'none'},
          hAxis: {title: 'Votes',  titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart'));
        chart.draw(data, options);
      }
    </script>
    
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
					<div class="span4 offset1" style="text-align:center">
						<h3>Current question</h3>
						<h4>Opened <abbr class="timeago" title="<?php echo $time; ?>"><?php echo $time; ?></abbr>.<h4>
						<h4><strong class="text-warning"><span id="numAnswers">?</span></strong> students have answered.</h4>
						<div id="chart"></div>
						<button class="btn btn-danger btn-large"><i class="icon-stop icon-white"></i> Close question</button>
					</div>
					<hr class="visible-phone">
					<div class="span4 offset2" style="text-align:center">
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