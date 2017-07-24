<?php include '../header.php'; ?>
<?php 
?>
<h2></h2>
<h2>&nbsp;&nbsp;&nbsp;Multiple File Upload</h2>
<div align="center">

<object width="600" height="500">
	<param name="movie" value="uploader/FileUploadApp.swf">
	<param name="FlashVars" value="uploaderURL=http://pagalfun.com/loveji/category/uploader/upload.php">
	<embed src="uploader/FileUploadApp.swf" FlashVars="uploaderURL=http://pagalfun.com/loveji/category/uploader/upload.php" width="550" height="400">
	</embed>
</object>
<br />

    <a href="folderfile.php?id=<?= $_REQUEST['id'] ?>" class="bt_green"><span class="bt_green_lft"></span><strong>[ Click Here ] to Move File to Site</strong><span class="bt_green_r"></span></a>
</div>
<?php include $adminfoldername.'/footer.php'; ?>