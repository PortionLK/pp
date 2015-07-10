<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];
    $edit_section = explode("_", $action);

    switch ($action) {

        case "viewHotels":
            viewHotels();
            break;
        case "addHotelFirstTime":
            addHotelFirstTime();
            break;
        case "updateHotelsStep_" . $edit_section[1]:
            call_user_func("updateHotelsStep_" . $edit_section[1]);
            break;
        case "deleteHotel":
            deleteHotel();
            break;
        case "editHotelFirst":
            editHotelFirst();
            break;
        case "loginHotels":
            loginHotels();
            break;
        case "logout":
            logout();
            break;
        case "activeHotel":
            activeHotel();
            break;
        case "activeHotelFeatured":
            activeHotelFeatured();
            break;
        case "viewHotelsFront":
            viewHotelsFront();
            break;
        case "hotelImageUploadProfileComplete":
            hotelImageUploadProfileComplete();
            break;
        case "removeHotelImage":
            removeHotelImage();
            break;
    }

    function removeHotelImage()
    {
        $file = $_REQUEST['image'];
        $file_path = DOC_ROOT . 'uploads/hotel-gal/' . $file;

        if (file_exists($file_path)) {
            if (unlink($file_path)) {
                Common::jsonSuccess("Hotel image Deleted Successfully");
            } else {
                Common::jsonError("Fail To Delete");
            }
        } else {
            Common::jsonError("Error");
        }
    }

    function hotelImageUploadProfileComplete()
    {
        $complete = new ProfileCompletion();
        $complete->setHotelStepId($_REQUEST['hotel_step_id']);
        $complete->setHotelStep1(1);
        $complete->updateProfileCompletionStep('8');
        echo($_REQUEST['hotel_step_id']);
        Common::jsonSuccess("");
    }

    function viewHotels()
    {
        $hotel = new Hotels();
        $data = $hotel->getAllHotelsPaginated($_REQUEST['page']);

        $count = $hotel->getAllHotelsCount();

        viewTable($data, $count[0]['count']);

    }

    function viewHotelsFront()
    {
        $hotel = new Hotels();
        $data = $hotel->getAllHotelsWithDiscountFront($_REQUEST['page']);
        $count = $hotel->getAllHotelsDiscountCountFront();
        viewTableFront($data, $count[0]['count']);

    }

    function activeHotel()
    {
        $hotel = new Hotels();
        $status = 0;

        if ($_REQUEST['hotel_status'] == 0) {
            $status = 1;
        } else if ($_REQUEST['hotel_status'] == 1) {
            $status = 0;
        }

        $hotel->setHotelId($_REQUEST['hotels_id']);
        $hotel->setHotelActiveStatus($status);

        if ($hotel->updateHotelStatus()) {
            Common::jsonSuccess("updated");
        } else {
            Common::jsonError("Error");
        }
    }

    function activeHotelFeatured()
    {
        $hotel = new Hotels();
        $status = 0;

        if ($_REQUEST['hotel_status'] == 0) {
            $status = 1;
        } else if ($_REQUEST['hotel_status'] == 1) {
            $status = 0;
        }

        $hotel->setHotelId($_REQUEST['hotels_id']);
        $hotel->setHotelsFeaturedStatus($status);

        if ($hotel->updateFeaturedStatus()) {
            Common::jsonSuccess("updated");
        } else {
            Common::jsonError("Error");
        }
    }

    function addHotelFirstTime()
    {
        $hotel = new Hotels();
        $hotel->setValues($_REQUEST);
        $hotel->setHotelSeoUrl($_REQUEST['seo']);
        $hotel_id = $hotel->addHotelFirstTime();
        if ($hotel_id) {
            $profilecomplete = new ProfileCompletion();
            $profilecomplete->setHotelStepHotelsId($hotel_id);
            $profilecomplete->setHotelStep1(1);
            $profilecomplete->newProfileCompletion();
        }
        echo $hotel_id;
    }

    function editHotelFirst()
    {
        $hotel = new Hotels();
        $hotel->setValues($_REQUEST);
        if ($hotel->editHotelFirst()) {
            Common::jsonSuccess("");
        } else {
            Common::jsonError("Error");
        }
    }

    function updateHotelsStep_1()
    {

        $hotel = new Hotels();
        $hotel->setValues($_REQUEST);
        if ($hotel->updateHotelsStep_1()) {
            $complete = new ProfileCompletion();
            $complete->setHotelStepId($_REQUEST['hotel_step_id']);
            $complete->setHotelStep1(1);
            $complete->updateProfileCompletionStep('2');
            echo($_REQUEST['hotel_step_id']);
            Common::jsonSuccess("");
        } else {
            Common::jsonError("Error");
        }
    }

    function updateHotelsStep_2()
    {
        $hotel = new Hotels();
        $hotel->setValues($_REQUEST);
        if ($hotel->updateHotelsStep_2()) {
            $complete = new ProfileCompletion();
            $complete->setHotelStepId($_REQUEST['hotel_step_id']);
            $complete->setHotelStep1(1);
            $complete->updateProfileCompletionStep('3');
            echo($_REQUEST['hotel_step_id']);
            Common::jsonSuccess("");
        } else {
            Common::jsonError("Error");
        }
    }

    function updateHotelsStep_3()
    {
        $hotelroomtype = new HotelRoomType();
        $hotelroomtype->setValues($_REQUEST);
        if ($hotelroomtype->newHotelRoomType()) {
            $complete = new ProfileCompletion();
            $complete->setHotelStepId($_REQUEST['hotel_step_id']);
            $complete->setHotelStep1(1);
            $complete->updateProfileCompletionStep('4');
            echo($_REQUEST['hotel_step_id']);
            Common::jsonSuccess("");
        } else {
            Common::jsonError("Error");
        }
    }

    function updateHotelsStep_4()
    {
        $hotel = new Hotels();
        $hotel->setValues($_REQUEST);
        if ($hotel->updateHotelsStep_4()) {
            $complete = new ProfileCompletion();
            $complete->setHotelStepId($_REQUEST['hotel_step_id']);
            $complete->setHotelStep1(1);
            $complete->updateProfileCompletionStep('5');
            echo($_REQUEST['hotel_step_id']);
            Common::jsonSuccess("");
        } else {
            Common::jsonError("Error");
        }
    }

    function updateHotelsStep_5()
    {
        $room_control = new roomcontrol();

        $rc_room_id = $_REQUEST['rc_room_type_id'];
        $rc_in_date = $_REQUEST['rc_in_date'];
        $rc_out_date = $_REQUEST['rc_out_date'];
        $rc_num_room = $_REQUEST['rc_num_of_rooms'];

        $res = $room_control->getAllRoomDates($rc_in_date, $rc_out_date, $rc_room_id);
        $room_control->addRoomCotroller($rc_in_date, $rc_out_date, $rc_room_id, $rc_num_room, $res);

        $complete = new ProfileCompletion();
        $complete->setHotelStepId($_REQUEST['hotel_step_id']);
        $complete->setHotelStep1(1);
        $complete->updateProfileCompletionStep('7');
        echo($_REQUEST['hotel_step_id']);

    }

    function updateHotelsStep_6()
    {

        $hotelroomtype = new HotelRoomType();
        $hotelroomtype->setValues($_REQUEST);
        if ($hotelroomtype->updateHotelRoomType()) {
            $complete = new ProfileCompletion();
            $complete->setHotelStepId($_REQUEST['hotel_step_id']);
            $complete->setHotelStep1(1);
            $complete->updateProfileCompletionStep('7');
            echo($_REQUEST['hotel_step_id']);
            Common::jsonSuccess("");
        } else {
            Common::jsonError("Error");
        }
    }

    function loginHotels()
    {
        $username = $_REQUEST['hotel_email'];
        $password = $_REQUEST['hotel_password'];
        $session = new Sessions();

        $hotel = new Hotels();
        $hotel->setHotelEmail($username);
        $data = $hotel->getHotelFromEmailID();

        if (count($data) > 0) {

            $hotel->extractor($data);
            if (strcmp($hotel->hotelPassword(), md5($password)) == 0) {

                $session->setHotelsLoginSessions($hotel->hotelId(), $hotel->hotelName());
                Common::jsonSuccess("Success");

            } else {
                Common::jsonError("Login Error");
            }

        } else {
            Common::jsonError("Login Error");
        }
    }

    function logout()
    {
        $sessions = new Sessions();
        $sessions->logoutMember();
        $sessions->logoutClient();
        $sessions->logoutHotels();
        header("Location: " . HTTP_PATH . "hotels");
    }

    function deleteHotel()
    {

        $admin = new Hotels();

        $admin->setHotelId($_REQUEST['id']);

        if ($admin->deleteHotel()) {
            Common::jsonSuccess("Hotel Deleted Succesfully");
        } else {
            Common::jsonError("Error");
        }

    }

    function viewTable($data, $count)
    {

        $hotel = new Hotels();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewHotels");
        $paginations->setTotalPages($count);
        $paginations->makePagination();


        ?>
        <div class="mws-panel-header">
            <span class="mws-i-24 i-table-1">View Hotel</span>
        </div>
        <div class="mws-panel-body">
        <table cellpadding="0" cellspacing="0" border="0" class="mws-datatable-fn mws-table">
            <thead>
            <tr>
                <th>Hotel Name</th>
                <th>Hotel Hits</th>
                <th>Active Status</th>
                <th>Featured Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($data) > 0) { ?>

                <?php
                for ($i = 0; $i < count($data); $i++) {
                    $hotel->extractor($data, $i);
                    ?>
                    <tr id="row_<?php echo $hotel->hotelId(); ?>">
                        <td><?php echo $hotel->hotelName(); ?></td>
                        <td><?php echo $hotel->hotelHits(); ?></td>
                        <td>
                            <a href="#" style="cursor:pointer;<?php if ($hotel->hotelActiveStatus() == 0) {
                                echo('color:#900;');
                            } else {
                                echo('color:#469400;');
                            } ?>"
                               onclick="hotelActiveStatus(<?php echo($hotel->hotelId()); ?>,<?php echo($hotel->hotelActiveStatus()); ?>)">
                                <?php if ($hotel->hotelActiveStatus() == 1) {
                                    echo('Active');
                                } else {
                                    echo('Inactive');
                                } ?>
                            </a>
                        </td>
                        <td>
                            <a href="#" style="cursor:pointer;<?php if ($hotel->hotelsFeaturedStatus() == 0) {
                                echo('color:#900;');
                            } else {
                                echo('color:#469400;');
                            } ?>"
                               onclick="hotelsFeaturedStatus(<?php echo($hotel->hotelId()); ?>,<?php echo($hotel->hotelsFeaturedStatus()); ?>)">
                                <?php if ($hotel->hotelsFeaturedStatus() == 1) {
                                    echo('Featured');
                                } else {
                                    echo('Not Featured');
                                } ?>
                            </a>
                        </td>
                        <td><a onclick="login_as_hotels('<?php echo $hotel->hotelId(); ?>');" style="cursor:pointer;">login
                                as hotels</a></td>
                    </tr>
                <?php
                }
                ?>

            <?php } ?>
            </tbody>
        </table>

        <?php
        $paginations->drawPagination();
    }

    function viewTableFront($data, $count)
    {

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewHotelsFront");
        $paginations->setTotalPages($count);
        $paginations->makePagination();

        $mainCity = new MainCity();
        $hotels = new Hotels();
        $dicount_hotel = new Hotels();
        $country = new country();
        $SubCity = new SubCity();
        $hotelimages = new hotelimages();
        $discount = new HotelRoomRates();





        ?>

        <?php

        for ($x = 0; $x < count($data); $x++) {
            $dicount_hotel->extractor($data, $x);
            $discount->setHotelId($dicount_hotel->hotelId());
            $discount_data = $discount->getRatesFromHotelId();
            $discount->extractor($discount_data);

            if (round($discount->discountRatesUpLocal()) >= 0) {
                $new_hotel = new Hotels();
                $new_hotel->setHotelId($dicount_hotel->hotelId());
                $new_hotel_data = $new_hotel->getHotelFromId();
                $new_hotel->extractor($new_hotel_data);
                $hotelimages->setImageHotelId($new_hotel->hotelId());
                $hotelimages->extractor($hotelimages->getImageFromHotelsIdOne());
                $mainCity_discount = new MainCity();
                $mainCity_discount->setMainCityId($new_hotel->hotelMainCityId());
                $mainCity_discount->extractor($mainCity_discount->getMainCityFromId());

                $filename = '../../uploads/hotels/thumbnails/' . $hotelimages->imageName();

                ?>


                <div class="offer-listing">

                    <?php

                        if (file_exists($filename) && $hotelimages->imageName() != "") {
                            ?>
                            <img src="uploads/hotels/thumbnails/<?php echo $hotelimages->imageName(); ?>" width="157"
                                 height="130" alt="new_hotel"/>
                        <?php } else { ?>
                            <img src="images/no_image.jpg" alt="image" width="151" height="130"/>
                        <?php } ?>

                    <h4 onclick="makeAlert(<?php echo $new_hotel->hotelId(); ?>);"
                        style="cursor:pointer;"><?php echo($new_hotel->hotelName()); ?></h4>
                    <input type="hidden" id="<?php echo $new_hotel->hotelId(); ?>"
                           name="<?php echo $new_hotel->hotelId(); ?>"
                           value="<?php echo $new_hotel->hotelSeoUrl(); ?>"/>

                    <h5><?php echo($mainCity_discount->mainCityName()); ?></h5>

                    <p>
                        <?php echo(substr($new_hotel->hotelDescription(), 0, 250)); ?>
                    </p>

                    <div class="price_tag">
                        <span class="striked_price"><!--Rs. 5,600--></span>
                        <span class="actual_price"><?php if ($discount->dblBbSellLocal()) {
                                echo('LKR ' . $discount->dblBbSellLocal());
                            } else {
                                echo('N/A');
                            } ?></span>
                        <span class="label">Price Per Night</span>
                    </div>
                    <button onclick="makeAlert(<?php echo $new_hotel->hotelId(); ?>);">Book Now ></button>
                </div>



            <?php
            }
        } ?>

        <div id="pagination"><?php $paginations->drawPagination(); ?></div><?php } ?>