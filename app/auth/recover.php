<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");
	$_SESSION['page_url'] = HTTP_PATH . 'recover';

	if(isset($_SESSION['recover_attempts']) && ($_SESSION['recover_attempts'] < 0)){
		die('You have used more than allowed attempts, please check back later');
	}else{
		if(isset($_POST['csrf']) && $_POST['csrf'] == '1de29af8729988c0673bb08e3bbe2b0c'){
			if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				$email = $_POST['email'];
				$member = new Member();
				$member = $member->where('email', '=', $email)->first();
				if(count($member)){
					$recovery_code = hash('sha256', rand(1111111111,9999999999));
					$member->recovery_code = $recovery_code;
					$member->save();

					$email = new Email();
					$message = $email->template(
						'recover',
						[
							'title' => 'Mr.',
							'firstName' => 'Janaka',
							'lastName' => 'Rajapaksha',
							'link' => 'http://tester.com'
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
					//$mail->addAddress('ellen@example.com');              			 // Name is optional
					$mail->addReplyTo('info@roomista.com', 'Information');
					//$mail->addCC('cc@roomista.com');
					//$mail->addBCC('bcc@roomista.com');

					/* $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
					$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name */
					$mail->isHTML(true);                                  // Set email format to HTML

					$mail->Subject = 'Here is the subject';
					$mail->Body    = $message;
					//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
					$mail->WordWrap = 50; // set word wrap

					if(!$mail->send()) {
						$_SESSION['recover_error'] = "There was an error with your submission. Please try again, you have " . $_SESSION['recover_attempts'] . " more attempt(s)." . $mail->ErrorInfo;
					} else {
						$_SESSION['recover_success'] = 'We have sent an email with recovery details, please check your email.';
						die(header('Location: ' . $_SESSION['page_url']));
					}
				}else{
					$_SESSION['recover_attempts'] -= 1;
					$_SESSION['logged_user'] = false;
					$_SESSION['recover_error'] = "There was an error with your submission. Please try again, you have " . $_SESSION['recover_attempts'] . " more attempt(s).";
					die(header('Location: ' . HTTP_PATH . 'recover'));
				}
			}else{
				$_SESSION['recover_attempts'] -= 1;
				$_SESSION['logged_user'] = false;
				$_SESSION['recover_error'] = "There was an error with your submission. Please try again, you have " . $_SESSION['recover_attempts'] . " more attempt(s).";
				die(header('Location: ' . HTTP_PATH . 'recover'));
			}
		}else{
			$_SESSION['recover_attempts'] = isset($_SESSION['recover_attempts']) ? $_SESSION['recover_attempts'] : 5;
		}
	}
?>
<!DOCTYPE>
<html>
	<?php require_once(DOC_ROOT . 'includes/head.php'); ?>
<body>
	<div id="wrapper">
		<?php include(DOC_ROOT . 'includes/header.php'); ?>
		<div class="home_banner inner" style="background-image:url(<?php echo HTTP_PATH; ?>images/banner_home.jpg);">
			<div class="container"></div>
		</div>
		<div class="container">
			<div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2 login-attempt">
				<div class="panel panel-default">
					<div class="panel-body">
					<h2 class="h4 w_700">Recover password</h2>
						<?php if(isset($_SESSION['recover_error']) && (strlen($_SESSION['recover_error']) > 0)){ ?>
						<div class="alert alert-danger"><?php echo $_SESSION['recover_error']; ?></div>
						<?php $_SESSION['recover_error'] = ''; } ?>
						<?php if(isset($_SESSION['recover_success']) && (strlen($_SESSION['recover_success']) > 0)){ ?>
						<div class="alert alert-success"><?php echo $_SESSION['recover_success']; ?></div>
						<?php $_SESSION['recover_success'] = ''; } ?>
						<div class="col-xs-12 col-md-8 col-sm-12 col-md-offset-2 ">
						<form class="form" role="form" method="post" action="<?php echo HTTP_PATH; ?>recover" accept-charset="UTF-8" id="login-nav">
							<input type="hidden" name="csrf" value="1de29af8729988c0673bb08e3bbe2b0c">
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" class="form-control" name="email" placeholder="Email address">
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary">Change password</button> 
								<span>or Create a <a href="<?php echo HTTP_PATH?>register/"><strong>new account</strong></a>
							</span>
							</div>
							<div class="clearfix"></div>
						</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include(DOC_ROOT . 'includes/footer.php'); ?>
	</div>
	<script src="<?php echo HTTP_PATH; ?>js/navigation.js"></script>
	<script src="<?php echo HTTP_PATH; ?>js/main.js"></script>
</body>
</html>