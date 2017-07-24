<?php
	include("../includes/admin-config.php");
	
	if($_GET['id'] != '' && $_GET['pid'] != '')
	{
		$parentid = $_GET['pid'];
		$q = 'select subcate from category where id = '.$_REQUEST['id'];

		if($db->query($q,database::GET_FIELD) == 1)
		{
			if($_GET['pid'] != 0)
				header("location: index.php?errid=6&pid=".$_GET['pid']);
			else
				header("location: index.php?errid=6");
			exit;
		}
                //if this folder have any file than remove first
                //start
		$qq = 'select * from file where cid = '.$_REQUEST['id'];
		$qt = $db->query($qq);
		
		$qfp = 'select folder from category where id = '.$_REQUEST['id'];
		$folderpath = '../../'.$db->query($qfp,database::GET_FIELD);
		
		foreach($qt as $row => $val)
		{
			unlink($folderpath.$val['dname'].'.'.$val['ext']);
			unlink($folderpath.'thumb-'.$val['dname'].'.'.$val['thumbext']);
		}
		
		$deletefile = 'delete from file where cid = '.$_REQUEST['id'];
		$db->query($deletefile);
		//end remove file
                //decrease category counting
		$chkanothercat = 'select count(id) from category where parentid = '.$parentid;
		if($db->query($chkanothercat,database::GET_FIELD) == 1)
		{
			$updatesubcat = 'update category set subcate = 0 where id = '.$parentid;
			$db->query($updatesubcat);
		}
		// now remove directory
		$folddel = substr($folderpath,0,$folderpath-1);
		rmdir($folddel);
		//echo '<pre>';
		//print_r($qt);
		//exit;
                //remove thumb now
		$qfp = 'select thumb from category where id = '.$_REQUEST['id'];
		$thumb = $db->query($qfp,database::GET_FIELD);
		
		@unlink('../../folderthumb/'.$thumb);

                //now delete this category
		$delcat = 'delete from category where id = '.$_GET['id'];
		$db->query($delcat);

		if($parentid != 0)
			header("location: index.php?errid=4&pid=$parentid");
		else
			header("location: index.php?errid=4");
	}
	
?>