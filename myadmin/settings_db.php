<?php include 'includes/admin-config.php'; ?>
<?php
	
	$name = $_REQUEST['username'];
	$pass = $_REQUEST['password'];
	$email = $_REQUEST['email'];
	$title = $_REQUEST['title'];
	$sitename = $_REQUEST['sitename'];
	$filepostfix = $_REQUEST['filepostfix'];
	$thumbw = $_REQUEST['thumbw'];
	$dthumbw = $_REQUEST['dthumbw']; 
	$dthumbh = $_REQUEST['dthumbh'];
	
	$nn = "update admin set 
			username = '$name', 
			password = '$pass', 
			email = '$email' ,
			sitename = '$sitename',
			title = '$title',
			thumbw = '$thumbw',
			filepostfix = '$filepostfix',
			dthumbw = '$dthumbw',
			dthumbh = '$dthumbh'
			where id = 1";
	$db->query($nn);
	
	header("location: settings.php?errid=11");
?>