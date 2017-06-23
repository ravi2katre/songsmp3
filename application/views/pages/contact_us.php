<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div id="contactus">

            <form role="form" method="post" action="">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Your Name" name="name" >
                    <?php echo form_error('name', '<div class="alert alert-danger contact-warning">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Your Email" name="email">
                    <?php echo form_error('email', '<div class="alert alert-danger contact-warning">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Your Website Address" name="website">
                    <?php echo form_error('website', '<div class="alert alert-danger contact-warning">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Your Subject" name="subject">
                    <?php echo form_error('subject', '<div class="alert alert-danger contact-warning">', '</div>'); ?>
                </div>
                <div class="form-group">
                    <textarea class="form-control" rows="10" placeholder="Please Enter Your Message" name="message"></textarea>
                    <?php echo form_error('message', '<div class="alert alert-danger contact-warning">', '</div>'); ?>
                </div>
                <hr>
                <div class="form-group">
                    <button type="reset" class="btn btn-danger">Clear Form</button>
                    <button type="submit" class="btn btn-success">Send Message</button>
                </div>
            </form>
        </div>
    </div>
</div>