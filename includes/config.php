<?php
// Report all PHP errors (see changelog)
//error_reporting(E_ALL);

// Report all PHP errors
error_reporting(0);

// Same as error_reporting(E_ALL);
//ini_set('error_reporting', E_ALL);

$agent_c = $_SERVER['HTTP_USER_AGENT'];

$rootDir = dirname(dirname(__FILE__));
set_include_path($rootDir . PATH_SEPARATOR . get_include_path());

// if not get error than take screen shot ;)
//include("class.URI_Cache.php");
//$cache = new URI_Cache(1100);

require_once('includes/language.php');
require_once('includes/function.php');
require_once('includes/connection.php');
require_once('includes/path.php');

//$db->disconnect();
//user paths
//define("BASE_PATH","http://new.sabmaza.com/");
//for error message
if ($_REQUEST['errid'] != "" && is_numeric($_REQUEST['errid'])) {
    if (count($message) < $_REQUEST['errid']) {
        $msg = $message[0];
    } else {
        $msg = $message[$_REQUEST['errid']];
    }

    $CurrentMessage = "<span class='error'>" . $msg . "</span><br>";
}

//print_r($_REQUEST);
$nname = $_GET['ht'];

if ($_GET['pid'] != '')
    $parentid = $_GET['pid'];
else
    $parentid = 0;


if (!is_numeric($parentid)) {
    echo "Please not try to be claver. Please do not edit url manually";
    exit;
}


// get title
if ($parentid != '' && $parentid > 0) {
    $folqtt = $db->query("select clink from category where id = " . $_REQUEST['pid'], database::GET_FIELD);
    $NTITLE = str_replace('/', ' > ', $folqtt);
}

//head setting
//setting for head
$headset = $db->query('select `set`,sitename,filepostfix,title,dthumbw,dthumbh from admin where id = 1', database::GET_ROW);





//$params['HEAD_TITLE'] = $headset['title'];
define("SITETITLE", $headset['title']);
define("SITENAME", $headset['sitename']);
define("POSTFIX", $headset['filepostfix']);
define("THUMB_W", $headset['dthumbw']);
define("THUMB_H", $headset['dthumbh']);


if ($parentid == 0) {
    $LOGO = '<div class="ad2 tCenter"><div class="bkmk">BookMark Now@PagalFun.Com</div>
							<div class="catRow"></div>';
}


?>