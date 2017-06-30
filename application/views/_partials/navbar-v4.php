<nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="#"><?php echo $site_name; ?></a>
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">

            <?php foreach ($menu as $parent => $parent_params): ?>

                <?php if (empty($parent_params['children'])): ?>

                    <?php $active = ($current_uri==$parent_params['url'] || $ctrler==$parent); ?>
                    <li <?php if ($active) echo 'class="nav-item active"'; else { echo 'class="nav-item"';} ?>>
                        <a class="nav-link" href='<?php echo $parent_params['url']; ?>'>
                            <?php echo $parent_params['name']; ?>
                        </a>
                    </li>

                <?php else: ?>

                    <?php $parent_active = ($ctrler==$parent); ?>
                    <li class='nav-item dropdown <?php if ($parent_active) echo 'active'; ?>'>
                        <a data-toggle='dropdown' class='nav-link dropdown-toggle' href='<?php echo $parent_params['url']; ?>'>
                            <?php echo $parent_params['name']; ?> <span class='caret'></span>
                        </a>
                        <ul role='menu' class='dropdown-menu'>
                            <?php foreach ($parent_params['children'] as $name => $url): ?>
                                <li class="nav-item"><a class="nav-link" href='<?php echo $url; ?>'><?php echo $name; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>

                <?php endif; ?>

            <?php endforeach; ?>


        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>
