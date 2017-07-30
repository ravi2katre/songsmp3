<li class="media">
    <a class="d-flex mr-3" href="files/<?php echo $id ?>/<?php echo create_slug($name) ?>" alt="Generic placeholder image"> <i class="fa fa-music"></i></a>

    <div class="media-body">
        <a href="files/<?php echo $id ?>/<?php echo create_slug($name) ?>"
           class="nav-link"><?php echo rawurldecode($name) . '.' . $ext; ?></a>
    </div>
</li>