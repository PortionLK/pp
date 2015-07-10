<h4 class="title-style4">Your Reservation <span class="title-block"></span></h4>
<form class="booking-form" name="bookroom" id="bookroom" method="post" action="<?php echo HTTP . 'bookings/get_step_01.php' ?>"/>
	<input type="hidden" name="csrf" value="4950ab6a5b3ef7addeb8d7fb2b2789e8"/>
	<input type="hidden" name="hotel" value="<?php echo $hotel->id; ?>"/>
	<div class="clearfix">
		<div class="one-half-form">
			<label for="check_in_date">Check In</label>
			<input name="check_in" type="text" id="check_in" size="10" class="datepicker2 required"/>
		</div>
		<div class="one-half-form last-col">
			<label for="check_out_date">Check Out</label>
			<input name="check_out" type="text" id="check_out" size="10" class="datepicker2 required"/>
		</div>
	</div>
	<hr class="space8"/>
	<input class="bookbutton" type="submit" value="Check Availability"/>
</form>
