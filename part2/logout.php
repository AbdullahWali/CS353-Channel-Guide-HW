<?php
	session_start();
	include_once 'dbconnect.php';

	unset($_SESSION['user']);
	session_unset();
	session_destroy();
	header("Location: index.php");
 	exit;
?>