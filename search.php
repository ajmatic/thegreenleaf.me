<?php 
//open connection to database
include("./cms/db_connect.php");

$q = (isset($_REQUEST["q"]))?$_REQUEST["q"]:"";
$q = trim(strip_tags($q));

if ($q != "") {
	//select posts grouped by month and year
	$sql = "SELECT post_id, title, summary, DATE_FORMAT(postdate, '%e %b %Y at %H:%i')
	AS dateattime FROM posts WHERE 
	MATCH (title,summary,post) AGAINST ('$q') LIMIT 50";
	$result = mysql_query($sql);
	$myposts = mysql_fetch_array($result);
}

//format search for HTML display
$q = stripslashes(htmlentities($q));

include("functions.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		<title>the green leaf blog</title>
		<script src="https://code.jquery.com/jquery.js"></script>
	    <!-- Include all compiled plugins (below), or include individual files as needed -->
	    <script src="../dist/js/bootstrap.min.js"></script>
	    <link href="../dist/css/bootstrap.css" rel="stylesheet">
	    <style type="text/css">@import url(http://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister);</style>
		<style type="text/css"> @import url(../css/blog.css); </style>
	</head>
	<body>
		
		<?php include("header.php"); ?>

		<!--this is the main part of the page -->
		<div id="maincontent">
			
			<div id="posts">
				<h2>Search Results</h2>
				<div id="results">
					<?php
					if($myposts) {
						$numresults = mysql_num_rows($result);
						$plural1 = ($numresults==1) ? "is" : "are";
						$plural2 = ($numresults==1) ? "" : "s";
						echo "<p>There $plural1 <em>$numresults</em> post$plural2 matching your search for <cite>$q</cite>.</p>";
						echo "<dl>\n";
						do {
							$post_id = $myposts["post_id"];
							$title = $myposts["title"];
							$summary = $myposts["summary"];
						echo "<dt><a href='post.php?post_id=$post_id'>$title</a></dt>\n";
						echo "<dd>$summary</dd>\n";
						} while ($myposts = mysql_fetch_array($result));
						echo "</dl>";
					} else {
						echo "<p>There were no posts matching your search for <cite>$q</cite>.</p>";
					}
					?>
				</div>
			</div>
			<div id="sidebar">
				<?php include("searchform.php"); ?>
			</div>
			<!--sidebar ends -->
		</div>
		<!--maincontent ends -->
		<?php include("footer.php"); ?>
	</body>
</html>