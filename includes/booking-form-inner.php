<div class="xs-span12 no-padding-xs">
    <form method="post" action="<?php echo HTTP_PATH; ?>search" name="searchForm" class="col-xs-12 no-padding booking-form">
		<input type="hidden" name="csrf" value="1064fd4b0dce47decf5c3e640037f3d0"/>
        <div class="col-xs-12 no-padding">
            <div class="form-group posRelative col-xs-12 col-sm-3">
                <label>Search for a city, hotel or destination...</label>
				<input name="string" type="search" class="form-control input-sm" id="searchString" autocomplete="off" placeholder="Type a city, hotel or destination..." value="<?php isset($searchBag['string']) ? $searchBag['string'] : ''; ?>"/>
				<input name="selector" type="hidden" id="selector" value="h"/>
				<div id="searchSuggestions" class="searchSuggestions">
					<div>
						<h5 class="searchHeading">Cities</h5>
						<div>
							<div class="searchValueCities" onclick="javascript:$('#selector').val('c');"></div>
						</div>
					</div>
					<div>
						<h5 class="searchHeading">Hotels</h5>
						<div>
							<div class="searchValueHotels" onclick="javascript:$('#selector').val('h');"></div>
						</div>
					</div>
					<div>
						<h5 class="searchHeading">Destinations</h5>
						<div>
							<div class="searchValueDestinations" onclick="javascript:$('#selector').val('d');"></div>
						</div>
					</div>
				</div>
			</div>
            <div class="form-group col-xs-12 col-sm-1">
                <label>Adults</label>
                    <select name="search_adults" id="search_adults" class="form-control input-sm" >
                        <?php
                        for ($h = 1; $h < 18; $h++) {
                        ?>
                        <option value="<?php echo $h; ?>" <?php echo (isset($searchBag['adults']) && ($searchBag['adults'] == $h)) ? 'selected="true"' : ''; ?>><?php echo $h; ?></option>
                        <?php } ?>
                    </select>
            </div>
            <div class="form-group col-xs-12 col-sm-1">
                <label>Children</label>
                    <select name="search_children" id="search_children" class="form-control input-sm">
                        <?php
                        for ($h = 0; $h < 10; $h++) {
                        ?>
                        <option value="<?php echo $h; ?>" <?php echo (isset($searchBag['children']) && ($searchBag['children'] == $h)) ? 'selected="true"' : ''; ?>><?php echo $h; ?></option>
                        <?php } ?>
                    </select>
            </div>
            <div class="form-group col-xs-12 col-sm-1">
                <label>Rooms</label>
                    <select name="search_num_of_room" id="search_num_of_room" class="form-control input-sm" >
                        <?php
                        for ($h = 1; $h < 40; $h++) {
                        ?>
                        <option value="<?php echo $h; ?>" <?php echo (isset($searchBag['rooms']) && ($searchBag['rooms'] == $h)) ? 'selected="true"' : ''; ?>><?php echo $h; ?></option>
                        <?php } ?>
                    </select>
            </div>
            <div class="form-group col-xs-12 col-sm-2">
                <label>Check in</label>
                    <input id="date_arriving" name="date_arriving" class="form-control input-sm" type="text" value="<?php echo isset($searchBag['check_in']) ? $searchBag['check_in'] : date('Y-m-d'); ?>"/>
            </div>
            <div class="form-group col-xs-12 col-sm-2">
                <label>Check out</label>
                    <input id="date_departure" name="date_departure" class="form-control input-sm" type="text" value="<?php echo isset($searchBag['check_out']) ? $searchBag['check_out'] : date('Y-m-d', strtotime(date('Y-m-d') . ' +1 days')); ?>"/>
            </div>
            <div class="form-group col-xs-12 col-sm-2">
                <label>&nbsp;</label>
                <div class="clearfix"></div>
                <button type="submit" class="btn btn-primary btn-block">Search</button>
            </div>
        </div>
        <div class="clearfix"></div>
    </form>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">
	$(function(){

		$('#date_arriving').datepicker({
			minDate:'+1D',
			onClose: function( selectedDate ) {
				$( "#date_departure" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$('#date_departure').datepicker({
			minDate:'+1D',
			onClose: function( selectedDate ) {
				$( "#date_arriving" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
		
		$('#searchString').on('keyup', function(){
			var searchString = $(this).val();
			var call = $.ajax({
				url: "<?php echo HTTP; ?>handlers/searchSuggestions.php",
				method: "POST",
				data: {key: searchString, value: '437d04d169b9b9a592f944802c6b3c39'},
				dataType: "json"
			});
			call.done(function(msg){
				$('.searchValueCities').html('');
				$('.searchValueHotels').html('');
				$('.searchValueDestinations').html('');
				$(msg.c).each(function(k1, v1){
					$('.searchValueCities').append('<div class="sCities btn btn-link btn-block">' + v1 + '</div>');
				});
				$(msg.h).each(function(k2, v2){
					$('.searchValueHotels').append('<div class="sHotels btn btn-link btn-block">' + v2 + '</div>');
				});
				$(msg.d).each(function(k3, v3){
					$('.searchValueDestinations').append('<div class="sDestinations btn btn-link btn-block">' + v3 + '</div>');
				});
			});
			call.fail(function(jqXHR, textStatus){
				alert("Request failed: " + textStatus);
			});
			$('#searchSuggestions').css({'display':'block'});
		});
		$('.sCities').live('click', function(){ $('#searchString').val($(this).text()); $('#searchSuggestions').fadeOut(); });
		$('.sHotels').live('click', function(){ $('#searchString').val($(this).text()); $('#searchSuggestions').fadeOut(); });
		$('.sDestinations').live('click', function(){ $('#searchString').val($(this).text()); $('#searchSuggestions').fadeOut(); });

		$('#searchSuggestions').width($('#searchSuggestions').parent().width()-2);

		$(document).mouseup(function (e){
		    var container = $("#searchSuggestions");

		    if (!container.is(e.target) // if the target of the click isn't the container...
		        && container.has(e.target).length === 0) // ... nor a descendant of the container
		    {
		        container.hide();
		    }
		});

	});
</script>