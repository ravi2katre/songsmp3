<?php include '../header.php'; ?>
<?php
if($_GET['pid'] != '')
    header('location: index.php?pid='.$_GET['pid']);
if ($_GET['id'] == '')
    exit;

$parentid = $_REQUEST['id'];

//dir_list.php
$default_dir = "../../folder/";

// lists files only for the directory which this script is run from
$listfile = array();
$i = 0;
if (!($dp = opendir($default_dir)))
    die("Cannot open $default_dir.");
while (false !== ($file = readdir($dp))) {
    if (!is_dir($file)) {
        if ($file != '.' && $file != '..') {
            $listfile[$i]['filename'] = $file;
            $i++;
        }
    }
}
closedir($dp);
$seq = "select path from category where id = " . $_REQUEST['id'];
$PATH = '&raquo;&nbsp;<a href="index.php">Home</a>&nbsp;' . $db->query($seq, database::GET_FIELD);
?>
<h2></h2>
<h2>&nbsp;&nbsp;Move Bulk File</h2>
<div style="height: 20px; color: #758719;">&nbsp;&nbsp;<?= $PATH ?></div>
<div align ="center">
    <table id="rounded-corner">
        <thead>
            <tr>
                <th scope="col" class="rounded-company"></th>
                <th scope="col" class="rounded">File Name</th>
                <th scope="col" class="rounded-q4">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $start_sr_no = 1;
            foreach ($listfile as $key => $val) {
            ?>
                <tr>
                    <td><?php echo $start_sr_no++ ?></td>
                    <td>
                    <?= $val['filename'] ?>
                </td>
                <td><a href="delete-folder-file.php?id=<?= $parentid ?>&name=<?= $val['filename'] ?>" class="ask"><img src="<?= ADMIN_BASE_PATH ?>images/trash.png" alt="" title="delete" border="0" /></a></td>
            </tr>
            <?php
                }
            ?>
                <tr>
                    <td colspan="3">
                        <form name="fr" method="post" action="folderfile_db.php" class="niceform">
                            <table cecellpadding="2" width="90%">
                                <tr>
                                    <td>
                                        <label for="Create thumb">Create thumb ? :</label><input type="checkbox" name='thumb' value='1' />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="Use existing thumb">Use existing thumb ? :</label><input type="checkbox" name='existingthumb' value='1' />  ex : thumb-[current filename].jpg
                                    </td>
                                </tr>
                            </table>
                            <input type="hidden" name="pid" value="<?= $parentid ?>" />
                            <input type="submit" name="Upload" value="Upload" />
                        </form>
                    </td>
                </tr>
            </tbody>

        </table>
    </div>
<?php include $adminfoldername.'/footer.php'; ?>