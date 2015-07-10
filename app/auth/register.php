<?php
    define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");
	//$_SESSION['page_url'] = HTTP_PATH . 'register';
?>
<!DOCTYPE>
<html>
	<?php require_once(DOC_ROOT . 'includes/head.php'); ?>
<body>
	<div id="wrapper">
		<?php include(DOC_ROOT . 'includes/header.php'); ?>
		<div class="clearfix"></div>
		<div class="home_banner inner" style="background-image:url(<?php echo DOMAIN; ?>images/banner_home.jpg);">
			<div class="container"></div>
		</div>
		<div class="container">
			<!--register-form-codding-->
			<div class="col-xs-12 no-padding-xs">
				<div class="col-sm-6 col-md-6 no-padding-xs">
					<br><br><br>
					<h1>Register with roomista</h1>
					<p>The world embraces numerous vicinities that could colour your dreams with different shades. Find your paradise among those that would ease your mind off with freshest breeze and calm surroundings. Go and enjoy that experience that is worth a life time and would never leave your mind. Roomista is always by your side accompanying you with finding the best possible hotels that could indulge you during your voyage, so you won't miss your home for even a fraction of a second.</p>
					<h4>If you all ready have a roomista account login <a href="<?php echo DOMAIN; ?>login-attempt">here</a></h4>
				</div>
				<div class="col-sm-6 col-md-6 no-padding-x"sl>
					<div class="well">
						<h2 class="margin-top-0">Please Register <small>It's free and always will be.</small></h2>
						<hr>
						<form action="<?php echo DOMAIN; ?>register/step-01" method="post" name="member" id="member">
								<div class="row">
									<div class="form-group col-xs-12 col-md-6 col-sm-6">
										<label>First Name *</label>
										<input class="form-control" type="text" id="member_first_name" name="first_name" placeholder="First Name">
									</div>
									<div class="form-group col-xs-12 col-md-6 col-sm-6">
										<label>Last Name *</label>
										<input class="form-control" type="text" id="member_last_name" name="last_name" placeholder="Last Name" >
									</div>
								</div>

								<div class="form-group">
									<label>Email *</label>
									<input class="form-control" type="email" id="member_email" name="email" placeholder="Email" >
								</div>

								<div class="row">
									<div class="form-group col-xs-12 col-md-6 col-sm-6">
										<label>Password *</label>
										<input class="form-control" type="password" id="member_password" name="password" placeholder="Password" >
									</div>
									<div class="form-group col-xs-12 col-md-6 col-sm-6">
										<label>Confirm Password *</label>
										<input class="form-control" type="password" id="member_password_confirm" name="password_confirm" placeholder="Password" >
									</div>
								</div>
								<div class="checkbox">
									<label>
										By clicking <strong class="label label-primary">Register</strong>, you agree to the <a href="#" data-toggle="modal" data-target="#t_and_c_m">Terms and Conditions</a> set out by this site, including our Cookie Use.
									</label>
								</div>
								<div class="form-group">
									<button class="btn btn-primary" type="submit">Register</button>
								</div>
						</form>
					</div>
				</div>
				<!-- message view -->
				<div id="message" class=""></div>
				<!-- message view end -->
			</div>
			<!--end mid-sec-->
		</div>
	</div>
	<!--end content-->
	<?php include(DOC_ROOT . 'includes/footer.php'); ?>
	<div class="clear"></div>
</div>
<!--end wrapper-->
<div class="clear"></div>
<script src="<?php echo DOMAIN; ?>js/navigation.js"></script>
</body>
</html>
