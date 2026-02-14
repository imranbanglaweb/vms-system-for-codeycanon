<?php
// Use local openssl.cnf from PHP extras directory
$opensslPath = __DIR__ . '/openssl2.cnf';

echo "Using: $opensslPath\n";
echo "Exists: " . (file_exists($opensslPath) ? "YES" : "NO") . "\n";

if (!file_exists($opensslPath)) {
    echo "openssl.cnf not found!\n";
    exit(1);
}

putenv('OPENSSL_CONF=' . $opensslPath);
$_ENV['OPENSSL_CONF'] = $opensslPath;

// Test key generation
echo "\nTest: Generating key...\n";
$config = [
    'private_key_type' => OPENSSL_KEYTYPE_EC,
    'curve_name' => 'prime256v1',
];

$res = @openssl_pkey_new($config);
if ($res) {
    echo "  Key created!\n";
    
    // Export with config
    $exportResult = '';
    $exportOk = @openssl_pkey_export($res, $exportResult, null, ['config' => $opensslPath]);
    if ($exportOk) {
        echo "  Export succeeded!\n";
        
        // Get details
        $details = openssl_pkey_get_details($res);
        if (isset($details['ec'])) {
            $xHex = $details['ec']['x'];
            $yHex = $details['ec']['y'];
            
            // Get private key D value
            $prv = openssl_pkey_get_private($exportResult);
            $prvDetails = openssl_pkey_get_details($prv);
            $dHex = $prvDetails['ec']['d'];
            
            // Convert to base64url
            $dBin = hex2bin($dHex);
            $dBase64Url = rtrim(strtr(base64_encode($dBin), '+/', '-_'), '=');
            
            $xBin = hex2bin(str_pad($xHex, 64, '0', STR_PAD_LEFT));
            $yBin = hex2bin(str_pad($yHex, 64, '0', STR_PAD_LEFT));
            $pubKeyBin = "\x04" . $xBin . $yBin;
            $pubKeyBase64Url = rtrim(strtr(base64_encode($pubKeyBin), '+/', '-_'), '=');
            
            echo "\n=== VAPID Keys ===\n";
            echo "Public Key: " . $pubKeyBase64Url . " (len: " . strlen($pubKeyBase64Url) . ")\n";
            echo "Private Key: " . $dBase64Url . " (len: " . strlen($dBase64Url) . ")\n\n";
            
            echo "=== For .env file ===\n";
            echo "VAPID_PUBLIC_KEY=\"$pubKeyBase64Url\"\n";
            echo "VAPID_PRIVATE_KEY=\"$dBase64Url\"\n";
        }
    } else {
        echo "  Export failed: " . openssl_error_string() . "\n";
    }
} else {
    echo "  Failed: " . openssl_error_string() . "\n";
}
