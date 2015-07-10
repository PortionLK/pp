<?php
    class MainCity extends Illuminate\Database\Eloquent\Model {
		public $timestamps = false;

		//has many main cities
		public function categories(){
			return $this->belongsToMany('Category', 'category_main_city');
		}

		//has many sub cities
		public function subCities(){
			return $this->belongsToMany('SubCity', 'main_city_sub_city');
		}

		//has many hotels
		public function hotels(){
			return $this->belongsToMany('Hotel', 'main_city_hotel');
		}

    }
