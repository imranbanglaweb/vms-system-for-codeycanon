<?php

// Set OpenSSL config path for Windows XAMPP before loading
if (PHP_OS === 'WINNT') {
    $opensslPath = 'F:/xampp php8/apache/conf/openssl.cnf';
    if (file_exists($opensslPath) && !getenv('OPENSSL_CONF')) {
        putenv('OPENSSL_CONF=' . $opensslPath);
    }
}

return [

    /**
     * These are the keys for authentication (VAPID).
     * These keys must be safely stored and should not change.
     */
    'vapid' => [
        'subject' => 'mailto:md.imran1200@gmail.com',
        'public_key' => env('VAPID_PUBLIC_KEY', 'BL8nB7H3jyXBugZ7NQbhyBidyynLlM9Ieuc1DaEYGpAp_adPZ1v8wGr94K2MGF1iXmX-qQSkZD9FdoNgXjY8SOY'),
        'private_key' => env('VAPID_PRIVATE_KEY', 'tkx0-90569Jleb0zToTjJ_WaTH-bqfqbbpbz-8ww3Dk'),
    ],

    /**
     * This is model that will be used to for push subscriptions.
     */
    'model' => \NotificationChannels\WebPush\PushSubscription::class,

    /**
     * This is the name of the table that will be created by the migration and
     * used by the PushSubscription model shipped with this package.
     */
    'table_name' => env('WEBPUSH_DB_TABLE', 'push_subscriptions'),

    /**
     * This is the database connection that will be used by the migration and
     * the PushSubscription model shipped with this package.
     */
    'database_connection' => env('WEBPUSH_DB_CONNECTION', env('DB_CONNECTION', 'mysql')),

    /**
     * The Guzzle client options used by Minishlink\WebPush.
     */
    'client_options' => [],

    /**
     * Google Cloud Messaging.
     *
     * @deprecated
     */
    'gcm' => [
        'key' => env('GCM_KEY'),
        'sender_id' => env('GCM_SENDER_ID'),
    ],

];
