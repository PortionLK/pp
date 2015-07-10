<h4 class="title-style4">Your Reservation <span class="title-block"></span></h4>
<form class="booking-form" name="bookroom" id="bookroom" method="post" action="<?php echo HTTP . 'bookings/get_step_02.php' ?>"/>
	<input type="hidden" name="csrf" value="179826a2de81ec53c09f7f6e3a2b18ff"/>
	<div class="clearfix">
		<div class="one-half-form">
			<label for="check_in_date">Room ID</label>
			<input name="room_id" type="text" id="room_id" size="10" class="datepicker2 required"/>
		</div>
		<div class="one-half-form last-col">
			<label for="check_out_date">Check Out</label>
			<input name="check_out" type="text" id="check_out" size="10" class="datepicker2 required"/>
		</div>
	</div>
	<hr class="space8"/>
	<input class="bookbutton" type="submit" value="Book Now"/>
</form>
