<?php 
    define('_MEXEC', 'OK');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/config/app.php");

	if(!isset($_GET['seo_url']) && (strlen($_GET['seo_url']) < 1)){ die(header('Location: ' . DOMAIN . '404')); }
    $_SESSION['page_url'] = ($_GET['page_url']) ? DOMAIN . $_GET['page_url'] : DOMAIN;

	$seo_url = $_GET['seo_url'];
	$hotel = new Hotel();
	$hotel = $hotel->where('seo_url', '=', $seo_url)->first();
	if(!$hotel){ die(header('Location: ' . DOMAIN . '404')); }

    if(isset($_GET['stage'])){
        $stage = intval($_GET['stage']);
        $stage = sprintf("%02d", $stage);
        if($stage == 02){
            require_once(DOC_ROOT . 'step_02.php');
            die();
        }else if($stage == 03){
            require_once(DOC_ROOT . 'step_03.php');
            die();
        }else if($stage == 04){
			require_once(DOC_ROOT . 'step_04.php');
            die();
		}
        
    }
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
                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-8">
                <div class="margin-top-30 panel panel-default">
                    <div class="panel-body">
                        <h4 class="w_700 no-margin-top">Choose your room type</h4>
                        <div class="col-xs-12">
                            <div class="row">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="col-xs-12 col-sm-3 no-padding">Deluxe</th>
                                            <th>Room Type</th>
                                            <th>Meal type</th>
                                            <th>No. rooms</th>
                                            <th>Adults</th>
                                            <th>Childrens</th>
                                            <th>     </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td data-th="Dluxe">
                                                <img src="<?php echo DOMAIN ?>images/hotel_cat/beach.jpg" class="img-responsive">
                                                <p class="text-left"><a href="" class="text-info"><i class="fa fa-info-circle"></i> Room info</a></p>
                                            </td>
                                            <td data-th="Room Type">
                                                <div class="form-group">
                                                    <select class="form-control input-sm">
                                                        <option>Single</option>
                                                        <option>Double</option>
                                                        <option>Triple</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td data-th="Meal type">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="mealType"> Room only
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="mealType"> Bed &amp; Breakfast
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="mealType"> Half board
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="mealType"> Full board
                                                    </label>
                                                </div>
                                            </td>
                                            <td data-th="No. rooms">
                                                <div class="form-group">
                                                <select class="form-control input-sm">
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                </select>
                                                </div>
                                            </td>
                                            <td data-th="Adults">
                                                <div class="form-group">
                                                <select class="form-control input-sm">
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                </select>
                                                </div>
                                            </td>
                                            <td data-th="Childrens">
                                                <div class="form-group">
                                                <select class="form-control input-sm">
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                </select>
                                                </div>
                                            </td>
                                            <td data-th="     ">
                                                <button class="btn btn-sm btn-warning">Add</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="col-xs-12 col-sm-3 no-padding">Superior</th>
                                            <th>Room Type</th>
                                            <th>Meal type</th>
                                            <th>No. rooms</th>
                                            <th>Adults</th>
                                            <th>Childrens</th>
                                            <th>     </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td data-th="Dluxe">
                                                <img src="<?php echo DOMAIN ?>images/hotel_cat/beach.jpg" class="img-responsive">
                                                <p class="text-left"><a href="" class="text-info"><i class="fa fa-info-circle"></i> Room info</a></p>
                                            </td>
                                            <td data-th="Room Type">
                                                <div class="form-group">
                                                    <select class="form-control input-sm">
                                                        <option>Single</option>
                                                        <option>Double</option>
                                                        <option>Triple</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td data-th="Meal type">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="mealType"> Room only
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="mealType"> Bed &amp; Breakfast
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="mealType"> Half board
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="mealType"> Full board
                                                    </label>
                                                </div>
                                            </td>
                                            <td data-th="No. rooms">
                                                <div class="form-group">
                                                <select class="form-control input-sm">
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                </select>
                                                </div>
                                            </td>
                                            <td data-th="Adults">
                                                <div class="form-group">
                                                <select class="form-control input-sm">
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                </select>
                                                </div>
                                            </td>
                                            <td data-th="Childrens">
                                                <div class="form-group">
                                                <select class="form-control input-sm">
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                </select>
                                                </div>
                                            </td>
                                            <td data-th="     ">
                                                <button class="btn btn-sm btn-warning">Add</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>     
            <div class="col-xs-12 col-sm-4 col-md-4">
                <div class="margin-top-30 panel panel-default">
                    <div class="panel-body">
                    <h4 class="w_700 no-margin-top">Reservation summery</h4>
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">Rooms: 00</div>
                        <div class="col-xs-12 col-sm-4">Adults: 00</div>
                        <div class="col-xs-12 col-sm-4">Childrens: 00</div>
                    </div>
                    <hr>
                    <p><strong>Superior Room</strong> - 2 Night(s) (8th jul - 10th jul)</p>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6"><p>Price (2 Nights)</p></div>
                        <div class="col-xs-12 col-sm-6"><p class="text-info w_700 text-right">USD 480</p></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6"><h4 class="text-uppercase">Net Amount</h4></div>
                        <div class="col-xs-12 col-sm-6"><h4 class="text-right">USD 480</h4></div>
                        <p class="small text-warning col-xs-12 text-uppercase">with taxes and service charges</p>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success btn-lg pull-right" type="submit">Book</button>
                    </div>
                    </div>
                </div>
            </div>     
        </div>
    </div>

<footer>
    <?php include(DOC_ROOT . "includes/footer_hotel.php"); ?>
</footer>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>