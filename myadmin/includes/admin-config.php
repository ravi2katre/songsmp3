<?php

	session_start();
	ob_start();
	error_reporting(0);
    $adminfoldername = 'myadmin';
	 $rootDir = dirname(dirname(__FILE__));
	$rootDir = str_replace($adminfoldername,'',$rootDir);
	set_include_path($rootDir . PATH_SEPARATOR . get_include_path());
	//set_include_path($_SERVER['DOCUMENT_ROOT'].'pagalfun.com' . PATH_SEPARATOR . get_include_path());
	require_once("includes/function.php");
	require_once($adminfoldername."/includes/language.php");
	require_once($rootDir."/includes/path.php");
    require_once('includes/admin_connection.php');

        $currentFile = $_SERVER["SCRIPT_NAME"];
	$parts = explode('/', $currentFile);
	$currpagename = $parts[count($parts)-1];

        //$_SESSION['admin_id'] = '1';

        //define('BASE_PATH','http://localhost/eclipse/djmaza.ravikatre.com/trunk/');
        define('ADMIN_BASE_PATH',BASE_PATH.'myadmin/');
$adminfolder = 'myadmin/';

	if(!($currpagename == 'admin_login.php' or $currpagename == 'login_check.php'))
        	CheckAdminLogin(ADMIN_BASE_PATH);


	// For Login
//	if(isset($_SESSION['session_fname']))
//	{
//            $params['G_ADMIN_ID'] = $_SESSION['admin_id'];
//            $params['G_ADMIN_NAME'] = $_SESSION['admin_id'];
//	}

	//for error message
	if($_REQUEST['errid']!="" && is_numeric($_REQUEST['errid']))
	{
            if(count($message) < $_REQUEST['errid'])
            {
                    $msg = $message[0];
            }
            else
            {
                    $msg = $message[$_REQUEST['errid']];
            }
            if($_REQUEST['errid'] == 2 || $_REQUEST['errid'] == 5 || $_REQUEST['errid'] == 17)
            {
                $CurrentMessage = '<div class="error_box" id="dddd">'.$msg.'</div>';
            }
            elseif($_REQUEST['errid'] == 6)
            {
                $CurrentMessage = '<div class="warning_box" id="dddd">'.$msg.'</div>';
            }
            else {
                $CurrentMessage = '<div class="valid_box" id="dddd">'.$msg.'</div>';
            }
	}

	//setting for head
	$headsetq = 'select * from admin where id = 1';
	$headset = $db->query($headsetq, database::GET_ROW);

	define("FILEADDNAME",$headset['filepostfix']);
	define("THUMBW",$headset['thumbw']);

	//watermark font size
	$font_size = '14';
	// RK $text = "PagalFun.com";
	$text = "";

?>