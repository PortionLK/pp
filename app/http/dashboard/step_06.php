<?php
	if(!isset($_SESSION['step_01_completed']) || $_SESSION['step_01_completed'] != true){
		die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-01'));
	}else if(!isset($_SESSION['step_02_completed']) || $_SESSION['step_02_completed'] != true){
		die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-02'));
	}else if(!isset($_SESSION['step_03_completed']) || $_SESSION['step_03_completed'] != true){
		die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-03'));
	}else if(!isset($_SESSION['step_04_completed']) || $_SESSION['step_04_completed'] != true){
		die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-04'));
	}

	if(isset($_SESSION['hotel_step_error']) && (strlen($_SESSION['hotel_step_error']) > 0)){
?>
<div><?php echo $_SESSION['hotel_step_error']; $_SESSION['hotel_step_error'] = ''; ?></div>
<?php } ?>
<?php
	$hotel_id = isset($_SESSION['editing_hotel']) ? $_SESSION['editing_hotel'] : -1;
	$room = new Room();
	$roomTypes = $room->where('hotel_id', '=', $hotel_id)
		->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
		->select('rooms.*', 'room_types.name as room_type_name', 'room_types.id as room_type_id')
		->get();
?>
<form action="<?php echo HTTP; ?>dashboard/get_step_06.php" method="post">
	<input type="hidden" value="ec14f83d70784a0c311a09533c9f9a23" name="csrf"/>
	<fieldset>
		<legend>Hotel Registration/Property-details</legend>
		<h3 class="h3">Assign rooms</h3>

		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Room type</th>
					<th>Assigned quantity</th>
					<th colspan="2" class="text-center">Available date range</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($roomTypes as $roomType){
					$numRooms = new Room();
					$numRooms = $numRooms->where('hotel_id', '=', $hotel_id)
						->where('room_type_id', '=', $roomType->room_type_id, 'AND')
						->sum('assigned_rooms');
				?>
				<tr>
					<td>
						<?php echo $roomType->room_type_name; ?>
						<input name="assign[roomType][<?php echo $roomType->room_type_id; ?>]" value="<?php echo $roomType->room_type_name; ?>" type="hidden"/>
					</td>
					<td>
						<div class="form-group">
						<label>&nbsp;</label>
						<select class="form-control" name="assign[roomQty][<?php echo $roomType->room_type_id; ?>]">
								
							<?php for(;$numRooms
							 > 0;$numRooms--){ ?>
							<option value="<?php echo $numRooms; ?>"><?php echo $numRooms; ?></option>
							<?php } ?>
						</select>
						</div>
					</td>
					<td>
						<div class="form-group">
						<label>From</label>
						<input class="form-control calendar" type="date" placeholder="Date from" name="assign[start][<?php echo $roomType->room_type_id; ?>]" class="from">
						</div>
					</td>

					<td>
						<div class="form-group">
						<label>To</label>
						<input class="form-control calendar" type="date" placeholder="Date to" name="assign[end][<?php echo $roomType->room_type_id; ?>]" class="from">
						</div>
					</td>

				</tr>
				<?php } ?>
			</tbody>
		</table>

		<div class="row">
			<div class="form-group col-xs-12">
				<button type="submit" name="submit" class="pull-right btn-lg btn btn-primary">Assign & Finish <i class="fa fa-arrow-circle-right"></i></button>
			</div>
		</div>
	</fieldset>
</form>

<script>
	$(function () {
		$('.calendar').datepicker({ dateFormat: "yy-mm-dd", minDate: 0 });
	})
</script>