<?php include '../header.php'; ?>
<?php
    if($_GET['id'] == '')
        exit;
    $id = $_GET['id'];
    $from = $id;
?>
 <div class="warning_box">
     Select always last folder <strong> ( which have not any sub folder...) </strong>
 </div>

<div style="padding: 20px; line-height: 20px">

    <?php
        $catname = $db->query('select name from category where id = '.$id,  database::GET_FIELD);
    ?>
        <h2></h2>
        <h2>Move File From : <strong><?=$catname?> </strong> 
        </h2>
        <h2>To :- Select Folder </h2>
        <?php
            function showlist($parent, $indent = 0,$db,$from)
            {
                    global $total;
                    $result = $db->query("SELECT * FROM category WHERE parentid =" . mysql_real_escape_string($parent));
                    $n = count($result);
                    for($i=0;$i<$n;$i++)
                    {
                            $indent++;
                            for($in=0;$in < $indent ; $in ++)
                                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;';
                            echo '<a href="'.ADMIN_BASE_PATH.'category/move-file-db.php?to='.$result[$i]["id"].'&from='.$from.'">'.$result[$i]["name"].'</a><br>';
                            //echo $result[$i]['totalitem'].'-'.$result[$i]['id'].'<br />';
                            //$indent .= '&nbsp;&nbsp;';
                            //echo $indent;
                            showlist($result[$i]["id"], $indent ,$db,$from);
                            $indent--;
                            //echo $indent."<br>";
                    }
            }

            $q = $db->query('select * from category where parentid = 0');
            $n = count($q);
            for($i=0;$i<$n;$i++)
            {
                   echo '&raquo;&nbsp;';
                   echo '<a href="'.ADMIN_BASE_PATH.'category/move-file-db.php?to='.$q[$i]['id'].'&from='.$from.'">'.$q[$i]['name'].'</a><br>';
                   //echo $q[$i]['name'].'<br>';
                   showlist($q[$i]['id'],0,$db,$from);
                    //echo $total.'<br />'.$q[$i]['id'];
                    //echo '<br />';
            }
        ?>
</div>
<?php include $adminfoldername.'/footer.php'; ?>