<?php
var_dump($_SERVER);
die; 
if ("local.thegreenleaf.me" === $_SERVER["SERVER_NAME"]) {
	$db = mysql_connect("localhost", "root", "Music2981") or die("Could not connect to databse.");
	mysql_select_db("blog", $db);
} else {
	$db = mysql_connect("db513541110.db.1and1.com", "dbo513541110", "ajmatic2881") or die("Could not connect to databse.");
	mysql_select_db("db513541110", $db);
}


?>