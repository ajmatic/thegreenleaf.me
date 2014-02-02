<?php 
//open connection to the database

include("./cms/db_connect.php");

//Get post_id from query string
$post_id = (isset($_REQUEST["post_id"]))?$_REQUEST["post_id"]:"";

//If post_id is a number get post from darabase
if (preg_match("/^[0-9]+$/", $post_id)) {
	$sql = "SELECT post_id, title, post, DATE_FORMAT(postdate, '%e %b %Y at %H:%i') AS dateattime FROM posts 
	WHERE post_id=$post_id LIMIT 1";
		$result = mysql_query($sql);
		$myposts = mysql_fetch_array($result);
}

include("functions.php");

//If comment has been submitted and post exists then add comment to database
if (isset($_POST["postcomment"]) != "") {
	$posttitle = addslashes(trim(strip_tags($_POST["posttitle"])));
	$name = addslashes(trim(strip_tags($_POST["name"])));
	$email = addslashes(trim(strip_tags($_POST["email"])));
	$website = addslashes(trim(strip_tags($_POST["website"])));
	$comment = addslashes(trim(strip_tags($_POST["comment"])));

	$sql = "INSERT INTO comments
	(post_id, name, email, website, comment)
	VALUES ('$post_id', '$name', '$email', '$website', '$comment')";
	$result2 = mysql_query($sql);
	if (!$result2) {
		$message = "Failed to insert comment.";
	} else {
		$message = "Comment added.";
		$comment_id = mysql_insert_id();

		//send yourself an email when a comment is successfully added 
		$emailsubject = "Comment added to: ".$posttitle;

		$emailbody = "Comment on '".$posttitle."'"."\r\n"."http://www.ajmatic.com/post.php?post_id=".$post_id."#c".$comment_id."\r\n\r\n"
			.$comment."\r\n\r\n"
			.$name." (".website.")\r\n\r\n";
			$emailbody - stripcslashes($emailbody);

			$emailheader = "From: ".$name." <".$email.">\r\n"."Reply-To: ".$email;

			mail("adam.lamagna@yahoo.com", $emailsubject, $emailbody, $emailheader);

			// direct to post page to eliminate repeat posts
			header("Location: post.php?post_id=$post_id&message=$message");
	}
}


if ($myposts) {
	$sql = "SELECT comment_id, name, website, comment FROM comments WHERE post_id = $post_id";
	$result3 = mysql_query($sql);
	$mycomments = mysql_fetch_array($result3);
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		<title>the green leaf blog</title>
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

			<!--this is the main part of the page -->
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
									echo "<h2>$title</h2>\n";
									echo "<h4>Posted on $dateattime</h4>\n";
									echo "<div class='post'>\n $post \n</div>";
								} while ($myposts = mysql_fetch_array($result));
							} else {
								echo "<p>There is no post matching a post_id of $post_id.</p>";
							}
							?>
							<div id="comments">
								<h2>Comments</h2>
								<?php
								if($mycomments) {
									echo "<dl>";
									do {
										$comment_id = $mycomments["comment_id"];
										$name = $mycomments["name"];
										$website = $mycomments["website"];
										$comment = format($mycomments["comment"]);
										if ($website != "") {
											echo "<dt><a href='$website'>$name</a> wrote:</dt>\n";
										} else {
											echo "<dt>$name wrote:</dt>\n";
										}
										echo "<dd>$comment</dd>\n";
									} while ($mycomments = mysql_fetch_array($result3));
									echo "</dl>"; 
									} else {
										echo "<p>There are no comments yet.</p>";
								}
								?>
								
							</div>
						</div>
					</div>
					<div class="col-sm-3 col-md-3">
						<div id="sidebar">
							<h3>Add a comment</h3>
							<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" class="form-horizontal" role="form">
							    <div class="form-group">
							      <div class="col-sm-10">
							        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>" />
									<input type="hidden" name="posttitle" value="<?php echo $title; ?>" />
									<?php
										if (isset($message)) {
											echo "<p class='message'>".$_POST["message"]."</p>";
										}
									?>
							      </div>
							    </div>
							    <div class="form-group">
							      <div class="col-sm-10">
							        <input type="text" class="form-control" id="name" name="name" placeholder="Name">
							      </div>
							    </div>
							    <div class="form-group">
							      <div class="col-sm-10">
							        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
							      </div>
							    </div>
							    <div class="form-group">
							      <div class="col-sm-10">
							        <input type="text" class="form-control" id="website" name="website" placeholder="Website">
							      </div>
							    </div>
							    <div class="form-group">
							      <div class="col-sm-10">
							        <textarea class="form-control" rows="3" id="comment" name="comment" placeholder="Comments"></textarea>
							      </div>
							    </div>
							    <div class="form-group">
							      <div class="col-sm-offset-2 col-sm-10">
							        <button type="submit" class="btn btn-primary" name="postcomment">Submit</button>
							        
							      </div>
							    </div>
							</form>
						</div>
				<!--sidebar ends-->
					</div>
					<div class="col-sm-3 col-md-3">
						<?php include("searchform.php"); ?>
					</div>
				</div>

			</div>
			<!--maincontent ends -->
			<?php include("footer.php"); ?>
		</div>
	</body>
</html>