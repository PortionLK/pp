<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");
	$_SESSION['page_url'] = HTTP_PATH;

    $hotel = new Hotel();
    $mainCity = new MainCity();
    $hotelImage = new HotelImage();
    $news = new News();

    $featuredHotels = $hotel->where('is_featured', '=', 1)->with('mainCity', 'subCity')->orderBy('id', 'DESC')->get();
    $newsData = $news->where('status', '=', 1)->take(4)->get();
	$topCities = $mainCity->where('top_cities', '=', 1)/*->take(2)*/->get();
	$otherCities = $mainCity->where('top_cities', '=', 0)->get();
?>
<!DOCTYPE>
<html>
<?php require_once(DOC_ROOT . 'includes/head.php'); ?>
<body>
<div id="wrapper">
	<?php include(DOC_ROOT . 'includes/header.php'); ?>
	<div id="content">
		<div class="home_banner home" style="background-image:url(<?php echo HTTP_PATH; ?>images/banner_home_3.jpg);">
			<div class="container">
				<?php include(DOC_ROOT . 'includes/booking-form.php'); ?>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 no-padding">
					<div class="col-xs-12 no-padding">
						<div class="breakingNews" id="bn2">
							<div class="bn-title"><h2>UPCOMING EVENTS</h2><span></span></div>
							<ul>
								<?php foreach($newsData as $news){ ?>
									<li><a href="event_calendar.php?event=<?php echo $news->id; ?>" class="bg"><?php echo $news->title; ?></a></li>
								<?php } ?>
							</ul>
							<div class="bn-navi">
								<span></span>
								<span></span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xs-12 no-padding">
				<div class="top-city_hotels col-xs-12 no-padding">
					<div class="col-xs-12 no-padding">
						<div class="row">
							<?php include(DOC_ROOT . 'includes/hotel-categories-home.php'); ?>
						</div>
					</div>
				</div>
			</div>
			<!--end after-mid-->
		</div>

		<div class="cateBg col-xs-12 no-padding">
			<h2 class="col-xs-12 text-center">Discover the top <span class="w_700 blue-text">[<?php echo count($topCities); ?>]</span> destinations in Sri Lanka</h2>
			<h4 class="col-xs-12 text-center">Roomista experts have trekked the Sri lanka to select the best cities and places to visit. Explore them now and plan your next tour.</h4>
			<div class="topDestination col-xs-12 no-padding">
			<ul id="categories" class="no-padding">
				<?php foreach($topCities as $topCity){
					$hotel = new Hotel();
					$countHotels = $hotel->where('main_city_id', '=', $topCity->id)->count(); ?>
				<li class="hotel-thumb col-sm-3 no-padding">
					<div class="item">
						<?php
						$filename = DOC_ROOT . 'uploads/main-city/' . $topCity['image'];
						if(file_exists($filename) && $topCity['image'] != "") {
						?>
						<img src="<?php echo HTTP_PATH; ?>timthumb.php?src=<?php echo HTTP_PATH; ?>uploads/main-city/<?php echo $topCity['image']; ?>&w=271&h=217">
						<?php }else{ ?>
						<img src="<?php echo HTTP_PATH; ?>timthumb.php?src=<?php echo HTTP_PATH; ?>images/no_image.jpg&w=271&h=217">
						<?php } ?>
						<div class="mask">
							<h3><?php echo $topCity['name']; ?></h3>
							<h5><?php echo $countHotels; ?> hotel<?php if($countHotels > 1){ echo 's'; } ?></h5>
							<a class="btn btn-border" href="<?php echo HTTP_PATH; ?>sri-lanka/hotels-in-<?php echo implode('-', explode(' ', strtolower($topCity['name']))); ?>">View Hotels</a>
						</div>
					</div>
				</li>
				<?php } ?>
			</ul>
			<a href="" class="categoryNavigation next" id="next2"></a>
			<a href="" class="categoryNavigation prev" id="prev2"></a>
			</div>
		</div>

		<div class="container hidden-xs">
			<div class="row">
				<div class="otherCityHotels col-xs-12 no-padding">
					<h3 class="text-center">Other destinations in sri lanka you might be like to visit. Check rest of the <span class="w_700 blue-text">[<?php echo count($otherCities) ?>]</span> destinations</h3>
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingOne">
								<h3 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Other destinations <i class="glyphicon glyphicon-menu-down"></i></a></h3>
							</div>
							<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
								<div class="panel-body">
									<?php foreach($otherCities as $otherCity){ 
									$OtherHotel = new Hotel();
									$countOtherCityHotels = $OtherHotel->where('main_city_id', '=', $otherCity->id)->count(); ?>
									<div class="item col-xs-6 col-sm-4 col-md-3">
										<a href="<?php echo HTTP_PATH; ?>sri-lanka/hotels-in-<?php echo implode('-', explode(' ', strtolower($otherCity['name']))); ?>" class="pull-left">
										<?php
										$filename = DOC_ROOT . 'uploads/main-city/' . $otherCity['image'];
										if(file_exists($filename) && $otherCity['image'] != "") {
										?>
										<img src="<?php echo HTTP_PATH; ?>timthumb.php?src=<?php echo HTTP_PATH; ?>uploads/main-city/<?php echo $otherCity['image']; ?>&w=271&h=150" class="img-responsive">
										<?php }else{ ?>
										<img src="<?php echo HTTP_PATH; ?>timthumb.php?src=<?php echo HTTP_PATH; ?>images/no_image.jpg&w=271&h=150" class="img-responsive">
										<?php } ?>
										<div class="mask">
											<h4 class="text-center text-white"><i class="fa fa-map-marker"></i> <?php echo $otherCity['name']; ?></h4>
											<h5 class="text-center text-white"><?php echo $countOtherCityHotels; ?> hotel<?php if($countOtherCityHotels > 1){ echo 's'; } ?></h5>
										</div>
										</a>
									</div>
									<?php }?>
      							</div>
							</div>
						</div>
					</div>
				</div>

				<div class="mid-right-sec">
					<div class="col-xs-12 col-sm-12 col-md-6">
						<div class="top-selling-hotels-outer col-xs-12 no-padding">
							<div class="row">
								<div class="page-header">
								<h3>Most Populer Hotels in Sri lanka</h3>
								<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam</p>
								</div>
							</div>
							<ul class="top-selling-hotels" id="toSellingHotels">
								<?php foreach($featuredHotels as $featuredHotel){
									$sCName = new SubCity();
									$numOfRoomsInFeatured = new Room();
									$sCName = $sCName->find($featuredHotel['sub_city_id']);
									$sCName = $sCName->name;
									$fHCPhoto = explode(',', $featuredHotel['cover_photo'])[0];
									$rMin = new RoomRate();
									$rMin = $rMin->where('hotel_id', '=', $featuredHotel->id)->min('sell_rate');

									$numOfRoomsInFeatured = $numOfRoomsInFeatured->where('hotel_id', '=', $featuredHotel['id'])->sum('no_of_rooms');
								?>
								<li class="selling-hotel col-xs-12 no-padding">
									<div class="col-md-2 col-sm-3 col-xs-4 no-padding">
										<?php
										$filename = DOC_ROOT . 'uploads/hotels/thumbnails/' . $fHCPhoto;
										if (file_exists($filename) && $fHCPhoto != "") {
										?>
										<img src="<?php echo HTTP_PATH; ?>timthumb.php?src=<?php echo HTTP_PATH; ?>uploads/hotels/thumbnails/<?php echo $fHCPhoto; ?>&w=312&h=234" alt="new_hotel"/>
										<?php } else { ?>
										<img src="<?php echo HTTP_PATH; ?>images/no_image.jpg" alt="image">
										<?php } ?>
									</div>
									<div class="col-md-10 col-sm-9 col-xs-8">
										<div class="col-md-9 col-sm-8 col-xs-12 no-padding">
											<a href="<?php echo HTTP_PATH; ?><?php echo $featuredHotel['seo_url']; ?>">
												<h4><?php echo $featuredHotel['name']; ?></h4>
											</a>
											<p><?php echo $sCName; ?></p>
											<p class="link"><?php echo $numOfRoomsInFeatured; ?> Room<?php echo ($numOfRoomsInFeatured > 1) ? 's': ''; ?></p>
										</div>
										<div class="col-md-3 col-sm-4 col-xs-12 no-padding">
											<span class="price text-right"><?php echo ($rMin) ? '$ ' . $rMin : ''; ?></span>
										</div>
									</div>
								</li>
								<?php } ?>
							</ul>
						</div>
					</div>

					<div class="col-xs-12 col-md-6 col-sm-12">
						<?php include(DOC_ROOT . 'includes/recently-added-hotels.php'); ?>					
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include(DOC_ROOT . 'includes/footer.php'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.caroufredsel/6.2.1/jquery.carouFredSel.packed.js"></script>
<script src="<?php echo HTTP_PATH; ?>js/chosen.jquery.min.js"></script>
<script src="<?php echo HTTP_PATH; ?>js/navigation.js"></script>
<script src="<?php echo HTTP_PATH; ?>js/BreakingNewsTicker.js"></script>

<script type="text/javascript">
$(function(){
    $('#toSellingHotels').carouFredSel({
        prev: '#prev1',
        next: '#next1',
        item:{
            visible: {
                min: 2,
                max: 6
            }
        },
        direction:'up',
        scroll:{
            pauseOnHover : true,
            duration : 1000,
        }
    });

    $('#categories').carouFredSel({
    	prev: '#prev2',
        next: '#next2',
		responsive: true,
		width: '100%',
		items: {
			width: 320,
		//	height: '30%',	//	optionally resize item-height
			visible: {
				min: 1,
				max: 8
			}
		},
		swipe: {
			onTouch: true
		},
		scroll:{
            pauseOnHover : true,
        }
	});

    $("#bn2").breakingNews({
		effect		:"slide-h",
		autoplay	:true,
		timer		:3000,
		color		:"blue",
		border		:true,
	});

    var cityNames = [];
    <?php foreach($topCities as $topCityJ){ ?>
    cityNames.push("<?php echo $topCityJ['name']?>");
    <?php }?>
    cityNames.push("Sri lanka");

    var i = 0;
    setInterval(function(){
    	$('#topCityName').text('').fadeOut(0)
    	$('#topCityName').text(cityNames[i]).fadeIn(1000, 'easeOutCirc')
    	++i;
    	if (i == cityNames.length-1) {
	    	i = 0;
	    }
    },3500)
});
</script>
</body>
</html>