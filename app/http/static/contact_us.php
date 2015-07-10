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
    <!--end header-inner-->
    <div class="map-canvas" id="map-canvas"></div>
    <div class="container">
        <div class="row">
            <div class="contac-us-bg col-xs-12">
                <div class="page-header">
                    <h2 class="text-center">Contact us</h2>
                </div>
                <address class="text-center">
                    <p><i class="fa fa-map-marker"></i> Roomista (Pvt) Ltd</p>
                    <p>No 16/3 Cambridge Place,</p>
                    <p>Colombo 7.</p>
                </address>
                <address class="text-center"><i class="fa fa-envelope-o"></i> info@roomista.com</address>
                <address class="text-center"><i class="glyphicon glyphicon-phone-alt"></i> +94 777 666 124</address>
                <address class="text-center"><i class="glyphicon glyphicon-phone-alt"></i> +94 777 555 832</address>

                <div class="col-md-6 col-md-offset-3">
                <div class="col-xs-12">
                <div class="col-xs-12">
                <div class="col-xs-12">
                <form class="contactUsForm">
                    <div class="form-group">
                        <label>Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label>Email<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label>Country<span class="text-danger">*</span></label>
                        <select class="form-control" name="name">
                            <option>Sri lanka</option>
                            <option>India</option>
                            <option>USA</option>
                            <option>England</option>
                            <option>Romania</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Telephone</label>
                        <input type="email" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea class="form-control" name="name"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block btn-md">Submit</button>
                    </div>
                </form>
                </div>
                </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <?php include(DOC_ROOT . 'includes/footer.php'); ?>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFGJsLtiBL7Cr1yqSl9Std8Er3leUn_bE"></script>
<script>
function initialize() {
    var myLatlng = new google.maps.LatLng(6.908119, 79.859320);
    var styles = [
                  {
                    "stylers": [
                      { "saturation": -100 },
                      { "gamma": 1.18 },
                      { "lightness": 30 }
                    ]
                  },{
                  }
                ]
    var mapOptions = {
        zoom:16,
        center:myLatlng,
        styles:styles,
        disableDefaultUI:true,
        scrollwheel:false,
        draggable:false
    }
     map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
}
    google.maps.event.addDomListener(window, 'load', initialize);
</script>
</body>
</html>
