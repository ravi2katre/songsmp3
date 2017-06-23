<?php

//////////////////////////////////////////////////////     GEN FUNCTIONS START     ////////////////////////////////////////////
// Functions By Ravi Katre Starts
function allow_files(){
$extentions = array('3gp','avi','mp4','mpeg','mpg','mp3','wav','mid','jpeg','jar','sis','sisx','cod','jad','apk','jpg','gif','png','bmp','jpg','swf','ipa','flv','swf');
return $extentions;
}

function delete_unwanted_extentions(){
$extentions = implode('\',\'',allow_files());
$sql = "DELETE FROM file WHERE ext NOT IN('{$extentions}')";
global $db;
$db->query($sql);
echo "unwanted files deleted.";
}
// Functions By Ravi Katre Ends

function isValidEmail($email) {
    return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
}

//size
function getSize($size) {
    $s = number_format((($size / 1024) / 1024), 2, '.', '') . ' mb';
    if ($s < 1)
        $s = number_format(($size / 1024), 2, '.', '') . ' kb';

    return $s;
}

//function instr
function InStr($String, $Find, $CaseSensitive = false) {
    $i = 0;
    while (strlen($String) >= $i) {
        unset($substring);
        if ($CaseSensitive) {
            $Find = strtolower($Find);
            $String = strtolower($String);
        }
        $substring = substr($String, $i, strlen($Find));
        if ($substring == $Find)
            return true;
        $i++;
    }
    return false;
}

function cleanfilename($name) {
    $string = $name;

    //$string = str_replace(' ','-',$string);
    $string = str_replace('%20', '-', $string);
    $string = str_replace('_', '-', $string);



    $string = preg_replace("/[^a-zA-Z0-9\s]/", "-", $string);
    return $string;
}

//post all posted variables again to specified url
function submitfrm($url) {

    $strfrm = "<html><head></head><body><form name='frmsub1' id='frmsub1' method='post' action='" . $url . "'>";

    //get all form fields
    foreach ($_REQUEST as $key => $val) {
        //echo $key.'-->'.$val.'<br>';
        $strfrm = $strfrm . "<input type='hidden' name='" . $key . "' value='" . $val . "'>";
    }

    //exit;
    $strfrm = $strfrm . "</form><script> document.frmsub1.submit(); </script></body></html> ";

    echo $strfrm;
    exit();
}

function selfURL() {
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/") . $s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":" . $_SERVER["SERVER_PORT"]);
    return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
}

//check compulsory fields
function CheckCompulsory($arrcompulsory, $url) {

    for ($i = 0; $i <= count($arrcompulsory) - 1; $i++) {
        if (strlen($_REQUEST[$arrcompulsory[$i]]) > 0 && $_REQUEST[$arrcompulsory[$i]] != '') {

        } else {
            if (InStr($url, '?')) {
                submitfrm($url . '&err=compulsory&errfld=' . $arrcompulsory[$i]);
            } else {
                submitfrm($url . '?errid=10&errfld=' . $arrcompulsory[$i]);
            }
        }
    }
}

function getfrmvalue($arr) {
    $myvals = array();

    for ($i = 0; $i <= count($arr) - 1; $i++) {
        $myvals[$i] = "'" . $_REQUEST[$arr[$i]] . "'";
    }

    return $myvals;
}

function EditFlds($arrfld, $arrval) {
    $str = '';

    for ($i = 0; $i <= count($arrfld) - 1; $i++) {
        $str = $str . $arrfld[$i] . "=" . $arrval[$i] . ",";
    }

    if (endsWith($str, ",")) {
        $str = substr($str, 0, $str . length - 1);
    }

    return $str;
}

function endsWith($str, $sub) {
    return ( substr($str, strlen($str) - strlen($sub)) === $sub );
}

//error function
function error($error, $location, $seconds = 10) {
    header("Refresh: $seconds; URL=\"$location\"");
    echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"' . "\n" .
    '"http://www.w3.org/TR/html4/strict.dtd">' . "\n\n" .
    '<html>' . "\n" .
    '    <head>' . "\n" .
    '    <title>Upload error . . . . . . . . Powered by ' . SITENAME . '</title>' . "\n\n" .
    '    	<meta content="web site design & developed by ayudevelopers.com" name="KEYWORDS"/>' . "\n\n" .
    '    </head>' . "\n\n" .
    '    <body>' . "\n\n" .
    '    <div id="Upload">' . "\n\n" .
    '        <h1>Upload failure</h1>' . "\n\n" .
    '        <p>An error has occured:<br /> ' . "\n\n" .
    '        <span style="font:bold 14px arial,verdana;text-decoration:blink;color:#ff0000;">' . $error . '...</span>' . "\n\n<br />" .
    '         The upload form is reloading...</p>' . "\n\n" .
    '     </div>' . "\n\n" .
    '</html>';
    exit;
}

//function for upload image
function UploadImage($imgfld, $invalidurl, $saveimgname, $savefolder, $createthumb, $savethumbimgpath, $smallheightwidth) {
    //upload image
    if (strlen($_FILES[$imgfld]['name']) > 0 && $_FILES[$imgfld]['name'] != '') {
        if (($_FILES[$imgfld]["type"] == "image/gif") || ($_FILES[$imgfld]["type"] == "image/jpeg") || ($_FILES[$imgfld]["type"] == "image/pjpeg") || ($_FILES[$imgfld]["type"] == "image/x-png") || ($_FILES[$imgfld]["type"] == "image/png")) {
            $ext = split('\.', $_FILES[$imgfld]["name"]);
            $imgname = $saveimgname . '.' . $ext[count($ext) - 1];

            //$imgname = str_replace(' ','_',$imgname);

            if (move_uploaded_file($_FILES[$imgfld]["tmp_name"], $savefolder . $imgname)) {
                if ($createthumb == '1') {
                    //create thumb nail
                    $sourcethumb = $savefolder . $imgname;
                    $destthumb = $savethumbimgpath . 'thumb-' . $imgname;
                    if (copy($sourcethumb, $destthumb)) {
                        //if($savethumbimgpath != '')
                        //	$savethumbimgpath = $savethumbimgpath.$imgname;
                        createthumb($sourcethumb, $destthumb, $smallheightwidth, $ext[count($ext) - 1]);
                    } else {
                        echo "invalid thumb path";
                        exit;
                    }

                    //resizeImage($imgname,70,);
                }

                //$imginfo = getimagesize("../images/".$savefolder."/".$imgname);
                $imginfo = getimagesize($savefolder . $imgname);

                $height = $imginfo[1];
                $width = $imginfo[0];

                $img[0] = $imgname;
                $img[1] = $imginfo[0];
                $img[2] = $imginfo[1];
                $img[3] = $ext[count($ext) - 1];

                return $img;
            } else {
                //if not image.. show message.
                if (!(InStr($invalidurl, '?'))) {
                    $invalidurl .= "?1=1";
                }
                submitfrm($invalidurl . '&errid=8&name=' . $_FILES[$imgfld]["name"]);
            }
        } else {
            //if not image.. show message.
            if (!(InStr($invalidurl, '?'))) {
                $invalidurl .= "?1=1";
            }
            submitfrm($invalidurl . '&errid=7&name=' . $_FILES[$imgfld]["name"]);
        }
    }
}

//function for create thumbnail
function createthumb($source, $dest, $aspect, $ext) {

    if ($dest == "")
        $dest = $source;

    // Get new sizes
    list($width, $height) = @getimagesize($source);

    if ($width >= $aspect and $height >= $aspect) {
        if ($width == $height) {
            $ar = $aspect * 100 / $width;
            $newwidth = round($width * $ar / 100);
            $newheight = round($height * $ar / 100);
        } elseif ($height > $width) {
            $ar = round($aspect * 100 / $height);
            $newwidth = round($width * $ar / 100);
            $newheight = round($height * $ar / 100);
        } elseif ($height < $width) {
            $ar = $aspect * 100 / $width;
            $newwidth = round($width * $ar / 100);
            $newheight = round($height * $ar / 100);
        }
    } else {
        copy($source, $dest);
    }

    $thumb = @imagecreatetruecolor($newwidth, $newheight);

    if (strtolower($ext) == 'jpg' || strtolower($ext) == 'jpe' || strtolower($ext) == 'JPG' || strtolower($ext) == 'jpeg')
        $source = @imagecreatefromjpeg($source);
    if (strtolower($ext) == 'gif')
        $source = @imagecreatefromgif($source);
    if (strtolower($ext) == 'png')
        $source = @imagecreatefrompng($source);

    // Resize
    if ($withSampling)
        @imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    else
        @imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    // Output
    if (strtolower($ext) == 'jpg' || strtolower($ext) == 'jpe' || strtolower($ext) == 'JPG' || strtolower($ext) == 'jpeg')
        return @imagejpeg($thumb, $dest);
    if (strtolower($ext) == 'gif')
        return @imagegif($thumb, $dest);
    if (strtolower($ext) == 'png')
        return @imagepng($thumb, $dest);
}

function get_files($folder, $include_subs = FALSE) {
    // Remove any trailing slash
    if (substr($folder, -1) == '/') {
        $folder = substr($folder, 0, -1);
    }

    // Make sure a valid folder was passed
    if (!file_exists($folder) || !is_dir($folder) || !is_readable($folder)) {
        return FALSE;
        exit();
    }

    // Grab a file handle
    $all_files = FALSE;
    if ($handle = opendir($folder)) {
        $all_files = array();
        // Start looping through a folder contents
        while ($file = @readdir($handle)) {
            // Set the full path
            $path = $folder . '/' . $file;

            // Filter out this and parent folder
            if ($file != '.' && $file != '..') {
                // Test for a file or a folder
                if (is_file($path)) {
					$pathinfo = pathinfo($path);
					//print_r($pathinfo['extension']);exit;
					if(in_array(strtolower($pathinfo['extension']),allow_files())){
                    	$all_files[] = $path;
					}
                } elseif (is_dir($path) && $include_subs) {
                    // Get the subfolder files
                    $subfolder_files = get_files($path, TRUE);

                    // Anything returned
                    if ($subfolder_files) {
                        $all_files = array_merge($all_files, $subfolder_files);
                    }
                }
            }
        }
        // Cleanup

        closedir($handle);
    }
    // Return the file array
    @sort($all_files);

    return $all_files;
}

//function for upload audio file
function UploadFile($fld, $invalidurl, $savename, $savefolder) {
    //upload audio
    if (strlen($_FILES[$fld]['name']) > 0 && $_FILES[$fld]['name'] != '') {
        $ext = split('\.', $_FILES[$fld]["name"]);
        $name = $savename . '.' . $ext[count($ext) - 1];

        if (move_uploaded_file($_FILES[$fld]["tmp_name"], $savefolder . "/" . $name)) {
            return true;
        } else {
            //if not image.. show message.
            if (!(InStr($invalidurl, '?'))) {
                $invalidurl .= "?1=1";
            }
            header("location: $invalidurl&errid=22");
        }
    }
}

//////////////////////////////////////////////////////     LOGIN FUNCTIONS START     ////////////////////////////////////////////
function IsUserLogin() {

    if (strlen($_SESSION['admin_id']) > 0 && $_SESSION['admin_id'] != '') {
        return true;
    } else {
        return false;
    }
}

function CheckAdminLogin($path) {
    if (IsUserLogin ()) {
        $_SESSION['adminlink'] = '';
    } else {
        $_SESSION['adminlink'] = $_SERVER['REQUEST_URI'];
        submitfrm($path . "admin_login.php?errid=2");
    }
}

function CheckLogin() {
    if (IsLogin ()) {
        $_SESSION['file_name'] = '';
        return;
    } else {
        $_SESSION['file_name'] = $_SERVER['REQUEST_URI'];
        submitfrm(BASE_PATH . "common/login.php?errid=1");
    }
}

//////////////////////////////////////////////////////     LOGIN FUNCTIONS END     /////////////////////////////////////////////
// convert from mysql DATETIME to "dd/mm/yyyy"
function fromSqlDate($strSqlDate, $format) {
    // Error checking
    $err = false;

    // We will be doning many levels of error checking
    // and will need to bale at any time,
    // so we do this...
    if (strlen($strSqlDate) >= 8 || strlen($strSqlDate) <= 10) {
        // separate date and time with space
        $tempDate = explode(' ', $strSqlDate);

        // if we got both
        if (count($tempDate) == 2) {
            $mydate = explode('-', $tempDate[0]);
            $mytime = explode(':', $tempDate[1]);
            $hour = $mytime[0];
            $minute = $mytime[1];
            $second = $mytime[2];
            $year = $mydate[0];
            $month = $mydate[1];
            $daynum = $mydate[2];
        } elseif (count($tempDate == 1)) {
            $mydate = explode('-', $tempDate[0]);

            $hour = 0;
            $minute = 0;
            $second = 0;
            $year = $mydate[0];
            $month = $mydate[1];
            $daynum = $mydate[2];
        }
        else
            $err = true;
    }
    else
        $err = true;

    if (!$err)
    // PHP Date Object
        return date($format, mktime($hour, $minute, $sec, $month, $daynum, $year));
    else
        return false;
}

//////////////////////////start resize image function /////////////////////////////
///creating thunb.
function resizeImage($filename, $aspect=0, $newfilename="", $withSampling=true) {
    if ($newfilename == "")
        $newfilename = $filename;

    // Get new sizes
    list($width, $height) = @getimagesize($filename);

    if ($width >= $aspect and $height >= $aspect) {
        if ($width == $height) {
            $ar = $aspect * 100 / $width;
            $newwidth = round($width * $ar / 100);
            $newheight = round($height * $ar / 100);
        } elseif ($height > $width) {
            $ar = round($aspect * 100 / $height);
            $newwidth = round($width * $ar / 100);
            $newheight = round($height * $ar / 100);
        } elseif ($height < $width) {
            $ar = $aspect * 100 / $width;
            $newwidth = round($width * $ar / 100);
            $newheight = round($height * $ar / 100);
        }
    }
    // Load

    $thumb = @imagecreatetruecolor($newwidth, $newheight);
    $ext = substr($filename, strlen($filename) - 3);

    if ($ext == 'jpg' || $ext == 'jpe' || $ext == 'JPG' || $ext == 'pjpeg' || $ext == 'jpeg')
        $source = @imagecreatefromjpeg($filename);
    if ($ext == 'gif')
        $source = @imagecreatefromgif($filename);
    if ($ext == 'png')
        $source = @imagecreatefrompng($filename);

    // Resize
    if ($withSampling)
        @imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    else
        @imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    // Output
    if ($ext == 'jpg' || $ext == 'jpe' || $ext == 'JPG' || $ext == 'pjpeg' || $ext == 'jpeg')
        return @imagejpeg($thumb, $newfilename);
    if ($ext == 'gif')
        return @imagegif($thumb, $newfilename);
    if ($ext == 'png')
        return @imagepng($thumb, $newfilename);
}

//////////////////////////end resize image function /////////////////////////////

function resizeImagec($filename, $newwidth, $newheight, $newfilename="", $withSampling=true) {
    if ($newfilename == "")
        $newfilename = $filename;

    // Get new sizes
    list($width, $height) = @getimagesize($filename);

    $thumb = @imagecreatetruecolor($newwidth, $newheight);
    $ext = substr($filename, strlen($filename) - 3);

    if ($ext == 'jpg' || $ext == 'jpe' || $ext == 'JPG' || $ext == 'peg' || $ext == 'jpeg')
        $source = @imagecreatefromjpeg($filename);
    if ($ext == 'gif')
        $source = @imagecreatefromgif($filename);
    if ($ext == 'png')
        $source = @imagecreatefrompng($filename);

    // Resize
    if ($withSampling)
        @imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    else
        @imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    // Output
    if ($ext == 'jpg' || $ext == 'jpe' || $ext == 'JPG' || $ext == 'peg' || $ext == 'jpeg')
        return @imagejpeg($thumb, $newfilename);
    if ($ext == 'gif')
        return @imagegif($thumb, $newfilename);
    if ($ext == 'png')
        return @imagepng($thumb, $newfilename);
}

function MoveFile($SourceFileName, $SourceFolderPath, $TargetFileName, $TargetFolderPath) {
    $original_name = '';

    if (strpos($SourceFileName, ' ') > 0) {
        $original_name = $SourceFileName;
        $SourceFileName = str_replace(' ', '-', $SourceFileName);
        rename('../' . str_replace(BASE_PATH, '', $SourceFolderPath) . $original_name, '../' . str_replace(BASE_PATH, '', $SourceFolderPath) . $SourceFileName);
    }
    $url = $SourceFolderPath . urldecode($SourceFileName);
    $savefile = $TargetFolderPath . cleanfilename($TargetFileName);
    //echo '../' . str_replace(BASE_PATH, '', $SourceFolderPath) . urldecode($SourceFileName).' | ';
    //echo str_replace(BASE_PATH, '', $TargetFolderPath) . $TargetFileName;
    //echo '<br/>';
    if (@copy('../' . str_replace(BASE_PATH, '', $SourceFolderPath) . urldecode($SourceFileName), str_replace(BASE_PATH, '', $TargetFolderPath) . $TargetFileName)) {

        /*        // create a new CURL resource
          $ch = curl_init();

          // set URL and other appropriate options
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_HEADER, false);
          curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLINFO_HEADER_OUT, true);

          set_time_limit(3000); # 5 minutes for PHP
          curl_setopt($ch, CURLOPT_TIMEOUT, 3000);// or die('time limit exceed... Contact to Developer... '); # and also for CURL

          $outfile = fopen($savefile, 'wb');
          curl_setopt($ch, CURLOPT_FILE, $outfile);// or die('can not write destination file');

          // grab file from URL
          curl_exec($ch) or die(' Error in copy source file.. ');

          $info = curl_getinfo($ch);
          fclose($outfile);
         */
        $ext1 = explode('.', $SourceFileName);
        $ext = $ext1[count($ext1) - 1];

        if (strtolower($ext) == 'jpg' || strtolower($ext) == 'jpeg' || strtolower($ext) == 'png') {
            $folder_lev = '../';
            $text = BASE_PATH;
            $color = '#000000';
            $font = 'arial.ttf';
            $font_size = '10';
            $angle = 90;
            $offset_x = 0;
            $offset_y = 0;
            $drop_shadow = true;
            $shadow_color = '#FFFFFF';
            $mode = 1;
            $images_folder = $TargetFolderPath;
            $destination_folder = $TargetFolderPath;

            // Image path
            $imgpath = $images_folder . $original_name;

            // Where to save watermarked image
            $imgdestpath = $imgpath;
            // create class instance
            $img = new Zubrag_watermark($imgpath);

            // shadow params
            $img->setShadow($drop_shadow, $shadow_color);

            // font params
            $img->setFont($font, $font_size);

            // Apply watermark
            $img->ApplyWatermark($text, $color, $angle, $offset_x, $offset_y);

            // Save on server
            $img->SaveAsFile($imgdestpath);

            // Output to browser
            //$img->Output();
            // release resources
            $img->Free();
        }
    }
    if ($original_name != '') {
        if (file_exists($TargetFolderPath . $SourceFileName))
            rename($TargetFolderPath . $SourceFileName, $TargetFolderPath . $original_name);
    }
    //echo $TargetFolderPath . $SourceFileName.' | ';
    //echo $TargetFolderPath . $original_name;
    //echo '<br/>';
}

?>
