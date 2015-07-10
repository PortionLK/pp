<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");

	if(!isset($_POST['csrf']) || $_POST['csrf'] != '1064fd4b0dce47decf5c3e640037f3d0'){
		http_response_code(404);
		die(header('Location: ' . DOMAIN . '404'));
	}

	$searchBag['string'] = $_POST['string'];
	$searchBag['searchType'] = $_POST['selector'];
	$searchBag['check_in'] = date('Y-m-d', strtotime($_POST['date_arriving']));
	$searchBag['check_out'] = date('Y-m-d', strtotime($_POST['date_departure']));
	$searchBag['rooms'] = intval($_POST['search_num_of_room']);
	$searchBag['adults'] = intval($_POST['search_adults']);
	$searchBag['children'] = intval($_POST['search_children']);
	unset($_POST);

	$bookedDate = new BookedDate();
	$room = new Room();
	$rmvdRoomIds = [];
	$bookedRooms = [];
	$avlblHotels = [];

	//remove already booked hotels
	// -----(========)----- or [==================] or [========)---------- or ----------(========]
	$rmvdHotels = $bookedDate->where('checked_in', '<=', $searchBag['check_in'])
		->where('checked_out', '>=', $searchBag['check_out'], 'AND')
		->get();
	foreach($rmvdHotels as $rmvdHotel){
		$rmvdRoomIds[] = $rmvdHotel->room_id;
		$bookedRooms[] = $rmvdHotel->booked_rooms;
	}
	unset($rmvdHotels);
	// (==--====)----------
	$rmvdHotels = $bookedDate->where('checked_in', '>', $searchBag['check_in'])
		->where('checked_in', '<', $searchBag['check_out'], 'AND')
		->get();
	foreach($rmvdHotels as $rmvdHotel){
		$rmvdRoomIds[] = $rmvdHotel->room_id;
		$bookedRooms[] = $rmvdHotel->booked_rooms;
	}
	unset($rmvdHotels);
	// ----------(==--====)
	$rmvdHotels = $bookedDate->where('checked_out', '>', $searchBag['check_in'])
		->where('checked_out', '<', $searchBag['check_out'], 'AND')
		->get();
	foreach($rmvdHotels as $rmvdHotel){
		$rmvdRoomIds[] = $rmvdHotel->room_id;
		$bookedRooms[] = $rmvdHotel->booked_rooms;
	}
	unset($rmvdHotels);
	// (===----------=====) or (===----------=====] or [===----------=====)
	$rmvdHotels = $bookedDate->where('checked_in', '>=', $searchBag['check_in'])
		->where('checked_out', '<=', $searchBag['check_out'], 'AND')
		->get();
	foreach($rmvdHotels as $rmvdHotel){
		$rmvdRoomIds[] = $rmvdHotel->room_id;
		$bookedRooms[] = $rmvdHotel->booked_rooms;
	}
	unset($rmvdHotels);

	if($searchBag['searchType'] == 'c'){
		$sCHotels = new SubCity();
		$sCHotels = $sCHotels->where('name', 'like', '%' . $searchBag['string'] . '%')->get(['id']);
		$subCityIds = [];
		foreach($sCHotels as $sCHotel){
			$subCityIds[] = $sCHotel->id;
		}
		foreach($rmvdRoomIds as $k => $rmvdRoomId){
			$x = $room->where('rooms.id', '=', $rmvdRoomId)
				->where('rooms.assigned_rooms', '>=', $bookedRooms[$k] + $searchBag['rooms'], 'AND')
				->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
				->whereIn('hotels.sub_city_id', $subCityIds)
				->select(
					'rooms.id as room_id',
					'rooms.room_type_id as room_type_id',
					'rooms.room_feature_ids as room_feature_ids',
					'rooms.no_of_rooms as room_no_of_rooms',
					'rooms.assigned_rooms as room_assigned_rooms',
					'rooms.max_persons as room_max_persons',
					'rooms.max_extra_beds as room_max_extra_beds',
					'hotels.*'
				)
				->groupBy('hotels.id')
				->first();
			$avlblHotels[] = $x ? $x : '';
			unset($x);
		}
		$list1 = $room->whereNotIn('rooms.id', $rmvdRoomIds)
			->where('rooms.assigned_rooms', '>=', $searchBag['rooms'], 'AND')
			->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
			->whereIn('hotels.sub_city_id', $subCityIds)
			->select(
				'rooms.id as room_id',
				'rooms.room_type_id as room_type_id',
				'rooms.room_feature_ids as room_feature_ids',
				'rooms.no_of_rooms as room_no_of_rooms',
				'rooms.assigned_rooms as room_assigned_rooms',
				'rooms.max_persons as room_max_persons',
				'rooms.max_extra_beds as room_max_extra_beds',
				'hotels.*'
			)
			->groupBy('hotels.id')
			->get();
		foreach($list1 as $lItem){
			$avlblHotels[] = $lItem ? $lItem : '';
		}
		unset($list1);
	}
	if($searchBag['searchType'] == 'h'){
		$sCHotels = new Hotel();
		$sCHotels = $sCHotels->where('name', 'like', '%' . $searchBag['string'] . '%')->get(['id']);
		$hotelIds = [];
		foreach($sCHotels as $sCHotel){
			$hotelIds[] = $sCHotel->id;
		}
		foreach($rmvdRoomIds as $k => $rmvdRoomId){
			$x = $room->where('rooms.id', '=', $rmvdRoomId)
				->where('rooms.assigned_rooms', '>=', $bookedRooms[$k] + $searchBag['rooms'], 'AND')
				->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
				->whereIn('hotels.id', $hotelIds)
				->select(
					'rooms.id as room_id',
					'rooms.room_type_id as room_type_id',
					'rooms.room_feature_ids as room_feature_ids',
					'rooms.no_of_rooms as room_no_of_rooms',
					'rooms.assigned_rooms as room_assigned_rooms',
					'rooms.max_persons as room_max_persons',
					'rooms.max_extra_beds as room_max_extra_beds',
					'hotels.*'
				)
				->groupBy('hotels.id')
				->first();
			$avlblHotels[] = $x ? $x : '';
			unset($x);
		}
		$list2 = $room->whereNotIn('rooms.id', $rmvdRoomIds)
			->where('rooms.assigned_rooms', '>=', $searchBag['rooms'], 'AND')
			->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
			->whereIn('hotels.id', $hotelIds)
			->select(
				'rooms.id as room_id',
				'rooms.room_type_id as room_type_id',
				'rooms.room_feature_ids as room_feature_ids',
				'rooms.no_of_rooms as room_no_of_rooms',
				'rooms.assigned_rooms as room_assigned_rooms',
				'rooms.max_persons as room_max_persons',
				'rooms.max_extra_beds as room_max_extra_beds',
				'hotels.*'
			)
			->groupBy('hotels.id')
			->get();
		foreach($list2 as $lItem){
			$avlblHotels[] = $lItem ? $lItem : '';
		}
		unset($list2);
	}
	if($searchBag['searchType'] == 'd'){
		$sCHotels = new Destination();
		$sCHotels = $sCHotels->where('name', 'like', '%' . $searchBag['string'] . '%')->get(['id']);
		$destinationIds = [];
		foreach($sCHotels as $sCHotel){
			$destinationIds[] = $sCHotel->id;
		}
		foreach($rmvdRoomIds as $k => $rmvdRoomId){
			$x = $room->where('rooms.id', '=', $rmvdRoomId)
				->where('rooms.assigned_rooms', '>=', $bookedRooms[$k] + $searchBag['rooms'], 'AND')
				->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
				->join('destinations', 'hotels.destination_id', '=', 'destinations.id')
				->whereIn('destinations.id', $destinationIds)
				->select(
					'rooms.id as room_id',
					'rooms.room_type_id as room_type_id',
					'rooms.room_feature_ids as room_feature_ids',
					'rooms.no_of_rooms as room_no_of_rooms',
					'rooms.assigned_rooms as room_assigned_rooms',
					'rooms.max_persons as room_max_persons',
					'rooms.max_extra_beds as room_max_extra_beds',
					'hotels.*'
				)
				->groupBy('hotels.id')
				->first();
			$avlblHotels[] = $x ? $x : '';
			unset($x);
		}
		$list3 = $room->whereNotIn('rooms.id', $rmvdRoomIds)
			->where('rooms.assigned_rooms', '>=', $searchBag['rooms'], 'AND')
			->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
			->join('destinations', 'hotels.destination_id', '=', 'destinations.id')
			->whereIn('destinations.id', $destinationIds)
			->select(
				'rooms.id as room_id',
				'rooms.room_type_id as room_type_id',
				'rooms.room_feature_ids as room_feature_ids',
				'rooms.no_of_rooms as room_no_of_rooms',
				'rooms.assigned_rooms as room_assigned_rooms',
				'rooms.max_persons as room_max_persons',
				'rooms.max_extra_beds as room_max_extra_beds',
				'hotels.*'
			)
			->groupBy('hotels.id')
			->get();
		foreach($list3 as $lItem){
			$avlblHotels[] = $lItem ? $lItem : '';
		}
		unset($list3);
	}
	$list0 = array_filter($avlblHotels);
	$list = array_unique($list0);//print_r($list);die();
?>
<!DOCTYPE>
<html>
	<?php require_once(DOC_ROOT . 'includes/head.php'); ?>
<body>
<div id="wrapper">
	<input type="hidden" id="myLatitude"/>
	<input type="hidden" id="myLongitude"/>
	<input type="hidden" id="myAccuracy"/>

    <?php include(DOC_ROOT . 'includes/header.php'); ?>
	<div class="clearfix"></div>
	<div class="home_banner inner" style="background-image:url(<?php echo DOMAIN; ?>images/banner_home.jpg);">
		<div class="container"><?php include(DOC_ROOT . 'includes/booking-form-inner.php'); ?></div>
	</div>
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
	<!--end header-inner-->
	<div class="container">
		<div class="col-xs-12 no-padding">
			<div class="row">

				<div class="col-xs-12 col-md-3 col-sm-4">
					<h5>&nbsp;</h5>
					<div class="panel panel-default">
						<div class="panel-heading"><h5 class="w_700">Things to do in Diyatalawa</h5></div>
						<div class="panel-body">
							
						</div>
					</div>
				</div>

				<?php if(count($list)){ ?>
				<div class="hotelCategoryList col-xs-12 col-md-9 col-sm-8">
					<h3>Your search matches with <span class="w_700 blue-text">[<?php echo count($list); ?>]</span> result<?php echo (count($list) > 1) ? 's.' : ''; ?></h3>
					<div class="hotel_list_cate">
						<?php foreach($list as $hotel){
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
								$filename = DOC_ROOT . 'uploads/hotels/thumbnails/' . $hotel_image;
								if(file_exists($filename) && $hotel_image != ""){
								?>
								<img src="<?php echo DOMAIN; ?>timthumb.php?src=<?php echo DOMAIN; ?>uploads/hotels/thumbnails/<?php echo $hotel_image; ?>&w=200&h=200" class="img-responsive">
								<?php }else{ ?>
								<img src="<?php echo DOMAIN; ?>timthumb.php?src=<?php echo DOMAIN; ?>images/no_image.jpg&w=200&h=200" alt="image" class="img-responsive">
								<?php } ?>
							</div>
							<div class="col-xs-12 col-sm-9 col-md-9 no-padding">
								<div class="col-xs-12 col-sm-3 col-md-3 pull-right no-padding">
									<a href="" class="btn btn-primary pull-right">Book now</a>
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
									document.getElementById("span_<?php echo md5($hotel->id); ?>").innerHTML = 'You are ' + dis_<?php echo md5($hotel->id); ?> ' away from us.';
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
						<?php } ?>
					</div>
				</div>
				<?php }else{ ?>
				<div class="hotelCategoryList col-xs-12 col-md-9 col-sm-8">
					<h3>No result matches with your search. Please change parameters and try again. Or you can browse by a category or a location.</h3>
				</div>
				<?php } ?>
				<div class="xs-hidden col-md-3 col-sm-4"></div>
			</div>
		</div>
    </div>
</div>
<!--end content-->
<?php include(DOC_ROOT . 'includes/footer.php'); ?>
</body>
</html>