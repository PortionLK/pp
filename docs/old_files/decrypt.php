<?php

    $decrypted = '';
    $encrypted = $_REQUEST['merchantReciept'];

    $privateKey = <<<EOD
-----BEGIN PRIVATE KEY-----
Please append your private key content 
-----END PRIVATE KEY-----
EOD;
    $encrypted = base64_decode($str); // decode the encrypted query string
    if (!openssl_private_decrypt($encrypted, $decrypted, $privateKey)) die('Failed to decrypt data');

    echo "Decrypted value: " . $decrypted;

?>
