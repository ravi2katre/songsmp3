<?php include '../header.php'; ?>
<script src="<?= BASE_PATH ?>js/validation.js"></script>
<script language="javascript" >
    var compulsory = new Array('name');
    var dispError = new Array('category name !');
</script>

<?php
if($_GET['pid'] != '')
    $parentid = $_GET['pid'];
else
    $parentid = 0;

if($parentid != 0)
{
	$seq = "select path from category where id = ".$parentid;
	$PATH = '&raquo;&nbsp;<a href="index.php">Home</a>&nbsp;'.$db->query($seq,database::GET_FIELD);
}

$WHER = 'where parentid = '.$parentid . ' order by kram desc';

$pagingqry = "select * from category ".$WHER;
$rowsPerPage=10;
$gets='?';

$pagelink = ADMIN_BASE_PATH.'category/index.php?pid='.$parentid.'&page=';
//echo $sort;
$htmlpage = '';

include("../../includes/paging_admin.php");

$CATEGORY = $db->query($pagingqry.$limit);
$totalcategory = $numrows;


    $start_sr_no = $offset + 1;
    ?>

    <h2></h2>
    <h2>&nbsp;&nbsp;Categories Management</h2>
    <div style="height: 20px; color: #758719;">&nbsp;&nbsp;<?=$PATH?></div>
    <div align ="center">
    <?php
        if($totalcategory > 0)
        {
            ?>
            <table id="rounded-corner">
                <thead>
                    <tr>
                        <th scope="col" class="rounded-company"></th>
                        <th scope="col" class="rounded">Category Name</th>
                        <th scope="col" class="rounded"></th>
                        <th scope="col" class="rounded"></th>
                        <th scope="col" class="rounded"></th>
                        <th scope="col" class="rounded">Edit</th>
                        <th scope="col" class="rounded-q4">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($CATEGORY as $key => $val)
                        {   ?>
                            <tr>
                                <td><?php echo $start_sr_no ++ ?></td>
                                <td>
                                        <?php
                                        if($val['subcate'] == 1)
                                        {
                                            echo '<img src="'.ADMIN_BASE_PATH.'images/folder.png">&nbsp;';
                                            $cl = 'folder_link';
                                        }
                                        else
                                        {
                                            echo '&raquo;&nbsp;';
                                            $cl = '';
                                        }

                                        ?><a class="<?=$cl?>" href="?pid=<?=$val['id']?>"><?=$val['name']?></a><?php
                                        if($val['totalitem'] != 0)
                                            echo ' ( '.$val['totalitem'] .' files )';
                                        ?>
                                </td>
                                <td>
                                        <?php
                                        if($val['subcate'] != 1)
                                            echo '<a href="addimage.php?id='.$val['id'].'">Add Image</a>';
                                        ?>
                                </td>
                                <td>
                                        <?php
                                        if($val['subcate'] != 1)
                                            echo '<a href="addfile.php?id='.$val['id'].'">Add File</a>';
                                        ?>
                                </td>
                                <td>
                                    <form name='formname<?=$key?>' method='post' action='kramupdate.php?id=<?=$val['id']?>'>
                                            <input type="hidden" name="pid" value="<?=$parentid?>" />
                                            <select name='kram' onchange="formname<?=$key?>.submit()">
                                                    <option value="<?=$val['kram']?>"><?=$val['kram']?></option>
                                                    <?php
                                                        for($i=0 ; $i<=$totalcategory;$i++)
                                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                                    ?>
                                            </select>
                                            <input type="hidden" name="page" value="<?=$_GET['page']?>">
                                     </form>
                                </td>
                                <td><a href="editcategory.php?id=<?=$val['id']?>&pid=<?=$parentid?>"><img src="<?=ADMIN_BASE_PATH?>images/user_edit.png" alt="" title="edit" border="0" /></a></td>
                                <td><a href="deletecategory.php?id=<?=$val['id']?>&pid=<?=$parentid?>" class="ask"><img src="<?=ADMIN_BASE_PATH?>images/trash.png" alt="" title="delete" border="0" /></a></td>
                            </tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table>
            <?=$PAGE_CODE?>
           <?php
        }
        else
        {
            $pagingqry = 'select * from file where cid = '.$parentid .' order by kram desc';
            $rowsPerPage=10;
            $gets='?';

            $pagelink = ADMIN_BASE_PATH.'category/index.php?pid='.$parentid.'&page=';
            //echo $sort;
            $htmlpage = '';

            include("../../includes/paging_admin.php");

            $FILE = $db->query($pagingqry.$limit);
            //$params['PAGE_CODE'] = $PAGE_CODEs;
            $TOTAL_FILE = $numrows;

            //$kramval = array();
            //for($i=0 ; $i < $numrows ; $i++)
             //       array_push($kramval,array('krams' => $i+1));

            //$params['KRAM']=$kramval;

            $folq = "select folder from category where id = ".$parentid;
            $FOLDER = '../'.$db->query($folq,database::GET_FIELD);
            if($TOTAL_FILE != 0)
            {
                ?>
                    <div>
                        &nbsp;<a href="move-file.php?id=<?=$parentid?>" class="bt_green"><span class="bt_green_lft"></span><strong>Move All File To Other Folder</strong><span class="bt_green_r"></span></a>
                    </div>
                <?php
            }
            // now start file listing
            ?>
            <table id="rounded-corner">
                <thead>
                    <tr>
                        <th scope="col" class="rounded-company"></th>
                        <th scope="col" class="rounded">File Name (Downloads)</th>
                        <th scope="col" class="rounded">Extention</th>
                        <th scope="col" class="rounded">Size (KB)</th>
                        <th scope="col" class="rounded">Thumb</th>
                        <th scope="col" class="rounded"></th>
                        <th scope="col" class="rounded">Edit</th>
                        <th scope="col" class="rounded-q4">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($FILE as $key => $val)
                        {   ?>
                            <tr>
                                <td><?php echo $start_sr_no ++ ?></td>
                                <td>
                                        <?=$val['name']?> ( <?=$val['download']?> )
                                </td>
                                <td>
                                    <?=$val['ext']?>
                                </td>
                                <td>
                                    <?php echo getSize($val['size']) ?>
                                </td>
                                <td>
                                    <img src="../<?=$FOLDER?>thumb-<?=$val['dname']?>.<?=$val['thumbext']?>" />
                                </td>
                                <td>
                                    <form name='formname<?=$key?>' method='post' action='kramupdate.php?fid=<?=$val['id']?>'>
                                            <input type="hidden" name="pid" value="<?=$parentid?>" />
                                            <select name='kram' onchange="formname<?=$key?>.submit()">
                                                    <option value="<?=$val['kram']?>"><?=$val['kram']?></option>
                                                    <?php
                                                        for($i=0 ; $i<=$TOTAL_FILE;$i++)
                                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                                    ?>
                                                    <input type="hidden" name="page" value="<?=$_GET['page']?>">
                                            </select>
                                     </form>
                                </td>
                                <td><a href="editfile.php?id=<?=$val['id']?>&cid=<?=$parentid?>"><img src="<?=ADMIN_BASE_PATH?>images/user_edit.png" alt="" title="edit" border="0" /></a></td>
                                <td><a href="deletefile.php?id=<?=$val['id']?>&cid=<?=$parentid?>" class="ask"><img src="<?=ADMIN_BASE_PATH?>images/trash.png" alt="" title="delete" border="0" /></a></td>
                            </tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table>
            <?=$PAGE_CODE?>
           <?php
        }
        if($totalcategory == 0)
        {
            ?>
                <a href="multiple-upload.php?id=<?=$parentid?>" class="bt_red"><span class="bt_red_lft"></span><strong>Upload Multiple File</strong><span class="bt_red_r"></span></a>
            <?php
        }

        if($TOTAL_FILE == 0)
        {
            ?>
    <div class="clear"></div>
    
            <h2></h2>
            <h2 style="color: #d2e7f0; background-color:#086c8f; ">&nbsp;&nbsp; Add Category</h2>
            <div class="form">
                <form method="post" action="add_cat_db.php" onsubmit="return chkfrm(compulsory,dispError,this)" enctype="multipart/form-data" class="niceform">
                    <fieldset>
                        <dl>
                            <dt><label for="Category name">Category name:</label></dt>
                            <dd><input type="text" name="name" id="" size="30" /><span class="error">Use only alphabatical charater</span></dd>
                        </dl>
                        <dl>
                            <dt><label for="Category Thumb">Category Thumb:</label></dt>
                            <dd><input type="file" name="thumb" id="thumb" /></dd>
                        </dl>

                        <dl class="submit">
                            <input type="hidden" name="pid" value="<?=$parentid?>" />
                            <input type="submit" name="submit" id="submit" value="Submit" />
                        </dl>
                    </fieldset>
                </form>
            </div>
    
            <?php
        }
        else
        {
            ?>
            <a href="addimage.php?id=<?=$parentid?>" class="bt_green"><span class="bt_green_lft"></span><strong>Add Image</strong><span class="bt_green_r"></span></a>
            <a href="addfile.php?id=<?=$parentid?>" class="bt_blue"><span class="bt_blue_lft"></span><strong>Add File</strong><span class="bt_blue_r"></span></a>
            <?php
        }
        ?>
</div>
<?php include $adminfoldername.'/footer.php'; ?>