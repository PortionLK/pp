<html>
<script type="text/javascript">
    function myfunc() {
        var frm = document.getElementById("login");
        frm.submit();
    }
</script>
<body>

<?php

    /*$mcode = $_REQUEST['merchantCode'];
    $tid = $_REQUEST['transactionId'];
    $tamount = $_REQUEST['transactionAmount'];
    $rurl =$_REQUEST['returnUrl'];*/

    $mcode = "TESTMERCHANT";
    $tid = "TEST" + 2820;
    $tamount = "10";
    $rurl = "http://roomista.com/decrypt.php";

    $sensitiveData = $mcode . '|' . $tid . '|' . $tamount . '|' . $rurl;

    $publicKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCW8KV72IMdhEuuEks4FXTiLU2o
bIpTNIpqhjgiUhtjW4Si8cKLoT7RThyOvUadsgYWejLg2i0BVz+QC6F7pilEfaVS
L/UgGNeNd/m5o/VoX9+caAIyu/n8gBL5JX6asxhjH3FtvCRkT+AgtTY1Kpjb1Btp
1m3mtqHh6+fsIlpH/wIDAQAB
-----END PUBLIC KEY-----
EOD;


    $encrypted = '';
    if (!openssl_public_encrypt($sensitiveData, $encrypted, $publicKey)) die('Failed to encrypt data');

    $encryptedData = base64_encode($encrypted);

?>

<form id='login' action='https://ipg.dialog.lk/ezCashIPGExtranet/servlet_sentinal' method='post'>
    <input type='hidden' name='merchantInvoice' value='<?php echo $encryptedData; ?>'/>

    <?= $encryptedData ?>


</form>

</body>
</html>