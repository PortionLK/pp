<?php
    class Email{
        public function template($file, $infoBag = [])
        {
			$template = DOC_ROOT . 'templates/emails/' . $file . '.php';
			$fd = fopen($template, "r");
			$message = fread($fd, filesize($template));
			foreach($infoBag as $pin => $point){
				$message = str_replace('{'.$pin.'}', $point, $message);
			}
			fclose($fd);
			return $message;
        }
    }
