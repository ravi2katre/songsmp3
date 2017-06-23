<?php include 'header.php'; ?>
<?php

    $folder_scan = '../scan_dir';
    $folder_scan_file = get_files($folder_scan,true);
?>

<div class="valid_box">
    <h2>Moved File Summery</h2>
    <ol>
        <li>Total file inserted in site : <strong><?php echo $_GET['tfi']; ?></strong> </li>
        <li>Total Exist Thumb which directly set to file : <strong><?php echo $_GET['tetm']; ?></strong> </li>
        <li>Total Make thumb for image file  : <strong><?php echo $_GET['tmt']; ?></strong> </li>
        <li>Total Created Directory : <strong><?php echo $_GET['tmd']; ?></strong> </li>
    </ol>
    <strong>Now You can remove Your scan_dir folder.</strong>
    

</div>

<h2></h2>
<h2>&nbsp;&nbsp;Syncronize Data From Folder</h2>
<div style="padding: 15px">
    Please Sure to you have not a Duplicate File name in same folder.<br />
    Other Wise it will may have problem In viewing site.<br /><br />

    You have <h2> <?php echo count($folder_scan_file); ?> </h2>  File in your scan_dir folder.<br /><br />
    <ol>
        <li>It will automatically create Images Thumb</li>
        <li>It will not upload file which start from 'thumb-' </li>
        <li>Which file have same name file start with 'thumb-' (image file) it will automatic set it to proper file thumb.<br />
            <strong>Ex.</strong><br />
            if folder have this file<br />
            <strong>abc.sis</strong><br />
            And also have this file<br />
            <strong>thumb-abc.jpg or gif or png</strong><br />
            So thumb-abc.jpg set thumb for abc.sis
        </li>
        <br />
        <br />
        <div class="sidebarmenu">
            <a class="menuitem_red" href="syncronize_db.php">Move File To Site</a>
        </div>
    </ol>
</div>


<?php include $adminfolder.'footer.php'; ?>