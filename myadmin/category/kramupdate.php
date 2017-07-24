<?php
	include("../includes/admin-config.php");

	$kram = $_POST['kram'];
	
	if($_REQUEST['id'] != '')
		$qryUpdate = "update category set kram = $kram where id =".$_REQUEST['id'];
	elseif($_REQUEST['fid'] != '')
		$qryUpdate = "update file set kram = $kram where id =".$_REQUEST['fid'];
	
	$db->query($qryUpdate);
	
	if($_REQUEST['page'] == '')
            header('location: index.php?pid='.$_REQUEST['pid']);
        else
            header('location: index.php?pid='.$_REQUEST['pid'].'&page='.$_REQUEST['page']);

?>