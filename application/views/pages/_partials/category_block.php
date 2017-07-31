

<div class="card text-center">
    <div class="text-center">
        <a href="category/<?php echo $id; ?>/<?php echo create_slug($name); ?>" >

    <?php
    if(empty($thumb)){
        echo '<img  class="card-img-top " src="https://scontent.fnag1-1.fna.fbcdn.net/v/t1.0-9/12821427_1140809332604262_1569773744317899529_n.jpg?oh=4b61a93d146354771040b15c962db90e&oe=59C8F62F" alt="' . $name . '">';

    }else{
        echo '<img class="card-img-top  " src="uploads/cat_images/' . $thumb . '" alt="' . $name . '">';
    }
    ?>
    </div>
    <div class="card-block">
        <h4 class="card-title text-center"><?php echo $name;?></h4>
        <p class="card-text"><small class="text-muted "><?php echo $des;?></small></p>
    </div>
    </a>
</div>