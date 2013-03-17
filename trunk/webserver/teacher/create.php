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
          <a class="brand" href="#">CAS</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="../index.php">Home</a></li>
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
					<form>
						<h2>Enter details</h2>
						<div style="max-width:300px;" class="center">
							<input type="text" class="input-block-level" name="sid" placeholder="Class session ID name">
							<input type="text" class="input-block-level" name="email" placeholder="Your email">
							<input type="password" class="input-block-level" name="pass" placeholder="Password">
							<input type="password" class="input-block-level" placeholder="Retype password TODOOO">
						</div>
						<button class="btn btn-large btn-primary" type="submit">Create + Administrate</button>
					</form>
				</div>
			</div>
		</div> <!-- /container -->
  </body>
</html>