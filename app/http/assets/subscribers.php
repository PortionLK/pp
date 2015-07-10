<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");

	$path = isset($_SESSION['page_url']) ? $_SESSION['page_url'] : DOMAIN;

	if(!isset($_POST['csrf']) || $_POST['csrf'] != '2f2f6673aab0fa90d9992a67801046cf'){
		die(header('Location: ' . $path));
	}else{
		$subsEmail = $_POST['subscribe_email'];

		$subscriber = new Subscriber();
		$subscriber->subscriber = $subsEmail;
		$subscriber->save();

		$_SESSION['subscribe_success'] = 'Successfully added to our subscriber list.';
		die(header('Location: ' . $path));
	}
?>