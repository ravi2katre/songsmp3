<?php
	include("../includes/admin-config.php");
	if(get_magic_quotes_runtime())
		set_magic_quotes_runtime(0);

	if (get_magic_quotes_gpc())
	{
		function stripslashes_array($array)
		{
			return is_array($array) ? array_map('stripslashes_array', $array) : stripslashes($array);
		}

		//$_GET = stripslashes_array($_GET);
		//$_POST = stripslashes_array($_POST);
		$_REQUEST = stripslashes_array($_REQUEST);
		//$_COOKIE = stripslashes_array($_COOKIE);
	}
		$am = $_REQUEST['home_topm'];
		$bm = $_REQUEST['home_bottomm'];
		$cm = $_REQUEST['home_categorym'];
		$dm = $_REQUEST['all_page_topm'];
		$em = $_REQUEST['all_page_bottomm'];
		$fm = $_REQUEST['after_download_linkm'];
		$gm = $_REQUEST['before_download_linkm'];
		$hm = $_REQUEST['file_list_startm'];
		$im = $_REQUEST['file_list_endm'];
                $jm = $_REQUEST['file_page_topm'];
                $km = $_REQUEST['file_page_bottomm'];
                $lm = $_REQUEST['before_thumbm'];
                $mm = $_REQUEST['related_download_startm'];
                $nm = $_REQUEST['related_download_endm'];
		$ap = $_REQUEST['home_topp'];
		$bp = $_REQUEST['home_bottomp'];
		$cp = $_REQUEST['home_categoryp'];
		$dp = $_REQUEST['all_page_topp'];
		$ep = $_REQUEST['all_page_bottomp'];
		$fp = $_REQUEST['after_download_linkp'];
		$gp = $_REQUEST['before_download_linkp'];
		$hp = $_REQUEST['file_list_startp'];
		$ip = $_REQUEST['file_list_endp'];
                $jp = $_REQUEST['file_page_topp'];
                $kp = $_REQUEST['file_page_bottomp'];
                $lp = $_REQUEST['before_thumbp'];
                $mp = $_REQUEST['related_download_startp'];
                $np = $_REQUEST['related_download_endp'];

		$addarray = array('a.adv','b.adv','c.adv','d.adv','e.adv','f.adv','g.adv','h.adv','i.adv','j.adv','k.adv','l.adv','m.adv','n.adv',
                    'a.pdv','b.pdv','c.pdv','d.pdv','e.pdv','f.pdv','g.pdv','h.pdv','i.pdv','j.pdv','k.pdv','l.pdv','m.pdv','n.pdv');
		$valarray = array($am,$bm,$cm,$dm,$em,$fm,$gm,$hm,$im,$jm,$km,$lm,$mm,$nm,
                    $ap,$bp,$cp,$dp,$ep,$fp,$gp,$hp,$ip,$jp,$kp,$lp,$mp,$np);
		//print_r($addarray);
		foreach($addarray as $k => $v)
		{
			$File = "../../$v"; 
			$Handle = fopen($File, 'w');
			$Data = $valarray[$k]; 
			fwrite($Handle, $Data); 
			fclose($Handle); 
		}
		header("location: ".ADMIN_BASE_PATH."advertisement/index.php?errid=13");
		
?>