<?php 
    define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");

	if(!isset($_GET['seo_url']) && (strlen($_GET['seo_url']) < 1)){ die(header('Location: ' . DOMAIN . '404')); }
    $_SESSION['page_url'] = ($_GET['page_url']) ? DOMAIN . $_GET['page_url'] : DOMAIN;

	$seo_url = $_GET['seo_url'];
	$hotel = new Hotel();
	$hotel = $hotel->where('seo_url', '=', $seo_url)->first();
	if(!$hotel){ die(header('Location: ' . DOMAIN . '404')); }

	if(isset($hotel->cover_photo) && (strlen($hotel->cover_photo) > 1)){
		$herCoverPhotos = explode(',', $hotel->cover_photo);
		foreach($herCoverPhotos as $photoKey => $herCoverPhoto){
			if(!file_exists(DOC_ROOT . 'uploads/hotel-cover-photos/' . $herCoverPhoto)){ unset($herCoverPhotos[$photoKey]); };
		}
	}else{
		$herCoverPhotos = ['default-cover-photo.jpg'];
	}

	$roomImage = new RoomImage();
	$roomImages = $roomImage->where('hotel_id', '=', $hotel->id)->get();

	$hFeature = new HotelFeature();
	$hFeatures = $hFeature->where('hotel_id', '=', $hotel->id)->get();
	$hFeatureList = [];
	foreach($hFeatures as $hFeature){
		$fTypeName = new HotelFeatureType();
		$fTypeName = $fTypeName->find($hFeature->feature_type_id);
		$fIds = $hFeature->feature_ids;
		$fIds = explode(',', $fIds);
		$fItems = new HotelFeatureList();
		$fItems = $fItems->whereIn('id', $fIds)->get();
		foreach($fItems as $fItem){
			$hFeatureList[$fTypeName->type][] = $fItem->feature;
		}
	}

	
?>

<html>
<?php require_once(DOC_ROOT . 'includes/head.php'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo DOMAIN ?>css/magnific-popup.css">
<body>
<div id="wrapper">
    <?php include(DOC_ROOT . 'includes/header_hotel.php'); ?>

    <div id="content">
        <div id="slides">
            <?php foreach($herCoverPhotos as $herCover){ ?>
			<img src="<?php echo DOMAIN; ?>uploads/hotel-cover-photos/<?php echo $herCover; ?>" alt="">
			<?php } ?>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-3">
                <h5 class="text-center">CHOOSE YOUR DATE</h5>
            </div>
            <div class="col-xs-12 col-sm-3">
                <h5 class="text-center">CHOOSE YOUR ROOM</h5>
            </div>
            <div class="col-xs-12 col-sm-3">
                <h5 class="text-center">PLACE YOUR RESERVATION</h5>
            </div>
            <div class="col-xs-12 col-sm-3">
                <h5 class="text-center">CONFIRMATION</h5>
            </div>
            <div class="clearfix"></div>

            <div class="progress">
                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                </div>
            </div>

        </div>
        
        <div class="page-header">
            <h2>When would you like to stay at <?php echo ucwords($hotel->name); ?>?</h2>
        </div>
        <div class="well">
            <div class="hidden-xs col-xs-12 col-sm-8 col-md-8">
                <div id="datepicker"></div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="<?php echo DOMAIN . 'bookings/' . $seo_url . '/step-02'; ?>" method="post">
                            <legend>Your reservation</legend>
                            <div class="row">
                                <div class="form-group col-xs-12 col-sm-12 col-md-6">
                                    <label>Check in</label>
                                    <input name="date_arriving" class="form-control" type="text" id="checkIn">
                                </div>
                                <div class="form-group col-xs-12 col-sm-12 col-md-6">
                                    <label>Check in</label>
                                    <input name="date_departure" class="form-control" type="text" id="checkOut">
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit">Check Availability</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <hr>
        <div class="col-xs-12">
            <div class="row">
                <h3><?php echo ucwords($hotel->name); ?> photo gallery</h3>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#gallery" aria-controls="gallery" role="tab" data-toggle="tab">Gallery</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="gallery">
                        <div class="panel-body">
                        <div class="galleryImages">
                            <?php foreach($roomImages as $rmImg){ ?>
							<a href="<?php echo DOMAIN ?>uploads/room-photos/<?php echo $rmImg->image; ?>" class="image-link col-lg-2 col-xs-6 col-sm-4 col-md-3">
                                <img src="<?php echo DOMAIN; ?>timthumb.php?src=<?php echo DOMAIN ?>uploads/room-photos/<?php echo $rmImg->image; ?>&w=300&h=300" class="img-responsive img-thumbnail">
                            </a>
							<?php } ?>
                        </div>
                        </div>
                    </div>
                </div>

            </div>
            <hr>
        </div>


        <!--  -->
        <div class="hidden-xs col-sm-4 col-md-3 pull-right">
            
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Special offers</h4></div>
                <div class="panel-body">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="<?php echo HTTP_PATH; ?>images/thumb-7.jpg" alt="...">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Media heading</h4>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="<?php echo HTTP_PATH; ?>images/thumb-7.jpg" alt="...">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Media heading</h4>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="<?php echo HTTP_PATH; ?>images/thumb-7.jpg" alt="...">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Media heading</h4>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-xs-12 col-sm-8 col-md-9 pull-right">
            <div class="col-xs-12 no-padding">
                <h3 class="w_700">Features of <?php echo $hotel->name; ?></h3>
				<?php foreach($hFeatureList as $k1 => $hFeatureItem){ ?>
				<div class="row">
					<div class="co-xs-12 col-md-3 col-sm-3 w_700"><?php echo $k1; ?></div>
					<div class="co-xs-12 col-md-9 col-sm-9">
						<ul>
							<?php foreach($hFeatureItem as $hFItm){ ?>
							<li class="col-xs-12 col-md-4 col-sm-4"><i class="fa fa-check-circle text-info"></i> <?php echo $hFItm; ?></li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<hr>
				<?php } ?>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="fa fa-minus-circle"></i> Resort Description</a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <p><?php echo $hotel->description; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"><i class="fa fa-minus-circle"></i> Resort Policies</a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <div class="col-xs-12 policies">
                                        <div class="row">
                                            <div class="itemHead col-xs-12 col-md-4 col-sm-5">
                                                <h6><i class="fa fa-credit-card"></i> Payment policy</h6>
                                            </div>
                                            <div class="itemDesc col-xs-12 col-md-8 col-sm-7">
                                                <p>Reservation payments are quoted generally per room per night. Any payment mode will be accepted.</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="itemHead col-xs-12 col-md-4 col-sm-5">
                                                <h6><i class="fa fa-times"></i> Cancelation policy</h6>
                                            </div>
                                            <div class="itemDesc col-xs-12 col-md-8 col-sm-7">
                                                <p>If a cancellation is required we should be informed before 72 hours.</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="itemHead col-xs-12 col-md-4 col-sm-5">
                                                <h6><i class="fa fa-child"></i> Child policy</h6>
                                            </div>
                                            <div class="itemDesc col-xs-12 col-md-8 col-sm-7">
                                                <p>0-3year old's are considered as infants where as guests lesser than 10 years old are considered as children.</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="itemHead col-xs-12 col-md-4 col-sm-5">
                                                <h6><i class="fa fa-check-square-o"></i> Check in check out policy</h6>
                                            </div>
                                            <div class="itemDesc col-xs-12 col-md-8 col-sm-7">
                                                <p>Early check-ins / late checkouts will be billed according to an hourly rate determined by the hotel.</p>
                                            </div>
                                        </div>
                                        <ul class="no-padding">
                                            <li>Guests over 12 years old are considered as adults.</li>
                                            <li>Extra beds are dependent on the room you choose, please check the individual room policy for more details.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree"><i class="fa fa-minus-circle"></i> Useful Info</a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">
                                    <table class="table">
                                        <tr>
                                            <td class="col-xs-6 w_700"></td>
                                            <td class="col-xs-6"></td>
                                        </tr>
                                        <tr>
                                            <td class="w_700">Breakfast Charge (when not included in room rate)</td>
                                            <td>90 USD</td>
                                        </tr>
                                        <tr>
                                            <td class="w_700">Room Voltage</td>
                                            <td>230</td>
                                        </tr>
                                        <tr>
                                            <td class="w_700">Number of Restaurants</td>
                                            <td>1</td>
                                        </tr>
                                        <tr>
                                            <td class="w_700">Year Hotel Built</td>
                                            <td>2012</td>
                                        </tr>
                                        <tr>
                                            <td class="w_700">Year Hotel Last Renovated</td>
                                            <td>2014</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  -->
        
    </div>

</div>
<footer>
    <?php include(DOC_ROOT . "includes/footer_hotel.php"); ?>
</footer>
<script src="<?php echo HTTP_PATH ?>js/jquery.slides.min.js"></script>
<script src="<?php echo HTTP_PATH ?>js/jquery.magnific-popup.min.js"></script>
<script>
$(function() {

    var sw = document.body.clientWidth;
    if (sw < 768) {
        $('#checkIn, #checkOut').attr('type', 'date');
        $('#checkIn, #checkOut').removeAttr('readonly');
    }else{
        $('#checkIn, #checkOut').attr('type', 'text');
        $('#checkIn, #checkOut').attr('readonly', 'readonly');
    }
    $(window).resize(function(){
        var sw = document.body.clientWidth;
        if (sw < 768) {
            $('#checkIn, #checkOut').attr('type', 'date');
            $('#checkIn, #checkOut').removeAttr('readonly');
        }else{
            $('#checkIn, #checkOut').attr('type', 'text');
            $('#checkIn, #checkOut').attr('readonly', 'readonly');
        }
    })

    $("#datepicker").datepicker({
        numberOfMonths: 2,
        minDate: '+1D',
        dateFormat: 'yy-mm-dd',
        beforeShowDay: function(date) {


            var date1 = $.datepicker.parseDate('yy-mm-dd', $("#checkIn").val());
            var date2 = $.datepicker.parseDate('yy-mm-dd', $("#checkOut").val());
            //debugger
            if (date >= date1 && date <= date2) {
                return [true, 'dateSelected'];
            }
            return [true, '', ''];

        },
        onSelect: function(dateText, inst) {

            var date1 = $.datepicker.parseDate('yy-mm-dd', $("#checkIn").val());
            var date2 = $.datepicker.parseDate('yy-mm-dd', $("#checkOut").val());

            if (!date1 || date2) {
                $("#checkIn").val(dateText);
                $("#checkOut").val("");
            } else {
                if (Date.parse(dateText) < Date.parse(date1)) {
                    $("#checkIn").val(dateText);
                    $("#checkOut").val("");
                } else {
                    $("#checkOut").val(dateText);
                }
            }
        }

    });

    $('.galleryImages').magnificPopup({
        delegate: '.image-link',
        type: 'image',
        zoom: {
            enabled: true,
            duration: 300 // don't foget to change the duration also in CSS
        },
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
        },
        mainClass: 'mfp-with-zoom mfp-img-mobile',
        image: {
            verticalFit: true,
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
        }
    });
    $('.panel-title a').click(function(){
        var ariaControls = $(this).attr('aria-controls');
        if ($('#'+ariaControls).hasClass('in')) {
            $('.fa', this).removeClass('fa-minus-circle').addClass('fa-plus-circle');
        }else{
            $('.fa', this).removeClass('fa-plus-circle').addClass('fa-minus-circle');
        }
    });

    $('#slides').slidesjs({
        width: 1920,
        height: 550,
        start: 1,
        navigation: {
            active: false,
            effect: "fade"
        },
        pagination: {
            active: false,
            effect: "fade"
        },
        play: {
            effect: "fade",
            interval: 5000,
            auto: true,
            swap: true,
        },
        effect: {
            fade: {
                speed: 1500,
                crossfade: true
            }
        },
    });


});
</script>

</body>
</html>