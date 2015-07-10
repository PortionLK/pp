<?php
	$category = new Category();
	$accTypes = $category->all();
	$mainCity = new MainCity();
	$mCities = $mainCity->all();
	$subCity = new SubCity();
	$sCities = $subCity->all();
	$hotelFeatureType = new HotelFeatureType();
	$hFTypes = $hotelFeatureType->all();
	$roomType = new RoomType();
	$rTypes = $roomType->all();
	$roomFeature = new RoomFeature();
	$rFeatures = $roomFeature->all();

	if(!isset($_SESSION['step_01_completed']) || $_SESSION['step_01_completed'] != true){
		die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-01'));
	}

	if(isset($_SESSION['editing_hotel']) && (strlen($_SESSION['editing_hotel']) > 0)){
		$hotel = new Hotel();
		$hotel = $hotel->find($_SESSION['editing_hotel']);
		if(!$hotel){ die(header('Location: ' . DOMAIN . '404')); }
		$hotelFeatures = new HotelFeature();
		$hotelFeatures = $hotelFeatures->where('hotel_id', '=', $_SESSION['editing_hotel'])->get();
		$fToCheck = [];
		foreach($hotelFeatures as $hotelFeature){
			$idsArr = explode(',', $hotelFeature->feature_ids);
			$fToCheck[$hotelFeature->feature_type_id] = array_combine($idsArr, $idsArr);
		}
	}

	if(isset($_SESSION['hotel_step_error']) && (strlen($_SESSION['hotel_step_error']) > 0)){
?>
<div><?php echo $_SESSION['hotel_step_error']; $_SESSION['hotel_step_error'] = ''; ?></div>
<?php } ?>
<form action="<?php echo HTTP; ?>dashboard/get_step_02.php" method="post">
	<input type="hidden" value="83620581b63ecf30c23cd5f97cc84939" name="csrf"/>
	<fieldset>
		<legend>Hotel Registration/Property-details</legend>
		<h3 class="h3">Hotel facilities</h3>

		<div class="row">
			<div class="col-xs-12">
				<h4>Hotel Facilities<span class="text-danger">*</span></h4>
				<?php foreach($hFTypes as $kk => $hFType){
					$hotelFeatureList = new HotelFeatureList();
					$hFLists = $hotelFeatureList->where('hotel_feature_type_id', '=', $hFType->id)->get();
					$checkboxes = '';
					foreach($hFLists as $hFList){
						$checked = (isset($fToCheck[$hFType->id][$hFList->id]) && (strlen($fToCheck[$hFType->id][$hFList->id]) > 0)) ? 'checked="true"' : '';
						$checkboxes .= '<div class="checkbox col-md-4 col-sm-4 col-xs-12"><label><input type="checkbox" name="hotel_feature[' . $hFType->id . '][]" value="' . $hFList->id . '" ' . $checked . '/>' . $hFList->feature . '</label></div>';
					}
				?>
				<div class="col-xs-12">
					<h3><?php echo $hFType->type; ?></h3>
					<?php echo $checkboxes; ?>
				</div>
				<?php } ?>
			</div>
		</div>
		<hr/>

		<div class="row">
			<div class="form-group col-xs-12">
				<button type="submit" name="submit" value="submit" class="pull-right btn-lg btn btn-primary">Save & Continue <i class="fa fa-arrow-circle-right"></i></button>
			</div>
		</div>
	</fieldset>
</form>
