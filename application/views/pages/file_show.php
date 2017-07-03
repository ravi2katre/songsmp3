<?php
//print_r($list);
 $this->load->view('pages/_partials/cat_detail_box', $list); ?><br>

<?php echo form_open('download',array('id' => 'myForm')); ?>
<input type="hidden" name="download_key" value="<?php echo serialize_data($list['id']); ?>" >
<div class="card">
    <h3 class="card-header title_bar"><i class="fa fa-music"></i> <?php echo $mPageTitle.'.'.$list['ext']; ?></h3>
    <div class="card-block">
        <a href="javascript:void(0)"  class="buttonDownload">Download</a>
    </div>
</div>


<?php echo form_close(); ?>
<script>
    $('a.buttonDownload').click( function() {
        $('form#myForm').submit();
    });
</script>
