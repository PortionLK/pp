<?php
	$mainCity = new MainCity();
	$mainCityList = $mainCity->all();
?>
<div class="befor-footer_3">
    <div class="container">
        <div class="footer-inner col-xs-12 no-padding">
            <div class="news_letters">
                <h2>Subscribe Now &amp; Get Exclusive Hotel Deals from roomista</h2>
                <div class="col-xs-12 no-padding" id="subscribe_div">
					<?php if(isset($_SESSION['']) && (strlen($_SESSION['']) > 1)){ ?>
					<div class="alert alert-success"><?php echo $_SESSION['']; ?></div>
					<?php } ?>
                    <form action="<?php echo DOMAIN; ?>assets/subscribers" method="post">
						<input type="hidden" name="csrf" value="2f2f6673aab0fa90d9992a67801046cf">
						<div class="form-group col-xs-12 col-sm-4 no-padding">
							<input class="form-control" id="subscribe_email" name="subscribe_email" placeholder="E-Mail" type="email"/>
						</div>
						<button class="btn btn-default" id="subscribe" name="subscribe" type="submit">Subscribe</button>
						<span class="alert alert-danger hidden" id="subcrbchk">Please enter the valid email address</span>
					</form>
				</div>
            </div>
        </div>
        <div class="footer-inner col-xs-12 no-padding">
            <h2>Hotels by Top City</h2>
            <ul class="hotel_list col col-xs-12 n-padding">
            <?php foreach($mainCityList as $mainCityItem){ ?>
                <li class="col-xs-12 col-lg-2 col-md-3 col-sm-4">
                    <a href="<?php echo HTTP_PATH; ?>sri-lanka/hotels-in-<?php echo implode("-", explode(" ", strtolower($mainCityItem->name))); ?>">Hotels in <?php echo $mainCityItem->name; ?></a>
                </li>
            <?php } ?>
            </ul>
        </div>
    </div>
</div>

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