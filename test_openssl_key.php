<?php
// Set OpenSSL config path for Windows XAMPP
$opensslPath = 'F:/xampp php8/apache/conf/openssl.cnf';
putenv('OPENSSL_CONF=' . $opensslPath);
$_ENV['OPENSSL_CONF'] = $opensslPath;

// Generate EC key pair for VAPID
$config = [
    'private_key_type' => OPENSSL_KEYTYPE_EC,
    'curve_name' => 'prime256v1',
    'config' => $opensslPath,
];

$res = openssl_pkey_new($config);
if ($res) {
    echo "Key generation works!\n";
    $exportConfig = ['config' => $opensslPath];
    
    // Export private key
    if (openssl_pkey_export($res, $privateKey, null, $exportConfig)) {
        echo "Key export works!\n\n";
        
        // Get public key details
        $details = openssl_pkey_get_details($res);
        
        // Debug: print the details
        // print_r($details);
        
        // Create public key in uncompressed format (04 + X + Y)
        $x = $details['ec']['x'];
        $y = $details['ec']['y'];
        
        $publicKeyHex = '04' 
            . str_pad(bin2hex($x), 64, '0', STR_PAD_LEFT) 
            . str_pad(bin2hex($y), 64, '0', STR_PAD_LEFT);
        $publicKeyBinary = hex2bin($publicKeyHex);
        $publicKeyBase64 = rtrim(strtr(base64_encode($publicKeyBinary), '+/', '-_'), '=');
        
        echo "=== VAPID Keys ===\n";
        echo "Public Key: " . $publicKeyBase64 . "\n";
        echo "Private Key: " . $privateKey . "\n\n";
        
        // Also create a formatted private key for .env
        $privateKeyTrimmed = trim(str_replace([
            '-----BEGIN PRIVATE KEY-----',
            '-----END PRIVATE KEY-----',
            "\n",
            "\r"
        ], '', $privateKey));
        
        echo "=== For .env file ===\n";
        echo "VAPID_PUBLIC_KEY=\"$publicKeyBase64\"\n";
        echo "VAPID_PRIVATE_KEY=\"$privateKeyTrimmed\"\n";
        
    } else {
        echo "Key export failed: " . openssl_error_string() . "\n";
    }
} else {
    echo "Key generation failed: " . openssl_error_string() . "\n";
}
