
<?php $this->load->view('_partials/navbar-v4'); ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <?php $this->load->view('pages/_partials/category_list'); ?>
            </div>

            <div class="col-sm-12 col-md-9">
                <?php $this->load->view($inner_view); ?>
            </div>
        </div>
    </div>

<?php $this->load->view('_partials/footer'); ?>