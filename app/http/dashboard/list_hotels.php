<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/auth.php");
	$_SESSION['page_url'] = DOMAIN . 'dashboard/list-hotels';

	$hotel = new Hotel();
	$myHotels = $hotel->where('member_id', '=', $_SESSION['user']['id'])->get();
?>
<!DOCTYPE>
<html>
	<?php require_once(DOC_ROOT . 'includes/head.php'); ?>
<body>
<div id="wrapper">
	<?php include(DOC_ROOT . 'includes/header.php'); ?>
	<div class="home_banner inner" style="background-image:url(<?php echo DOMAIN; ?>/images/banner_home.jpg);">
		<div class="container"></div>
	</div>
	<div class="container">
		<div class="container-fluid main-container">
            <?php require_once(DOC_ROOT . 'includes/dashboard_left.php'); ?>
			<div class="col-md-9 col-sm-12 col-xs-12 content no-padding-sm no-padding-xs">
				<h1 class="h1"><i class="fa fa-tachometer text-info"></i> List Hotels</h1>
                <hr>
                <p class="lead"></p>

				<div class="panel panel-default">
                    <div class="panel-heading"><strong>Your hotels</strong> <span class="label label-info"><?php echo count($myHotels); ?></span></div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="active">
                                    <th>#</th>
                                    <th>Hotel name</th>
                                    <th>Location</th>
                                    <th>Hits on roomista</th>
                                    <th>Roomista URL</th>
                                    <th>Website URL</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
									foreach($myHotels as $num => $myHotel){
										$subCity = new SubCity();
										$subCity = $subCity->find($myHotel->sub_city_id);
										if($subCity){ $sCName = $subCity->name; }else{ $sCName = ''; }
								?>
								<tr>
                                    <td data-th="Hotel name"><?php echo $num + 1; ?></td>
                                    <td data-th="Location"><?php echo $myHotel->name; ?></td>
                                    <td data-th="Hits on roomista"><?php echo $sCName; ?></td>
                                    <td data-th="Roomista URL"><?php echo $myHotel->hotel_hits; ?></td>
                                    <td data-th="Website URL"><a href="<?php echo HTTP_PATH . $myHotel->seo_url; ?>"><i class="fa fa-file-pdf-o text-danger"></i><?php echo $myHotel->seo_url; ?></a></td>
                                    <td data-th="Options"><a href="<?php echo 'http://' .$myHotel->web_url; ?>" target="_blank"><i class="fa fa-file-pdf-o text-danger"></i><?php echo $myHotel->web_url; ?></a></td>
									<td data-th="">
										<form action="<?php echo DOMAIN; ?>dashboard/list-hotels/edit" method="post">
											<input type="hidden" name="csrf" value="ee3af08b009b4b6eaab02829ce0d0497">
											<input type="hidden" name="prop" value="<?php echo $myHotel->id; ?>">
											<button type="submit" class="btn btn-success btn-xs"><i class="fa fa-check-circle-o"></i> Edit</button>
										</form>
										<!--<a class="btn btn-danger btn-xs" href="remove"><i class="fa fa-trash-o"></i> Remove</a>-->
									</td>
                                </tr>
								<?php } ?>
                            </tbody>
                        </table>
                        <!--<a href="" class="btn btn-link pull-right"><i class="fa fa-eye text-success"></i> View more hotels</a>-->
                    </div>
                </div>
			</div>
		</div>
	</div>
	<?php include(DOC_ROOT . 'includes/footer.php'); ?>
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

<script src="http://maps.googleapis.com/maps/api/js?sensor=true&amp;libraries=places"></script>
<script src="<?php echo DOMAIN; ?>js/jquery.geocomplete.js"></script>
<script src="<?php echo DOMAIN; ?>js/chosen.jquery.min.js"></script>
<script src="<?php echo DOMAIN; ?>js/navigation.js"></script>

</body>
</html>