<?php
	$hotelCatsHome = new Category();
	$hotelCatsHome = $hotelCatsHome->all();
?>
<div class="row inner">
	<div class="col-xs-12">
	<div class="top-sec col-xs-12">
		<?php foreach($hotelCatsHome as $hotelCatHome){ ?>
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="col-xs-12 hotel-cont">
				<a href="<?php echo HTTP_PATH; ?>sri-lanka/<?php echo str_replace(' ', '-', $hotelCatHome->seo_name); ?>-hotels">
					<div class="hotel_type"><span><?php echo ucwords($hotelCatHome->name); ?> Hotels</span></div>
				</a>
			</div>
		</div>
		<?php } ?>
	</div>
	</div>
</div>
