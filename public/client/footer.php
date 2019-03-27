<?php if ($account != 'Login') {
    ?>
    </div>
    </div>
    <footer class="footer">
        <div class="pull-left m-t-20">
            © 2018. All rights reserved To Conquer Hub.
        </div>
        <div class="pull-right">
            <img src="<?php echo $app->BASE_URL('public/assets/images/sidebar-logo.png'); ?>" width="60"
                 height="60">
        </div>
    </footer>
    </div>
    </div>
<?php } ?>
<script>
    var base_url = '<?php echo $app->BASE_URL('controllers/ajax.php');?>';
    var orign = '<?php echo $app->BASE_URL('');?>';
    var resizefunc = [];
</script>
<!-- jQuery  -->
<script src="<?php echo $app->BASE_URL('public/assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo $app->BASE_URL('public/assets/js/app.js'); ?>"></script>
<script src="<?php echo $app->BASE_URL('public/assets/js/jquery.core.js'); ?>"></script>
<script src="<?php echo $app->BASE_URL('public/assets/js/jquery.app.js'); ?>"></script>
<script>
    jQuery(document).ready(function () {
        <?php if ($account == 'chat') { ?>
        $(".conversation-list").animate({scrollTop: $('.conversation-list').prop("scrollHeight")}, 1000);
        setInterval(chat.get_new, 2000);
        <?php } if (isset($_SESSION['account'])) {  ?>
        setInterval(notifications.new_notifications, 5000);
        <?php } ?>
        $('.data-table').DataTable();
        $(window).load(function () {
            $('.sp-wrap').smoothproducts();
        });
        $('#owl-multi').owlCarousel({
            loop: false,
            margin: 20,
            nav: false,
            autoplay: true
        });
        $('.popup').magnificPopup({
            type: 'image',
            closeOnContentClick: true,
            mainClass: 'mfp-fade',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
            }
        });
    });
</script>
</body>
</html>