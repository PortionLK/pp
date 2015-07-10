<?php
	if(!isset($_SESSION['step_01_completed']) || $_SESSION['step_01_completed'] != true){
		die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-01'));
	}else if(!isset($_SESSION['step_02_completed']) || $_SESSION['step_02_completed'] != true){
		die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-02'));
	}else if(!isset($_SESSION['step_03_completed']) || $_SESSION['step_03_completed'] != true){
		die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-03'));
	}

	if(isset($_SESSION['editing_hotel']) && is_numeric($_SESSION['editing_hotel'])){
		$hotel_id = $_SESSION['editing_hotel'];
	}else{
		die(header('Location: ' . $_SESSION['page_url']));
	}

	$hotelAttr = new HotelAttribute();
	$hotelAttr = $hotelAttr->where('hotel_id', '=', $hotel_id)->first();

	if(isset($_SESSION['hotel_step_error']) && (strlen($_SESSION['hotel_step_error']) > 0)){
?>
<div><?php echo $_SESSION['hotel_step_error']; $_SESSION['hotel_step_error'] = ''; ?></div>
<?php } ?>
<form action="<?php echo HTTP; ?>dashboard/get_step_04.php" method="post" enctype="multipart/form-data">
	<input type="hidden" value="d1b30e3e603d149cd12327fe2ec7510d" name="csrf"/>
	<fieldset>
		<legend>Hotel Registration/Property-details</legend>
		<h3 class="h3">Additional information</h3>

		<div class="row">
			<div class="form-group col-md-12 col-sm-12 col-xs-12">
				<label class="title-label">Airport Transfer Available</label>
				<div class="radio">
					<label><input type="radio" name="info[is_transport]" value="1" <?php echo (isset($hotelAttr->is_airport_transfer) && ($hotelAttr->is_airport_transfer == 1)) ? 'checked="true"' : ''; ?>> Yes</label>
					</div>
					<div class="radio">
					<label><input type="radio" name="info[is_transport]" value="0" <?php echo (isset($hotelAttr->is_airport_transfer) && ($hotelAttr->is_airport_transfer == 0)) ? 'checked="true"' : ''; ?>> No</label>
				</div>
			</div>

			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label class="title-label">Airport Transfer Fee</label>
				<div class="input-group">
					<input class="form-control" type="text" name="info[ransport_fee]" value="<?php echo isset($hotelAttr->airport_transfer_fee) ? $hotelAttr->airport_transfer_fee : ''; ?>" placeholder="__.__">
				<div class="input-group-addon"><strong>USD</strong></div>
				</div>
			</div>
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label class="title-label">Distance from Airport(km)</label>
				<div class="input-group">
				<input name="info[distance]" value="<?php echo isset($hotelAttr->distance_to_airport) ? $hotelAttr->distance_to_airport : ''; ?>" type="text" class="form-control" placeholder="__.__"> <div class="input-group-addon"><strong>km</strong></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label class="title-label">Check-In(hh:mm)</label>
				<input name="info[check_in]" value="<?php echo isset($hotelAttr->check_in) ? $hotelAttr->check_in : ''; ?>" type="text" class="form-control" placeholder="__:__">
			</div>
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label class="title-label">Check-Out(hh:mm)</label>
				<input name="info[check_out]" value="<?php echo isset($hotelAttr->check_out) ? $hotelAttr->check_out : ''; ?>" type="text" class="form-control" placeholder="__:__">
			</div>
		</div>
		<hr/>

		<div class="row">
			<div class="form-group col-xs-12">
				<button type="submit" name="submit" value="submit" class="pull-right btn-lg btn btn-primary">Next <i class="fa fa-arrow-circle-right"></i></button>
			</div>
		</div>
	</fieldset>
</form>
