
<div class="card">
    <h3 class="card-header"><?php echo $mPageTitle; ?></h3>
    <div class="card-block">

        <div class="card-group">
            <?php
            //cidb($sidebar_menu);
            foreach ($list['rows'] as $key => $item) {
                if($key%3 ==0){
                    echo "</div><div class=\"card-group\">";
                }

                $this->load->view('pages/_partials/category_block', $item);
            }
            //cidb($item);
            ?>
        </div>
        <div>
            <?php echo $pagination; ?>
        </div>



    </div>
</div>

