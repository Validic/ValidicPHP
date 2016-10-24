<?php
/**
 * Push Notification Signature Tests
*/

// Show all errors
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

require __DIR__ . '/../vendor/autoload.php';
//require '../include/config.php';

use \Validic\PushNotification\PushNotification;

// set the timezone in case it is not set in the ini file
date_default_timezone_set('UTC');

//$client = new Validic\Client($config['validic']['client']);

// Generate a random access token
$access_token = random_string(64);

// Generate a random application secret
$application_secret = random_string(64);


//2016-06-06T13:10:50641427307000
//2016-06-07T04:59.24641108512878
$x_validic_timestamp = new DateTime();


$micro = explode('.', number_format(microtime(true), 14));
echo $x_validic_timestamp->format('Y-m-d') . 'T' . $x_validic_timestamp->format('h:i') . '.' . $micro[1];


exit;


$signature = base64_encode(hash_hmac('sha1', $access_token . 'notification' . $x_validic_timestamp->format('cu'), $application_secret, true));


















/**
 * Generate a random string.
 *
 * @param number $length
 * @return string
*/
function random_string($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $options = strlen($characters) - 1;
    $random = '';

    for ($i = 0; $i < $length; $i ++) {
        $random .= $characters[mt_rand(0, $options)];
    }

    return $random;
}