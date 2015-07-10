<?php 
    define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");

	if(!isset($_GET['seo_url']) && (strlen($_GET['seo_url']) < 1)){ die(header('Location: ' . DOMAIN . '404')); }
    $_SESSION['page_url'] = ($_GET['page_url']) ? DOMAIN . $_GET['page_url'] : DOMAIN;
	$seo_url = $_GET['seo_url'];
    $hotel = new Hotel();
    $hotel = $hotel->where('seo_url', '=', $seo_url)->first();
?>
<!DOCTYPE html>
<html>
<?php require_once(DOC_ROOT . 'includes/head.php'); ?>
<body onload="">
<div id="wrapper">
    <?php include(DOC_ROOT . 'includes/header_hotel.php'); ?>

    <div class="container">
        <div id="map-canvas" class="col-xs-12 col-sm-12 col-md-8 map-canvas-direction"></div>
        <div id="directions-panel" class="col-xs-12 col-sm-12 col-md-4 directions-panel"></div>
    </div>

</div>
<footer>
    <?php include(DOC_ROOT . "includes/footer_hotel.php"); ?>
</footer>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFGJsLtiBL7Cr1yqSl9Std8Er3leUn_bE"></script>
<script>

var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;
var geocoder;

function initialize(endPosLat, endPosLng) {
    directionsDisplay = new google.maps.DirectionsRenderer();
    var mapOptions = {
        zoom: 16
    };
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    directionsDisplay.setMap(map);
    geocoder = new google.maps.Geocoder();

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var posLatLng = String(position.coords.latitude+', '+position.coords.longitude);
            var endPos = String(endPosLat+', '+endPosLng);
            calcRoute(posLatLng, endPos);

            var origins = new google.maps.LatLng(position.coords.latitude,position.coords.longitude); 
            var destinations = new google.maps.LatLng(endPosLat, endPosLng);

            calculateDistances(origins, destinations);
            map.setCenter(origins);

        }, function() {
            handleNoGeolocation(true);
        });
    } else {
        handleNoGeolocation(false);
    }
}

function handleNoGeolocation(errorFlag) {
    if (errorFlag) {
        var content = 'Error: The Geolocation service failed.';
    } else {
        var content = 'Error: Your browser doesn\'t support geolocation.';
    }

    var options = {
        map: map,
        position: new google.maps.LatLng(60, 105),
        content: content
    };

    var infowindow = new google.maps.InfoWindow(options);
    map.setCenter(options.position);
}

function calcRoute(posLatLng, endPos) {

    var start = posLatLng;
    var end = endPos;
    var request = {
        origin: start,
        destination: end,
        travelMode: google.maps.TravelMode.DRIVING
    };
    directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
            directionsDisplay.setPanel(document.getElementById('directions-panel'));
        }
    });
}

function calculateDistances(origins, destinations) {
    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix({
        origins: [origins],
        destinations: [destinations],
        travelMode: google.maps.TravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC,
        avoidHighways: false,
        avoidTolls: false
    }, callback);
}

function callback(response, status) {
    if (status != google.maps.DistanceMatrixStatus.OK) {
        alert('Error was: ' + status);
    } else {
        var origins = response.originAddresses;
        var destinations = response.destinationAddresses;
        var outputDiv = document.getElementById('outputDiv');
        outputDiv.innerHTML = 'Calculating';
        for (var i = 0; i < origins.length; i++) {
            var results = response.rows[i].elements;
            for (var j = 0; j < results.length; j++) {
                outputDiv.innerHTML += 'You are ' + results[j].distance.text + ' km away from us. '+results[j].duration.text; // origins[i] + ' to ' + destinations[j] + ': ' +  + ' in ' + results[j].duration.text + '<br>';
            }
        }
    }
}

</script>
<script>
$(function(){
    $('body table').addClass('table');
    initialize(7.284393, 80.644572);
});
</script>
</body>
</html>