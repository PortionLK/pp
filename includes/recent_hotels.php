
	
	<div class="heading">Recently Added Hotels in <span class="color_2">Sri Lanka</span></div>
    <?php
	$hotel = new Hotel();
	$activeHotels = $hotel->where('active_status', '=', 1)->take(6)->orderBy('id', 'DESC')->get();
	foreach($activeHotels as $activeHotel){
	?>
	<div class="box_1">
		<div class="main_thumbnail">
		<?php
		$filename = DOC_ROOT . 'uploads/hotels/thumbnails/' . explode(',', $activeHotel->cover_photo)[0];
		if(file_exists($filename) && explode(',', $activeHotel->cover_photo)[0] != ""){
			?>
			<img src="<?php echo HTTP_PATH; ?>uploads/hotels/thumbnails/<?php echo explode(',', $activeHotel->cover_photo)[0]; ?>" width="151" height="109" alt="new_hotel" onclick="makeAlert(<?php echo $activeHotel->id; ?>);" style="cursor:pointer;"/>
		<?php }else{ ?>
			<img src="<?php echo HTTP_PATH; ?>images/no_image.jpg" alt="image" width="151" height="109"/>
		<?php } ?>
		</div>
		<div class="hotel_name" onclick="makeAlert(<?php echo $activeHotel->id; ?>);">
			<?php echo $activeHotel->name; ?>
			<input type="hidden" id="<?php echo $activeHotel->id; ?>" name="<?php echo $activeHotel->id; ?>" value="<?php echo $activeHotel->seo_url; ?>"/>
		</div>
		<?php
		$hotelImages = $activeHotel->cover_photo;
		$hotelImages = explode(',', $hotelImages);
		if(count($hotelImages) >= 3){
		for($i = 0; $i < 3; $i++){ ?>
		<div class="small_thumbnail">
			<?php
			$filename = DOC_ROOT . 'uploads/hotels/thumbnails/' . $hotelImages[$i];
			if(file_exists($filename) && $hotelImages[$i] != ""){
				?>
			<img src="<?php echo HTTP_PATH; ?>uploads/hotels/thumbnails/<?php echo $hotelImages[$i]; ?>" width="45" height="46" alt="small_hotel_thumbnail"/>
			<?php } else { ?>
			<img src="<?php echo HTTP_PATH; ?>images/no_image.jpg" alt="image" width="45" height="46"/>
			<?php } ?>
		</div>
		<?php }
		}else{
		foreach($hotelImages as $hotelImage){ ?>
		<div class="small_thumbnail">
			<?php
			$filename = DOC_ROOT . 'uploads/hotels/thumbnails/' . $hotelImage;
			if(file_exists($filename) && $hotelImage != ""){
				?>
			<img src="<?php echo HTTP_PATH; ?>uploads/hotels/thumbnails/<?php echo $hotelImage; ?>" width="45" height="46" alt="small_hotel_thumbnail"/>
			<?php } else { ?>
			<img src="<?php echo HTTP_PATH; ?>images/no_image.jpg" alt="image" width="45" height="46"/>
			<?php } ?>
		</div>
		<?php }
		} ?>
	</div>
	<?php } ?>