<?php include '../header.php'; ?>
<?php 
require_once 'uploader/class.FlashUploader.php';
IAF_display_js();
$uploader = new FlashUploader('uploader', 'uploader/uploader',ADMIN_BASE_PATH.'category/uploader/upload.php');

//CUSTOMIZATION CODE GOES HERE!
?>
<h2></h2>
<h2>&nbsp;&nbsp;&nbsp;Multiple File Upload</h2>
<div align="center">
    <?php
    $uploader->display();
    ?>

    <a href="folderfile.php?id=<?= $_REQUEST['id'] ?>" class="bt_green"><span class="bt_green_lft"></span><strong>[ Click Here ] to Move File to Site</strong><span class="bt_green_r"></span></a>
</div>
<?php include $adminfoldername.'/footer.php'; ?>