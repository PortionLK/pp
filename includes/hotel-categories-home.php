<?php
	$hotelCatsHome = new Category();
	$hotelCatsHome = $hotelCatsHome->all();
?>
<h2>Hotel Categories</h2>
<h4></h4>
<div class="hotelCategories">
	<div class="col-xs-12 no-padding">
		<?php foreach($hotelCatsHome as $hotelCatHome){ ?>
		<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 no-padding">
			<div class="col-xs-12 hotel-cont">
				<a href="<?php echo HTTP_PATH; ?>sri-lanka/<?php echo str_replace(' ', '-', $hotelCatHome->seo_name); ?>-hotels">
					<img src="<?php echo HTTP_PATH; ?>images/hotel_cat/<?php echo str_replace(' ', '', $hotelCatHome->seo_name); ?>.jpg"/>
					<div class="hotel_type">
						<h4><?php echo ucwords($hotelCatHome->name); ?> Hotels</h4>
						<p><?php echo $hotelCatHome->description; ?></p>
					</div>
				</a>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
