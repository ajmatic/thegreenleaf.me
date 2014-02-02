<?php 
//open connection to the database
include ("functions.php");
include("cms/db_connect.php");

//select 5 most recent posts
$sql = "SELECT post_id, title, post, DATE_FORMAT(postdate, '%e %b %Y at %H:%i') AS dateattime FROM posts ORDER BY post_id DESC LIMIT 5";
$result = mysql_query($sql);
$myposts = mysql_fetch_array($result);
?> 


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		<title>The Green Leaf</title>
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

			<!--this is the main part of the page-->
			
			<div id="maincontent">
				<div class="row">
					<div class="col-sm-6 col-md-6">
						<div id="posts">
							<?php 
							if($myposts) {
								do {
									$post_id = $myposts["post_id"];
									$title = $myposts["title"];
									$post = format($myposts["post"]);
									$dateattime = $myposts["dateattime"];
									echo "<h2 id='post$post_id'><a href='post.php?post_id=$post_id' rel='bookmark'>
									$title</a></h2>\n";
									echo "<h4>Posted on $dateattime</h4>\n";
									echo "<div class='post'>$post</div>";
								} while ($myposts = mysql_fetch_array($result));
							} else {
								echo "<p>I haven't posted to my blog yet.</p>";
							}
							?>
						</div>
					</div>
					<div class="col-sm-3 col-md-3">
						<div id="sidebar">
							<div id="about">
								<h3>About:</h3>
								<p>the green leaf is a communal website of poems, sayings, movie quotes and more to help inspire and provoke. If you're a member and would like to make a post <a href="login.php">login.</a> If you'd like to become a member <a href="register.php">register</a>. </p>
							</div>
						</div>
					</div>
					<div class="col-sm-3 col-md-3">
						
						
							<?php include("searchform.php"); ?>

							<div id="recent">
								<h3>Recent posts</h3>
								<?php
								mysql_data_seek($result, 0);
								$myposts = mysql_fetch_array($result);

								if($myposts) {
									echo "<ul>\n";
									do {
										$post_id = $myposts["post_id"];
										$title = $myposts["title"];
									echo "<li><a href='post.php?post_id=$post_id' rel='bookmark'>
									$title</a></li>\n";
									} while ($myposts = mysql_fetch_array($result));
									echo "</ul>";
								}
								?>
							</div>
						
					</div>
				<!--sidebar ends-->
				</div>
				
			</div>
			<!--maincontent ends-->
			<?php include("footer.php"); ?>
		</div>
	</body>
</html>