<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");

	if(!isset($_POST['value']) || $_POST['value'] != '437d04d169b9b9a592f944802c6b3c39'){
		die('Try again.');
	}

	$string = isset($_POST['key']) ? $_POST['key'] : '';
	if(strlen($string) < 1){ die(false); }

	$quaries = ['c' => [], 'h' => [], 'd' => []];
	$objC = new SubCity();
	$list1 = $objC->where('name', 'like', '%' . $string . '%')
		->take(7)
		->get(['name']);
	foreach($list1 as $list1Val){
		$quaries['c'][] = $list1Val->name;
	}
	$objH = new Hotel();
	$list2 = $objH->where('name', 'like', '%' . $string . '%')->take(7)->get(['name']);
	foreach($list2 as $list2Val){
		$quaries['h'][] = $list2Val->name;
	}
	$objD = new Destination();
	$list3 = $objD->where('destination', 'like', '%' . $string . '%')
		->take(7)
		->get(['destination']);
	foreach($list3 as $list3Val){
		$quaries['d'][] = $list3Val->destination;
	}

	$quaries = json_encode($quaries);
	echo $quaries;
?>