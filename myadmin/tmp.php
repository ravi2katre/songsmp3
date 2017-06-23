<?php
// for read directory
    include("includes/admin-config.php");

function get_files ($folder, $include_subs = FALSE) {
	// Remove any trailing slash
	if(substr($folder, -1) == '/') {
		$folder = substr($folder, 0, -1);
	}

	// Make sure a valid folder was passed
	if(!file_exists($folder) || !is_dir($folder) || !is_readable($folder)) {
		return FALSE;
		exit();
	}

	// Grab a file handle
	$all_files = FALSE;
	if($handle = opendir($folder))	{
		$all_files = array();
		// Start looping through a folder contents
		while ($file = @readdir ($handle)) {
			// Set the full path
			$path = $folder.'/'.$file;

			// Filter out this and parent folder
			if($file != '.' && $file != '..') {
				// Test for a file or a folder
				if(is_file($path)) {
					$all_files[] = $path;
				} elseif (is_dir($path) && $include_subs) {
					// Get the subfolder files
					$subfolder_files = get_files ($path, TRUE);

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

$folder_scan = '../scan_dir';
$folder_scan_file = get_files($folder_scan,true);
echo '<pre>';
print_r($folder_scan_file);
echo '<br />---------------------<br />';
$folder_lev = '../';
include($folder_lev."includes/watermark_text.class.php");
foreach($folder_scan_file as $key => $val)
{
    $parentid = 0;

    $flink = str_replace($folder_scan.'/', '', $val);
    $fpart = explode('/', $flink);

    $folder_level = count($fpart) - 1;
    // now check all sub folder
    for($i=0;$i < $folder_level;$i++)
    {
        $thumbext = '';
        if($parentid <= 0)
            $where = ' and parentid = 0';
        else
            $where = '';
        $chk_f = $db->query('select id from category where name ="'.$fpart[$i].'" '.$where,  database::GET_FIELD);
        if(is_array($chk_f))
        {
            if($parentid != 0)
            {
                    $qfol = 'select folder,clink from category where id = '.$parentid;
                    $fo = $db->query($qfol,  database::GET_ROW);
                    $folderpath = $fo['folder'];
                    $clinkp = $fo['clink'].'/';
            }
            else
            {
                    $folderpath = 'upload_file/';
            }
            $newid = $db->query("insert into category (name,parentid)
                    values('".$fpart[$i]."','$parentid')");
            $newid = $db->insert_id;

            if($newid < 1)
                echo 'error';
            // new folder create
            $mkfolder = $folder_lev.$folderpath.$newid;
            $folder = $folderpath.$newid.'/';
            if(!is_dir($folder_lev.$mkfolder))
            {
                    mkdir($mkfolder, 0777);
                    chmod($mkfolder, 0777);
            }
            if(!is_dir($mkfolder))
            {
                echo '<h2>Error to Createing Directory On '.$mkfolder.' <br /> Automatic Back in 5 seconds........</h2>';

                if($parentid != 0)
                        header("refresh: 5; url=index.php?errid=3&pid=$parentid");
                else
                        header("refresh: 5; url=index.php?errid=3");
                exit;
            }

            $clink = str_replace('upload_file/','',$clinkp.$fpart[$i]);

            // update subcate and folder structure
            $db->query("update category set folder = '$folder' , clink = '$clink' where id = ".$newid);

            if($parentid > 0)
                $db->query("update category set subcate = 1 where id = ".$parentid);

            //update path
            // this path for use in admin
            $q = 'select path from category where id = '.$parentid;
            if($parentid > 0)
                $path = $db->query($q,  database::GET_FIELD) . '&nbsp;&raquo;&nbsp;<a href="?pid='.$newid.'">'.$fpart[$i].'</a>';
            else
                $path = '&nbsp;&raquo;&nbsp;<a href="?pid='.$newid.'">'.$fpart[$i].'</a>';

            $qc = 'select pathc from category where id = '.$parentid;
            if($parentid > 0)
                $pathc = $db->query($qc,  database::GET_FIELD) . '&nbsp;&raquo;&nbsp;<a href="'.BASE_PATH.'category/'.$newid.'/'.$fpart[$i].'.html">'.$fpart[$i].'</a>';
            else
                $pathc = '&nbsp;&raquo;&nbsp;<a href="'.BASE_PATH.'category/'.$newid.'/'.$fpart[$i].'.html">'.$fpart[$i].'</a>';


            $db->query("update category set path = '$path',pathc = '$pathc' where id = ".$newid);

            $parentid = $newid;

        }
        else
        {
           $parentid = $db->query('select id from category where name ="'.$fpart[$i].'" '.$where,  database::GET_FIELD);
        }
    }
    // now insert file to folder
        // get extantion
        $l_filename = $fpart[$folder_level];
        $chknamethumb = substr($l_filename, 0, 6);
        
   if($chknamethumb != 'thumb-')
   {

        $Filename = $l_filename;
        //$currentfilename = $l_filename;
        $folder = $db->query('select folder from category where id ="'.$parentid.'"',  database::GET_FIELD);

        $val_path = substr($val, 0,  (strlen($val) - strlen($Filename)));

        //rename($val,$val_path.$currentfilename);
        
        // check thumb
        $ext1 = explode('.',$Filename);
        $ext = $ext1[count($ext1)-1];

        if(strlen($ext) == 3)
            $newname = substr($Filename,0,strlen($Filename)-4);
        elseif(strlen($ext) == 4)
            $newname = substr($Filename,0,strlen($Filename)-5);

        //file name without extantion
        $l_filename_without_ext = substr($l_filename, 0,strlen($l_filename) - (strlen($ext)+1));
        if(file_exists($val_path.'thumb-'.$l_filename_without_ext.'.jpg'))
            $thumbext = 'jpg';
        elseif(file_exists($val_path.'thumb-'.$l_filename_without_ext.'.gif'))
            $thumbext = 'gif';
        elseif(file_exists($val_path.'thumb-'.$l_filename_without_ext.'.png' ))
            $thumbext = 'png';
        elseif(file_exists($val_path.'thumb-'.$l_filename_without_ext.'.jpeg'))
            $thumbext = 'jpeg';
        elseif(file_exists($val_path.'thumb-'.$l_filename_without_ext.'.JPG'))
            $thumbext = 'JPG';
        elseif(file_exists($val_path.'thumb-'.$l_filename_without_ext.'.GIF'))
            $thumbext = 'GIF';
        elseif(file_exists($val_path.'thumb-'.$l_filename_without_ext.'.PNG' ))
            $thumbext = 'PNG';
        elseif(file_exists($val_path.'thumb-'.$l_filename_without_ext.'.JPEG'))
            $thumbext = 'JPEG';
        else
            $thumbext = '';

        //$oldcurrentfilename = $newname.FILEADDNAME.'.'.$ext;
        //$oldcurrentfilename = $newname.'.'.$ext;

        $name = $newname;
        $newname = $newname;

        $url = BASE_PATH. substr($val_path,3).$Filename;
        $rurl = $folder_lev.$folder.$newname.'.'.$ext;
        // create a new CURL resource
        $ch = curl_init();

        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        set_time_limit(9000); # 15 minutes for PHP
        curl_setopt($ch, CURLOPT_TIMEOUT, 9000) or error('time limit exceed... Contact to Developer... ',$invalidurl); # and also for CURL

        $outfile = fopen($rurl, 'wb');
        curl_setopt($ch, CURLOPT_FILE, $outfile) or error('can not write destination file',$invalidurl);

        // grab file from URL
        curl_exec($ch) or error(' Error in copy source file.. ', $invalidurl,7);

        $info = curl_getinfo($ch);
        fclose($outfile);
        $fileSize = $info['size_download'];

        if(strlen($ext) == 3)
            $oldthumbwe = substr($Filename,0,strlen($Filename)-4);
        elseif(strlen($ext) == 4)
            $oldthumbwe = substr($Filename,0,strlen($Filename)-5);

        if($thumbext != '')
        {
            $thumb_source = $folder_lev.substr($val_path,3).'thumb-'.$oldthumbwe.'.'.$thumbext;
            //echo '<br />';
            $thumb_target = $folder_lev.$folder.'thumb-'.$newname.'.'.$thumbext;
            //echo '<br />';
            //echo '------------------';
            copy($thumb_source, $thumb_target);
            //$imgtype = 1;
        }
        else
        {
            $thumbext = '';
            //$imgtype = 0;
        }
        
        if(strtolower($ext) == 'jpg' || strtolower($ext) == 'jpeg' || strtolower($ext) == 'png' || strtolower($ext) == 'gif')
            $imgtype = 1;
        else
            $imgtype = 0;

        // if file is image than create thumb
        if(strtolower($ext) == 'jpg' || strtolower($ext) == 'jpeg' || strtolower($ext) == 'png' )
        {
            //$text = BASE_PATH;
            $color = '#000000';
            $font = 'arial.ttf';
            //$font_size = '10';
            $angle = 90;
            $offset_x = 0;
            $offset_y = 0;
            $drop_shadow = true;
            $shadow_color = '#FFFFFF';
            $mode = 1;
            $images_folder = $folder_lev.$folder;
            $destination_folder = $folder_lev.$folder;

            // Image path
            $imgpath = $images_folder.$newname.'.'.$ext ;

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

        if($imgtype == 1 && $thumbext == '')
        {
            //echo $folder_lev.$folder.$oldcurrentfilename.' | '.$folder_lev.$folder.'thumb-'.$newname.'.'.$ext.' | '.THUMBW.' | '.$ext;
            //exit;
            createthumb(BASE_PATH.$folder.$Filename,$folder_lev.$folder.'thumb-'.$newname.'.'.$ext,THUMBW,$ext);
            $thumbext = $ext;
            //echo 'chintan';
            //exit;
            //rename('../../'.$savefolder.'thumb-'.$newname.'.'.$ext,'../../'.$savefolder.'thumb-'.$oldcurrentfilename);
        }

        // save file to its default name
        //rename($folder_lev.$folder.$newname.'.'.$ext,$folder_lev.$folder.$oldcurrentfilename);

        $Filename= $folder_lev.$folder.$newname.'.'.$ext;
        //$newname = $oldthumbwe;
        if(strtolower($ext)=='mp3')
            include 'chintan.php';

        $qryUpdate = "insert into file (name,dname,cid,ext,thumbext,size,imagetype)
                VALUES ('$name','$newname',$parentid,'$ext','$thumbext','$fileSize',$imgtype)";
        $db->query($qryUpdate);

        $qryUpdate = "update category set totalitem = totalitem + 1 where id  = $parentid ";
        $db->query($qryUpdate);
        $Filename = '';

    }
}


?>
