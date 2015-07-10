<?php
    if(session_id() == '') { //For versions of PHP < 5.4.0
        session_start();
    }

    //For versions of PHP >= 5.4.0
    /*if (session_status() == PHP_SESSION_NONE) {
    	session_start();
    }*/
    include("pgconfig.php"); ?>
<html>
<?php

    $perform = $_REQUEST["perform"];
    $currencyCode = $_REQUEST["currency_code"];
    $amount = $_REQUEST["amount"] * 100;
    $merchantReferenceNo = $_REQUEST["merchant_reference_no"];
    $orderDesc = $_REQUEST["order_desc"];


    $messageHash = $pgInstanceId . "|" . $merchantId . "|" . $perform . "|" . $currencyCode . "|" . $amount . "|" . $merchantReferenceNo . "|" . $hashKey . "|";
    $message_hash = "CURRENCY:7:" . base64_encode(sha1($messageHash, true));


?>
<head><title>Processing..</title>
    <script language="javascript">
        function onLoadSubmit() {
            document.merchantForm.submit();
        }
    </script>
</head>

<body onLoad="onLoadSubmit();">
<br/>&nbsp;<br/>
<center><font size="5" color="#3b4455">Transaction is being processed,<br/>Please wait ...</font></center>
<form name="merchantForm" method="post" action="https://<?php echo $pgdomain; ?>/AccosaPG/verify.jsp">

    <input type="hidden" name="pg_instance_id" value="<?php echo $pgInstanceId; ?>"/>
    <input type="hidden" name="merchant_id" value="<?php echo $merchantId; ?>"/>

    <input type="hidden" name="perform" value="<?php echo $perform; ?>"/>
    <input type="hidden" name="currency_code" value="<?php echo $currencyCode; ?>"/>
    <input type="hidden" name="amount" value="<?php echo $amount; ?>"/>
    <input type="hidden" name="merchant_reference_no" value="<?php echo $merchantReferenceNo; ?>"/>
    <input type="hidden" name="order_desc" value="<?php echo $orderDesc; ?>"/>

    <input type="hidden" name="message_hash" value="<?php echo $message_hash; ?>"/>

    <noscript>
        <br/>&nbsp;<br/>
        <center>
            <font size="3" color="#3b4455">
                JavaScript is currently disabled or is not supported by your browser.<br/>
                Please click Submit to continue the processing of your transaction.<br/>&nbsp;<br/>
                <input type="submit"/>
            </font>
        </center>
    </noscript>
</form>
</body>
</html>
