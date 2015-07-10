<?php
    define('_MEXEC', 'OK');
    require_once("../system/load.php");
    include("upload_class.php"); //classes is the map where the class file is stored

    $session = new Sessions();
    $upload = new file_upload();

    $upload->upload_dir = '../uploads/hotel-gal/';
    $upload->extensions = array('.png', '.jpg'); // specify the allowed extensions here
    $upload->rename_file = true;

    $image_list = array();

    $hotel_file_id = $_REQUEST['hotel_file_id'];

    if (!empty($_FILES) && $hotel_file_id != '') {
        $upload->the_temp_file = $_FILES['userfile']['tmp_name'];
        $upload->the_file = $_FILES['userfile']['name'];
        $upload->http_error = $_FILES['userfile']['error'];
        $upload->do_filename_check = 'y'; // use this boolean to check for a valid filename
        $upload->hotel_image_id = $hotel_file_id . '_' . $_FILES['userfile']['name'];

        if ($upload->upload()) {
            echo '<div id="status">success</div>';
            echo '<div id="message">' . $upload->file_copy . ' Successfully Uploaded</div>';
            //return the upload file
            echo '<div id="uploadedfile">' . $upload->file_copy . '</div>';
            //---------------thumbanail-------------------
            $src = "../uploads/hotel-gal/" . $upload->file_copy;
            $dest = "../uploads/hotels/thumbnails/" . $upload->file_copy;
            $desired_width = 205;

            /* read the source image */
            $source_image = imagecreatefromjpeg($src);
            $width = imagesx($source_image);
            $height = imagesy($source_image);

            /* find the "desired height" of this thumbnail, relative to the desired width  */
            $desired_height = floor($height * ($desired_width / $width));

            /* create a new, "virtual" image */
            $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

            /* copy source image at a resized size */
            imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

            /* create the physical thumbnail image to its destination */
            imagejpeg($virtual_image, $dest);
            //----------------------------------

            $image_list .= $upload->file_copy . ',';

            $session->setHotelImageUploadList($image_list);

            $hotels = new Hotels();
            $hotels->setHotelId($hotel_file_id);
            $hotels->extractor($hotels->getHotelFromId());
            $hotel_img = $hotels->hotelsImages();

            //$img_list = "";

            if ($hotel_img != '') {
                $hotel_img .= ',' . $upload->file_copy;
                $hotels->updateHotelsImages($hotel_img);
                //$img_list = $hotel_img;
            } else {
                $hotels->updateHotelsImages($upload->file_copy);
                //$img_list = $upload->file_copy;
            }

            $hotel_images = new HotelImages();
            $hotel_images->setImageHotelId($hotel_file_id);
            $hotel_images->setImageType('main');
            $hotel_images->setImageName($upload->file_copy);
            $hotel_images->setImageTitle('');
            $hotel_images->setImagePosition('');

            $hotel_images->newImage();
        } else {

            echo '<div id="status">failed</div>';
            echo '<div id="message">' . $upload->show_error_string() . '</div>';

        }
    }
?>