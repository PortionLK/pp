<?php
    class Hotel extends Illuminate\Database\Eloquent\Model {
		public $timestamps = false;

		//belongs to a category
		public function category(){
			return $this->belongsToMany('Category', 'category_hotel');
		}

		//belongs to a main city
		public function mainCity(){
			return $this->belongsToMany('MainCity', 'main_city_hotel');
		}

		//belongs to a sub city
		public function subCity(){
			return $this->belongsTo('SubCity', 'sub_city_hotel');
		}

		//has many hotels
		public function hotels(){
			return $this->hasMany('Hotel', 'sub_city_hotel');
		}

		//has many rooms
		public function rooms(){
			return $this->hasMany('Room');
		}

    }
