<?php 
	
?>
<!DOCTYPE html>
<html>
<?php require_once(DOC_ROOT . 'includes/head.php'); ?>
<body>
<div id="wrapper">
    <?php include(DOC_ROOT . 'includes/header_hotel.php'); ?>

    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-3">
                <h5 class="text-center">CHOOSE YOUR DATE</h5>
            </div>
            <div class="col-xs-12 col-sm-3">
                <h5 class="text-center">CHOOSE YOUR ROOM</h5>
            </div>
            <div class="col-xs-12 col-sm-3">
                <h5 class="text-center">PLACE YOUR RESERVATION</h5>
            </div>
            <div class="col-xs-12 col-sm-3">
                <h5 class="text-center">CONFIRMATION</h5>
            </div>
            <div class="clearfix"></div>
            <div class="progress">
                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%;">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-8">
                <div class="margin-top-30 panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="border-right col-xs-12 col-sm-4">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">Check in Date</div>
                                    <div class="col-xs-12 col-sm-6">16-Jul-2015</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">Check out Date</div>
                                    <div class="col-xs-12 col-sm-6">18-Jul-2015</div>
                                </div>
                            </div>
                            <div class="border-right col-xs-12 col-sm-4">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">Nights</div>
                                    <div class="col-xs-12 col-sm-6">2</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">Rooms</div>
                                    <div class="col-xs-12 col-sm-6">1</div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">Adults</div>
                                    <div class="col-xs-12 col-sm-6">3</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">Children (0 - 12)</div>
                                    <div class="col-xs-12 col-sm-6">0</div>
                                </div>
                            </div>
                        </div>
                        <table class="table-bordered">
                            <thead>
                                <tr>
                                    <th>    </th>
                                    <th>Occupancy</th>
                                    <th>Room type</th>
                                    <th>Basic</th>
                                    <th>Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-th="     "><strong>Room 1</strong></td>
                                    <td data-th="Occupancy">Adults : 3<br>Childrens : 0</td>
                                    <td data-th="Room type">Deluxe Triple</td>
                                    <td data-th="Basic">Room only</td>
                                    <td data-th="Rate">USD 1,182.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-bookings">
                    <div class="well col-xs-12">
                        <form>
                            <legend>Guest details</legend>
                            <div class="row">
                                <div class="form-group col-xs-12 col-sm-6">
                                    <label>First name <span class="text-danger">*</span></label>
                                    <input type="text" name="fname" class="form-control" placeholder="First name">
                                </div>
                                <div class="form-group col-xs-12 col-sm-6">
                                    <label>Last name <span class="text-danger">*</span></label>
                                    <input type="text" name="lname" class="form-control" placeholder="Last name">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-xs-12 col-sm-6">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                </div>
                                <div class="form-group col-xs-12 col-sm-6">
                                    <label>Confirm Email <span class="text-danger">*</span></label>
                                    <input type="email" name="confEmail" class="form-control" placeholder="Confirm Email">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-12 col-sm-6">
                                    <label>Passport <span class="text-danger">*</span></label>
                                    <input type="number" name="passport" class="form-control" placeholder="Passport">
                                </div>
                                <div class="form-group col-xs-12 col-sm-6">
                                    <label>Telephone <span class="text-danger">*</span></label>
                                    <input type="tele" name="tele" class="form-control" placeholder="Telephone">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Address <span class="text-danger">*</span></label>
                                <textarea name="address" class="form-control" placeholder="Address"></textarea>
                            </div>

                            <div class="row">
                                <div class="form-group col-xs-12 col-sm-4">
                                    <label>City <span class="text-danger">*</span></label>
                                    <input type="text" name="city" class="form-control" placeholder="City">
                                </div>
                                <div class="form-group col-xs-12 col-sm-4">
                                    <label>Country <span class="text-danger">*</span></label>
                                    <input type="text" name="country" class="form-control" placeholder="Country">
                                </div>
                                <div class="form-group col-xs-12 col-sm-4">
                                    <label>Zip code <span class="text-danger">*</span></label>
                                    <input type="text" name="zip" class="form-control" placeholder="Zip code">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Special requirements <span class="text-danger">*</span></label>
                                <textarea name="specialrequirements" class="form-control" placeholder="Special requirements"></textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success pull-right">Continue with bookings</button>
                            </div>

                        </form>
                    </div>
                </div>


            </div>

            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="margin-top-30 panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Select your special offer</h3>
                    </div>
                    <div class="panel-body">
                        <fieldset>
                        <div class="radio">
                            <label>
                                <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">
                                <div class="media no-margin">
                                    <div class="media-left">
                                        <img class="media-object" src="<?php echo HTTP_PATH; ?>images/thumb-7.jpg" alt="...">
                                    </div>
                                    <div class="media-body">
                                        <h5 class="media-heading">Media heading</h5>
                                        <p>Lorem ipsum dolor sit amet, consectetur</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                <div class="media no-margin">
                                    <div class="media-left">
                                        <img class="media-object" src="<?php echo HTTP_PATH; ?>images/thumb-7.jpg" alt="...">
                                    </div>
                                    <div class="media-body">
                                        <h5 class="media-heading">Media heading</h5>
                                        <p>Lorem ipsum dolor sit amet, consectetur</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-default pull-right"><i class="fa fa-check-square-o"></i> Uncheck</button>
                        </div>
                        </fieldset>
                        <hr>
                        <fieldset>
                        <div class="form-group">
                            <label><h5>Coupan code</h5></label>
                            <div class="input-group">
                                <input type="text" name="coupan" class="form-control">
                                <div class="input-group-btn">
                                    <button class="btn btn-default"><i class="fa fa-barcode"></i> Validate</button>
                                </div>
                            </div>
                        </div>
                        </fieldset>

                    </div>
                </div>
                <div class="margin-top-30 panel panel-default">
                    <div class="panel-body">
                        <h4 class="text-center">Total Cost with taxes and service charges</h4>
                        <h2 class="text-info text-center">USD 945.60</h2>
                        <hr>
                        <p class="small text-uppercase text-center"><i class="fa fa-asterisk text-info"></i> Discount has been applied</p>
                        <p class="small link center-block text-uppercase text-center" id="viewDiscount">View Discount <i class="fa fa-arrow-circle-right"></i></p>
                        <div id="viewDiscountBox" style="display:none" class="deviewDiscountBox text-center col-xs-12 no-padding">
                            <h4>Discount</h4>
                            <p class="small">Test offer 2 (20%)</p>
                            <p class="small">&nbsp;</p>
                            <p class="small">Total Amount to pay</p>
                            <p class="small">(1,182.00 USD - 236.40 USD)</p>
                            <h4 class="text-warning">USD 945.60</h4>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        
    </div>

<footer>
    <?php include(DOC_ROOT . "includes/footer_hotel.php"); ?>
</footer>
<script type="text/javascript">
    $(function(){
        $('#viewDiscount').click(function(){
            $('#viewDiscountBox').slideToggle();
        })
    })
</script>
</body>
</html>