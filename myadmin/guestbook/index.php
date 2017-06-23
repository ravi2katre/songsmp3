<?php include '../header.php'; ?>
<?php
$pagingqry = 'select * from `guest_book` order by id desc';
$rowsPerPage=10;
$gets='?';

$pagelink = ADMIN_BASE_PATH.'guestbook/index.php?page=';
$htmlpage = '';

include("../../includes/paging_admin.php");

$Book = $db->query($pagingqry.$limit);

$TOTAL_Book = $numrows;

?>
<h2></h2>
<h2>&nbsp;&nbsp; Guest Book</h2>
<div align="center">
    <table id="rounded-corner">
        <thead>
            <tr>
                <th scope="col" class="rounded-company"></th>
                <th scope="col" class="rounded">Name</th>
                <th scope="col" class="rounded">Message</th>
                <th scope="col" class="rounded">Mobile</th>
                <th scope="col" class="rounded">Email</th>
                <th scope="col" class="rounded-q4">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $start_sr_no = $offset + 1;
            foreach ($Book as $key => $val)
            {
            ?>
                <tr>
                    <td><?php echo $start_sr_no++; ?></td>
                    <td>
                        <?= $val['name'] ?>
                    </td>
                    <td>
                        <?= $val['message'] ?>
                    </td>
                    <td>
                        <?= $val['mobile'] ?>
                    </td>
                    <td>
                        <?= $val['email'] ?>
                    </td>
                    <td><a href="deleteguestbook.php?id=<?= $val['id'] ?>&page=<?=$_REQUEST['page']?>" class="ask"><img src="<?= ADMIN_BASE_PATH ?>images/trash.png" alt="" title="delete" border="0" /></a></td>
                </tr>
            <?php
                        }
            ?>
        </tbody>
    </table>
</div>
<?= $PAGE_CODE ?>
<?php include $adminfolder . 'footer.php'; ?>