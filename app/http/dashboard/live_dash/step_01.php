<?php
	$category = new Category();
	$accTypes = $category->all();
	$mainCity = new MainCity();
	$mCities = $mainCity->all();
	$subCity = new SubCity();
	$sCities = $subCity->all();
	
	if(isset($_SESSION['editing_hotel']) && (strlen($_SESSION['editing_hotel']) > 0)){
		$hotel = new Hotel();
		$hotel = $hotel->find($_SESSION['editing_hotel']);
		if(!$hotel){ die(header('Location: ' . DOMAIN . '404')); }
		$categoryHotel = new CategoryHotel();
		$categoryHotel = $categoryHotel->where('hotel_id', '=', $_SESSION['editing_hotel'])->get();
		$categoryIds = [];
		foreach($categoryHotel as $categoryId){
			$categoryIds[] = $categoryId->category_id;
		}
		$subCityName = $subCity->find($hotel->sub_city_id);
		$subCityName = $subCityName->name;
		$coverPhotos = explode(',', $hotel->cover_photo);
		$coverPhotos = array_filter($coverPhotos);
	}
?>
<form action="<?php echo HTTP; ?>dashboard/get_step_01.php" method="post" enctype="multipart/form-data">
	<input type="hidden" value="d1c4ed87775fffbab3acc36170b0cf2d" name="csrf"/>
	<fieldset>
		<legend>Hotel Registration/Property-details</legend>
		<h3 class="h3">Hotel information</h3>
		<div class="form-group">
			<label for="hotelName">Hotel Name<span class="text-danger">*</span></label>
			<input type="text" value="<?php echo isset($hotel->name) ? $hotel->name: ''; ?>" name="hotelName" class="form-control" placeholder="Hotel name" required="required">
		</div>

		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<div class="map_canvas col-xs-12 no-padding" style="height:330px"></div>
				</div>
			</div>

			<div class="col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="hotelLocation">Map Location<span class="text-danger">*</span></label>
					<input id="geocomplete" type="text" name="hotelLocation" class="form-control" placeholder="Type for Location" required="required" value="<?php echo (isset($hotel->map_location) && (strlen($hotel->map_location) > 1)) ? $hotel->map_location : ''; ?>" onclick="javascript:this.select();">
				</div>
				<div class="form-group">
					<button id="find" type="button" class="btn btn-info btn-block">Find</button>
				</div>

				<div class="form-group">
					<label>Latitude</label>
					<input name="lat" value="<?php echo isset($hotel->latitude) ? $hotel->latitude : ''; ?>" id="lat" type="text" readonly="true" class="form-control">
				</div>
				<div class="form-group">
					<label>Longitude</label>
					<input name="lng" value="<?php echo isset($hotel->longitude) ? $hotel->longitude : ''; ?>" id="lng" type="text" readonly="true" class="form-control">
				</div>
				<div class="form-group">
					<label>Formatted Address</label>
					<input value="<?php echo (isset($hotel->map_location) && (strlen($hotel->map_location) > 1)) ? $hotel->map_location : ''; ?>" name="formatted_address" type="text" readonly="true" class="form-control">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label for="accommodationType">Type of Accommodation</label><br/>
				<?php foreach($accTypes as $accType){ ?>
				<label><input type="checkbox" name="accommodationType[]" value="<?php echo $accType->id; ?>" <?php echo in_array($accType->id, $categoryIds) ? 'checked="true"' : ''; ?>><?php echo $accType->name; ?> hotels</label>
				<?php } ?>
			</div>

			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label for="starRating">Star Rating <span class="text-danger">*</span></label>
				<select name="starRating" class="form-control" required="required">
					<option value="">Select Rating</option>
					<option value="0" <?php echo (isset($hotel->star_rating) && ($hotel->star_rating == 0)) ? 'selected="true"' : ''; ?>>No rating</option>
					<option value="1" <?php echo (isset($hotel->star_rating) && ($hotel->star_rating == 1)) ? 'selected="true"' : ''; ?>>1</option>
					<option value="2" <?php echo (isset($hotel->star_rating) && ($hotel->star_rating == 2)) ? 'selected="true"' : ''; ?>>2</option>
					<option value="3" <?php echo (isset($hotel->star_rating) && ($hotel->star_rating == 3)) ? 'selected="true"' : ''; ?>>3</option>
					<option value="4" <?php echo (isset($hotel->star_rating) && ($hotel->star_rating == 4)) ? 'selected="true"' : ''; ?>>4</option>
					<option value="5" <?php echo (isset($hotel->star_rating) && ($hotel->star_rating == 5)) ? 'selected="true"' : ''; ?>>5</option>
					<option value="8" <?php echo (isset($hotel->star_rating) && ($hotel->star_rating == 8)) ? 'selected="true"' : ''; ?>>Boutique</option>
				</select>
			</div>
		</div>
		<hr>

		<div class="row">
			<div class="form-group col-xs-12">
				<label for="address">Street Address <span class="text-danger">*</span></label>
				<input class="form-control" value="<?php echo isset($hotel->street_address) ? $hotel->street_address : ''; ?>" name="streetAddress" placeholder="Street address" required="required">
			</div>
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label for="mainCity">Main city <span class="text-danger">*</span></label>
				<select class="form-control" name="mainCity" placeholder="Main City" required="required">
					<?php foreach($mCities as $mCity){ ?>
					<option value="<?php echo $mCity->id; ?>" <?php echo (isset($hotel->main_city_id) && ($mCity->id == $hotel->main_city_id)) ? 'selected="true"' : ''; ?>><?php echo $mCity->name; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label for="subCity">Sub city <span class="text-danger">*</span></label>
				<input class="form-control" value="<?php echo isset($subCityName) ? $subCityName : ''; ?>" id="subCity" placeholder="Sub City" required="required">
				<input name="subCityId" value="<?php echo isset($hotel->sub_city_id) ? $hotel->sub_city_id : ''; ?>" type="hidden" id="subCityId">
			</div>

			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label for="postalCode">Postal Code <span class="text-danger">*</span></label>
				<input type="text" value="<?php echo isset($hotel->postal_code) ? $hotel->postal_code : ''; ?>" name="postalCode" class="form-control" placeholder="Postal Code" required="required">
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label for="phone">Phone <span class="text-danger">*</span></label>
				<input type="tel" value="<?php echo isset($hotel->phone) ? $hotel->phone : ''; ?>" name="phone" class="form-control" placeholder="Phone number" maxlength="10" required="required">
			</div>

			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label for="fax">Fax</label>
				<input type="tel" class="form-control" value="<?php echo isset($hotel->fax) ? $hotel->fax : ''; ?>" name="fax" placeholder="Fax number">
			</div>
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label for="email">Email <span class="text-danger">*</span></label>
				<input type="email" class="form-control" value="<?php echo isset($hotel->email) ? $hotel->email : ''; ?>" name="email" placeholder="Email" required="required">
			</div>
		</div>
		<hr/>
		<div class="form-group">
			<label for="websiteUrl">Website URL</label>
			<input type="url" value="<?php echo isset($hotel->web_url) ? 'http://' . $hotel->web_url : ''; ?>" name="websiteUrl" class="form-control" placeholder="Website URL">
		</div>

		<div class="form-group">
			<label for="seoUrl">SEO URL <span class="text-danger">*</span></label>
			<div class="input-group">
				<div class="input-group-addon">www.roomista.com/</div>
				<input type="text" value="<?php echo isset($hotel->seo_url) ? $hotel->seo_url : ''; ?>" name="seoUrl" class="form-control" placeholder="SEO URL" required="required">
			</div>
		</div>

		<div class="row">
			<div class="form-group col-xs-12">
				<label for="hotel_description">Hotel description</label>
				<textarea class="form-control" cols="100" rows="5" name="hotel_description" placeholder="Hotel description"><?php echo isset($hotel->description) ? $hotel->description : ''; ?></textarea>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-xs-12">
				<label for="hotel_description">Hotel cover photo</label>
				<input type="file" class="form-control" name="hotel_coverphoto[]" placeholder="Hotel cover photo" multiple="true"/>
				<?php if(isset($coverPhotos) && count($coverPhotos)){
					foreach($coverPhotos as $coverPhoto){ ?>
				<img src="<?php echo DOMAIN; ?>timthumb.php?src=<?php echo DOMAIN; ?>uploads/hotel-cover-photos/<?php echo $coverPhoto; ?>&w=250&h=160"/>
					<?php }
				} ?>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-xs-12">
				<button type="submit" name="submit" value="submit" class="pull-right btn-lg btn btn-primary">Save & Continue <i class="fa fa-arrow-circle-right"></i></button>
			</div>
		</div>
	</fieldset>
</form>
<script type="text/javascript">
	var subCities = [
	<?php foreach($sCities as $sCity){ echo '{id:' . $sCity->id .', label:"' . $sCity->name . '"},'; } ?>
	];

  	$('#subCity').autocomplete({
		source: subCities,
		select: function(event, ui){
			$("#subCityId").val(ui.item.id);
			$("#subCity").val(ui.item.label);
		}
	});
</script>