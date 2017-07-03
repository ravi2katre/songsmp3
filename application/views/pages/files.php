<?php  $this->load->view('pages/_partials/cat_detail_box', $list); ?>
<br>
<div class="card">
    <div class="card-header title_bar">
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





