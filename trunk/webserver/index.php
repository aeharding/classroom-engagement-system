<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Classroom Engagement System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <script type="text/javascript" src="js/ie-mobile-fix.js"></script>
    
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    
    <link href="css/cas.css" rel="stylesheet">

    <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
		
		<script type="text/javascript" src="js/jquery.backstretch.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function () {
			$.backstretch([
					"img/bg/lecture.jpg"
				, "img/bg/campus.jpg"
				, "img/bg/lincoln.jpg"
				, "img/bg/winter.jpg"
			], {duration: 6000, fade: 750});
		});
  </script>
  
		<link href='http://fonts.googleapis.com/css?family=Just+Me+Again+Down+Here' rel='stylesheet' type='text/css'>
		
    <script type="text/javascript" src="js/bootstrap.js"></script>
    

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->
		
  </head>

  <body>
		<div id="wrap">
			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span6 offset3 alpha50" id="welcomer">
						<h1 class="friendly">Welcome to the next generation of classroom interaction.</h1>
						<button class="btn btn-large btn-primary" type="button" onclick="parent.location='student/index.php'">Join a session <i class="icon-forward icon-white"></i></button>
						<br><br>
						<button class="btn btn-large btn-info" type="button" onclick="parent.location='teacher/create.php'">Create a session <i class="icon-asterisk icon-white"></i></button>
						<br><br>
						<button class="btn btn-large btn-danger" type="button" onclick="parent.location='teacher/admin.php'">Administer a session <i class="icon-wrench icon-white"></i></button>
						<br><br>
					</div>
				</div>
			</div> <!-- /container -->
    </div> <!-- /wrap for footer -->
		<div id="footer">
      <div class="container-fluid">
        <p class="muted"><br>Created by Research to Reality <a href="http://wiki.gpii.net/index.php/R2R">[about us]</a>
      </div>
    </div>
    
  </body>
</html>
