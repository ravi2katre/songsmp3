<?php

include("../includes/admin-config.php");

if ($_POST['pid'] != '') {

        function set_newpath_rename_category($id,$pid,$newname,$db,$base_path,$new = 0)
        {
            $parent_path = $db->query('select path,pathc,clink from category where id = '.$pid , database::GET_ROW);
            $new_create_path = $db->query('select * from category where id = '.$id , database::GET_ROW);

            $newpath = $parent_path['path'];
            $newpathc = $parent_path['pathc'];
            $newclink = $parent_path['clink'];
            $name = $new_create_path['name'];
            if($new != 1)
                $newname = $name;

            $newpath .= '&nbsp;&raquo;&nbsp;<a href="?pid='.$id.'">'.$newname.'</a>';
            //echo '<br/>';
            $newpathc .= '&nbsp;&raquo;&nbsp;<a href="'.$base_path.'category/'.$id.'/'.$newname.'.html">'.$newname.'</a>';
            //echo '<br/>';
            $newclink .= '/'.$newname;
            //echo "update category path = '$newpath' , pathc = '$newpathc' , clink = '$newclink' where id = $id";
            //echo '<br/>';
            //exit;
            $db->query("update category set path = '$newpath' , pathc = '$newpathc' , clink = '$newclink' where id = $id");
        }
        function showlist($parent, $indent = 0,$newname,$base_path,$db)
        {
                global $total;
                $result = $db->query("SELECT * FROM category WHERE parentid =" . mysql_real_escape_string($parent));
                $n = count($result);
                for($i=0;$i<$n;$i++)
                {
                        //echo $result[$i]["id"].' | '.$result[$i]["parentid"] . "<br>";
                        set_newpath_rename_category($result[$i]["id"], $result[$i]["parentid"], $newname, $db, $base_path);
                        showlist($result[$i]["id"], $indent = 0,$newname,BASE_PATH,$db);
                }
        }
    $parentid = $_REQUEST['pid'];
    $id = $_REQUEST['id'];
    
    $qnew = 'select thumb,name,folder from category where id = ' . $id;
    $old = $db->query($qnew,  database::GET_ROW);
    $oldthumb = $old['thumb'];
    $oldname = $old['name'];
    $folder = $old['folder'];
    $newname = $_REQUEST['name'];
    $thumbfullname = '';
    $flds = array("name","des", "newitemtag", "updateitemtag");
    $vals = getfrmvalue($flds);

    if ($_FILES['thumb']['name'] != '') {
        $rand = rand(111111111111, 999999999999);
        $thumbname = $rand . '-' . $_REQUEST['name'];
        @getimagesize($_FILES['thumb']['tmp_name']) or error('only image uploads are allowed', $invalidurl);
        $thumbup = UploadImage('thumb', $invalidurl, $thumbname, '../../folderthumb/', 0, '', 0);
        createthumb('../../folderthumb/' . $thumbname . '.' . $thumbup[3], '../../folderthumb/' . $thumbname . '.' . $thumbup[3], THUMBW, $thumbup[3]);
        $thumbext = $thumbup[3];
        $thumbfullname = $thumbname . '.' . $thumbext;
        unlink('../../folderthumb/' . $oldthumb);
    } else {
        $thumbfullname = $oldthumb;
    }
    // clear thumb
    if ($_REQUEST['clearthumb'] == 'on') {
        $thumbfullname = '';
    }

    $qryUpdate = "update category set " . EditFlds($flds, $vals) . ",thumb = '$thumbfullname' where id=" . $id;

    $db->query($qryUpdate);

    if($oldname != $newname)
    {
        // no need to rename folder name
        // first rename current record than we will go to parent record
        set_newpath_rename_category($id, $parentid, $newname, $db, BASE_PATH,1);
        showlist($id, $indent = 0,$newname,BASE_PATH,$db);
        //$newname1 = substr($folder, 0,  (strlen($folder) - strlen($oldname))-1);
        //$oldfolder = substr($folder, 0,  strlen($folder)-1);
        //$newfolder = $newname1.$_REQUEST['name'];
        //rename('../../'.$oldfolder, '../../'.$newfolder);
        //exit;
    }

    $para = ($parentid !=0 ? "errid=12&id=" . $id . "&pid=$parentid" : "errid=12&id=" . $id );
    
    if ($parentid != 0)
        header("location: index.php?" . $para);
    else
        header("location: index.php?". $para);
}
?>