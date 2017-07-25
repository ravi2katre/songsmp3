<?php echo $form->messages(); ?>

<div class="row">

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?php //echo $title; ?></h3>
            </div>
            <div class="box-body">
                <?php echo $form->open(); ?>

                <?php
                //cidb($mp3info['tags_html']);exit;
                foreach ($mp3info['tags']['id3v1'] as $key => $val) {
                    //cidb($val);
                    $value = implode(",", $val);
                    echo $form->bs3_text($key, $key, $value);
                }
                ?>
                <?php /* echo $form->bs3_text('First Name', 'first_name'); ?>
                <?php echo $form->bs3_text('Last Name', 'last_name'); ?>
                <?php echo $form->bs3_text('Username', 'username'); ?>
                <?php echo $form->bs3_text('Email', 'email'); ?>
                <?php echo $form->bs3_password('Password', 'password'); ?>
                <?php echo $form->bs3_password('Retype Password', 'retype_password'); */ ?>
                <?php echo $form->bs3_submit(); ?>

                <?php echo $form->close(); ?>
            </div>
        </div>
    </div>

</div>