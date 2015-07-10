<?php
	class IP{
		/**
		* check the device and
		* get real IP
		* return IP or unknown or mobile
		*/
		public function realIP(){
			$ip = "unknown"; //catch the missed 1%
			if (stristr(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile') || stristr(strtolower($_SERVER['HTTP_USER_AGENT']), 'android')) { //check for mobile devices
				$ip = "mobile";
			}
			elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) { //check if IP is from shared Internet
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			}
			elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { //check if IP is passed from proxy
				$ip_array = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
				$ip = trim($ip_array[count($ip_array) - 1]);
			}
			elseif (!empty($_SERVER['REMOTE_ADDR'])) { //standard IP check
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			return $ip;
		}
	}
?>