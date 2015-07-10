	
	//here

	$("#subscribe").click(function(){
        subscribe();
    });

    $("#date_arriving").datepicker({minDate: 0, dateFormat: $.datepicker.ATOM});
    $("#date_departure").datepicker({minDate: 0, dateFormat: $.datepicker.ATOM});
    
    $('#date_arriving').change(function () {
        var date1 = $('#date_arriving').datepicker('getDate');
        var date = new Date(Date.parse(date1));
        date.setDate(date.getDate() + 1);

        var newDate = date.toDateString();
        newDate = new Date(Date.parse(newDate));

        $('#date_departure').datepicker('setDate', newDate);

        $("#date_departure").datepicker({minDate: 0, dateFormat: $.datepicker.ATOM});

        date_departure.datepicker('option', 'minDate', minArrivalDate);
    });

    $("#check_in_date, #check_out_date").datepicker({
        onSelect: DatePicked,
        minDate: 0,
        dateFormat: 'yy-mm-dd'
    });
    $("#no_of_dates").change(DatePicked);
    DatePicked();


    $(document.body).click(function (e) {
        var $box = $('#searchbox');
        if (e.target.id !== 'searchbox' && !$.contains($box[0], e.target)){
            $("#suggestionsList").hide();
        }
    });

    var widowWidth = $(window).width();

    if (widowWidth < 768) {
        $('#date_arriving').attr('type', 'date');
        $('#date_departure').attr('type', 'date');
    }else{
        $('#date_arriving').attr('type', 'text');
        $('#date_departure').attr('type', 'text');
    }

	/* $('.no_of_nights').chosen({
        disable_search:true,
    }) */

$(window).resize(function(){
    var widowWidth = $(window).width();
    if (widowWidth < 768) {
        $('#date_arriving').attr('type', 'date');
        $('#date_departure').attr('type', 'date');
    }else{
        $('#date_arriving').attr('type', 'text');
        $('#date_departure').attr('type', 'text');
    }
})