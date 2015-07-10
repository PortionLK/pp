
<div class="befor-footer_4">
    <div class="container">

    <div class="col-sm-6">
    <div class="befor-inner">
        <div class="col-md-6 pull-left">
        <h5 class="title">We're accepting</h5>
        <div class="payment_methods">
            <img src="<?php echo HTTP_PATH; ?>images/payment_method_icons/CreditCard_MasterCard.png" alt="master_card">
            <img src="<?php echo HTTP_PATH; ?>images/payment_method_icons/CreditCard_Visa.png" alt="visa_card">
            <img src="<?php echo HTTP_PATH; ?>images/payment_method_icons/Paypal.png" alt="paypal">
            <img src="<?php echo HTTP_PATH; ?>images/payment_method_icons/CreditCard_Amex.png" class="cards" alt="american_express">
        </div>
        </div>
    </div>
    </div>

    <div class="col-sm-6">
        <div class="col-xs-12 no-padding">
        <nav id="footerNav" role="navigation">
            <div class="nav-bar footer-nav">
            <ul class="nav-right">
                <li><a href="terms_and_conditions.php">Terms &amp; Conditions</a></li>
                <li><a href="">Privacy Policy</a></li>
                <li><a href="<?php echo HTTP_PATH; ?>contact-us/">Contact us</a></li>
            </ul>
            </div>
        </nav>
        </div>
        <div class="col-xs-12 no-padding">
            <p class="text-right">&copy; 2015 Roomista.com</p>
        </div>
    </div>
    </div>
    <!--end befor-footer-->
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
<!--<script src="<?php echo HTTP_PATH; ?>js/helpers.js"></script>-->
<script>
    $(function(){
        var sideMenu = $('*').hasClass('.hotelList');
        console.log(sideMenu);
    })
</script>