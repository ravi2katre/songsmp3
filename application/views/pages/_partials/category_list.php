

<?php //cidb($sidebar_menu);?>
<div class="card" >
    <h3 class="card-header title_bar">Main Categories</h3>
    <div class="card-block">
        <ul class="list-group list-group-flush">
            <?php
            foreach ($sidebar_menu['rows'] as $key => $item) {
                ?>
                <li class="list-group-item">

                    <a href="category/<?php echo $item['id']; ?>/<?php echo create_slug($item['name']); ?>" ><i class="fa fa-folder" ></i> <?php echo $item['name']; ?></a></li>
              <?php
            }

            ?>


        </ul>
    </div>
</div>
<br>