<?php
	include("includes/admin-config.php");
	$_SESSION['admin_id']="";
	$_SESSION['user_name']="";
	session_destroy();
	$login = ADMIN_BASE_PATH."admin_login.php?errid=2";
	header("Location:".$login);
	exit;
?>