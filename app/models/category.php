<?php
	class Category extends Illuminate\Database\Eloquent\Model {
		public $timestamps = false;

		//has many main cities
		public function mainCities(){
			return $this->belongsToMany('MainCity', 'category_main_city');
		}

		//has many sub cities
		public function subCities(){
			return $this->belongsToMany('SubCity', 'category_sub_city');
		}

		//has many hotels
		public function hotels(){
			return $this->belongsToMany('Hotel', 'category_hotel');
		}

    }
