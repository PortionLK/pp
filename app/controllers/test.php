<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $query = "SELECT * FROM  room_rates WHERE room_rate_id= '30'";
    $rescc = mysql_query($query) or die(mysql_error());
    $row_xx = mysql_fetch_array($rescc);

    $sql = "SHOW COLUMNS FROM room_rates";
    $res = mysql_query($sql) or die(mysql_error());

    $ic = 0;
    while ($rowCol = mysql_fetch_array($res)) {
        if ($ic > 7 && $ic < 67) {
            $ARRAY[$ic] = $row_xx[$rowCol['Field']];

        }
        $ic++;
    }

    echo $ARRAY[54];

    $val_array = array();

    for ($x = 67; $x > 7; $x--) {
        $y = ($x - 1);
        if ($x < 36) {
            $val_array_local[] = (($ARRAY[$x] - $ARRAY[$y]) / 100);
        } else {
            $val_array_foreign[] = (($ARRAY[$x] - $ARRAY[$y]) / 100);
        }
    }

    var_dump($val_array_local);
    var_dump($val_array_foreign);

    echo max($val_array_foreign) . ' = ' . max($val_array_local);
    echo('<br>');
    echo min($val_array_foreign) . ' = ' . min($val_array_local);

?>