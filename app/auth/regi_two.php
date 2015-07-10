<?php
    define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");

	$info_bag = [
		'first_name' => isset($_POST['firm_name']) ? $_POST['firm_name'] : '',
		'last_name' => isset($_POST['last_name']) ? $_POST['last_name'] : '',
		'address' => isset($_POST['address']) ? $_POST['address'] : '',
		'phone_fixed' => isset($_POST['phone_fixed']) ? $_POST['phone_fixed'] : '',
		'phone_mobile' => isset($_POST['phone_mobile']) ? $_POST['phone_mobile'] : '',
		'email' => isset($_POST['email']) ? $_POST['email'] : '',
		'password' => isset($_POST['password']) ? $_POST['password'] : '',
		'ip_address' => isset($_POST['ip_address']) ? $_POST['ip_address'] : '',
		'registered_date' => isset($_POST['registered_date']) ? $_POST['registered_date'] : '',
		'zip_code' => isset($_POST['zip_code']) ? $_POST['zip_code'] : '',
		'country' => isset($_POST['country']) ? $_POST['country'] : '',
		'passport_nic' => isset($_POST['passport_nic']) ? $_POST['passport_nic'] : '',
		'status' => isset($_POST['status']) ? $_POST['status'] : ''
	];
	print_r($info_bag);

	$member = new Member();
	$member->first_name = $info_bag['first_name'];
	$member->last_name = $info_bag['last_name'];
	$member->address = $info_bag['address'];
	$member->phone_fixed = $info_bag['phone_fixed'];
	$member->phone_mobile = $info_bag['phone_mobile'];
	$member->email = $info_bag['email'];
	$member->password = $info_bag['password'];
	$member->ip_address =  $info_bag['ip_address'];
	$member->registered_date =  $info_bag['registered_date'];
	$member->zip_code =  $info_bag['zip_code'];
	$member->country =  $info_bag['country'];
	$member->passport_nic =  $info_bag['passport_nic'];
	$member->status =  $info_bag['status'];
	$member->save();

?>