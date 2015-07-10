<?php
	define('_MEXEC', 'OK');
	require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");

	if(!isset($_GET['seo_url']) && (strlen($_GET['seo_url']) < 1)){ die(header('Location: ' . DOMAIN . '404')); }
	$_SESSION['page_url'] = ($_GET['page_url']) ? DOMAIN . $_GET['page_url'] : DOMAIN;	

	$seo_url = $_GET['seo_url'];
	$hotel = new Hotel();
	$hotel = $hotel->where('seo_url', '=', $seo_url)->first();
	if(!$hotel){ die(header('Location: ' . DOMAIN . '404')); }
//$headDescription = $hotel->meta_description;
//$headKeywords = $hotel->meta_keyword;
	$mainCity = new MainCity();
	$mainCity = $mainCity->find($hotel->main_city_id);
	$subCity = new SubCity();
	$subCity = $subCity->find($hotel->sub_city_id);

	$bCrumb = (trim(strtolower($subCity->name)) == trim(strtolower($mainCity->name))) ? 'Hotels in ' . ucwords($mainCity->name) . ' ' . ucwords($hotel->name) : ucwords($mainCity->name) . ' ' . ucwords($subCity->name) . ' ' . ucwords($hotel->name);
	$hFeature = new HotelFeature();
	$hFeatures = $hFeature->where('hotel_id', '=', $hotel->id)->get();
	$hFeatureList = [];
	foreach($hFeatures as $hFeature){
		$fTypeName = new HotelFeatureType();
		$fTypeName = $fTypeName->find($hFeature->feature_type_id);
		$fIds = $hFeature->feature_ids;
		$fIds = explode(',', $fIds);
		$fItems = new HotelFeatureList();
		$fItems = $fItems->whereIn('id', $fIds)->get();
		foreach($fItems as $fItem){
			$hFeatureList[$fTypeName->type][] = $fItem->feature;
		}
	}

	$hAttribute = new HotelAttribute();
	$hAttribute = $hAttribute->where('hotel_id', '=', $hotel->id)->first();
	$usefulInfo = [];
	$usefulInfo['Airport transfer availability by hotel'] = (isset($hAttribute->is_airport_transfer) && (strlen($hAttribute->is_airport_transfer) > 0)) ? 'Yes' : 'No';
	$usefulInfo['Average airport transfer fee'] = (isset($hAttribute->airport_transfer_fee) && (strlen($hAttribute->airport_transfer_fee) > 0)) ? $hAttribute->airport_transfer_fee . ' USD' : '';
	$usefulInfo['Distance to airport'] = (isset($hAttribute->distance_to_airport) && (strlen($hAttribute->distance_to_airport) > 0)) ? $hAttribute->distance_to_airport . ' km' : '';
	$usefulInfo['Check-In from'] = (isset($hAttribute->check_in) && (strlen($hAttribute->check_in) > 0)) ? $hAttribute->check_in : '';
	$usefulInfo['Check-Out until'] = (isset($hAttribute->check_out) && (strlen($hAttribute->check_out) > 0)) ? $hAttribute->check_out : '';

	$roomImage = new RoomImage();
	$hotelImages = $roomImage->where('hotel_id', '=', $hotel->id)->get();

	$roomRate = new RoomRate();
	$roomRates = $roomRate->where('hotel_id', '=', $hotel->id)->get();

	$searchBag['check_in'] = isset($_POST['date_arriving']) ? date('Y-m-d', strtotime($_POST['date_arriving'])) : date('Y-m-d');
	$searchBag['check_out'] = isset($_POST['date_departure']) ? date('Y-m-d', strtotime($_POST['date_departure'])) : date('Y-m-d', time() + 86400);
	$searchBag['rooms'] = isset($_POST['search_num_of_room']) ? intval($_POST['search_num_of_room']) : 1;

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

	foreach($rmvdRoomIds as $k => $rmvdRoomId){
		$x = $room->where('rooms.id', '=', $rmvdRoomId)
			->where('rooms.assigned_rooms', '>=', $bookedRooms[$k] + $searchBag['rooms'], 'AND')
			->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
			->whereIn('hotels.id', [$hotel->id])
			->select(
				'rooms.id as room_id',
				'rooms.room_type_id as room_type_id',
				'rooms.room_feature_ids as room_feature_ids',
				'rooms.no_of_rooms as room_no_of_rooms',
				'rooms.assigned_rooms as room_assigned_rooms',
				'rooms.max_persons as room_max_persons',
				'rooms.max_extra_beds as room_max_extra_beds'
			)
			->first();
		$avlblHotels[] = $x ? $x : '';
		unset($x);
	}
	$list2 = $room->whereNotIn('rooms.id', $rmvdRoomIds)
		->where('rooms.assigned_rooms', '>=', $searchBag['rooms'], 'AND')
		->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
		->whereIn('hotels.id', [$hotel->id])
		->select(
			'rooms.id as room_id',
			'rooms.room_type_id as room_type_id',
			'rooms.room_feature_ids as room_feature_ids',
			'rooms.no_of_rooms as room_no_of_rooms',
			'rooms.assigned_rooms as room_assigned_rooms',
			'rooms.max_persons as room_max_persons',
			'rooms.max_extra_beds as room_max_extra_beds'
		)
		->get();
	foreach($list2 as $lItem){
		$avlblHotels[] = $lItem ? $lItem : '';
	}
	unset($list2);

	$list0 = array_filter($avlblHotels);
	$roomTypeList = array_unique($list0);
?>
<!DOCTYPE>
<html>
	<?php require_once(DOC_ROOT . 'includes/head.php'); ?>
<body>
<div id="wrapper">
    <?php include(DOC_ROOT . 'includes/header.php'); ?>
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?php echo DOMAIN; ?>">Home</a></li>
            <li><a href="<?php echo DOMAIN; ?>sri-lanka/hotels-in-<?php echo str_replace(' ', '-', strtolower($mainCity->name)); ?>"><?php echo ucwords($mainCity->name); ?></a></li>
            <li><a href="<?php echo DOMAIN; ?>sri-lanka/hotels-in-<?php echo str_replace(' ', '-', strtolower($mainCity->name)); ?>/hotels-<?php echo $subCity->seo; ?>"><?php echo ucwords($subCity->name); ?></a></li>
            <li class="active"><?php echo ucwords($hotel->name); ?></li>
        </ol>
        <div class="col-xs-12 hotelPage no-padding">
			<div class="col-xs-12 col-md-3 col-sm-4">
				<div class="panel panel-default">
					<div class="panel-heading"><h5 class="w_700">When would you like to stay at <?php echo ucwords($hotel->name); ?>?</h5></div>
					<div class="panel-body">
						<form action="" method="post">
							<div class="form-group col-xs-12">
								<div class="no-padding col-xs-12"><label for="checkIn">Check in</label></div>
								<input type="text" name="date_arriving" value="<?php echo (isset($searchBag['check_in'])) ? $searchBag['check_in'] : ''; ?>" id="checkIn" class="form-control calendar" placeholder="yyyy-mm-dd">
							</div>
							<div class="form-group col-xs-12">
								<div class="no-padding col-xs-12"><label for="checkOut">Check out</label></div>
								<input type="text" name="date_departure" value="<?php echo (isset($searchBag['check_out'])) ? $searchBag['check_out'] : ''; ?>" id="checkOut" class="form-control calendar" placeholder="yyyy-mm-dd">
							</div>
							<div class="form-group col-xs-12">
								<button class="btn btn-primary">Availability</button>
							</div>
						</form>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading"><h5 class="w_700">Things to do in Diyatalawa</h5></div>
					<div class="panel-body">
						
					</div>
				</div>
			</div>

			<div class="col-xs-12 col-md-9 col-sm-8">
				<div class="page-header">
					<h3 class="w_700 hotePageName"><?php echo ucwords($hotel->name); ?> <i class="fa fa-star text-orange"></i><i class="fa fa-star text-orange"></i><i class="fa fa-star text-orange"></i><i class="fa fa-star text-orange"></i><i class="fa fa-star text-orange"></i></h3>
					<address>
						<p class="address">
						<?php echo ucwords($hotel->street_address); ?>,
						<?php echo ucwords($subCity->name);
							echo (trim(strtolower($subCity->name)) != trim(strtolower($mainCity->name))) ? ', ' . ucwords($mainCity->name) : ''; ?>
							<a href="" class="w_700 text-italic">(Show on map)</a>
						</p>
					</address>
				</div>
				<div></div>
				<div class="content">
					<div id="galleria">
						<?php foreach($hotelImages as $hotelImg){ ?>
						<a href="<?php echo DOMAIN; ?>uploads/room-photos/<?php echo $hotelImg->image; ?>">
							<img src="<?php echo DOMAIN; ?>timthumb.php?src=<?php echo DOMAIN; ?>uploads/room-photos/<?php echo $hotelImg->image; ?>&amp;w=60&amp;h=50" class="img-responsive">
						</a>
						<?php } ?>
					</div>
				</div>

				<?php if(isset($searchBag['check_in']) && isset($searchBag['check_out'])){ ?>
				<div class="changeDate col-xs-12 no-padding">
						<div class="col-xs-12 col-sm-6">
						<?php
							echo date('M d, Y', strtotime($searchBag['check_in']));
							echo ' - ' . date('M d, Y', strtotime($searchBag['check_out']));
							echo ' | ' . date_diff(date_create($searchBag['check_out']), date_create($searchBag['check_in']))->format("%a nights");
						?>
						</div>
						<div class="col-xs-12 col-sm-6">
							<span id="toggleDateChange" class="btn btn-link w_700 pull-right"><i class="fa fa-exchange"></i> Change dates</span>
						</div>
					<div class="dateChanger col-xs-12" id="dateChanger">
						<form action="" method="post">
							<div class="form-group col-xs-12 col-sm-3">
								<label>Check in date</label>
								<input type="text" name="date_arriving" value="<?php echo $searchBag['check_in']; ?>" class="form-control calendar" placeholder="yyyy-mm-dd">
							</div>
							<div class="form-group col-xs-12 col-sm-3">
								<label>Check out date</label>
								<input type="text" name="date_departure" value="<?php echo $searchBag['check_out']; ?>" class="form-control calendar" placeholder="yyyy-mm-dd">
							</div>
							<div class="form-group col-xs-12 col-sm-6">
								<label class="center-block">&nbsp;</label>
								<button class="btn btn-primary pull-right" type="submit">Change dates</button>
							</div>
						</form>
					</div>
				</div>
				<?php } ?>
				<div class="col-xs-12 no-padding bookingTable">
					<table class="table table-bordered">
						<thead>
							<tr class="active">
								<th>Room type</th>
								<th>Max</th>
								<th>Rate<br>per room per night</th>
								<th>No rooms</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($roomTypeList as $roomType){ ?>
							<?php
							$roomRate = new RoomRate();
							$roomRate = $roomRate->where('hotel_id', '=', $hotel->id)
								->where('room_type_id', '=', $roomType->room_type_id, 'AND')
								->where('currency_id', '=', 2, 'AND')
								->where('start', '<=', $searchBag['check_in'], 'AND')
								->where('end', '>=', $searchBag['check_out'], 'AND')
								->join('service_types', 'room_rates.service_type_id', '=', 'service_types.id')
								->join('room_types', 'room_rates.room_type_id', '=', 'room_types.id')
								->select('room_rates.sell_rate', 'service_types.service', 'room_types.name')
								->orderBy('service_types.id', 'ASC')
								->get();

							$roomImages = $roomImage->where('room_id', '=', $roomType->room_id)->first();
							foreach($roomRate as $roomItem){
							?>
							<tr>
								<td>
									<div class="roomTypeInTable">
										<h4 class="w_700"><a href="" data-toggle="modal" data-target="#Superior"><?php echo $roomItem->name; ?> - <?php echo $roomItem->service; ?></a></h4>
										<a class="pull-left" href="" data-toggle="modal" data-target="#Superior">
											<img src="<?php echo HTTP_PATH; ?>timthumb.php?src=<?php echo HTTP_PATH; ?>uploads/room-photos/<?php echo $roomImages->image; ?>&amp;w=80&amp;h=60" class="img-responsive">
										</a>

										<div class="pull-left">
											<small class="small text-info"><i class="fa fa-asterisk"></i> Limited Time Offer. Rate includes 15% discount!</small>
											<?php $maxExtraBeds = isset($roomType->room_max_extra_beds) ? $roomType->room_max_extra_beds : 0;
											if($maxExtraBeds){ ?>
											<div class="form-group">
												<label>Extra beds:</label>
												<select name="" class="form-control">
													<?php for(;$maxExtraBeds > 0;$maxExtraBeds--){ ?>
													<option value="<?php echo $maxExtraBeds; ?>"><?php echo $maxExtraBeds; ?></option>
													<?php } ?>
												</select>
											</div>
											<?php }
											unset($maxExtraBeds); ?>
										</div>
										<div class="clearfix"></div>
										<div>
											<small><a href="" data-toggle="modal" data-target="#Superior">Room info</a></small>
										</div>

										<div class="modal fade" id="Superior" tabindex="-1" role="dialog" aria-labelledby="superiorRoom">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														<h4 class="modal-title" id="superiorRoom">Superior room</h4>
													</div>
													<div class="modal-body">
														...
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														<button type="button" class="btn btn-primary">Save changes</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</td>
								<td>
									<div class="text-center v-align-middle">
										<?php
										$maxPersons = $roomType->room_max_persons;
										for($maxPersons; $maxPersons > 0; $maxPersons--){
										?>
										<i class="fa fa-male"></i>
										<?php } ?>
									</div>
								</td>
								<td>
									<p class="text-center">
										<!--<del class="lead">USD 150</del><br>-->
										<span class="text-info w_700">USD <?php echo $roomItem->sell_rate; ?></span>
									</p>
								</td>
								<td>
									<div class="form-group">
										<label for="noOfRooms">No of rooms</label>
										<select class="form-control" name="noOfRooms" id="noOfRooms">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
										</select>
									</div>
								</td>
								<td>
									<button type="submit" class="btn btn-primary">Book now</button>
								</td>
							</tr>
							<?php } }
							if(count($roomTypeList) < 1){ ?>
								<tr><td colspan="5">There is no matching rooms available for the dates selected. Please refine your date and check again.</td></tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<!--  -->
				<div class="col-xs-12 no-padding">
					<h3 class="w_700">Features of <?php echo ucwords($hotel->name); ?></h3>
					<?php foreach($hFeatureList as $k1 => $hFeatureItem){ ?>
					<div class="row">
						<div class="co-xs-12 col-md-3 col-sm-3 w_700"><?php echo $k1; ?></div>
						<div class="co-xs-12 col-md-9 col-sm-9">
							<ul>
								<?php foreach($hFeatureItem as $hFItm){ ?>
								<li class="col-xs-12 col-md-4 col-sm-4"><i class="fa fa-check-circle text-info"></i> <?php echo $hFItm; ?></li>
								<?php } ?>
							</ul>
						</div>
					</div>
					<hr>
					<?php } ?>
				</div>

				<div class="row">
					<div class="col-xs-12">
						<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingOne">
									<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="fa fa-minus-circle"></i> Resort Description</a>
									</h4>
								</div>
								<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
									<div class="panel-body">
										<p><?php echo $hotel->description; ?></p>
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingTwo">
									<h4 class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"><i class="fa fa-minus-circle"></i> Resort Policies</a>
									</h4>
								</div>
								<div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
									<div class="panel-body">
										<div class="col-xs-12 policies">
											<div class="row">
												<div class="itemHead col-xs-12 col-md-4 col-sm-5">
													<h6><i class="fa fa-credit-card"></i> Payment policy</h6>
												</div>
												<div class="itemDesc col-xs-12 col-md-8 col-sm-7">
													<p>Reservation payments are quoted generally per room per night. Any payment mode will be accepted.</p>
												</div>
											</div>

											<div class="row">
												<div class="itemHead col-xs-12 col-md-4 col-sm-5">
													<h6><i class="fa fa-times"></i> Cancelation policy</h6>
												</div>
												<div class="itemDesc col-xs-12 col-md-8 col-sm-7">
													<p>If a cancellation is required we should be informed before 72 hours.</p>
												</div>
											</div>

											<div class="row">
												<div class="itemHead col-xs-12 col-md-4 col-sm-5">
													<h6><i class="fa fa-child"></i> Child policy</h6>
												</div>
												<div class="itemDesc col-xs-12 col-md-8 col-sm-7">
													<p>0-3year old's are considered as infants where as guests lesser than 10 years old are considered as children.</p>
												</div>
											</div>

											<div class="row">
												<div class="itemHead col-xs-12 col-md-4 col-sm-5">
													<h6><i class="fa fa-check-square-o"></i> Check in check out policy</h6>
												</div>
												<div class="itemDesc col-xs-12 col-md-8 col-sm-7">
													<p>Early check-ins / late checkouts will be billed according to an hourly rate determined by the hotel.</p>
												</div>
											</div>

											<ul class="no-padding">
												<li>Guests over 12 years old are considered as adults.</li>
												<li>Extra beds are dependent on the room you choose, please check the individual room policy for more details.</li>
											</ul>
										</div>
										</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingThree">
									<h4 class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree"><i class="fa fa-minus-circle"></i> Useful Info</a>
									</h4>
								</div>
								<div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
									<div class="panel-body">
										<table class="table">
											<?php foreach($usefulInfo as $kInfo => $usefulInfoItem){ ?>
											<?php if($usefulInfoItem){ ?>
											<tr>
												<td class="col-xs-6 w_700"><?php echo $kInfo; ?></td>
												<td class="col-xs-6"><?php echo $usefulInfoItem; ?></td>
											</tr>
											<?php } ?>
											<?php } ?>
											<tr>
												<td class="w_700">Breakfast Charge (when not included in room rate)</td>
												<td>90 USD</td>
											</tr>
											<tr>
												<td class="w_700">Room Voltage</td>
												<td>230</td>
											</tr>
											<tr>
												<td class="w_700">Number of Restaurants</td>
												<td>1</td>
											</tr>
											<tr>
												<td class="w_700">Year Hotel Built</td>
												<td>2012</td>
											</tr>
											<tr>
												<td class="w_700">Year Hotel Last Renovated</td>
												<td>2014</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--  -->

			</div>
		</div>
    </div>
    <?php include(DOC_ROOT . 'includes/footer.php'); ?>
</div>
<script src="<?php echo HTTP_PATH; ?>js/galleria-1.4.2.min.js"></script>
<script type="text/javascript">
    var http_path = '<?php echo HTTP_PATH; ?>';
    Galleria.loadTheme(http_path+'js/galleria.classic.min.js');
    Galleria.run('#galleria');
    $(function(){
        $('#checkIn').datepicker({
			minDate:'+1D',
			onClose: function( selectedDate ) {
				$( "#checkOut" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$('#checkOut').datepicker({
			minDate:'+1D',
			onClose: function( selectedDate ) {
				$( "#checkIn" ).datepicker( "option", "maxDate", selectedDate );
			}
		});;


		$('#toggleDateChange').click(function(){
            $('#dateChanger').slideToggle();
        });
        $('.panel-title a').click(function(){
            var ariaControls = $(this).attr('aria-controls');
            if ($('#'+ariaControls).hasClass('in')) {
                $('.fa', this).removeClass('fa-minus-circle').addClass('fa-plus-circle');
            }else{
                $('.fa', this).removeClass('fa-plus-circle').addClass('fa-minus-circle');
            }
        });
    });
</script>
</body>
</html>