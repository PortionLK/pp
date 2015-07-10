<?php
	define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");
	if(!isset($_GET['stage']) || !is_numeric($_GET['stage'])){
		die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-01'));
	}

	$stage = intval($_GET['stage']);
	$stage = sprintf("%02d", $stage);
    require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/auth.php");
	$_SESSION['page_url'] = DOMAIN . "dashboard/add-hotel/step-$stage";
?>
<!DOCTYPE>
<html>
	<?php require_once(DOC_ROOT . 'includes/head.php'); ?>
<body>
<div id="wrapper">
	<?php include(DOC_ROOT . 'includes/header.php'); ?>
	<div class="home_banner inner" style="background-image:url(<?php echo DOMAIN; ?>/images/banner_home.jpg);">
		<div class="container"></div>
	</div>
	<div class="container">
		<div class="container-fluid main-container">
            <?php require_once(DOC_ROOT . 'includes/dashboard_left.php'); ?>

			<div class="col-md-9 col-sm-12 col-xs-12 content no-padding-sm no-padding-xs">
				<div class="steps-for-form">
					<ul class="nav nav-pills">
						<li role="presentation" class="<?php echo (isset($_SESSION['step_01_completed']) && $_SESSION['step_01_completed'] == true) ? 'active' : 'disabled'; ?>"><a href="<?php echo DOMAIN . 'dashboard/add-hotel/step-01'; ?>"><i class="fa fa-check-circle-o"></i> 01</a></li>
						<li role="presentation" class="<?php echo (isset($_SESSION['step_02_completed']) && $_SESSION['step_02_completed'] == true) ? 'active' : 'disabled'; ?>"><a href="<?php echo DOMAIN . 'dashboard/add-hotel/step-02'; ?>"><i class="fa fa-check-circle-o"></i> 02</a></li>
						<li role="presentation" class="<?php echo (isset($_SESSION['step_03_completed']) && $_SESSION['step_03_completed'] == true) ? 'active' : 'disabled'; ?>"><a href="<?php echo DOMAIN . 'dashboard/add-hotel/step-03'; ?>"><i class="fa fa-check-circle-o"></i> 03</a></li>
						<li role="presentation" class="<?php echo (isset($_SESSION['step_04_completed']) && $_SESSION['step_04_completed'] == true) ? 'active' : 'disabled'; ?>"><a href="<?php echo DOMAIN . 'dashboard/add-hotel/step-04'; ?>"><i class="fa fa-check-circle-o"></i> 04</a></li>
						<li role="presentation" class="<?php echo (isset($_SESSION['step_05_completed']) && $_SESSION['step_05_completed'] == true) ? 'active' : 'disabled'; ?>"><a href="<?php echo DOMAIN . 'dashboard/add-hotel/step-05'; ?>"><i class="fa fa-check-circle-o"></i> 05</a></li>
						<li role="presentation" class="<?php echo (isset($_SESSION['step_06_completed']) && $_SESSION['step_06_completed'] == true) ? 'active' : 'disabled'; ?>"><a href="<?php echo DOMAIN . 'dashboard/add-hotel/step-06'; ?>"><i class="fa fa-check-circle-o"></i> 06</a></li>
					</ul>
				</div>
				<?php
					$_SESSION['step_01_completed'] = true;
					$_SESSION['step_02_completed'] = true;
					$_SESSION['step_03_completed'] = true;
					$_SESSION['step_04_completed'] = true;
					$_SESSION['step_05_completed'] = true;
					$_SESSION['step_06_completed'] = true;
					$stepForm = DOC_ROOT . "app/http/dashboard/step_$stage.php";
					if(file_exists($stepForm)){
						require_once($stepForm);
					}else{
						die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-01'));
					}
				?>
            </div>
		</div>
	</div>
	<?php include(DOC_ROOT . 'includes/footer.php'); ?>
</div>

<script>
$(function(){
    $('.side-menu-container>.navbar-nav>li>a').click(function(){
        var collapsId = $(this).attr('href');
        $('.collapse').not(collapsId).removeClass('in');
        $('.collapse').not(collapsId).attr('aria-expanded', 'false');
        $('.collapse').not(collapsId).animate('height', 0);
        $('.side-menu-container>.navbar-nav>li>a').not(this).addClass('collapsed');
        $('.side-menu-container>.navbar-nav>li>a').not(this).attr('aria-expanded', 'false');
    })
});
</script>

<script src="http://maps.googleapis.com/maps/api/js?sensor=true&amp;libraries=places"></script>
<script src="<?php echo HTTP_PATH; ?>js/jquery.geocomplete.js"></script>
<script src="<?php echo HTTP_PATH; ?>js/chosen.jquery.min.js"></script>

<script type="text/javascript">
  $(function(){

	$('.chosen-select').chosen();

	$("#geocomplete").geocomplete({
		map: ".map_canvas",
		details: "form",
		markerOptions: {
			draggable: true
		},
		location: <?php if(isset($hotel->latitude) && isset($hotel->longitude) && (strlen($hotel->latitude) > 1) && (strlen($hotel->longitude) > 1)){ echo '["' . $hotel->latitude . '", "' . $hotel->longitude . '"]'; }else if(isset($hotel->map_location) && (strlen($hotel->map_location) > 1)){ echo '"' . $hotel->map_location . '"'; }else{ echo '"Colombo"'; } ?>
	});

	$("#geocomplete").bind("geocode:dragged", function(event, latLng){
	  $("input[name=lat]").val(latLng.lat());
	  $("input[name=lng]").val(latLng.lng());
	  $("#reset").show();
	});

	$("#find").click(function(){
	  $("#geocomplete").trigger("geocode");
	}).click();

	$('.selectFilters').on('change', function(){
		var key = $(this).val();
		var apply = $(this).attr('child');
		var method = $(this).attr('mthod');
		var child = $('#'+apply);
		child.html('');

		var request = $.ajax({
			url: '/dashboard/get_value_list.php',
			method: "POST",
			data: {filter: key, method: method}
		});
		request.done(function(msg){
			child.html(msg);
			$('.chosen-select').chosen();
			$('.chosen-select').trigger("chosen:updated");
		});
		request.fail(function(jqXHR, textStatus) {
			alert("Request failed: " + textStatus);
		});
	});

	$('.chosen-select').trigger("chosen:updated");

});
</script>

</body>
</html>