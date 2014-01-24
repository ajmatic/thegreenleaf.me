<?php

include($_SERVER["DOCUMENT_ROOT"] . "/functions.php");
//Open connection to database
include("db_connect.php");

//If delete has a valid post_id
$delete = (isset($_REQUEST["delete"]))?$_REQUEST["delete"]:"";
if (preg_match("/^[0-9]+$/", $delete)) {
	$sql = "DELETE FROM posts WHERE post_id = $delete LIMIT 1";
	$result = mysql_query($sql);
	if (!$result) {
		$message = "Failed to delete post $delete. MySQL said " . mysql_error();
	} else {
		$message = "Post $delete deleted.";
		$message .= "<br />" . makerssfeed();
	}
}

//Select all posts in db
$sql = "SELECT post_id, title, DATE_FORMAT(postdate, '%e %b %Y at %H:%i') AS dateattime FROM  posts ORDER BY post_id DESC";
$result = mysql_query($sql);
$myposts = mysql_fetch_array($result);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		<title>All blog posts - Blog CMS</title>
		<style type="text/css"> @import url(../cms/css/cms.css); </style>
	</head>
	<body>
		<?php include("nav.inc") ?>
		<h1>All blog posts</h1>

		<?php 
		if (isset($message)) {
			echo "<p class='message'>".$message."</p>";
		}

		if($myposts) {
			echo "<ol>\n";
			do {
				$post_id = $myposts["post_id"];
				$title = $myposts["title"];
				$dateattime = $myposts["dateattime"];
				echo "<li value='$post_id'>";
				echo "<a href='addpost.php?post_id=$post_id'>$title</a> posted $dateattime";
				echo " [<a href='".$_SERVER["PHP_SELF"]."?delete=$post_id' onclick='return confirm(\"Are you sure?\")'>delete</a>]";
				echo "</li>\n";
			} while ($myposts = mysql_fetch_array($result));
			echo "</ol>";
		} else {
			echo "<p>There are no blog posts in the database.</p>";
		}
		?>
	</body>
</html>