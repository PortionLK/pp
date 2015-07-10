<?php
    class SubCity  extends Illuminate\Database\Eloquent\Model {
		public $timestamps = false;

		//has many main cities
		public function categories(){
			return $this->belongsToMany('Category', 'category_sub_city');
		}

		//has many sub cities
		public function mainCities(){
			return $this->belongsToMany('MainCity', 'main_city_sub_city');
		}

		//has many hotels
		public function hotels(){
			return $this->belongsToMany('Hotel', 'sub_city_hotel');
		}

    }
