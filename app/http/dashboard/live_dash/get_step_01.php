<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/auth.php");
	
	if(!isset($_POST['csrf']) || $_POST['csrf'] != 'd1c4ed87775fffbab3acc36170b0cf2d'){
		die(header('Location: ' . $_SESSION['page_url']));
	}else{
		$hotelName = $_POST['hotelName'];
		$lat = $_POST['lat'];
		$lng = $_POST['lng'];
		$formattedAddr = $_POST['formatted_address'];
		$accommodationType = $_POST['accommodationType'];
		$starRating = $_POST['starRating'];
		$streetAddress = $_POST['streetAddress'];
		$mCityId = $_POST['mainCity'];
		$sCityId = $_POST['subCityId'];
		$postalCode = $_POST['postalCode'];
		$phone = $_POST['phone'];
		$fax = $_POST['fax'];
		$email = $_POST['email'];
		$websiteUrl = explode('http://', $_POST['websiteUrl']);
		$websiteUrl = array_pop($websiteUrl);
		$seoUrl = $_POST['seoUrl'];
		$hotel_description = $_POST['hotel_description'];

		$mainCity = new MainCity();
		$hotel = new Hotel();
		$categoryHotel = new CategoryHotel();
		$mainCityHotel = new MainCityHotel();

		if(isset($_SESSION['editing_hotel']) && strlen($_SESSION['editing_hotel']) > 0){
			$hotel = $hotel->find($_SESSION['editing_hotel']);
		}

		$memberId = $hotel->member_id;
		if($memberId != $_SESSION['user']['id']){
			die(header('Location: ' . DOMAIN . '404'));
		}

		$hotel->member_id = $_SESSION['user']['id'];
		$hotel->country_id = 195;
		$hotel->main_city_id = $mCityId;
		$hotel->sub_city_id = $sCityId;
		$hotel->name = $hotelName;
		$hotel->street_address = $streetAddress;
		$hotel->postal_code = $postalCode;
		$hotel->phone = $phone;
		$hotel->fax = $fax;
		$hotel->email = $email;
		$hotel->web_url = $websiteUrl;
		$hotel->star_rating = $starRating;
		$hotel->active_status = 0;
		$hotel->seo_url = $seoUrl;
		$hotel->hotel_hits = $seoUrl;
		$hotel->position = 0;
		$hotel->is_featured = 0;
		$hotel->latitude = $lat;
		$hotel->longitude = $lng;
		$hotel->map_location = $formattedAddr;
		$hotel->description = $hotel_description;
		$hotel->save();

		$hotel_id = $_SESSION['editing_hotel'] = $hotel->id;

		$coverPhoto = $_FILES['hotel_coverphoto'];
		$images = $coverPhoto['name'];
		$prefix = hash('md5', $hotel_id);
		$uploadDir = DOC_ROOT . 'uploads/hotel-cover-photos/';
		$coverPhotoArr = [];

		foreach($images as $iK => $image){
			$nIType = $roomImages['type'][$iK];
			$nIType = explode('/', $nIType);
			$nIType1 = $nIType[0];
			$nIType2 = $nIType[1];
			if($nIType1 == 'image'){
				if($nIType2 == 'jpeg' || $nIType2 == 'pjpeg'){ $ext = '.jpg'; }
				else if($nIType2 == 'png'){ $ext = '.png'; }
				else{ $ext = '.noExt_'; }
				$nITemp = $roomImages['tmp_name'][$iK];
				$newName = $prefix . '_' . md5(time() . rand(111111111,999999999));
				$newName .= '_' . md5(time() . rand(111111111,999999999));
				$newName .= $ext;
				if(move_uploaded_file($nITemp, $uploadDir . $newName)){
					$coverPhotoArr[] = $newName;
				}
			}
		}

		$coverPhotosToSave = implode(',', $coverPhotoArr);
		if(isset($hotel->cover_photo) && strlen($hotel->cover_photo) > 0){
			$coverPhotosToRemove = explode(',', $hotel->cover_photo);
			foreach($coverPhotosToRemove as $toRemove){
				unlink(DOC_ROOT . 'uploads/hotel-cover-photos/' . $toRemove);
			}
		}
		$hotel->cover_photo = $coverPhotosToSave;
		$hotel->save();

		$mainCityHotel->main_city_id = $mCityId;
		$mainCityHotel->hotel_id = $hotel->id;
		$mainCityHotel->save();

		foreach($accommodationType as $aType){
			$categoryHotel->category_id = $aType;
			$categoryHotel->hotel_id = $hotel->id;
			$categoryHotel->save();
		}

		$_SESSION['step_01_completed'] = true;
		die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-02'));
	}
?>