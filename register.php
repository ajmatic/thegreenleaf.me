<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>The Green Leaf: Registration</title>
		<link rel="shortcut icon" href="img/leaf.jpg" alt="green leaf favicon" />
		<script src="https://code.jquery.com/jquery.js"></script>
	    <!-- Include all compiled plugins (below), or include individual files as needed -->
	    <script src="../dist/js/bootstrap.min.js"></script>
	    <link href="../dist/css/bootstrap.css" rel="stylesheet">
	    <style type="text/css">@import url(http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister);</style>
	    <style type="text/css"> @import url(../css/blog.css); </style>
	</head>
	<body>
		<div class="container">
		<?php include("header.php"); ?>
			<div class="row">	
				<div class="col-sm-6 col-md-6">
					<h3>Register</h3>
					<form action="/process_registration.php" method="post" class="form-horizontal" role="form">
					    <div class="form-group">
					      <div class="col-sm-10">
					       
							<?php
								if (isset($message)) {
									echo "<p class='message'>".$_POST["message"]."</p>";
								}
							?>
					      </div>
					    </div>
					    
					    <div class="form-group">
					      <div class="col-sm-10">
					        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
					      </div>
					    </div>
					    <div class="form-group">
					      <div class="col-sm-10">
					        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
					      </div>
					    </div>
					    <div class="form-group">
					      <div class="col-sm-10">
					        <input type="password" class="form-control" id="confirm" name="confirm" placeholder="Confirm Password">
					      </div>
					    </div>
					    <div class="form-group">
					      <div class="col-sm-offset-2 col-sm-10">
					        <button type="submit" class="btn btn-primary">Register</button>
					        
					      </div>
					    </div>
					</form>
				</div>
			</div>
		<?php include("footer.php"); ?>
		</div>

	</body>
</html>