<?php
/*
// web root
$base_url = 'http';
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
{
   
    $base_url .= 's';
    
}

$base_url .= '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']; 
$base_url = preg_replace('@[^/]*$@i', '', $base_url);*/
//define('BASE_URL', 'http://zjmaza.localhost/');

define('BASE_URL', 'http://songsmp3.localhost/');

// doc root
define('BASE_DIR', getcwd() . '/');
define("BASE_PATH",BASE_URL);
?>