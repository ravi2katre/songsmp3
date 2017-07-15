<?php
$name = (isset($cat_name))?$cat_name:$mPageTitle;
?>
<div class="card">
    <h3 class="card-header title_bar"><i class="fa fa-music"></i> <?php echo $name; ?></h3>
    <div class="card-block">
        <div class="movie_cover_box">
            <div class="movie_cover">
                <?php
                if(empty($thumb)){
                    // echo '<img  class="card-img-top img-fluid" src="https://scontent.fnag1-1.fna.fbcdn.net/v/t1.0-9/12821427_1140809332604262_1569773744317899529_n.jpg?oh=4b61a93d146354771040b15c962db90e&oe=59C8F62F" alt="'.$mPageTitle.'">';

                }else{
                    echo '<img class="card-img-top img-fluid" src="uploads/cat_images/'.$thumb.'" alt="'.$mPageTitle.'">';
                }
                ?>            </div>
            <div class="movie_details">
                <ul>
                    <?php
                    if(isset($tags['rows']) && count($tags['rows']) > 0){
                        foreach($tags['rows'] as $key=>$val){
                            cidb($val);
                        }
                    }

                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>



