<?php
/*
$image_name = 'call';
	$fh = fopen("tmp_crawl.php", 'w') or die("can't open file");
	$stringData = $image_name;
	fwrite($fh, $stringData);
	fclose($fh);					

	@extract($_REQUEST);
	
	$filename	= $_FILES['file']['name'];
	$temp_name	= $_FILES['file']['tmp_name'];
	$error		= $_FILES['file']['error'];
	$size		= $_FILES['file']['size'];
	
	/* NOTE: Some server setups might need you to use an absolute path to your "dropbox" folder
	(as opposed to the relative one I've used below).  Check your server configuration to get
	the absolute path to your web directory*/
	/* if(!$error)
		move_uploaded_file($temp_name, '../../../folder/'.$filename);
		
	echo '1'; 
*/
?>

<?php

$errors = array();
$data = "";
$success = "false";

function return_result($success,$errors,$data) {
	echo("<?xml version=\"1.0\" encoding=\"utf-8\"?>");	
	?>
	<results>
	<success><?=$success;?></success>
	<?=$data;?>
	<?=echo_errors($errors);?>
	</results>
	<?
}

function echo_errors($errors) {

	for($i=0;$i<count($errors);$i++) {
		?>
		<error><?=$errors[$i];?></error>
		<?
	}
}

switch($_REQUEST['action']) {

    case "upload":

    $file_temp = $_FILES['file']['tmp_name'];
    $file_name = $_FILES['file']['name'];

    $file_new_name = $_REQUEST['newName'].'.'.pathinfo($file_name, PATHINFO_EXTENSION);

    $file_path = '../../../folder';

    //checks for duplicate files
    if(!file_exists($file_path."/".$file_name)) {

         //complete upload
         $filestatus = move_uploaded_file($file_temp,$file_path."/".$file_new_name);

         if(!$filestatus) {
         $success = "false";
         array_push($errors,"Upload failed. Please try again.");
         }

    }
    else {
    $success = "false";
    array_push($errors,"File already exists on server.");
    }

    break;

    default:
    $success = "false";
    array_push($errors,"No action was requested.");

}

return_result($success,$errors,$data);

?>