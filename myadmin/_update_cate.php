<?php
include("includes/admin-config.php");

$id = 733;
$pid = 0;
$newname = 'new_id_new';

//echo '<br/>';

//$db->query("update category set name = '$newname',path = '$newpath' , pathc = '$newpathc' , clink = '$newclink' where id = $id");

//<a href="?pid=737">22</a> //<a href="http://ayudevelopers.com/wap/category/737/22.html">22</a>
//print_r($ccpath1);
//exit;
function set_newpath_rename_category($id,$pid,$newname,$db,$base_path)
{
    $parent_path = $db->query('select path,pathc,clink from category where id = '.$pid , database::GET_ROW);
    $new_create_path = $db->query('select * from category where id = '.$id , database::GET_ROW);

    $newpath = $parent_path['path'];
    $newpathc = $parent_path['pathc'];
    $newclink = $parent_path['clink'];

    $newpath .= '&nbsp;&raquo;&nbsp;<a href="?pid='.$id.'">'.$newname.'</a>';
    //echo '<br/>';
    echo $newpathc .= '&nbsp;&raquo;&nbsp;<a href="'.$base_path.'category/'.$id.'/'.$newname.'.html">'.$newname.'</a>';
    //echo '<br/>';
    $newclink .= '/'.$newname;
    //echo '<br/>';
    $db->query("update category set name = '$newname',path = '$newpath' , pathc = '$newpathc' , clink = '$newclink' where id = $id");
}


//$total = 0;
//global $total;
function showlist($parent, $indent = 0,$db)
{
	global $total;
	$result = $db->query("SELECT * FROM category WHERE parentid =" . mysql_real_escape_string($parent));
	$n = count($result);
	for($i=0;$i<$n;$i++)
	{
		
                //echo $result[$i]["id"].' | '.$result[$i]["parentid"] . "<br>";
		//echo $result[$i]['totalitem'].'-'.$result[$i]['id'].'<br />';
		//if($result[$i]['subcate'] == 0)
		//{
			
                        //echo 'here<br />';
			//$indent = $result[$i]['totalitem'];
			//$total = $total + $indent;
		//}
                $indent++;
//$indent .= '&nbsp;&nbsp;';
		//echo $indent;
		showlist($result[$i]["id"], $indent ,$db);
		//echo $indent."<br>";
	}
}

//$q = $db->query('select * from category where subcate = 1');
//$n = count($q);
//for($i=0;$i<$n;$i++)
//{
//	$total = 0;
	showlist($id,0,$db);
//	$db->query('update category set totalitem = '.$total.' where id = '.$q[$i]['id']);
	//echo $total.'<br />'.$q[$i]['id'];
	//echo '<br />';
//}

?>
