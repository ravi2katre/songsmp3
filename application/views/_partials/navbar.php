<nav class="navbar navbar-default navbar-fixed-top" role="navigation">

    <style>
        .sidebar-nav {
            padding: 9px 0;
        }

        .dropdown-menu .sub-menu {
            left: 100%;
            position: absolute;
            top: 0;
            visibility: hidden;
            margin-top: -1px;
        }

        .dropdown-menu li:hover .sub-menu {
            visibility: visible;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .nav-tabs .dropdown-menu, .nav-pills .dropdown-menu, .navbar .dropdown-menu {
            margin-top: 0;
        }

        .navbar .sub-menu:before {
            border-bottom: 7px solid transparent;
            border-left: none;
            border-right: 7px solid rgba(0, 0, 0, 0.2);
            border-top: 7px solid transparent;
            left: -7px;
            top: 10px;
        }
        .navbar .sub-menu:after {
            border-top: 6px solid transparent;
            border-left: none;
            border-right: 6px solid #fff;
            border-bottom: 6px solid transparent;
            left: 10px;
            top: 11px;
            left: -6px;
        }
    </style>

    <div class="container">

	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href=""><?php echo $site_name; ?></a>
	</div>

	<div class="navbar-collapse collapse">

		<ul class="nav navbar-nav">
			<?php foreach ($menu as $parent => $parent_params): ?>

				<?php if (empty($parent_params['children'])): ?>

					<?php $active = ($current_uri==$parent_params['url'] || $ctrler==$parent); ?>
					<li <?php if ($active) echo 'class="active"'; ?>>
						<a href='<?php echo $parent_params['url']; ?>'>
							<?php echo $parent_params['name']; ?>
						</a>
					</li>

				<?php else: ?>

					<?php $parent_active = ($ctrler==$parent); ?>
					<li class='dropdown <?php if ($parent_active) echo 'active'; ?>'>
						<a data-toggle='dropdown' class='dropdown-toggle' href='<?php echo $parent_params['url']; ?>'>
							<?php echo $parent_params['name']; ?> <span class='caret'></span>
						</a>
						<ul role='menu' class='dropdown-menu'>
							<?php foreach ($parent_params['children'] as $name => $url): ?>
								<li><a href='<?php echo $url; ?>'><?php echo $name; ?></a></li>
							<?php endforeach; ?>
						</ul>
					</li>

				<?php endif; ?>

			<?php endforeach; ?>
		</ul>

		<?php $this->load->view('_partials/language_switcher'); ?>
		
	</div>

</div>
</nav>
<script>
    window.addEventListener("DOMContentLoaded", function(){
        $(".dropdown-toggle").click(function(){
            var url = $(this).attr("href");
            $(location).attr('href', url);
        });
    });
</script>