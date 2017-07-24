<?php
	include("../includes/admin-config.php");
	
	if($_POST['cid'] != '')
	{
		$cid = $_REQUEST['cid'];
		$fieldname = 'file';	
		$invalidurl = ADMIN_BASE_PATH.'category/addimage.php?id='.$cid;
		if($_FILES[$fieldname]['name'] == '')
		{
			if($_REQUEST['url'] == '')
				error('Please select file or enter url properly ', $invalidurl,7);
		}

		//$rand = rand(111111111,999999999);
					
		if($_FILES[$fieldname]['name'] != '')
		{
			@getimagesize($_FILES[$fieldname]['tmp_name']) or error('only image uploads are allowed', $invalidurl);
			
			$ext1 = explode('.',$_FILES[$fieldname]['name']);
			$ext = $ext1[count($ext1)-1];
			$newname = cleanfilename($ext1[0]).FILEADDNAME;
			
			if($_REQUEST['name'] == '')
			{
				$name = $ext1[0];
			}
			else
			{
				$name = $_REQUEST['name'];
			}
	
			$fileSize = $_FILES[$fieldname]['size'];
			$q = 'select folder from category where id = '.$cid;
			$savefolder = $db->query($q,  database::GET_FIELD);
					
			UploadImage($fieldname,$invalidurl,$newname,'../../'.$savefolder,1,'../../'.$savefolder,THUMBW);
	
		}
		elseif($_REQUEST['url'] != '')
		{
			$url = $_REQUEST['url'];
			//get extention
			$ext2 = explode('/',$url);
			$ext1 = explode('.',$ext2[count($ext2)-1]);
			
			$ext = $ext1[count($ext1)-1];
			
			if($ext == '')
				error('Please select Url properly (with extention) ', $invalidurl,7);
				
			$newname = cleanfilename($ext1[0]).FILEADDNAME;
			
			if($_REQUEST['name'] == '')
			{
				$name = cleanfilename($ext1[0]);
			}
			else
			{
				$name = $_REQUEST['name'];
			}

			$q = 'select folder from category where id = '.$cid;
			$savefolder = $db->query($q,  database::GET_FIELD);
			
			// create a new CURL resource
			$ch = curl_init();

			// set URL and other appropriate options
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLINFO_HEADER_OUT, true);

			set_time_limit(300); # 5 minutes for PHP
			curl_setopt($ch, CURLOPT_TIMEOUT, 300) or error('time limit exceed... ',$invalidurl); # and also for CURL
			
			$outfile = fopen('../../'.$savefolder.$newname.'.'.$ext, 'wb');
			curl_setopt($ch, CURLOPT_FILE, $outfile) or error('can not write destination file',$invalidurl);
			
			// grab file from URL
			curl_exec($ch) or error(' Error in copy source file.. ', $invalidurl,7);
			
			$info = curl_getinfo($ch);
			fclose($outfile);
			
			$fileSize = $info['size_download'];			
			
			@getimagesize('../../'.$savefolder.$newname.'.'.$ext) or error('only image uploads are allowed', $invalidurl);
			createthumb('../../'.$savefolder.$newname.'.'.$ext,'../../'.$savefolder.'thumb-'.$newname.'.'.$ext,THUMBW,$ext);
		}
		if($ext != 'gif')
		{		
			$text = "Pagalfun.com";
			$color = '#000000';
			$font = 'arial.ttf';
			
			$angle = 90;
			$offset_x = 0;
			$offset_y = 0;
			$drop_shadow = true;
			$shadow_color = '#FFFFFF';
			$mode = 1;
			$images_folder = '../../'.$savefolder;
			$destination_folder = '../../'.$savefolder;
			
			include("../../includes/watermark_text.class.php");
	
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
			$img->Free();   echo $savefolder.$newname.'.'.$ext;   echo "raviokkkkk";exit;
		}
		
		$des = $_REQUEST['desc'];
		$newtag = $_REQUEST['newtag'];
		
		$qryUpdate = "insert into file (name,dname,cid,ext,thumbext,size,`desc`,newtag,imagetype) VALUES ('$name','$newname',$cid,'$ext','$ext','$fileSize','$des','$newtag',1)";
		$db->query($qryUpdate);
                //set kram on 14-4-11
                $getnewid = $db->insert_id;
                $qrygetkram = $db->query("select count(id) from file where cid = $cid",  database::GET_FIELD);
                $qryupdatekram = $db->query("update file set kram = $qrygetkram where id = $getnewid");
                /// over kram
		$qryUpdate = "update category set totalitem = totalitem + 1 where id = $cid";
		$db->query($qryUpdate);
		
		header("location: addimage.php?errid=1&id=$cid&last=$name.$ext");
	}
	
?>
