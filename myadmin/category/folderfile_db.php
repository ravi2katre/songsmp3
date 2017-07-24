<?php
	include("../includes/admin-config.php");
	
	$pid = $_POST['pid'];

	if($pid != '')
	{
		//print_r($_REQUEST);

		//dir_list.php
		$default_dir = "../../folder/"; 
		
		// lists files only for the directory which this script is run from
		$listfile = array();
		$i = 0;
		if(!($dp = opendir($default_dir))) die("Cannot open $default_dir.");
		while(false !== ($file = readdir($dp))) 
		{
			if(!is_dir($file)) 
			{
				if($file != '.' && $file != '..') 
				{
					$listfile[$i]['filename'] =  $file;
					$i++;
				}
			}
		}
		closedir($dp);
		
		$invalidurl = ADMIN_BASE_PATH.'category/folderfile.php?id='.$pid;

		$q = 'select folder from category where id = '.$pid;
		$savefolder = $db->query($q,  database::GET_FIELD);
		
		include("../../includes/watermark_text.class.php");
		
		foreach($listfile as $k => $v)
		{
			$oldcurrentfilename = $listfile[$k]['filename'];
			$currentfilename = str_replace(' ','-',$listfile[$k]['filename']);
			
			rename('../../folder/'.$listfile[$k]['filename'],'../../folder/'.$currentfilename);
			
			if($_POST['existingthumb'] == 1)
			{
				//get name without ext
				$thumbext = 'jpg';
			}

			$ext1 = explode('.',$currentfilename);
			$ext = $ext1[count($ext1)-1];
			
			if(strlen($ext) == 3)
				$newname = substr($currentfilename,0,strlen($currentfilename)-4);	
			elseif(strlen($ext) == 4)
				$newname = substr($currentfilename,0,strlen($currentfilename)-5);	
			//$actu = $newname;
			//$newname = $rand.'-'.cleanfilename($ext1[0]).FILEADDNAME;
			$oldcurrentfilename = $newname.FILEADDNAME.'.'.$ext;
			
			$name = $newname;
			$newname = cleanfilename($newname);
			//$newname = $currentfilename;
			//$name = cleanfilename($ext1[0]);
			
			$url = BASE_PATH.'folder/'.$currentfilename;
			$rurl = '../../folder/'.$currentfilename;
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
			
			$outfile = fopen('../../'.$savefolder.$newname.'.'.$ext, 'wb');
			curl_setopt($ch, CURLOPT_FILE, $outfile) or error('can not write destination file',$invalidurl);
			
			// grab file from URL
			curl_exec($ch) or error(' Error in copy source file.. ', $invalidurl,7);
			
			$info = curl_getinfo($ch);
			fclose($outfile);
			$fileSize = $info['size_download'];	

			//copy($url,'../../'.$savefolder.$newname.'.'.$ext);

			if($_POST['thumb'] == 1)
			{
				//@getimagesize($url) or error('only image uploads are allowed', $invalidurl);
				createthumb('../../'.$savefolder.$newname.'.'.$ext,'../../'.$savefolder.'thumb-'.$newname.'.'.$ext,THUMBW,$ext);
				$thumbext = $ext;
				$imgtype = 1;
			}
			else
			{
				$imgtype = 0;
			}
			// if file is image than create thumb
			if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' )
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
				$images_folder = '../../'.$savefolder;
				$destination_folder = '../../'.$savefolder;
				
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
			rename('../../'.$savefolder.$newname.'.'.$ext,'../../'.$savefolder.$oldcurrentfilename);
			
			if($_POST['thumb'] == 1)
			{
				rename('../../'.$savefolder.'thumb-'.$newname.'.'.$ext,'../../'.$savefolder.'thumb-'.$oldcurrentfilename);
			}
			
	//		$actu = $newname;
			if(strlen($ext) == 3)
				$newname = substr($oldcurrentfilename,0,strlen($oldcurrentfilename)-4);	
			elseif(strlen($ext) == 4)
				$newname = substr($oldcurrentfilename,0,strlen($oldcurrentfilename)-5);			
				
                        $Filename= '../../'.$savefolder.$newname.'.'.$ext;
                        //$newname = $oldcurrentfilename;
                        if(strtolower($ext)=='mp3')
                            include 'chintan.php';

			$qryUpdate = "insert into file (name,dname,cid,ext,thumbext,size,imagetype) 
				VALUES ('$name','$newname',$pid,'$ext','$thumbext','$fileSize',$imgtype)";
			$db->query($qryUpdate);
	                //set kram on 14-4-11
                        $getnewid = $db->insert_id;
                        $qrygetkram = $db->query("select count(id) from file where cid = $pid",  database::GET_FIELD);
                        $qryupdatekram = $db->query("update file set kram = $qrygetkram where id = $getnewid");
                        /// over kram
			$qryUpdate = "update category set totalitem = totalitem + 1 where id in($pid)";
			$db->query($qryUpdate);
			
			unlink($default_dir.$currentfilename);
		
		}
	}
	
	header("location: index.php?pid=$pid");
?>
