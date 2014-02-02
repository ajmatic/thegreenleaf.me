<?php
//open connection to database
include("./cms/db_connect.php");

$month = (isset($_REQUEST["month"])) ? $_REQUEST["month"] : "";
$year = (isset($_REQUEST["year"])) ? $_REQUEST["year"] : "";
 
if (preg_match("/^[0-9][0-9][0-9][0-9]$/", $year) AND preg_match("/^[0-9]?[0-9]$/", $month)) {
	//select posts for this month
	$sql = "SELECT post_id, title, summary, DATE_FORMAT(postdate, '%e %b %Y at %H:%i') AS dateattime FROM posts WHERE MONTH(postdate) = $month AND YEAR(postdate) = $year";
	$result = mysql_query($sql);
	$myposts = mysql_fetch_array($result);
	if ($myposts) {
		$showbymonth = true;
		$text = strtotime("$month/1/$year");
		$thismonth = date("F Y", $text);
	}
}

if (!isset($showbymonth)) {
	$showbymonth = false;
	//select posts grouped by month and year
	$sql = "SELECT DATE_FORMAT(postdate, '%M %Y') AS monthyear, MONTH(postdate) AS month, YEAR(postdate) AS year, count(*) AS count FROM posts  GROUP BY monthyear ORDER BY year, month";
	$result = mysql_query($sql);
	$myposts = mysql_fetch_array($result);
}  

include("functions.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		<title><?php if(isset($thismonth)) echo $thismonth; ?>
			Archive | the green leaf blog</title>
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
		 <!-- this is the main part of the page -->
			<div id="maincontent">
				<div class="row">
					<div class="col-sm-9 col-md-9">
						<div id="posts">
							<h2>
								<?php if(isset($thismonth)) echo $thismonth; ?> 
								Archive
							</h2>
							<?php 
							switch ($showbymonth) {
								case true:
								if($myposts) {
									echo "<dl>\n";
									do {
										$post_id = $myposts["post_id"];
										$title = $myposts["title"];
										$summary = $myposts["summary"];
									echo "<dt><a href='post.php?post_id=$post_id' rel='bookmark'>$title</a></dt>\n";
									echo "<dd>$summary</dd>\n";
									} while ($myposts = mysql_fetch_array($result));
									echo "</dl>";
								}
								break;

								case false:
								$previousyear = "";
								if($myposts) {
									do {
										$year = $myposts["year"];
										$month = $myposts["month"];
										$monthyear = $myposts["monthyear"];
										$count = $myposts["count"];
										if ($year != $previousyear) {
											if ($previousyear != "") {
												echo "</ul>\n";
											}
											echo "<h3>$year</h3>";
											echo "<ul>\n";
											$previousyear = $year;
										}
										$plural = ($count==1) ? "" : "s";
										echo "<li><a href='archive.php?year=$year&amp;month=$month'>$monthyear</a> ($count post$plural)</li>\n";
									} while ($myposts = mysql_fetch_array($result));
									echo "</ul>";
								}
								break;
							}
							?>
						</div>
					</div>
					
					<div class="col-sm-3 col-md-3">
						<div id="sidebar">
							<?php include("searchform.php"); ?>
						</div>
				<!-- sidebar ends -->
					</div>
				</div>
			</div>
			<!-- maincontent ends -->
			<?php include("footer.php"); ?>
		</div>
	</body>

</html>