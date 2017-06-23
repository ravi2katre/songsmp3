<?php
    //require_once 'includes/CacheHandler.Class.php';
	require_once 'includes/admin.class.database.php';

	$db_host = 'localhost';
	$db_user = 'root';
	$db_pass = 'root';
	$db_name = 'facebook_facebook99';

	// Calling the object with a database selected
	$db = new database($db_host,$db_user,$db_pass,$db_name);
?>