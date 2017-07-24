<?php
require_once('getid3/getid3.php');     

/*RK 2012-09--31
*fatech dynamic tags for clinet pcs
*/
$clientServersDetail = array();
if(isset($_GET['requestfrom']) && !empty($_GET['requestfrom'])){
	$clientServersDetail = $db->query("select * from client_servers where domain= '{$_GET['requestfrom']}'", database::GET_ROW);
	//print_r($clientServersDetail );
	
	//$clientServersDetail = $mp3tagdetails[$_GET['requestfrom']];
}
//exit;
/**/

$TaggingFormat = 'UTF-8';

$DirectoryToScan = '';
$mp3 = $Filename;//$DirectoryToScan."a.mp3"; //The mp3 file.

// Initialize getID3 engine
$getID3 = new getID3;
$getID3->setOption(array('encoding'=>$TaggingFormat));

require_once('getid3/write.php');

// Initialize getID3 tag-writing module
$tagwriter = new getid3_writetags;
//$tagwriter->filename = '/path/to/file.mp3';
$tagwriter->filename = $mp3;
//$tagwriter->filename = 'P:/webroot/_dev/getID3/testfiles/_writing/2011-02-02/test.mp3';

$tagwriter->tagformats = array('id3v1', 'id3v2.3');
//$tagwriter->tagformats = array('id3v2.3');

// set various options (optional)
$tagwriter->overwrite_tags = true;
//$tagwriter->overwrite_tags = false;
$tagwriter->tag_encoding   = $TaggingFormat;
$tagwriter->remove_other_tags = true;

/*change mp3 img
*
*/
if(count($clientServersDetail) > 0)
{
	$chintan_image = $clientServersDetail['mp3_thumb'];
}
else
	$chintan_image = 'files/img2.jpg';
/**/

$fd = @fopen($chintan_image, 'rb');
$APICdata = fread($fd, filesize($chintan_image));
fclose ($fd);
list($APIC_width, $APIC_height, $APIC_imageTypeID) = GetImageSize($chintan_image);
$imagetypes = array(1=>'gif', 2=>'jpeg', 3=>'png');

$bas = substr(BASE_PATH,0,strlen(BASE_PATH) -1);
$bas = str_replace('http://', '', $bas);
// populate data array

if(isset($_GET['requestfrom']) && !empty($_GET['requestfrom'])){
$bas = substr($_GET['requestfrom'],0,strlen($_GET['requestfrom']));
$bas = str_replace('http://', '', $bas);
}


	$TagData = array(
		'title'   => array($name.' '.$bas),
		'artist'  => array($bas),
		'album'   => array($bas),
		'year'    => array(date('y')),
		'genre'   => array($bas),
		'comment' => array('Download From '.$_GET['requestfrom']),
		'track'   => array($_GET['requestfrom']),
	);





if (isset($imagetypes[$APIC_imageTypeID])) {

	$TagData['attached_picture'][0]['data']          = $APICdata;
	$TagData['attached_picture'][0]['picturetypeid'] = 0;
	$TagData['attached_picture'][0]['description']   = $chintan_image;
	$TagData['attached_picture'][0]['mime']          = 'image/'.$imagetypes[$APIC_imageTypeID];
}

$tagwriter->tag_data = $TagData;

// write tags
if ($tagwriter->WriteTags()) {
	//echo 'Successfully wrote tags<br>';
	if (!empty($tagwriter->warnings)) {
		echo 'There were some warnings:<br>'.implode('<br><br>', $tagwriter->warnings);
	}
} else {
	echo 'Failed to write tags!<br>'.implode('<br><br>', $tagwriter->errors);
}
 ?>