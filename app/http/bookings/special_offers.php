<?php 
    define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");

	if(!isset($_GET['seo_url']) && (strlen($_GET['seo_url']) < 1)){ die(header('Location: ' . DOMAIN . '404')); }
    $_SESSION['page_url'] = ($_GET['page_url']) ? DOMAIN . $_GET['page_url'] : DOMAIN;
	$seo_url = $_GET['seo_url'];
    $hotel = new Hotel();
    $hotel = $hotel->where('seo_url', '=', $seo_url)->first();
?>
<!DOCTYPE html>
<html>
<?php require_once(DOC_ROOT . 'includes/head.php'); ?>
<body>
<div id="wrapper">
    <?php include(DOC_ROOT . 'includes/header_hotel.php'); ?>

    <div class="container">
        <div class="col-xs-12 no-padding specialOffers">
            <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-xs-12 col-sm-4">
                                <img src="<?php echo HTTP_PATH; ?>images/thumb-7.jpg" width="100%">
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <h4>Special offer heading</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<footer>
    <?php include(DOC_ROOT . "includes/footer_hotel.php"); ?>
</footer>
<script>
$(function() {
});
</script>

</body>
</html>