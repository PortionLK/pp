<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");
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
				<h1>&nbsp;</h1>
				<div class="panel panel-default">
					<div class="panel-body">
					<h2 class="h4 w_700">Login to roomista</h2>
						<?php if(isset($_SESSION['login_error']) && (strlen($_SESSION['login_error']) > 0)){ ?>
						<div class="alert alert-danger"><?php echo $_SESSION['login_error']; ?></div>
						<?php $_SESSION['login_error'] = ''; } ?>
						<?php if(isset($_SESSION['login_success']) && (strlen($_SESSION['login_success']) > 0)){ ?>
						<div class="alert alert-success"><?php echo $_SESSION['login_success']; ?></div>
						<?php $_SESSION['login_success'] = ''; } ?>
						<div class="col-xs-12 col-md-8 col-sm-12 col-md-offset-2 ">
						<form class="form" role="form" method="post" action="<?php echo HTTP_PATH; ?>login" accept-charset="UTF-8" id="login-nav">
							<input type="hidden" name="csrf" value="e29a7dc6b05461dfb19942e4331666b9">
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" class="form-control" name="email" placeholder="Email address">
							</div>
							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" class="form-control" name="pswd" placeholder="Password">
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary">Sign in</button> 
								<span>or Create a <a href="<?php echo HTTP_PATH?>register/"><strong>new account</strong></a>
							</span>
							</div>
							<p>
								<a href="<?php echo HTTP_PATH?>recover/">Forgot your Password?</a> 
							</p>
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
</body>
</html>