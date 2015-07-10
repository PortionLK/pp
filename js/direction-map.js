$(document).ready(function(){
	calculateDistances();
	getLocation();
})

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function setPosition(position) {
	var myLat = position.coords.latitude;
	var myLon = position.coords.longitude;
}

var map;
var geocoder;
var bounds = new google.maps.LatLngBounds();
var markersArray = [];
var origin1 = new google.maps.LatLng(myLat, myLon);
var destinationA = new google.maps.LatLng(<?php echo $hotel->latitude; ?>, <?php echo $hotel->longitude; ?>);


var originIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=O|FFFF00|000000';
lat:  lon: 
function initialize() {
    var opts = {
        center: new google.maps.LatLng(55.53, 9.4),
        zoom: 10
    };
    map = new google.maps.Map(document.getElementById('map-canvas'), opts);
    geocoder = new google.maps.Geocoder();
}

function calculateDistances() {
    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix({
        origins: [origin1],
        destinations: [destinationA],
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
        var outputDiv = document.getElementById('distanceBlock');
        outputDiv.innerHTML = '';
        deleteOverlays();
        for (var i = 0; i < origins.length; i++) {
            var results = response.rows[i].elements;
            addMarker(origins[i], false);
            for (var j = 0; j < results.length; j++) {
                addMarker(destinations[j], true);
                outputDiv.innerHTML += origins[i] + ' to ' + destinations[j] + ': ' + results[j].distance.text + ' in ' + results[j].duration.text + '<br>';
            }
        }
    }
}

google.maps.event.addDomListener(window, 'load', initialize);