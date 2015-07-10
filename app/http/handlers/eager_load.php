<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");
	
	if($_POST['type'] == 'cat'){
		$type = urldecode($_POST['pageType']);
		$urlType = strtolower($type);
		$type = str_replace('-', ' ', $type);
		$category = new Category();
		$varBag = [
			'mCity' => $_POST['mCity'],
			'sCity' => $_POST['sCity'],
			'isMain' => $_POST['isMain'],
			'type' => $type
		];
		if((strlen($varBag['mCity']) < 1) && (strlen($varBag['sCity']) < 1)){
			$hotelsList = $category->where('categories.seo_name', '=', $type)
				->join('category_hotel', 'categories.id', '=', 'category_hotel.category_id')
				->join('hotels', 'category_hotel.hotel_id', '=', 'hotels.id')
				->orderBy('hotels.id', 'DESC')
				->skip($_SESSION['eagerLoad'])
				->take(10)
				->get();
		}else if(strlen($varBag['sCity']) < 1){
			$mPlace = urldecode($varBag['mCity']);
			$mPlace = str_replace('-', ' ', $mPlace);

			$thisMainCity = $mainCity->where('name', '=', $mPlace)->first();
			$thisMainCityId = isset($thisMainCity->id) ? $thisMainCity->id : -1;
			$hotelsList = $category->where('categories.seo_name', '=', $type)
				->join('category_hotel', 'categories.id', '=', 'category_hotel.category_id')
				->join('hotels', 'category_hotel.hotel_id', '=', 'hotels.id')
				->where('hotels.main_city_id', '=', $thisMainCityId)
				->orderBy('hotels.id', 'DESC')
				->skip($_SESSION['eagerLoad'])
				->take(10)
				->get();
		}else if($varBag['isMain'] == 'noMain'){
			//by category and sub city
			$sPlace = urldecode(urldecode($varBag['sCity']));
			$sPlace = str_replace('-', ' ', $sPlace);

			$thisSubCity = $subCity->where('name', '=', $sPlace)->first();
			$thisSubCityId = isset($thisSubCity->id) ? $thisSubCity->id : -1;
			$hotelsList = $category->where('categories.seo_name', '=', $type)
				->join('category_hotel', 'categories.id', '=', 'category_hotel.category_id')
				->join('hotels', 'category_hotel.hotel_id', '=', 'hotels.id')
				->where('hotels.sub_city_id', '=', $thisSubCityId)
				->orderBy('hotels.id', 'DESC')
				->skip($_SESSION['eagerLoad'])
				->take(10)
				->get();
		}else{
			//by category, main city and sub city
			$mPlace = urldecode($varBag['mCity']);
			$mPlace = str_replace('-', ' ', $mPlace);
			$sPlace = urldecode(urldecode($varBag['sCity']));
			$sPlace = str_replace('-', ' ', $sPlace);

			$thisMainCity = $mainCity->where('name', '=', $mPlace)->first();
			$thisSubCity = $subCity->where('name', '=', $sPlace)->first();
			$thisMainCityId = isset($thisMainCity->id) ? $thisMainCity->id : -1;
			$thisSubCityId = isset($thisSubCity->id) ? $thisSubCity->id : -1;
			$hotelsList = $category->where('categories.seo_name', '=', $type)
				->join('category_hotel', 'categories.id', '=', 'category_hotel.category_id')
				->join('hotels', 'category_hotel.hotel_id', '=', 'hotels.id')
				->where('hotels.main_city_id', '=', $thisMainCityId)
				->where('hotels.sub_city_id', '=', $thisSubCityId)
				->orderBy('hotels.id', 'DESC')
				->skip($_SESSION['eagerLoad'])
				->take(10)
				->get();
		}
	}else if($_POST['type'] == 'loc'){
		$mainCity = new MainCity();
		$subCity = new SubCity();
		$mPlace = urldecode($_POST['mCity']);
		$mPlace = str_replace('-', ' ', $mPlace);
		if(strlen($_POST['sCity']) < 1){
			//by main city
			$hotelsList = $mainCity->where('main_cities.name', '=', $mPlace)
				->join('hotels', 'main_cities.id', '=', 'hotels.main_city_id')
				->orderBy('hotels.id', 'DESC')
				->skip($_SESSION['eagerLoad'])
				->take(10)
				->get();
		}else if(strlen($_GET['sCity']) > 0){
			//by main city then sub city
			$city = urldecode($_POST['sCity']);
			$city = str_replace('-', ' ', $city);

			$thisSubCity = $subCity->where('name', '=', $city)->first();
			$thisSubCityId = isset($thisSubCity->id) ? $thisSubCity->id : -1;
			$hotelsList = $mainCity->where('main_cities.name', '=', $mPlace)
				->join('hotels', 'main_cities.id', '=', 'hotels.main_city_id')
				->where('hotels.sub_city_id', '=', $thisSubCityId)
				->orderBy('hotels.id', 'DESC')
				->skip($_SESSION['eagerLoad'])
				->take(10)
				->get();
		}
	}else if($_POST['type'] == 'sch'){
		
	}

?>

<?php foreach($hotelsList as $hotel){
	$location = new SubCity();
	$location = $location->find($hotel->sub_city_id);
	if($location){ $location = strtolower($location->name); $urlLocation = str_replace(' ', '-', $location); }
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
		<h5 class="place"><a href="<?php echo DOMAIN; ?>sri-lanka/<?php echo $urlType; ?>-hotels/0/hotels-<?php echo $urlLocation; ?>"> <?php echo $location; ?></a> <span class="text-danger">&rArr;</span> <span class="w_700">Hotel - with Free Wi-Fi <i class="text-success fa fa-wifi"></i></span></h5>
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
<?php } ?>
<?php if(count($hotelsList) == 0){ echo false; } ?>
<?php $_SESSION['eagerLoad'] = $_SESSION['eagerLoad'] + 10; ?>