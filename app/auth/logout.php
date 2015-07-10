<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");

	if(!isset($_POST['csrf']) || $_POST['csrf'] != '93661628262a8a7eec4a61518f92bf8c'){
		$_SESSION['logged_user'] = (isset($_SESSION['logged_user']) && $_SESSION['logged_user'] == true) ?: false;
		die(header('Location: ' . $_SESSION['page_url']));
	}else{
		$_SESSION['logged_user'] = false;
		$_SESSION['login_success'] = "You have logged out.";
		die(header('Location: ' . HTTP_PATH . 'login-attempt'));
	}
?>