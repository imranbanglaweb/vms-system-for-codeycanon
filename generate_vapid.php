<?php
// Set OpenSSL config path for Windows XAMPP
$opensslPath = 'F:/xampp php8/apache/conf/openssl.cnf';
putenv('OPENSSL_CONF=' . $opensslPath);
$_ENV['OPENSSL_CONF'] = $opensslPath;

require_once __DIR__ . '/vendor/autoload.php';

use Minishlink\WebPush\VAPID;

try {
    $vapid = VAPID::createVapidKeys();
    
    echo "=== Generated VAPID Keys ===\n";
    echo "Public Key: " . $vapid['publicKey'] . "\n";
    echo "Private Key: " . $vapid['privateKey'] . "\n\n";
    
    echo "=== For .env file ===\n";
    echo "VAPID_PUBLIC_KEY=\"" . $vapid['publicKey'] . "\"\n";
    echo "VAPID_PRIVATE_KEY=\"" . $vapid['privateKey'] . "\"\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
