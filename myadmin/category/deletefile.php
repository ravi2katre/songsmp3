<?php
	include("../includes/admin-config.php");
	
	if($_GET['id'] != '' && $_GET['cid'] != '')
	{
		$cid = $_GET['cid'];
		$id = $_GET['id'];
		
		$q = 'select * from file where id = '.$id;
		$qt = $db->query($q,  database::GET_ROW);
		
		$qfp = 'select folder from category where id = '.$cid;
		$folderpath = '../../'.$db->query($qfp,  database::GET_FIELD);
		
		unlink($folderpath.$qt['dname'].'.'.$qt['ext']);
		unlink($folderpath.'thumb-'.$qt['dname'].'.'.$qt['thumbext']);
		
		$deletefile = 'delete from file where id = '.$id;
		$db->query($deletefile);
					
		$updatesubcat = 'update category set totalitem = totalitem - 1 where id = '.$cid;
		$db->query($updatesubcat);
		
		if($cid != 0)
			header("location: index.php?errid=9&pid=$cid");
		else
			header("location: index.php?errid=9");
	}
	
?>