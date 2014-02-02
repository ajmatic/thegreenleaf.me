<?php
session_start();
// check to make sure user is logged in
if (true !== $_SESSION["logged_in"]){
	header("Location: /login.php");
}