
<div class="footer bg-inverse" style="padding-top: 20px;">
	<div class="container text-center">
		<span class="text-muted">&copy; <strong><?php echo date('Y'); ?></strong> All rights reserved.</span>
	</div>
</div>
<script>
    var onResize = function() {
// apply dynamic padding at the top of the body according to the fixed navbar height
        $("body").css("padding-top", $(".fixed-top").height()+40);
        set_footer();
    };

    // attach the function to the window resize event
    $(window).resize(onResize);

    // call it also when the page is ready after load or reload
    $(function() {
        onResize();
    });

</script>

<script>

    function set_footer() {

        var docHeight = $(window).height();
        var footerHeight = $('.footer').height();
        var footerTop = $('.footer').position().top + footerHeight;

        if (footerTop < docHeight) {
            $('.footer').css('margin-top', -20+ (docHeight - footerTop) + 'px');
        }
    }
</script>
