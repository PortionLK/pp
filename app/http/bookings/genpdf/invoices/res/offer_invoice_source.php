<?php
    if(session_id() == '') { //For versions of PHP < 5.4.0
        session_start();
    }

    //For versions of PHP >= 5.4.0
    /*if (session_status() == PHP_SESSION_NONE) {
    	session_start();
    }*/
    require_once('../../../_config/config.php');
    //require_once('../../../_controller/isset_controller.php');
    require_once('../../../_classes/order_class.php');
    require_once('../../../_classes/localisation_class.php');

    $classOrder = new ORDER;
    $classLocalisation = new LOCALISATION;

    $order_id = mysql_real_escape_string($_REQUEST['id']);

    $viewOrdersByIdCall = $classOrder->viewOrdersById($order_id);
    $rowOrder = mysql_fetch_array($viewOrdersByIdCall);

    $getVoucherByOrderIdCall = $classOrder->getVoucherByOrderId($order_id);
    $rowVoucherDet = mysql_fetch_array($getVoucherByOrderIdCall);

    $dateTime = new DateTime("now", new DateTimeZone('Asia/Colombo'));
    $submitted_date = $dateTime->format("Y-m-d H:i:s");

    $currentDate = date("F j, Y, g:i a");


?>

<div style="width:400px; height:auto; margin:0 auto; margin-top:40px;">
<table width="100%" border="0">
    <tr>
        <td colspan="2" style="width:300px; height:69px;"><img src="../../../../_images/logo.jpg" width="300"
                                                               height="69" alt="dfsdfds"/></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right"
            style="text-align:right; font-size:20px; font-family:Arial, Helvetica, sans-serif; color:#0072bc;"></td>
    </tr>
    <tr>
        <td colspan="2" align="right"
            style="text-align:right; font-size:11px; font-family:Arial, Helvetica, sans-serif; color:#2f2f2f;"><span
                style="font-size:15px; font-family:Arial, Helvetica, sans-serif;"><strong>Delivery
                    Address</strong></span><br/>
        <span style="font-size:11px; font-family:Arial, Helvetica, sans-serif; margin-top:5px;">ATTN:
            <?= "{$rowOrder['firstname']} {$rowOrder['lastname']}" ?>
        </span><br/>
        <span style="font-size:11px; font-family:Arial, Helvetica, sans-serif; margin-top:5px;">
        <?php
            if ($rowOrder['delivery_address'] != '') {
                echo stripslashes($rowOrder['delivery_address']);
            } else {
                echo stripslashes($rowOrder['address']);
            }
        ?>
        </span><br/>
        <span style="font-size:11px; font-family:Arial, Helvetica, sans-serif; margin-top:5px;">Tel :
            <?= $rowOrder['telephone_mob']; ?>
        </span><br/>
        <span style="font-size:11px; font-family:Arial, Helvetica, sans-serif; margin-top:5px;">
        <?php
            if ($rowOrder['post_code'] != '') {
                echo "Post Code : {$rowOrder['post_code']}";
            }
        ?>
      </span></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right"
            style="text-align:right; color:#2f2f2f; font-size:20px; font-family:Arial, Helvetica, sans-serif;">
            &nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" style="background:#efefef; padding:5px;"><span style="font-size:18px; font-weight:600;"><strong>Invoice
                    # tplk01<?= $rowOrder['order_id']; ?>0</strong></span><br/>
        <span style="font-size:12px; margin-top:5px;">Invoice Date :
            <?= $rowOrder['submitted_date']; ?>
        </span></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><span style="font-size:15px; font-family:Arial, Helvetica, sans-serif;"><strong>Invoiced
                    To</strong></span><br/>
        <span style="font-size:11px; font-family:Arial, Helvetica, sans-serif; margin-top:5px;">ATTN:
            <?= "{$rowOrder['firstname']} {$rowOrder['lastname']}" ?>
        </span><br/>
        <span style="font-size:11px; font-family:Arial, Helvetica, sans-serif; margin-top:5px;">
        <?= stripslashes($rowOrder['address']); ?>
        </span><br/>
        <span style="font-size:11px; font-family:Arial, Helvetica, sans-serif; margin-top:5px;">Tel :
            <?= $rowOrder['telephone_mob']; ?>
        </span><br/></td>
        <td align="center"><?php
                switch ($rowOrder['payment_status']) {
                    case 1:
                        echo '<span style="font-size:40px; font-family:Arial, Helvetica, sans-serif; color:#090; font-weight:bold;">PAID</span>';
                        break;

                    case 0:
                        echo '<span style="font-size:40px; font-family:Arial, Helvetica, sans-serif; color:#F30; font-weight:bold;">UN PAID</span>';
                        break;
                }
            ?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" bgcolor="#2f2f2f" align="center"
            style=" width:750px; text-align:center; padding:6px 0; color:#FFFFFF; font-size:16px; font-family:Arial, Helvetica, sans-serif; border-bottom:3px solid #666;">
            Customer Invoice for recent purchased
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>

<table width="500" border="0" align="center" cellpadding="10" cellspacing="0" id="names">
    <tr>
        <td style="width:200px;text-align:center; padding:5px; background:#2f2f2f; color:#FFFFFF; text-transform:uppercase; font-size:12px; font-family:Arial, Helvetica, sans-serif;">
            product DETAILS
        </td>
        <td style="text-align:center; padding:5px; background:#2f2f2f; color:#FFFFFF; text-transform:uppercase; font-size:12px; font-family:Arial, Helvetica, sans-serif;">
            unit price
        </td>
        <td style="text-align:center; padding:5px; background:#2f2f2f; color:#FFFFFF; text-transform:uppercase; font-size:12px; font-family:Arial, Helvetica, sans-serif;">
            qty
        </td>
        <td style="text-align:center; padding:5px; background:#2f2f2f; color:#FFFFFF; text-transform:uppercase; font-size:12px; font-family:Arial, Helvetica, sans-serif;">
            <!--Total Item<br/> Weight--></td>
        <td style="text-align:center; padding:5px; background:#2f2f2f; color:#FFFFFF; text-transform:uppercase; font-size:12px; font-family:Arial, Helvetica, sans-serif;">
            AMOUNT
        </td>
    </tr>
    <?php
        $total_weight = 0;
        $total_delivery_final = 0;
        $viewOrderProductByIdCall = $classOrder->viewOrderProductById($rowOrder['order_id']);
        while ($rowoder_pro = mysql_fetch_array($viewOrderProductByIdCall)) {
            ?>
            <tr>
                <td style="width:200px;padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-right:1px dashed #CCC; border-bottom:1px dashed #CCC;"><?= $rowoder_pro['product_name']; ?>
                    (Included Relevant Tax)<br/>
                    <?php /*<em>(Unit Weight :
        <?=$rowoder_pro['product_unit_weight']; ?>
        Kg)</em> */
                    ?></td>
                <td style="text-align:center; padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-bottom:1px dashed #CCC; border-right:1px dashed #CCC;"><?= "{$rowOrder['curr_prefix']} {$rowoder_pro['product_unit_with_tax']} {$rowOrder['curr_suffix']}"; ?></td>
                <td style="text-align:center; padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-bottom:1px dashed #CCC; border-right:1px dashed #CCC;"><?= $rowoder_pro['product_quantity']; ?></td>
                <td style="text-align:center; padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-bottom:1px dashed #CCC; border-right:1px dashed #CCC;">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php /*?><?= $rowoder_pro['product_unit_weight']*$rowoder_pro['product_quantity'].'  (Kg)'; ?><?php */ ?></td>
                <td style="text-align:center; padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-bottom:1px dashed #CCC;"><?= "{$rowOrder['curr_prefix']} {$rowoder_pro['product_total_price']} {$rowOrder['curr_suffix']}"; ?></td>
            </tr>
            <?
            $total_weight = ($rowoder_pro['product_unit_weight'] * $rowoder_pro['product_quantity']) + $total_weight;
            //$total_delivery_final=$rowoder_pro['product_tot_delivery_charge']+$total_delivery_final;
        }
    ?>

    <tr>
        <td style="padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-right:1px dashed #CCC; border-bottom:1px dashed #CCC;">
            <strong>Delivery Note : </strong><?= $rowOrder['delivery_note']; ?><br/>
            <strong>Delivery Date : </strong><?= $rowOrder['delivery_date']; ?></td>
        <td style="text-align:center; padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-bottom:1px dashed #CCC; border-right:1px dashed #CCC;">
            &nbsp;</td>
        <td style="text-align:center; padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-bottom:1px dashed #CCC; border-right:1px dashed #CCC;">
            &nbsp;</td>
        <td style="text-align:center; padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-bottom:1px dashed #CCC; border-right:1px dashed #CCC;">
            &nbsp;</td>
        <td style="text-align:center; padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-bottom:1px dashed #CCC;">
            &nbsp;</td>
    </tr>
    <tr>
        <td style="text-align:center; padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-right:1px dashed #CCC; border-bottom:1px dashed #CCC;">
            &nbsp;</td>
        <td style="text-align:center; padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-bottom:1px dashed #CCC; border-right:1px dashed #CCC;">
            &nbsp;</td>
        <td style="text-align:center; padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-bottom:1px dashed #CCC; border-right:1px dashed #CCC;">
            &nbsp;</td>
        <td style="text-align:center; padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-bottom:1px dashed #CCC; border-right:1px dashed #CCC;">
            &nbsp;</td>
        <td style="text-align:center; padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-bottom:1px dashed #CCC;">
            &nbsp;</td>
    </tr>
    <tr>
        <td colspan="4" align="right"
            style=" padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-right:1px dashed #CCC; border-bottom:1px dashed #CCC;">
            <strong>Total Qty</strong></td>
        <td style="text-align:center; padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-bottom:1px dashed #CCC;"><?= $rowOrder['total_qty']; ?></td>
    </tr>
    <?php /*?> <tr>
      <td colspan="4" align="right" style=" padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-right:1px dashed #CCC; border-bottom:1px dashed #CCC;"><strong>Total Weight</strong></td>
      <td style="text-align:center; padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-bottom:1px dashed #CCC;"><?= $total_weight; ?>
        Kg</td>
    </tr><?php */
    ?>
    <tr>
        <td colspan="4" align="right"
            style=" padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-right:1px dashed #CCC; border-bottom:1px dashed #CCC;">
            <strong>Total Delivery Charge</strong></td>
        <td style="text-align:center; padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-bottom:1px dashed #CCC;"><?php
                $total_delivery_final = number_format($rowOrder['total_deliver_charge'], 2);

            ?>
            <?= "{$rowOrder['curr_prefix']} {$total_delivery_final}  {$rowOrder['curr_suffix']}"; ?></td>
    </tr>

    <?php
        if ($rowVoucherDet['voucher_id'] != '') {
            ?>
            <tr>
                <td colspan="4" align="right"
                    style=" padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-right:1px dashed #CCC; border-bottom:1px dashed #CCC;">
                    <strong>Voucher Deduction :<br/>
                        <em class="size-11">Voucher Code : <?= $rowVoucherDet['voucher_code']; ?></em></strong></td>
                <td style="text-align:center; padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-bottom:1px dashed #CCC;"><?= "{$rowOrder['curr_prefix']} {$rowVoucherDet['voucher_amount']}  {$rowOrder['curr_suffix']}"; ?></td>
            </tr>
        <?
        } else {
        } ?>


    <tr>
        <td colspan="4" align="right" bgcolor="#e7e7e7"
            style="padding:10px; color:#2f2f2f; font-size:11px; font-family:Arial, Helvetica, sans-serif; border-right:1px dashed #CCC; border-bottom:2px solid #c7c7c7;">
            <strong>Total Due Price</strong></td>
        <td bgcolor="#e7e7e7"
            style="text-align:center; padding:10px; color:#2f2f2f; font-size:14px; font-family:Arial, Helvetica, sans-serif; border-top:1px solid #c7c7c7; border-bottom:2px solid #c7c7c7;">
            <strong>
                <?php
                    $order_total = number_format($rowOrder['order_total'], 2);

                ?>
                <?= "{$rowOrder['curr_prefix']} {$order_total}  {$rowOrder['curr_suffix']}"; ?>
            </strong></td>
    </tr>
</table>
<br/>
&nbsp;
<p align="center">
<table width="100%" border="0" align="center">
    <tr>
        <td align="center"
            style="font-size:10px; font-family:Arial, Helvetica, sans-serif; color:#CCC; text-align:center;">
            <table width="100%" border="0" cellpadding="5">
                <tr style="font-size:12px; font-family:Arial, Helvetica, sans-serif;"
                ">
                <td width="6%"><strong>Name : </strong></td>
                <td width="48%">...........................................................</td>
                <td width="11%"><strong>NIC No : </strong></td>
                <td width="35%">...........................................................</td>
                </tr>
                <tr style="font-size:12px; font-family:Arial, Helvetica, sans-serif;"
                ">
                <td><strong>Date : </strong></td>
                <td>...........................................................</td>
                <td><strong>Signature : </strong></td>
                <td>...........................................................</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center"
            style="font-size:10px; font-family:Arial, Helvetica, sans-serif; color:#CCC; text-align:center;">&nbsp;</td>
    </tr>
    <tr>
        <td align="center"
            style="font-size:10px; font-family:Arial, Helvetica, sans-serif; color:#CCC; text-align:center;">&nbsp;</td>
    </tr>


    <tr>
        <td align="center"
            style="font-size:10px; font-family:Arial, Helvetica, sans-serif; color:#333; text-align:center;"><strong>NAG
                HOLDINGS (Pvt) LTD</strong>, 42/A, Walter Gunasekara Mawatha, Nawala, Sri Lanka.
            <strong><br>
                Tel :</strong>0112806080 / 0114336080 / 0115336080 <strong>Hot Line :</strong>071 1708090
            <strong>e-mail :</strong> sales@topshop.lk / support@topshop.lk<br></td>
    </tr>


    <tr>
        <td align="center"
            style="font-size:10px; font-family:Arial, Helvetica, sans-serif; color:#CCC; text-align:center;">Please note
            that this is a computer generated report. do not reply to this email. This mailbox is not monitored and you
            will not receive a response.
        </td>
    </tr>
    <tr>
        <td align="center"
            style="font-size:11px; font-family:Arial, Helvetica, sans-serif; color:#666; text-align:center;"><span
                style="color:#360; font-size:10px;">Do you really need to print this document? If yes, please print only the pages you need. Help make a difference, save paper, help save the planet.</span><br/>
            <br/>
            © Topshop :: Online Shopping Solution 2011-2012. All rights Reserved.
        </td>
    </tr>
    <tr>
        <td align="center"><a href="http://www.weblook.com" target="_blank"
                              style="color:#09C; font-size:11px; font-family:Arial, Helvetica, sans-serif;">Software by
                : Weblook.com</a></td>
    </tr>
</table>
</p>
</div>