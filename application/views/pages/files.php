<div class="card">
    <h3 class="card-header"><i class="fa fa-folder-open" ></i>  <?php echo $mPageTitle; ?></h3>
    <div class="card-block">

    </div>
</div>
<br>
<div class="card">
    <div class="card-header">
        Songs
    </div>
    <div class="card-block">
        <ul class="list-unstyled">
            <?php
            //cidb($sidebar_menu);
            foreach ($list['rows'] as $key => $item) {
                if($key%4 ==0){
                    //echo "</div><div class=\"card-columns\">";
                }

                $this->load->view('pages/_partials/file_list', $item);
            }
            //cidb($item);
            ?>
        </ul>
    </div>
</div>





