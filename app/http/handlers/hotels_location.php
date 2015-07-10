<?php
    define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");

	if(!isset($_GET['mainCity']) && (strlen($_GET['mainCity']) < 1)){ die(header('Location: ' . DOMAIN . '404')); }
	$_SESSION['page_url'] = ($_GET['page_url']) ? DOMAIN . $_GET['page_url'] : DOMAIN;
	$_SESSION['eagerLoad'] = 30;

    $mainCity = new MainCity();
    $subCity = new SubCity();
    $hotel = new Hotel();
    $hotelImage = new HotelImage();

	$mPlace = urldecode($_GET['mainCity']);
	$mPlace = str_replace('-', ' ', $mPlace);
	$title = ucwords($mPlace);
	$bCrumb = ucwords($mPlace);

	$subCityList = $mainCity->where('main_cities.name', '=', $mPlace)
			->join('hotels', 'main_cities.id', '=', 'hotels.main_city_id')
			->join('sub_cities', 'hotels.sub_city_id', '=', 'sub_cities.id')
			->orderBy('sub_cities.name', 'ASC')
			->groupBy('sub_cities.name')
			->select('sub_cities.name', 'sub_cities.seo', 'sub_cities.id')
			->get();
    if(!isset($_GET['subCity']) || (strlen($_GET['subCity']) < 1)){
		//by main city
		$hotelsList = $mainCity->where('main_cities.name', '=', $mPlace)
			->join('hotels', 'main_cities.id', '=', 'hotels.main_city_id')
			->orderBy('hotels.id', 'DESC')
			->skip(0)
			->take(30)
			->get();
	}else if(isset($_GET['subCity']) && (strlen($_GET['subCity']) > 0)){
		//by main city then sub city
		$city = urldecode($_GET['subCity']);
        $city = str_replace('-', ' ', $city);
		$title .= ' | ' . ucwords($city);
		$bCrumb .= ' > ' . ucwords($city);

		$thisSubCity = $subCity->where('name', '=', $city)->first();
		$thisSubCityId = isset($thisSubCity->id) ? $thisSubCity->id : -1;
		$hotelsList = $mainCity->where('main_cities.name', '=', $mPlace)
			->join('hotels', 'main_cities.id', '=', 'hotels.main_city_id')
			->where('hotels.sub_city_id', '=', $thisSubCityId)
			->orderBy('hotels.id', 'DESC')
			->skip(0)
			->take(30)
			->get();
    }else{
        $hotelsList = [];
    }
?>
<!DOCTYPE>
<html>
	<?php require_once(DOC_ROOT . 'includes/head.php'); ?>
<body>
<div id="wrapper">
    <?php include(DOC_ROOT . 'includes/header.php'); ?>
	<div class="clearfix"></div>
	<div class="home_banner inner" style="background-image:url(<?php echo DOMAIN; ?>images/banner_home.jpg);">
		<div class="container"><?php include(DOC_ROOT . 'includes/booking-form-inner.php'); ?></div>
	</div>
	<!--end header-inner-->
	<div class="container">
		<?php include(DOC_ROOT . 'includes/hotel-categories-inner.php'); ?>
		<div class="col-xs-12">
			<ol class="breadcrumb">
				<li><a href="<?php echo DOMAIN; ?>">Home</a></li>
				<li class="active"><?php echo $bCrumb; ?> Hotels</li>
			</ol>
			<?php if(count($subCityList)){ ?>
			<div class="col-xs-12 col-md-3 col-sm-4 no-padding hidden-xs">
                <div class="list-group">
					<?php foreach($subCityList as $subCityItem){
					$hotelCount = $mainCity->where('main_cities.name', '=', $mPlace)
						->join('hotels', 'main_cities.id', '=', 'hotels.main_city_id')
						->where('hotels.sub_city_id', '=', $subCityItem->id)
						->count();
					?>
					<a class="list-group-item" href="<?php echo DOMAIN; ?>sri-lanka/hotels-in-<?php echo strtolower($mPlace); ?>/hotels-<?php echo implode('-', explode(' ', strtolower($subCityItem->seo))); ?>">
					<span class="badge"><?php echo ($hotelCount > 1) ? $hotelCount . ' hotels': $hotelCount . ' hotel'; ?></span>
					<?php echo ucwords(strtolower($subCityItem->name)); ?></a>
					<?php } ?>
                </div>
            </div>
			<?php } ?>

			<div class="hotelCategoryList col-xs-12 col-md-9 col-sm-8">
	            <h3>You have <span class="w_700 blue-text">[<?php echo count($hotelsList); ?>]</span> hotel<?php echo (count($hotelsList) > 1) ? 's': ''; ?> in <?php echo isset($city) ? ucwords($city) : ucwords($mPlace); ?> to pick for your stay.</h3>
				<input type="hidden" id="myLatitude"/>
				<input type="hidden" id="myLongitude"/>
				<input type="hidden" id="myAccuracy"/>
				<script type="text/javascript">
					var options = {
					  enableHighAccuracy: true,
					  timeout: 5000,
					  maximumAge: 0
					};
					function success(pos) {
					  var crd = pos.coords;
					  var latitude = document.getElementById('myLatitude');
					  var longitude = document.getElementById('myLongitude');
					  var accuracy = document.getElementById('myAccuracy');
					  latitude.value = crd.latitude;
					  longitude.value = crd.longitude;
					  accuracy.value = crd.accuracy;
					}
					function error(err) {
					  console.warn('ERROR(' + err.code + '): ' + err.message);
					}
					if (navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(success, error, options);
					} else { 
						alert("Geolocation is not supported by this browser.");
					}
					var latitude = document.getElementById('myLatitude');
					var longitude = document.getElementById('myLongitude');
					var accuracy = document.getElementById('myAccuracy');
					var origin = new google.maps.LatLng(latitude.value, longitude.value);
				</script>
				<div class="row hotel_list_cate">
					<?php foreach($hotelsList as $k => $hotel){
						$location = new MainCity();
						$location = $location->find($hotel->main_city_id);
						if($location){ $location = strtolower($location->name); }
						$discount = new RoomRate();
						$discount = $discount->where('hotel_id', '=', $hotel->id)
							->where('currency_id', '=', 2, 'AND')
							->orderBy('foreign_discount_rate', 'DESC')
							->first(['foreign_discount_rate', 'sell_rate']);
						if(isset($discount->sell_rate) && isset($discount->foreign_discount_rate)){
							$calcDiscount = $discount->sell_rate * (1 - ($discount->foreign_discount_rate / 100));
						}
						?>
					<div class="hotel_cat_item col-xs-12">
						<div class="col-xs-12 col-md-3 col-sm-3">
							<?php
							$hotel_image = explode(',', $hotel->cover_photo)[0];
							$filename = DOC_ROOT . 'uploads/hotel-cover-photos/' . $hotel_image;
							if(file_exists($filename) && $hotel_image != ""){
							?>
							<img src="<?php echo DOMAIN; ?>timthumb.php?src=<?php echo DOMAIN; ?>uploads/hotel-cover-photos/<?php echo $hotel_image; ?>&w=200&h=200" class="img-responsive">
							<?php }else{ ?>
							<img src="<?php echo DOMAIN; ?>timthumb.php?src=<?php echo DOMAIN; ?>images/no_image.jpg&w=200&h=200" alt="image" class="img-responsive">
							<?php } ?>
						</div>
						<div class="col-xs-12 col-sm-9 col-md-9 no-padding">
							<div class="col-xs-12 col-sm-3 col-md-3 pull-right no-padding">
								<a href="<?php echo DOMAIN . $hotel->seo_url; ?>" class="btn btn-primary pull-right">Book now</a>
							</div>
							<h4 class="w_700">
								<a href="<?php echo DOMAIN . $hotel->seo_url; ?>"><?php echo ucwords($hotel->name); ?></a>
								<span class="text-orange">
									<?php
									$theirRate = $hotel->star_rating;
									for(;$theirRate > 0; $theirRate--){
									?>
									<i class="fa fa-star"></i>
									<?php
									} ?>
								</span>
							</h4>
							<h5 class="place"><a href=""> <?php echo $location; ?></a> <span class="text-danger">&rArr;</span> <span class="w_700">Hotel - with Free Wi-Fi <i class="text-success fa fa-wifi"></i></span></h5>
							<p><?php echo (strlen($hotel->description) > 390) ? substr($hotel->description, 0, 390) . '...': $hotel->description; ?></p>
							<span id="span_<?php echo md5($hotel->id); ?>"></span>
							<script type="text/javascript">
								var a_<?php echo md5($hotel->id); ?> = new google.maps.LatLng(<?php echo $hotel->latitude; ?>, <?php echo $hotel->longitude; ?>);
								var dis_<?php echo md5($hotel->id); ?> = google.maps.geometry.spherical.computeDistanceBetween(origin, a_<?php echo md5($hotel->id); ?>);
								dis_<?php echo md5($hotel->id); ?> /= 1000;
								dis_<?php echo md5($hotel->id); ?> = parseFloat(dis_<?php echo md5($hotel->id); ?>).toFixed(3);
								dis_<?php echo md5($hotel->id); ?> += ' km';
								document.getElementById("span_<?php echo md5($hotel->id); ?>").innerHTML = 'You are ' + dis_<?php echo md5($hotel->id); ?> + ' away from us.';
							</script>
							<div class="col-xs-12 no-padding">
								<a href="" class="w_700">Room types</a>
								<span class="pull-right label label-default rateName">Rates per night from</span>
								<div class="roomRateDisplay">
									<p class="text-success"><span class="small"><?php echo isset($discount->foreign_discount_rate) ? 'Discount : ' . $discount->foreign_discount_rate . '%': ''; ?></span> <span class="h5 pull-right text-primary bold"><?php echo isset($calcDiscount) ? 'USD ' . $calcDiscount: ''; unset($calcDiscount); ?></span> </p>
								</div>
							</div>
						</div>
					</div>
					<?php if($k == 25){ ?><div id="eagerDetect" class="col-xs-12"></div><?php } ?>
					<?php } ?>
					<button id="eagerLoad" type="button" class="col-xs-12">Load More</button>
				</div>
			</div>
        </div>
    </div>
</div>
<!--end content-->
<?php include(DOC_ROOT . 'includes/footer.php'); ?>
</div>
<script type="text/javascript">
	$(function(){
		$('#eagerLoad').on('click', function(){
			var loadMore = $.ajax({
				url: "<?php echo HTTP; ?>handlers/eager_load.php",
				method: "POST",
				data: {
					type: "loc",
					pageType: "",
					mCity: "<?php echo isset($_GET['mainCity']) ? $_GET['mainCity'] : ''; ?>",
					sCity: "<?php echo isset($_GET['subCity']) ? $_GET['subCity'] : ''; ?>",
					isMain: "<?php echo isset($_GET['isMain']) ? $_GET['isMain'] : ''; ?>"
				},
				dataType: "html"
			});
			loadMore.done(function(response){
				if(response == false){ $('#eagerLoad').fadeOut(300); }
				else{ $('#eagerLoad').before(response); }
			});
			loadMore.fail(function(jqXHR, textStatus){
				console.log('Failed getting more hotels');
			});
		});
	});
</script>
</body>
</html>