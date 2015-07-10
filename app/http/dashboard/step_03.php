<?php
	$roomFeature = new RoomFeature();
	$rFeatures = $roomFeature->all();

	if(!isset($_SESSION['step_01_completed']) || $_SESSION['step_01_completed'] != true){
		die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-01'));
	}else if(!isset($_SESSION['step_02_completed']) || $_SESSION['step_02_completed'] != true){
		die(header('Location: ' . DOMAIN . 'dashboard/add-hotel/step-02'));
	}

	$hotel_id = isset($_SESSION['editing_hotel']) ? $_SESSION['editing_hotel'] : -1;
	$addedRooms = new Room();
	$addedRooms = $addedRooms->where('hotel_id', '=', $hotel_id)
		->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
		->select('rooms.*', 'room_types.name as room_type_name')
		->get();
?>
<?php if(isset($_SESSION['hotel_step_error']) && (strlen($_SESSION['hotel_step_error']) > 0)){ ?>
<div><?php echo $_SESSION['hotel_step_error']; $_SESSION['hotel_step_error'] = ''; ?></div>
<?php } ?>
<?php if(count($addedRooms)){ ?>
<table class="table table-bordered">
<thead>
	<tr>
		<th>Name</th>
		<th>No of Rooms</th>
		<th>Assigned rooms</th>
		<th>Max Persons</th>
		<th>Max Extra Beds</th>
		<th>Action</th>
	</tr>
</thead>
<tbody>
	<?php foreach($addedRooms as $addedRoom){ ?>
	<tr>
		<td data-th="Name"><?php echo $addedRoom->room_type_name; ?></td>
		<td data-th="No of Rooms"><?php echo $addedRoom->no_of_rooms; ?></td>
		<td data-th="Assigned rooms"><?php echo $addedRoom->assigned_rooms; ?></td>
		<td data-th="Max Persons"><?php echo $addedRoom->max_persons; ?></td>
		<td data-th="Max Extra Beds"><?php echo $addedRoom->max_extra_beds; ?></td>
		<td data-th="Action">
			<!--<a class="btn btn-success btn-xs" href="edit"><i class="fa fa-check-circle-o"></i> Edit</a>-->
			<form action="<?php echo DOMAIN; ?>dashboard/add-hotel/step-<?php echo $stage; ?>/remove-room" method="post">
				<input type="hidden" name="csrf" value="802e06de1a6b657de6e5cd8b751e39d2">
				<input type="hidden" name="prop" value="<?php echo $addedRoom->id; ?>">
				<button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash-o"></i> Remove</button>
			</form>
		</td>
	</tr>
	<?php } ?>
</tbody>
</table>
<?php } ?>
<form action="<?php echo HTTP; ?>dashboard/get_step_03.php" method="post" enctype="multipart/form-data">
	<input type="hidden" value="c7a7a96215b31d0e6d9b0c40894e2a73" name="csrf"/>
	<fieldset>
		<legend>Hotel Registration/Property-details</legend>
		<h3 class="h3">Add rooms</h3>

		<div class="row">
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label for="roomType">Room type<span class="text-danger">*</span></label>
				<input name="room[type]" id="roomType" class="form-control" type="text"/>
			</div>
			<div class="form-group col-md-12 col-sm-12 col-xs-12">
				<label for="filter_b_1">Room features<span class="text-danger">*</span></label>
				<div>
					<?php foreach($rFeatures as $rFeature){ ?>
						<div class="checkbox col-md-4 col-sm-4 col-xs-12">
							<label>
								<input type="checkbox" name="room[feature][]" value="<?php echo $rFeature->id; ?>"><?php echo $rFeature->feature; ?>
							</label>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label for="noRooms">Number of rooms</label>
				<input type="number" id="noRooms" name="room[qty]" class="form-control" placeholder="Number of rooms"/>
			</div>
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label for="noRoomsAssign">Room allotments for Roomista</label>
				<input type="number" id="noRoomsAssign" name="room[qtyAssigned]" class="form-control" placeholder="Room allotments for Roomista" onclick="javascript:$(this).select();"/>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label for="maxPersons">Max persons per this room type</label>
				<input type="number" id="maxPersons" name="room[maxPersons]" class="form-control" placeholder="Max persons"/>
			</div>
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label for="maxExtraBeds">Max extra beds per this room type</label>
				<input type="number" id="maxExtraBeds" name="room[maxExtraBeds]" class="form-control" placeholder="Max extra beds"/>
			</div>
		</div>
		<div class="form-group">
			<label>Room images</label>
			<input type="file" class="form-control" multiple="true" name="roomImg[]"/>
		</div>
		<hr/>

		<div class="row">
			<div class="form-group col-xs-12">
				<button type="submit" name="submit" value="Add this room type" class="pull-right btn btn-default"><i class="fa text-success fa-check-circle"></i><?php echo (count($addedRooms)) ? 'Add more room types' : 'Add room type'; ?></button>
			</div>
		</div>
		<?php if(count($addedRooms)){ ?>
		<div class="row">
			<div class="form-group col-xs-12">
				<button type="submit" name="submit" value="next" class="pull-right btn-lg btn btn-primary">Save & Continue <i class="fa fa-arrow-circle-right"></i></button>
			</div>
		</div>
		<?php } ?>
	</fieldset>
</form>
<script type="text/javascript">
	$(function(){
		$('#noRooms').on('keyup', function(){
			var myRooms = $(this).val();
			myRooms = parseInt(myRooms) * 0.10;
			myRooms = Math.ceil(myRooms);
			$('#noRoomsAssign').val(myRooms);
		});
	});
</script>