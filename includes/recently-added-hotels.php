<?php
	$recentHotels = new Hotel();
	$recentHotels = $recentHotels->where('active_status', '=', 1)->with('mainCity')->take(5)->orderBy('id', 'DESC')->get();
?>
<div class="col-xs-12 recentlyAddedHotels no-padding">
	<div class="page-header">
	<h3>Get know about latest hotels we found for you</h3>
	<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam</p>
	</div>
	<?php foreach($recentHotels as $recentHotel){ ?>	
		<div class="col-xs-12 item no-padding">
			<div class="col-md-2 col-sm-3 col-xs-4 no-padding">
				<?php
				$numOfRooms = new Room();
				$numOfRooms = $numOfRooms->where('hotel_id', '=', $recentHotel->id)->sum('no_of_rooms');
				$coverPhoto = explode(',', $recentHotel->cover_photo)[0];
				$filename = DOC_ROOT . 'uploads/hotels/thumbnails/' . $coverPhoto;
				if(file_exists($filename) && $coverPhoto != "") {
				?>
				<img src="<?php echo HTTP_PATH; ?>timthumb.php?src=<?php echo HTTP_PATH; ?>uploads/hotels/thumbnails/<?php echo $coverPhoto; ?>&w=300&h=250" width="100%" alt="new_hotel"/>
				<?php } else { ?>
				<img src="<?php echo HTTP_PATH; ?>timthumb.php?src=<?php echo HTTP_PATH; ?>images/no_image.jpg&w=300&h=250" alt="image" width="100%"/>
				<?php } ?>
			</div>

			<div class="col-md-6 col-sm-6 col-xs-8">
				<div class="item_desc">
					<div class="hotel-name-price">
						<h5><a href="<?php echo HTTP_PATH; ?><?php echo $recentHotel->seo_url; ?>"><?php echo $recentHotel->name; ?></a></h5>
						<span><i class="fa fa-bed"></i> <?php echo $numOfRooms; ?> Room<?php echo ($numOfRooms > 1) ? 's' : ''; ?></span>
					</div>
					<input type="hidden" id="<?php echo $recentHotel->id; ?>" name="<?php echo $recentHotel->id; ?>" value="<?php echo $recentHotel->seo_url; ?>"/>
					<span><i class="fa fa-map-marker"></i> <?php echo $recentHotel['mainCity'][0]->name; ?></span>
				</div>
			</div>
			<div class="col-md-4 col-sm-3 col-xs-12 no-padding-md">
				<a href="<?php echo HTTP_PATH; ?>bookings/<?php echo $recentHotel->seo_url; ?>" class="btn btn-primary btn-block">Book now</a>
			</div>
		</div>
	<?php } ?>
</div>