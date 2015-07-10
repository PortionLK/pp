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
	$roomRate = new RoomRate();
	$addedRates = $roomRate->where('hotel_id', '=', $hotel_id)
		->join('room_types', 'room_rates.room_type_id', '=', 'room_types.id')
		->select('room_rates.*', 'room_types.name as room_type_name')
		->groupBy('season')->get();
	$roomTypes = $room->where('hotel_id', '=', $hotel_id)
		->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
		->select('rooms.*', 'room_types.name as room_type_name', 'room_types.id as room_type_id')
		->get();
?>		
<?php if(count($addedRates)){ ?>
<table class="table table-bordered">
<thead>
	<tr>
		<th>Season name</th>
		<th>Type of room</th>
		<th>Date start</th>
		<th>Date end</th>
		<th>Action</th>
	</tr>
</thead>
<tbody>
	<?php foreach($addedRates as $addedRate){ ?>
	<tr>
		<td><?php echo $addedRate->season; ?></td>
		<td><?php echo $addedRate->room_type_name; ?></td>
		<td><?php echo $addedRate->start; ?></td>
		<td><?php echo $addedRate->end; ?></td>
		<td>
			<a class="btn btn-success btn-xs" href="edit"><i class="fa fa-check-circle-o"></i> Edit</a>
			<a class="btn btn-danger btn-xs" href="remove"><i class="fa fa-trash-o"></i> Remove</a>
		</td>
	</tr>
	<?php } ?>
</tbody>
</table>
<?php } ?>
<form action="<?php echo HTTP; ?>dashboard/get_step_05.php" method="post" enctype="multipart/form-data">
	<input type="hidden" value="05243c527493c2145a9023d2fac0dc59" name="csrf"/>
	<fieldset>
		<legend>Hotel Registration/Property-details</legend>
		<h3 class="h3">Room rates</h3>

		<div class="row">
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label class="title-label">Room type</label>
				<select class="form-control" name="rate[type]">
					<option value="0">Select room type</option>
					<?php foreach($roomTypes as $roomType){ ?>
					<option value="<?php echo $roomType->room_type_id; ?>"><?php echo $roomType->room_type_name; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label class="title-label">Season name</label>
				<input name="rate[season]" type="text" class="form-control" placeholder="Season name">
			</div>
		</div>
		<div class="row">
			<label class="title-label col-xs-12">Date range</label>
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label class="title-label">From</label>
				<input name="rate[from]" type="text" class="form-control calendar" readonly="true" placeholder="yyyy-mm-dd">
			</div>
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label class="title-label">To</label>
				<input name="rate[to]" type="text" class="form-control calendar" readonly="true" placeholder="yyyy-mm-dd">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label class="title-label">Discount rate for foreigners</label>
				<input name="rate[foreignDiscountRate]" type="text" class="form-control" placeholder="Discount rate for foreigners">
			</div>
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label class="title-label">Minimum price for foreigners</label>
				<input name="rate[foreignMinPrice]" type="text" class="form-control" placeholder="Minimum price for foreigners">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label class="title-label">Discount rate for locals</label>
				<input name="rate[localDiscountRate]" type="text" class="form-control" placeholder="Discount rate for locals">
			</div>
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
				<label class="title-label">Minimum price for locals</label>
				<input name="rate[localMinPrice]" type="text" class="form-control" placeholder="Minimum price for locals">
			</div>
		</div>
		<hr/>

		<div class="row">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th align="center"></th>
						<th colspan="4" align="center">SINGLE</th>
						<th colspan="4" align="center">DOUBLE</th>
						<th colspan="4" align="center">TRIPLE</th>
					</tr>
					<tr>
						<th align="center">&nbsp;</th>
						<th align="center">FIT Rate</th>
						<th align="center">Nett Rate</th>
						<th align="center">Agent Rate</th>
						<th align="center">Sell Rate</th>
						<th align="center">FIT Rate</th>
						<th align="center">Nett Rate</th>
						<th align="center">Agent Rate</th>
						<th align="center">Sell Rate</th>
						<th align="center">FIT Rate</th>
						<th align="center">Nett Rate</th>
						<th align="center">Agent Rate</th>
						<th align="center">Sell Rate</th>
					</tr>
				</thead>
				<tbody>
					<tr class="copy_ro">
						<td align="center">Room Only (RO)</td>
						<td align="center"><input name="rate[table][1][1][fr]" value="10" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][1][1][nr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][1][1][ar]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][1][1][sr]" value="0" type="text" class="fp form-control"></td>

						<td align="center"><input name="rate[table][2][1][fr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][2][1][nr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][2][1][ar]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][2][1][sr]" value="0" type="text" class="fp form-control"></td>

						<td align="center"><input name="rate[table][3][1][fr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][3][1][nr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][3][1][ar]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][3][1][sr]" value="0" type="text" class="fp form-control"></td>
					</tr>
					<tr class="copy_bnbf">
						<td align="center">Bed & Breakfast (BnBF)</td>
						<td align="center"><input name="rate[table][1][2][fr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][1][2][nr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][1][2][ar]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][1][2][sr]" value="0" type="text" class="fp form-control"></td>

						<td align="center"><input name="rate[table][2][2][fr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][2][2][nr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][2][2][ar]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][2][2][sr]" value="0" type="text" class="fp form-control"></td>

						<td align="center"><input name="rate[table][3][2][fr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][3][2][nr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][3][2][ar]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][3][2][sr]" value="0" type="text" class="fp form-control"></td>
					</tr>
					<tr class="copy_hb">
						<td align="center">Half board (HB)</td>
						<td align="center"><input name="rate[table][1][3][fr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][1][3][nr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][1][3][ar]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][1][3][sr]" value="0" type="text" class="fp form-control"></td>

						<td align="center"><input name="rate[table][2][3][fr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][2][3][nr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][2][3][ar]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][2][3][sr]" value="0" type="text" class="fp form-control"></td>

						<td align="center"><input name="rate[table][3][3][fr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][3][3][nr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][3][3][ar]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][3][3][sr]" value="0" type="text" class="fp form-control"></td>
					</tr>
					<tr class="copy_fb">
						<td align="center">Full board (FB)</td>
						<td align="center"><input name="rate[table][1][4][fr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][1][4][nr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][1][4][ar]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][1][4][sr]" value="0" type="text" class="fp form-control"></td>

						<td align="center"><input name="rate[table][2][4][fr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][2][4][nr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][2][4][ar]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][2][4][sr]" value="0" type="text" class="fp form-control"></td>

						<td align="center"><input name="rate[table][3][4][fr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][3][4][nr]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][3][4][ar]" value="0" type="text" class="fp form-control"></td>
						<td align="center"><input name="rate[table][3][4][sr]" value="0" type="text" class="fp form-control"></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="row">
			<fieldset class="form-inline">
				<legend><small>Keep 0 for same prices as foreign rates.</small></legend>
				<div class="form-group">
				<label>Calculate local rates with percentage of</label>
					<div class="input-group">
						<input type="text" class="form-control" name="rate[localCalcPercent]" value="0" id="localCalcPercent" onclick="javascript:$(this).select();"/>
						<span class="input-group-addon">%</span>
					</div>
				</div>
				<div class="form-group">
					<select class="form-control" name="rate[localCalcType]" id="localCalcType">
						<option value="-">Discount</option>
						<option value="+">Surcharge</option>
					</select>
				</div>
				<button type="button" class="btn btn-default" id="giveLocal"/>Calculate</button>
			</fieldset>
		</div>
		<div class="row">
			<div class="form-group col-xs-12 no-padding">
				<div class="copyTable"></div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-xs-12">
				<button type="submit" name="submit" class="pull-right btn-lg btn btn-primary">Add this rate variation <i class="fa fa-arrow-circle-right"></i></button>
			</div>
		</div>
	</fieldset>
</form>
<?php if(count($addedRates)){ ?>
<div class="row">
	<div class="form-group col-xs-12">
		<a href="<?php echo DOMAIN; ?>dashboard/add-hotel/step-06"><button type="button" class="pull-right btn-lg btn btn-primary">Save & Continue <i class="fa fa-arrow-circle-right"></i></button></a>
	</div>
</div>
<?php } ?>
<script type="text/javascript">
	$(function(){
		$('#giveLocal').on('click', function(){
			$('.copyTable').html('');
			$('.copyTable').html('\
				<table class="table table-bordered">\
					<thead>\
						<tr>\
							<td align="center"></td>\
							<td colspan="4" align="center"><strong>SINGLE</strong></td>\
							<td colspan="4" align="center"><strong>DOUBLE</strong></td>\
							<td colspan="4" align="center"><strong>TRIPLE</strong></td>\
						</tr>\
						<tr>\
							<td align="center">&nbsp;</td>\
							<td align="center">FIT Rate</td>\
							<td align="center">Nett Rate</td>\
							<td align="center">Agent Rate</td>\
							<td align="center">Sell Rate</td>\
							<td align="center">FIT Rate</td>\
							<td align="center">Nett Rate</td>\
							<td align="center">Agent Rate</td>\
							<td align="center">Sell Rate</td>\
							<td align="center">FIT Rate</td>\
							<td align="center">Nett Rate</td>\
							<td align="center">Agent Rate</td>\
							<td align="center">Sell Rate</td>\
						</tr>\
					</thead>\
					<tbody>\
						<tr class="copy_ro">\
							<td align="center">Room Only (RO)</td>\
							<td align="center"><input name="rate[tableLocal][1][1][fr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][1][1][nr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][1][1][ar]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][1][1][sr]" value="0" type="text" class="ap form-control"></td>\
\
							<td align="center"><input name="rate[tableLocal][2][1][fr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][2][1][nr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][2][1][ar]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][2][1][sr]" value="0" type="text" class="ap form-control"></td>\
\
							<td align="center"><input name="rate[tableLocal][3][1][fr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][3][1][nr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][3][1][ar]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][3][1][sr]" value="0" type="text" class="ap form-control"></td>\
						</tr>\
						<tr class="copy_bnbf">\
							<td align="center">Bed & Breakfast (BnBF)</td>\
							<td align="center"><input name="rate[tableLocal][1][2][fr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][1][2][nr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][1][2][ar]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][1][2][sr]" value="0" type="text" class="ap form-control"></td>\
\
							<td align="center"><input name="rate[tableLocal][2][2][fr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][2][2][nr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][2][2][ar]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][2][2][sr]" value="0" type="text" class="ap form-control"></td>\
\
							<td align="center"><input name="rate[tableLocal][3][2][fr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][3][2][nr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][3][2][ar]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][3][2][sr]" value="0" type="text" class="ap form-control"></td>\
						</tr>\
						<tr class="copy_hb">\
							<td align="center">Half board (HB)</td>\
							<td align="center"><input name="rate[tableLocal][1][3][fr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][1][3][nr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][1][3][ar]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][1][3][sr]" value="0" type="text" class="ap form-control"></td>\
\
							<td align="center"><input name="rate[tableLocal][2][3][fr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][2][3][nr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][2][3][ar]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][2][3][sr]" value="0" type="text" class="ap form-control"></td>\
\
							<td align="center"><input name="rate[tableLocal][3][3][fr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][3][3][nr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][3][3][ar]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][3][3][sr]" value="0" type="text" class="ap form-control"></td>\
						</tr>\
						<tr class="copy_fb">\
							<td align="center">Full board (FB)</td>\
							<td align="center"><input name="rate[tableLocal][1][4][fr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][1][4][nr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][1][4][ar]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][1][4][sr]" value="0" type="text" class="ap form-control"></td>\
\
							<td align="center"><input name="rate[tableLocal][2][4][fr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][2][4][nr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][2][4][ar]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][2][4][sr]" value="0" type="text" class="ap form-control"></td>\
\
							<td align="center"><input name="rate[tableLocal][3][4][fr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][3][4][nr]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][3][4][ar]" value="0" type="text" class="ap form-control"></td>\
							<td align="center"><input name="rate[tableLocal][3][4][sr]" value="0" type="text" class="ap form-control"></td>\
						</tr>\
					</tbody>\
				</table>'
			);
			var iFactor = $('#localCalcPercent').val();
			iFactor = parseFloat(iFactor).toFixed(2) / 100;
			iFactor = iFactor.toFixed(4);
			var localCalcType = $('#localCalcType').val();
			var fp = [];
			var tempValue = 0;
			$('.fp').each(function(index, elem){
				tempValue = parseFloat(elem.value).toFixed(2);
				if(localCalcType == '-'){
					var iFactorReduced = 1 - iFactor;
					tempValue = tempValue * iFactorReduced;
					tempValue = parseFloat(tempValue).toFixed(2);
					fp.push(tempValue);
				}else if(localCalcType == '+'){
					iFactor *= 1;
					var iFactorAdded = (1 + iFactor);
					tempValue = tempValue * iFactorAdded;
					tempValue = parseFloat(tempValue).toFixed(2);
					fp.push(tempValue);
				}else{
					fp.push(tempValue);
				}
			});
			$('.ap').each(function(key, val){
				val.value = fp[key];
			});
		});
		$('.fp').live('keyup', function(){
			var iFactor = $('#localCalcPercent').val();
			iFactor = parseFloat(iFactor) / 100;
			iFactor = iFactor.toFixed(4);
			var localCalcType = $('#localCalcType').val();

			var cell = $(this).index('.fp');
			var newVal = $(this).val();
			var otherElem = $('.ap').get(cell);

			if(localCalcType == '-'){
				var iFactorReduced = 1 - iFactor;
				newVal = newVal * iFactorReduced;
				newVal = parseFloat(newVal).toFixed(2);
				otherElem.value = newVal;
			}else if(localCalcType == '+'){
				iFactor *= 1;
				var iFactorAdded = 1 + iFactor;
				newVal = newVal * iFactorAdded;
				newVal = parseFloat(newVal).toFixed(2);
				otherElem.value = newVal;
			}else{
				otherElem.value = newVal;
			}
		});
		$('.fp').on('click', function(){ $(this).select(); });
		$('.ap').live('click', function(){ $(this).select(); });

		$('.calendar').datepicker({ 
		dateFormat: "yy-mm-dd",
		minDate: 0 });
	});
</script>