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
                $title =  $this->input->post('title');
                $artist =  $this->input->post('artist');
                $album =  $this->input->post('album');
                $year =  $this->input->post('year');
                $comment =  $this->input->post('comment');

                //cidb($mp3info['tags_html']);exit;
                foreach ($mp3info['tags']['id3v1'] as $key => $val) {
                    $value = implode(",", $val);
                    $$key= $value;
                }

                echo $form->bs3_text('title', 'title', $title);
                echo $form->bs3_text('artist', 'artist', $artist);
                echo $form->bs3_text('album', 'album', $album);
                echo $form->bs3_text('year', 'year', $year);
                echo $form->bs3_text('comment', 'comment',$comment);

                ?>

                <?php echo $form->bs3_submit(); ?>

                <?php echo $form->close(); ?>
            </div>
        </div>
    </div>

</div>