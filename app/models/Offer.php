<?php
	class Offer extends  Illuminate\Database\Eloquent\Model {
		public $timestamps = false;
	
		public function validOffers($from, $to, $room_type, $bed, $meal, $no_of_rooms)
		{
			$off_array = array();
			$offerAvailable = false;
			$customOffer = false;
			$custom_cus_array=array();
			$custom_cus_array1=array();
			$tot_pay = 0;
			$tot_pay_lkr = 0;
			$offerAmount = 0;
			$tot_pay = Sessions::getOnlinePaymentRate();
			$discount_fixed = 0;
			$discount_percentage = 0;
			$discount_freeN = 0;
			$discount_price = 0;
			$discounted_total=0;
			$discounted_total_lkr=0;
			$custom = '';

			$from = date('Y-m-d', strtotime($from));
			$to = date('Y-m-d', strtotime($to));

			$startTime = strtotime($from);
			$endTime = strtotime($to);
			$numDays = round(($endTime - $startTime) / 86400);

			//get offers between from and to dates  - check if any rooms available to date range
			$this->setFromDate($from);
			$this->setToDate($to);
			$this->setRoomType($room_type);
			$off_data = $this->getOffersToDates(); //checking if any
			for ($x = 0; $x < count($off_data); $x++) {
				$this->extractor($off_data, $x);
				$f_id = $this->id();
				$f_from = $this->fromDate();
				$f_to = $this->toDate();
				$f_type = $this->disType();
				$f_validity = $this->dateValidity();
				$f_min_n = $this->minNights();
				$f_free_n = $this->freeNights();
				$f_roomtype = $this->roomType();
				$f_bedtype = $this->bedType();
				$f_mealtype = $this->mealType();
				$f_amount = $this->amount();

				$room_list = array_filter(explode(':', $f_roomtype));
				$bed_list = array_filter(explode(':', $f_bedtype));
				$meal_list = array_filter(explode(':', $f_mealtype));


				if (in_array($room_type, $room_list)) { //check room type availabe in offer
					if ((($f_bedtype == "") || (in_array($bed, $bed_list))) && (($f_mealtype == "") || (in_array($meal, $meal_list)))) {
						//$off_array[] = $f_id;
						$out_date = $f_min_n + $f_free_n;
						$offer_start_date = strtotime($f_from);
						$startTime = strtotime($from);
						$offer_end_date = strtotime($f_to);
						$endTime = strtotime($to);
						if ($offer_start_date >= $startTime) {
							$my_start_date = $f_from;
						} else {
							$my_start_date = $from;
						}
						if ($offer_end_date >= $endTime) {
							$my_end_date = $to;
						} else {
							$my_end_date = $f_to;
						}
						//Fixed
						if ($this->disType() == "0") {
							$normal_rate = 0;
							$offer_rate = 0;
							if ((($f_min_n != "0" || $f_min_n != "") && $numDays >= $f_min_n) || $f_min_n == "0" || $f_min_n == "") {
								$allotment = new HotelRoomRates();
								$dates_array = $allotment->getDatesBetween2Dates($from, $to);
								$dates_arrayOffer = $allotment->getDatesBetween2DatesOffer($my_start_date, $my_end_date);
								for ($y = 0; $y < count($dates_array); $y++) {
									if (in_array($dates_array[$y], $dates_arrayOffer)) {
										$rate = new HotelRoomRates();
										$rate->setHotelRoomTypeId($room_type);
										$rate_data = $rate->getRoomRatesForDatesAndRoomId($dates_array[$y], $bed, $meal);
										$normal_rate += $rate_data;
										$offer_rate += $f_amount;
									}
								}
								if ($f_validity == "on") {
									$discount_fixed = ($tot_pay - ($normal_rate * $no_of_rooms)) + ($offer_rate * $no_of_rooms);
								} else {
									$discount_fixed = count($dates_array) * ($f_amount * $no_of_rooms);
								}
								//Convert Currency
								if ($_SESSION['display_rate_in'] == "LKR") {
									$discount_fixed = Common::currencyConvert("USD", $_SESSION['display_rate_in'], $discount_fixed);
								} else {
									$discount_fixed = $discount_fixed;
								}
								if ($discount_fixed > 0) {
									$offerAvailable = true;
								}
								$offerAmount = $discount_fixed;
							}
						}
						//Percentage
						if ($this->disType() == "1") {
							$normal_rate = 0;
							$offer_rate = 0;
							if ((($f_min_n != "0" || $f_min_n != "") && $numDays >= $f_min_n) || $f_min_n == "0" || $f_min_n == "") {
								$allotment = new HotelRoomRates();
								if ($f_validity == "on") {
									$dates_array = $allotment->getDatesBetween2Dates($from, $to);
									$dates_arrayOffer = $allotment->getDatesBetween2DatesOffer($my_start_date, $my_end_date);
									for ($y = 0; $y < count($dates_array); $y++) {
										if (in_array($dates_array[$y], $dates_arrayOffer)) {
											$rate = new HotelRoomRates();
											$rate->setHotelRoomTypeId($room_type);
											$rate_data = $rate->getRoomRatesForDatesAndRoomId($dates_array[$y], $bed, $meal);
											$normal_rate += $rate_data;
										}
									}

									if ($_SESSION['display_rate_in'] == "LKR") {
										$normal_rate = Common::currencyConvert("USD", $_SESSION['display_rate_in'], $normal_rate);
									}

									$offer_rate = ($normal_rate - (($normal_rate * ($f_amount / 100)) * $no_of_rooms));
									$discount_percentage = ($tot_pay - $normal_rate) + $offer_rate;
								} else {
									//ori: $discount_percentage = $tot_pay - ($tot_pay * ($f_amount / 100));
									$dates_array = $allotment->getDatesBetween2Dates($from, $to);
									for ($y = 0; $y < count($dates_array); $y++) {
										$rate = new HotelRoomRates();
										$rate->setHotelRoomTypeId($room_type);
										$rate_data = $rate->getRoomRatesForDatesAndRoomId($dates_array[$y], $bed, $meal);
										$normal_rate += $rate_data;
									}
									if ($_SESSION['display_rate_in'] == "LKR") {
										$normal_rate = Common::currencyConvert("USD", $_SESSION['display_rate_in'], $normal_rate);
									}
									$discount_percentage = $tot_pay - (($normal_rate * ($f_amount / 100)) * $no_of_rooms);
								}
								//Convert Currency
	//                            if ($_SESSION['display_rate_in'] == "LKR") {
	//                                $discount_percentage = $discount_percentage;
	//                            } else {
	//                                $discount_percentage = Common::currencyConvert("LKR", $_SESSION['display_rate_in'], $discount_percentage);
	//                            }
								if ($discount_percentage > 0) {
									$offerAvailable = true;
								}
								$offerAmount = $discount_percentage;
							}
						}
						//Free Nights
						if ($this->disType() == "2") {
							if ($numDays >= $f_min_n) {
								$allotment = new HotelRoomRates();
								$dates_array = $allotment->getDatesBetween2DatesOffer($my_start_date, $my_end_date);
								for ($y = 0; $y < count($dates_array); $y++) {
									//if (($y >= $f_min_n) && ($y < $out_date)) {
									if (($y > $f_min_n) && ($y <= $out_date)) {
										$rate = new HotelRoomRates();
										$rate->setHotelRoomTypeId($room_type);
										$rate_data = $rate->getRoomRatesForDatesAndRoomId($dates_array[$y], $bed, $meal);
										$discount_freeN += $rate_data;
									}
								}
							}
							//Convert Currency
							if ($_SESSION['display_rate_in'] == "LKR") {
								$discount_freeN = Common::currencyConvert("USD", $_SESSION['display_rate_in'], $discount_freeN);
							} else {
								$discount_freeN = $discount_freeN;
							}
							if ($discount_freeN > 0) {
								$offerAvailable = true;
							}
							$offerAmount = $tot_pay - ($discount_freeN * $no_of_rooms);
						}
						//Custom
						if ($this->disType() == "3") {
	//                        $custom = $this->des(); //if appilicable with custom other offers :)
	//                        if ($custom != "") {
	//                            $customOffer = true;
	//                            $offerAvailable = true;

							if ($f_validity == "on") { //if appilicable with custom other offers :)
								$custom_cus_array[] = array("id" => $this->id(), "title" => $this->title(), "des" => $this->des());
							} else {
								$c = 1;
								if ($c == 1) {
									$custom_cus_array1[] = array("id" => $this->id(), "title" => $this->title(), "des" => $this->des());
									$c++;
								}
							}
							$customOffer = true;
	//                        $offerAvailable = true;
						}
					}
				} else {
					//echo "no offers available";
					$offerAvailable = false;
				}
				if ($offerAmount != "") {
					$offerAmtArray[$f_id] = $offerAmount;
				}
			}
	//        if($customOffer==true){
	//            $entitled_offer
	//        }else{
	//            $entitled_offer
	//        }
			$entitled_offer = array_search(min($offerAmtArray), $offerAmtArray);
			$this->setId($entitled_offer);
			$data = $this->getById();
			$this->extractor($data);
			$offer_title=$this->title();
			$description = $this->des();
			if (empty($offerAmtArray)) { //if you only have custom offers
				$custom_array = array_merge($custom_cus_array, $custom_cus_array1);
				//$discount_price = $tot_pay - min($offerAmtArray);
			} else { //if you found good offers :) -- adding on custom offers to thta
				$custom_array = $custom_cus_array;
				//$discount_price = $tot_pay - min($offerAmtArray);
				$discount_price = min($offerAmtArray);
			}
			$discounted_total=min($offerAmtArray);
			//$discounted_total=$tot_pay - min($offerAmtArray);

	//        $tot_pay_lkr = Common::currencyConvert("USD", "LKR", $tot_pay);
	//        $discounted_total_lkr = Common::currencyConvert("USD", "LKR", $discounted_total);

			if ($_SESSION['display_rate_in'] == "LKR") {
				$tot_pay_lkr = $tot_pay;
			} else {
				$tot_pay_lkr = $tot_pay;
			}

			if ($_SESSION['display_rate_in'] == "LKR") {
				$discounted_total_lkr = $discounted_total;
			} else {
				$discounted_total_lkr = $discounted_total; //Common::currencyConvert($_SESSION['display_rate_in'], "LKR", $discounted_total);
			}


			$off_array = array("Total" => $tot_pay, "TotalLKR" => $tot_pay_lkr, "OfferAvailable" => $offerAvailable, "CustomOffer" => $customOffer, "DiscountedTotal" => $discounted_total, "DiscountedTotalLKR" => $discounted_total_lkr, "Discount" => $discount_price, "CurrencyType" => $_SESSION['display_rate_in'], "offer_id" => $entitled_offer, "Title" => $offer_title, "Description" => $description, "Custom" => $custom_array);
			if($offerAvailable==true || $customOffer==true ){
				Sessions::setOnlinePaymentOffer(urlencode(serialize($off_array)));
				if($customOffer==false) {
					if ($_SESSION['display_rate_in'] == "LKR") {
						Sessions::setOnlinePaymentRate($discounted_total_lkr);
					} else {
						Sessions::setOnlinePaymentRate($discounted_total);
					}
				}else{
					if ($_SESSION['display_rate_in'] == "LKR") {
						Sessions::setOnlinePaymentRate($tot_pay_lkr);
					}else if($customOffer==true){
						Sessions::setOnlinePaymentRate($tot_pay);
					}
				}
			}else {
				Sessions::resetOnlinePaymentOffer();
				if ($_SESSION['display_rate_in'] == "LKR") {
					Sessions::setOnlinePaymentRate($tot_pay_lkr);
				}else{
					Sessions::setOnlinePaymentRate($tot_pay);
				}
			}
			return $off_array;
		}
	}
