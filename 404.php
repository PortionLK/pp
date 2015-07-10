<?php
define('_MEXEC', 'OK');
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");
?>

<!DOCTYPE html>
<html>
<head>
<title>404 Error</title>
<link rel="stylesheet" type="text/css" href="<?php echo HTTP_PATH; ?>css/404.css">
</head>
<body>

<div class="stage">
	<div class="cloud" id="cloud">
		<div class="plane" id="plane"></div>
	</div>
</div>

<div class="container">
	<h1>Looks like you are flying in a wrong way or the hotel you are looking for is just has been stopped their services.</h1>
	<a href="<?php echo HTTP_PATH; ?>" class="btn btn-border">Go back to home page</a>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="<?php echo HTTP_PATH; ?>js/jquery.spritely.js"></script>
<script>
$(function() {
    $('#cloud').pan({
        fps: 30,
        speed: 2,
        dir: 'left'
    });
    $('#plane').sprite({
        fps: 60,
        no_of_frames: 1
    }).spRandom({
        top: 30,
        bottom: 60,
        left: 30,
        right: 60
    })
})
</script>
</body>
</html>