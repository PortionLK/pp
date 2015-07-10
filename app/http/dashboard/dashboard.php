<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/auth.php");
	$_SESSION['page_url'] = DOMAIN . 'dashboard';
?>

<!DOCTYPE>
<html>
	<?php include(DOC_ROOT.'includes/head.php'); ?>
<body>
<div id="wrapper">
    <?php include(DOC_ROOT . 'includes/header.php'); ?>
	<div class="clearfix"></div>
	<div class="home_banner inner" style="background-image:url(<?php echo DOMAIN; ?>/images/banner_home.jpg);">
		<div class="container">
			<?php include(DOC_ROOT . 'includes/booking-form-inner.php'); ?>
		</div>
	</div>
    <div class="container">
        <div class="container-fluid main-container">
            <?php require_once(DOC_ROOT . 'includes/dashboard_left.php'); ?>
			<div class="col-md-9 col-sm-12 col-xs-12 dashboard no-padding-sm no-padding-xs">
                <h1 class="h1"><i class="fa fa-tachometer text-info"></i> Dashboard</h1>
                <hr>
                <p class="lead"></p>

                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Recently booked hotels</strong></div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="active">
                                    <th>#</th>
                                    <th>Hotel name</th>
                                    <th>Location</th>
                                    <th>Booked date</th>
                                    <th>Price</th>
                                    <th>Invoice</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--<tr>
                                    <td data-th="#">01</td>
                                    <td data-th="Hotel name">Canfrod villa</td>
                                    <td data-th="Location">Badulla</td>
                                    <td data-th="Booked date">2015-05-25</td>
                                    <td data-th="Price">USD 270</td>
                                    <td data-th="Invoice"><a href=""><i class="fa fa-file-pdf-o text-danger"></i> PDF</a></td>
                                </tr>-->
                            </tbody>
                        </table>
                        <!--<a href="" class="btn btn-link pull-right"><i class="fa fa-eye text-success"></i> View more bookings</a>-->
                    </div>
                </div>

            </div>
        </div>
	</div>
    <?php include(DOC_ROOT.'includes/footer.php'); ?>
</div>

<script>
$(function(){
    $('.side-menu-container>.navbar-nav>li>a').click(function(){
        var collapsId = $(this).attr('href');
        $('.collapse').not(collapsId).removeClass('in');
        $('.collapse').not(collapsId).attr('aria-expanded', 'false');
        $('.collapse').not(collapsId).animate('height', 0);
        $('.side-menu-container>.navbar-nav>li>a').not(this).addClass('collapsed');
        $('.side-menu-container>.navbar-nav>li>a').not(this).attr('aria-expanded', 'false');
    })
});
</script>
</body>
</html>