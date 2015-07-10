<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/system/config/app.php");

	if(!isset($_GET['start']) && !isset($_GET['end']) && !is_numeric($_GET['start']) && !is_numeric($_GET['end'])){
		$start = 0;
		$end = 8;
	}else{
		$start = $_GET['start'];
		$end = $_GET['end'];
	}

	$mainCity = new MainCity();
	$topCities = $mainCity->where('top_cities', '=', 1)->skip($start)->take($end)->get();
?>
<div class="hotel-thumb-set col-xs-12 no-padding">
	<?php
		foreach($topCities as $topCity){
			$hotel = new Hotel();
			$countHotels = $hotel->where('main_city_id', '=', $topCity->id)->count();
	?>
	<div class="hotel-thumb col-sm-3">
		<a href="<?php echo HTTP_PATH; ?>sri-lanka/hotels-<?php echo implode('-', explode(' ', strtolower($topCity['name']))); ?>">
		<?php
		$filename = DOC_ROOT . 'uploads/main-city/' . $topCity['image'];
		if(file_exists($filename) && $topCity['image'] != "") {
		?>
		<img src="<?php echo HTTP_PATH; ?>timthumb.php?src=<?php echo HTTP_PATH; ?>uploads/main-city/<?php echo $topCity['image']; ?>&w=239&h=100">
		<?php }else{ ?>
		<img src="<?php echo HTTP_PATH; ?>timthumb.php?src=<?php echo HTTP_PATH; ?>images/no_image.jpg&w=239&h=100">
		<?php } ?>
		</a>
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<a href="<?php echo HTTP_PATH; ?>sri-lanka/hotels-<?php echo strtolower($topCity['name']); ?>"><?php echo $topCity['name']; ?></a>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<span class="text-right"><?php echo $countHotels; ?> hotel<?php if($countHotels > 1){ echo 's'; } ?></span>
			</div>
		</div>
	</div>
	<?php } ?>
</div>