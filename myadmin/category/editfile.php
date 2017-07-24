<?php include '../header.php'; ?>
<?php
$id = $_GET['id'];
$cid = $_GET['cid'];
if($_GET['id'] == '' || $_GET['cid'] == '')
	exit;
else
{
	$n = $db->query('select * from file where id = '.$id,database::GET_ROW);

	$folq = "select folder from category where id = ".$cid;
	$FOLDER = '../../'.$db->query($folq,database::GET_FIELD);
}

?>
    <h2></h2>
    <a href="index.php?pid=<?=$cid?>" class="bt_blue"><span class="bt_blue_lft"></span><strong>&laquo; Go Back To File list</strong><span class="bt_blue_r"></span></a>
    <h2>&nbsp;&nbsp; Edit File</h2>
    <div align="left">
        <form action="editfile_db.php" method="post" enctype="multipart/form-data" class="niceform">
            <fieldset>
                <dl>
                    <dt><label for="File name">File name:</label></dt>
                    <dd><input type="text" name="name" id="" value="<?=$n['name']?>" size="54" /></dd>
                </dl>
                <dl>
                    <dt><label for="File Thumb">File Thumb:</label></dt>
                    <dd>
                        <img src="<?=$FOLDER?>thumb-<?=$n['dname']?>.<?=$n['thumbext']?>" />
                    </dd>
                </dl>
                <dl>
                    <dt></dt>
                    <dd><input type="file" name="thumb" />  ( only jpg file )</dd>
                </dl>
                <dl>
                    <dt><label for="File to upload">File to upload:</label></dt>
                    <dd>
                        <?=$n['dname']?>.<?=$n['ext']?><br />
                        <?php
                            if($n['ext'] == 'jpg' || $n['ext'] == 'gif' || $n['ext'] == 'jpeg' || $n['ext'] == 'png' )
                                    echo '<img src="'.$FOLDER.$n['dname'].'.'.$n['ext'].'" width="350" />';
                        ?>
                        <input type="file" name="file" />

                    </dd>
                </dl>

                <dl>
                    <dt><label for="New item tag">New Item Tag:</label></dt>
                    <dd>
                        <?php
                        if($n['newtag'] == 1)
                            echo '<input type="checkbox" checked="checked" name="newtag" value="1" />';
                        else
                            echo '<input type="checkbox" name="newtag" value="1" />';
                        ?>
                        <label class="check_label"></label>
                    </dd>
                </dl>
                <dl>
                    <dt><label for="sitename">Description:</label></dt>
                    <dd><textarea name="desc" rows="10" cols="50"><?=$n['desc']?></textarea></dd>
                </dl>

                <input type="hidden" name="id" value="<?=$id?>" />
                <input type="hidden" name="cid" value="<?=$cid?>" />
				<dl>
					<dt><label for="Meta Keywords">Meta Keywords:</label></dt>
					<dd>
						<input type="input" name="meta_keywords" value="<?=$n['meta_keywords']?>" />
					</dd>
				</dl>
				<dl>
					<dt><label for="Meta Description">Meta Description:</label></dt>
					<dd>
						<input type="input" name="meta_description" value="<?=$n['meta_description']?>" />
					</dd>
				</dl>                        
                <dl class="submit">
                    <dt></dt>
                    <dd>
                        <input type="submit" name="submit" id="submit" value="Update Now" />
                    </dd>
                </dl>
            </fieldset>
         </form>
         </div>
<?php include $adminfoldername.'/footer.php'; ?>