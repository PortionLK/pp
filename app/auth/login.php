<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");

	if(!isset($_POST['csrf']) || $_POST['csrf'] != 'e29a7dc6b05461dfb19942e4331666b9'){
		$_SESSION['logged_user'] = false;
		die(header('Location: ' . DOMAIN . 'login-attempt'));
	}else{
		$pw	= hash('sha512', $_POST['pswd']);
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$_SESSION['logged_user'] = false;
			$_SESSION['login_error'] = "Email and password doesn't match";
			die(header('Location: ' . DOMAIN . 'login-attempt'));
		}else{
			$email = $_POST['email'];
		}
		$member = new Member();
		$member = $member->where('email', '=', $email)->first();
		if(!$member){
			$_SESSION['logged_user'] = false;
			$_SESSION['login_error'] = "Email and password doesn't match";
			die(header('Location: ' . DOMAIN . 'login-attempt'));
		}else{
			$mempw = $member->password;
			unset($member->password);
			$member = $member->toArray();
			$user = [];
			foreach($member as $user_attrib => $user_value){
				$user[$user_attrib] = $user_value;
			}
			if($mempw == $pw){
				$_SESSION['logged_user'] = true;
				$_SESSION['user'] = $user;
				$path = DOMAIN . 'dashboard';
				//$path = (isset($_SESSION['page_url']) && ($_SESSION['page_url'] != DOMAIN . 'register')) ? $_SESSION['page_url'] : DOMAIN;
				die(header('Location: ' . $path));
			}else{
				$_SESSION['logged_user'] = false;
				$_SESSION['login_error'] = "Email and password doesn't match";
				die(header('Location: ' . DOMAIN . 'login-attempt'));
			}
		}
	}
?>