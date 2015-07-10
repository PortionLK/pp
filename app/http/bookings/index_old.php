<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");

	if(!isset($_GET['seo_url']) && (strlen($_GET['seo_url']) < 1)){ die(""); }
	$seoUrl = urldecode($_GET['seo_url']);

	if(!isset($_GET['stage']) || !is_numeric($_GET['stage'])){
		die(header('Location: ' . HTTP . "bookings/$seoUrl/step-01"));
	}
	$stage = intval($_GET['stage']);
	$stage = sprintf("%02d", $stage);

	$_SESSION['page_url'] = HTTP . "bookings/$seoUrl/step-$stage";

	$hotel = new Hotel();
	$hotel = $hotel->where('seo_url', '=', $seoUrl)->first();
?>
<!DOCTYPE>
<html>
	<?php require_once(DOC_ROOT . 'includes/head.php'); ?>
<body>
    <div id="wrapper">
		
	</div>
	<!-- here to start -->
    <div id="background-wrapper">
        <div class="container">
            <div class="hotel_image" style="background-image:url(<?php echo DOMAIN; ?>images/bg-image.jpg)"></div>
            <div class="hotel_name">
                <h2><?php echo $hotel->name; ?></h2>
                <h5><?php echo $hotel->street_address; ?></h5>
            </div> 
        </div>
            <?php
			$imageName = explode(',', $hotel->cover_photo)[0];
            $imageSrc = "uploads/hotels/" . "header-" . $imageName;
            if(file_exists(DOC_ROOT . $imageSrc)){ ?>
                <div id="page-header" style="background:url(<?php echo DOMAIN . $imageSrc; ?>) no-repeat top center;">
            <?php
            }else{ ?>
                <div id="page-header" style="background:url(<?php echo DOMAIN; ?>images/demo_image.jpg) no-repeat top center;">
            <?php } ?>
            </div>
            <div class="content-wrapper clearfix">
                <div class="booking-step-wrapper clearfix">
                    <div class="step-wrapper clearfix">
                        <div class="step-icon-wrapper">
                            <div class="step-icon step-icon-current">1. Choose Your Date</div>
                        </div>
                    </div>
                    <div class="step-wrapper clearfix">
                        <div class="step-icon-wrapper">
                            <div class="step-icon">2. 
                            <?php if ($hotel->main_city_id == 1) { ?>
                            Choose Your Options
                            <?php } else { ?>
                                Choose Your Room
                            <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="step-wrapper clearfix">
                        <div class="step-icon-wrapper">
                            <div class="step-icon">3. Place Your Reservation</div>
                        </div>
                        <div class="step-title"></div>
                    </div>
                    <div class="step-wrapper last-col clearfix">
                        <div class="step-icon-wrapper">
                            <div class="step-icon">4. Confirmation</div>
                        </div>
                        <div class="step-title"></div>
                    </div>
                    <div class="step-line"></div>
                </div>

                <div class="booking-main-wrapper pull-left">
                    <div class="booking-main">
                        <div id="datepicker_loading"><center>Loading.....</center></div>
                        <div class="dark-notice calendar-notice"><p>Please select your dates from the calendar</p></div>
                        <div id="open_datepicker"></div>
                        <div class="clearboth"></div>
                        <div class="datepicker-key clearfix">
                            <div class="key-unavailable-wrapper clearfix">
                                <div class="key-unavailable-icon"></div>
                                <div class="key-unavailable-text">Unavailable</div>
                            </div>
                            <div class="key-available-wrapper clearfix">
                                <div class="key-available-icon"></div>
                                <div class="key-available-text">Available</div>
                            </div>
                            <div class="key-selected-wrapper clearfix">
                                <div class="key-selected-icon"></div>
                                <div class="key-selected-text">Selected Dates</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="booking-side-wrapper pull-right">
                    <div class="booking-side">
						<?php if(isset($_SESSION['booking_nav_error']) && strlen($_SESSION['booking_nav_error']) > 5){ ?>
						<div><?php echo $_SESSION['booking_nav_error']; ?></div>
						<?php $_SESSION['booking_nav_error'] = ''; } ?>

						<?php
							$stepForm = DOC_ROOT . "bookings/step_$stage.php";
							if(file_exists($stepForm)){
								require_once($stepForm);
							}else{
								die(header('Location: ' . HTTP . "bookings/$seoUrl/step-01"));
							}
						?>
                    </div>
                </div>
            </div>
            <?php
			$hotel_images = new HotelImage;
			$hotel_images->setImageHotelId($hotel->id);
			$hotelImageData = $hotel_images->getHotelImageById();
			?>
            <div class="content-wrapper clearfix gallery">
                <div class="mygallery">
                <?php for($iq=0; $iq < count($hotelImageData); $iq++){
					$hotel_images->extractor($hotelImageData, $iq);
					?>
                    <div>
                        <a class="example-image-link" href="<?php echo DOMAIN; ?>uploads/hotel-gal/<?php echo $hotel_images->imageName(); ?>" data-lightbox="example-set" data-title="">
                            <img alt="<?php echo $hotel_images->imageTitle(); ?>" src="<?php echo DOMAIN; ?>timthumb.php?src=<?php echo DOMAIN; ?>uploads/hotel-gal/<?php echo $hotel_images->imageName(); ?>&w=229&h=172" />
                            <div class="hover"></div>
                        </a>
                        <span><?php echo $hotel_images->imageTitle(); ?></span>
                    </div>
					<?php } ?>
                </div>
            </div>

            <div class="content-wrapper clearfix hotel-info">
                <h2>Hotel infomation</h2>
                <p><?php echo $hotels->hotelDescription(); ?></p>
            </div>

            <div class="content-wrapper clearfix features">
                <h2>Features of <?php echo $hotels->hotelName(); ?></h2>
                <div class="group-set">
                <?php
				$hotelFeatureType = new HotelFetursType();
				$hFeatureType_data = $hotelFeatureType-> getAllHotelFeatureType();
				
				for($ft=0; $ft<count($hFeatureType_data); $ft++){
					 $hotelFeatureType->extractor($hFeatureType_data,$ft);
					 ?>
                        <div class="acc-inner-cont">
                            <div class="left-sec"><?php echo $hotelFeatureType->hotelFeatureTypeName(); ?></div>
                            <ul class="right-sec">
                            <?php
							//get feature list							
							$hotelFeatureList = new HotelFetursList();//hotel_feature_type_id
							$hotelFeatureList->setHotelFeatureListTypeId($hotelFeatureType->hotelFeatureTypeId());
							$hfeatureList_data = $hotelFeatureList->getHotelFeatureListFromTypeId();
							for($fl=0; $fl<count($hfeatureList_data); $fl++){
								$hotelFeatureList->extractor($hfeatureList_data,$fl);
								
								$featursIDlist = explode(",", $hotels->hotelFeatures());
								
								$listID = $hotelFeatureList->hotelFeatureListId();
								
								if(in_array($listID,$featursIDlist)){
									?><li class="check-mark"><?php echo $hotelFeatureList->hotelFeatureListName(); ?></li><?php
								}
							}
							?>
                            </ul>
                            <div class="clear"></div>
                        </div>
					 
					 <?php
				}
				
				?>
                    <div class="clear"></div>
                </div>

            </div>

            <div class="content-wrapper clearfix policies">
                <h2>HOTEL POLICIES</h2>
                    <div class="group-set">

                        <div class="acc-inner-cont">
                            <div class="left-sec">
                                Payment policy
                            </div>
                            <div class="right-sec">
                                <i class="tick"></i>Reservation payments are quoted generally per room per night. Any payment mode will be accepted.
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="acc-inner-cont">
                            <div class="left-sec">
                                Cancelation policy
                            </div>
                            <div class="right-sec">
                                <i class="tick"></i>If a cancellation is required we should be informed before 72 hours.
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="acc-inner-cont">
                            <div class="left-sec">
                                Child policy
                            </div>
                            <div class="right-sec">
                                <i class="tick"></i>0-3year old's are considered as infants where as guests lesser than 10 years old are considered as children.
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="acc-inner-cont">
                            <div class="left-sec">
                                Check in check out policy
                            </div>
                            <div class="right-sec">
                                <i class="tick"></i>Early check-ins / late checkouts will be billed according to an hourly rate determined by the hotel.
                            </div>
                            <div class="clear"></div>
                        </div>

                    <div class="clear"></div>
                </div>

            </div>
            <div class="content-wrapper clearfix use-info">
            <h2>Useful Information</h2>
                <div class="group-set">
                
                <?php
				
				if ($hotels->hotelNameInOther()) {
					?>
                    <div class="acc-inner-cont">
                        <div class="left-sec">Formerly Known as</div>
                        <div class="right-sec"><span class="green"><?php echo $hotels->hotelNameInOther(); ?></span></div>
                        <div class="clear"></div>
                    </div>                    
                    <?php
				}
				?>
                                
                    <div class="acc-inner-cont">
                        <div class="left-sec">Airport Transfer Availability</div>
                        <div class="right-sec"><span class="green">
                        
                        <?php 
						switch ($hotels->hotelAirportTransportAvailability()) {
                            case 1:
                                echo 'Yes';
                                break;
                            case 0:
                                echo 'No';
                                break;
                        }
						?>
                        </span></div>
                        <div class="clear"></div>
                    </div>
                    
                    <?php
					if($hotels->hotelAirportTransportFee() !=""){
					?>
                    <div class="acc-inner-cont">
                        <div class="left-sec">Airport Transfer Fee</div>
                        <div class="right-sec"><?php echo $hotels->hotelAirportTransportFee(); ?></div>
                        <div class="clear"></div>
                    </div>
                    
                    <?php	
					}
					?>
                    <?php
					if($hotels->hotelCheckinTime() !=""){
					?>
                    <div class="acc-inner-cont">
                        <div class="left-sec">Earliest Check-In (HH:mm)</div>
                        <div class="right-sec"><?php echo $hotels->hotelCheckinTime(); ?></div>
                        <div class="clear"></div>
                    </div>
                    <?php	
					}
					?>
                    <div class="acc-inner-cont">
                        <div class="left-sec">Check-Out (HH:mm)</div>
                        <div class="right-sec"><?php echo $hotels->hotelCheckoutTime(); ?></div>
                        <div class="clear"></div>
                    </div>
                    <?php
					if($hotels->hotelDistanceFromCity() !=""){
					?>
                    <div class="acc-inner-cont">
                        <div class="left-sec">Distance from Airport (km)</div>
                        <div class="right-sec"><?php echo $hotels->hotelDistanceFromCity(); ?></div>
                        <div class="clear"></div>
                    </div>
                    <?php	
					}
					?>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer">
        <div class="container"><span class="copy">&copy; 2014 Roomista.com | All rights reserved</span></div>
    </div>
    <!-- JavaScript -->
</body>
</html>