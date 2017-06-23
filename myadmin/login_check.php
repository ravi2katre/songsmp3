<?php
	include("includes/admin-config.php");
	
	$logqry = "select * from admin where username='".$_REQUEST['uname']."' and password='".$_REQUEST['pwd']."'";

	if($logrec = $db->query($logqry,database::GET_ROW))
	{

	    $id=$logrec["id"];
		
		//echo $id; 
		$_SESSION['admin_id']=$logrec["id"];
		$_SESSION['admin_name']=$logrec["username"];

                if($link1!="")
		{
			//print "<META http-equiv='refresh' content='0;URL=$link1'>"; 
			header('Location: '.$link1);
		}
		else			
		{	//echo $_SESSION['session_fname'];
			header('Location: '.ADMIN_BASE_PATH .'index.php');
		}
	  }
	else
	{
			header('Location: '.ADMIN_BASE_PATH."admin_login.php?errid=16");
	}	
	  
?>