<?php
	if(!isset($_SESSION['logged_user']) || $_SESSION['logged_user'] != true){
		$_SESSION['login_error'] = 'Please login to continue.';
		die(header('Location: ' . HTTP_PATH . 'login-attempt'));
	}
?>