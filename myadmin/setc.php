<?php
include("includes/admin-config.php");

$a = 'select * from category';
$z = $db->query($a);
if(count($z) > 0)
{
    foreach($z as $key => $val)
    {
            $qnq = 'select count(id) as totfile from file where cid = '.$val['id'];
            $qnz = $db->query($qnq , database::GET_ROW);
            if($qnz['totfile'] >= 0)
            {
                $upd = 'update category set totalitem = '.$qnz['totfile'].' where id = '.$val['id'];
                $db->query($upd);
            }

    }
}

$total = 0;
global $total;
function showlist($parent, $indent = 0,$db)
{
	global $total;
	$result = $db->query("SELECT * FROM category WHERE parentid =" . mysql_real_escape_string($parent));
	$n = count($result);
	for($i=0;$i<$n;$i++)
	{
		//echo $indent, $result[$i]["name"], "<br>";
		//echo $result[$i]['totalitem'].'-'.$result[$i]['id'].'<br />';
		if($result[$i]['subcate'] == 0)
		{
			//echo 'here<br />';
			$indent = $result[$i]['totalitem'];
			$total = $total + $indent;
		}
		//$indent .= '&nbsp;&nbsp;';
		//echo $indent;
		showlist($result[$i]["id"], $indent ,$db);
		//echo $indent."<br>";
	}
}

$q = $db->query('select * from category where subcate = 1');
$n = count($q);
for($i=0;$i<$n;$i++)
{
	$total = 0;
	showlist($q[$i]['id'],0,$db);
	$db->query('update category set totalitem = '.$total.' where id = '.$q[$i]['id']);
	//echo $total.'<br />'.$q[$i]['id'];
	//echo '<br />';
}

header( 'refresh: 3; url='.ADMIN_BASE_PATH);
echo '<h1>Database Setup successfully......Wait 3 second!</h1>';
?>
<a href="<?=BASE_PATH?>admin/">Click Here</a>
