<?php
    define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");

	$info_bag = [
		'first_name' => isset($_POST['first_name']) ? $_POST['first_name'] : '',
		'last_name' => isset($_POST['last_name']) ? $_POST['last_name'] : '',
		'email' => isset($_POST['email']) ? $_POST['email'] : '',
		'password' => isset($_POST['password']) ? $_POST['password'] : ''
	];

	//returns the real ip address of a user (really?)
	$ip = new IP();
	$ip = $ip->realIP();

	$member = new Member();
	$prevNoob = $member->where('email', '=', $info_bag['email'])->first();
	if($prevNoob){
		$prevNoob->first_name = $info_bag['first_name'];
		$prevNoob->last_name = $info_bag['last_name'];
		$prevNoob->email = $info_bag['email'];
		$prevNoob->password = hash('sha512', $info_bag['password']);
		$prevNoob->ip_address =  $ip;
		$prevNoob->registered_date =  date('Y-m-d');
		$prevNoob->status =  0;
		$prevNoob->has_hotels = 1;
		$prevNoob->save();
		$nId = $prevNoob->id;
	}else{
		$member->first_name = $info_bag['first_name'];
		$member->last_name = $info_bag['last_name'];
		$member->email = $info_bag['email'];
		$member->password = hash('sha512', $info_bag['password']);
		$member->ip_address =  $ip;
		$member->registered_date =  date('Y-m-d');
		$member->status =  0;
		$member->has_hotels = 1;
		$member->save();
		$nId = $member->id;
	}

	$noob = new Member();
	$noob = $noob->find($nId);

	unset($noob->password);
	$noob = $noob->toArray();
	$user = [];
	foreach($noob as $user_attrib => $user_value){
		$user[$user_attrib] = $user_value;
	}
	$_SESSION['logged_user'] = true;
	$_SESSION['user'] = $user;

	$email = new Email();
	$message = $email->template(
		'register',
		[
			'title' => '',
			'firstName' => $info_bag['first_name'],
			'lastName' => $info_bag['last_name'],
			'link' => 'http://roomista.com/login-attempt'
		]
	);

	$mail = new PHPMailer();
	$s = new SMTP();
	$s->setTimeout(60);

	//$mail->SMTPDebug = 3;                   // Enable verbose debug output

	$mail->isSMTP();                        // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';			// Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                 // Enable SMTP authentication
	$mail->Username = 'booking@roomista.com'; // SMTP username
	$mail->Password = 'ubU*u5RT';     // SMTP password
	$mail->SMTPSecure = 'tls';              // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                      // TCP port to connect to

	$mail->From = 'support@roomista.com';
	$mail->FromName = 'Roomista';
	$mail->addAddress('janaka@weblook.com', "Roomista");    // Add a recipient
	$mail->addAddress($info_bag['email'], $info_bag['first_name']);    // Add a recipient
	$mail->addReplyTo('info@roomista.com', 'Information');
	//$mail->addCC('cc@roomista.com');
	//$mail->addBCC('bcc@roomista.com');

	/* $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name */
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = 'Welcome to roomista!';
	$mail->Body    = $message;
	//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	$mail->WordWrap = 50; // set word wrap

	if(!$mail->send()) {
		$_SESSION['register_error'] = "There was an error with sending an email";
	} else {
		$_SESSION['register_success'] = 'We have sent an email with your registration details, please check your email.';
	}

	$path = DOMAIN . 'dashboard';
	//$path = (isset($_SESSION['page_url']) && ($_SESSION['page_url'] != DOMAIN . 'register')) ? $_SESSION['page_url'] : DOMAIN . 'dashboard';
	die(header('Location: ' . $path));
?>