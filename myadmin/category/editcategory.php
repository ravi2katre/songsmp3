<?php include '../header.php'; ?>
<script src="<?=BASE_PATH?>js/validation.js"></script>
<script language="javascript" >
	var compulsory = new Array('name');
	var dispError = new Array('category name !');
</script>

<?php
    if($_GET['pid'] != '')
        $parentid = $_GET['pid'];
    else
        exit;
    $id = $_GET['id'];
    $q = "select * from category where id = ".$_GET['id'];
    $CATEGORY = $db->query($q,  database::GET_ROW);
?>

<h2></h2>
<a href="index.php?pid=<?= $pid ?>" class="bt_blue"><span class="bt_blue_lft"></span><strong>&laquo; Go Back To File list</strong><span class="bt_blue_r"></span></a>
<h2>&nbsp;&nbsp; Edit Category</h2>
<div align="left">
    <form action="edit_cat_db.php" method="post" onsubmit="return chkfrm(compulsory,dispError,this)" enctype="multipart/form-data" class="niceform">
        <fieldset>
            <dl>
                <dt><label for="Category name">Category name:</label></dt>
                <dd><input type="text" value="<?=$CATEGORY['name']?>" name="name" id="" size="30" /><span class="error">Use only alphabatical charater</span></dd>
            </dl>
            <dl>
                <dt><label for="Category Thumb">Category Thumb:</label></dt>
                <dd>
                    <input type="file" name="thumb"  />
                </dd>
            </dl>
            <dl>
                <dt><label for="Old Thumb">Old Thumb:</label></dt>
                <dd>
                    <img src="../../folderthumb/<?=$CATEGORY['thumb']?>">
                </dd>
            </dl>
            <dl>
                <dt><label for="Clear Thumb">Clear Thumb:</label></dt>
                <dd>
                    <input type="checkbox" name="clearthumb" />
                </dd>
            </dl>
            <dl>
                <dt><label for="New item tag">New item tag:</label></dt>
                <dd>
                    <?php
                        if($CATEGORY['newitemtag'] == 1)
                            echo '<input type="checkbox" name="newitemtag" checked="checked" value="1" />';
                        else
                            echo '<input type="checkbox" name="newitemtag" value="1" />';
                    ?>
                </dd>
            </dl>
            <dl>
                <dt><label for="Update item tag">Update item tag:</label></dt>
                <dd>
                    <?php
                        if($CATEGORY['updateitemtag'] == 1)
                            echo '<input type="checkbox" name="updateitemtag" checked="checked" value="1" />';
                        else
                            echo '<input type="checkbox" name="updateitemtag" value="1" />';
                    ?>
                </dd>
            </dl>
            <dl>
                <dt><label for="Description">Description:</label></dt>
                <dd><textarea name="des" rows="10" cols="50"><?= $CATEGORY['des'] ?></textarea></dd>
            </dl>
            <dl class="submit">
                <dt></dt>
                <dd>
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="pid" value="<?=$parentid?>" />
                    <input type="submit" name="submit" id="submit" value="Update Category" />
                <dd>
            </dl>
        </fieldset>
    </form>
</div>
<?php include $adminfoldername.'/footer.php'; ?>