<?php
/**
 * User Tests
 */

// Show all errors
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

require __DIR__ . '/../vendor/autoload.php';
require 'demo.config.php';

use \Validic\User\User;

// set the timezone in case it is not set in the ini file
date_default_timezone_set('UTC');

$client = new Validic\Client($config['validic']['client']);

$user = new User(['uid' => rand(1000000, 9999999)]);


/**
 * Create user
 */
output("Creating a new user with random uid", 1);

$response = $user->buildAndSendRequestCreate($client);

if ($response->succeeded()) {
    output("User created: " . json_encode(['uid' => $user->uid, 'validic_id' => $user->validic_id, 'authentication_token' => $user->authentication_token]));
} else {
    output("User creation failed: " . join(", ", $response->getErrors()));
    exit;
}


/**
 * Update user
 */
output("Updating the user", 1);

$user->gender = 'F';
$user->country = 'USA';
$user->uid = rand(1000000, 9999999);

$response = $user->buildAndSendRequestUpdate($client);

if ($response->succeeded()) {
    output("User updated: " . json_encode(['uid' => $user->uid, 'gender' => $user->gender, 'country' => $user->country]));
} else {
    output("User update failed: " . join(", ", $response->getErrors()));
    exit;
}


/**
 * Suspend user
 */
output("Suspending the user", 1);

$response = $user->buildAndSendRequestSuspend($client);

if ($response->succeeded()) {
    output("User suspended: " . $response);
} else {
    output("User suspend failed: " . join(", ", $response->getErrors()));
}


/**
 * Unsuspend user
 */
output("Unsuspending the user", 1);

$response = $user->buildAndSendRequestUnsuspend($client);

if ($response->succeeded()) {
    output("User unsuspended: " . $response);
} else {
    output("User unsuspend failed: " . join(", ", $response->getErrors()));
}


/**
 * Refresh user token
 */
output("Refreshing the user's token", 1);

$response = $user->buildAndSendRequestRefreshToken($client);

if ($response->succeeded()) {
    output("Token refreshed: " . json_encode(['authentication_token' => $user->authentication_token]));
} else {
    output("Token refresh failed: " . join(", ", $response->getErrors()));
    exit;
}


/**
 * Get user's id from uid
 */
output("Getting the user's id from uid", 1);

$new_user = new User(['uid' => $user->uid]);

$response = $new_user->buildAndSendRequestIdFromUid($client);

if ($response->succeeded()) {
    output("Validic id retrieved: " . json_encode(['validic_id' => $new_user->validic_id]));
} else {
    output("Validic id retrieval failed: " . join(", ", $response->getErrors()));
    exit;
}


/**
 * Get user's id from token
 */
output("Getting the user's id from authentication token", 1);

$new_user = new User(['authentication_token' => $user->authentication_token]);

$response = $new_user->buildAndSendRequestIdFromAuthToken($client);

if ($response->succeeded()) {
    output("Validic id retrieved: " . json_encode(['validic_id' => $new_user->validic_id]));
} else {
    output("Validic id retrieval failed: " . join(", ", $response->getErrors()));
    exit;
}


/**
 * Get user's profile
 */
output("Getting the user's profile", 1);

$response = $new_user->buildAndSendRequestProfile($client);

if ($response->succeeded()) {
    output("Profile retrieved: " . json_encode(['gender' => $new_user->gender, 'country' => $new_user->country, 'uid' => $new_user->uid]));
} else {
    output("Profile retrieval failed: " . join(", ", $response->getErrors()));
    exit;
}


/**
 * Delete user
 */
$response = $user->buildAndSendRequestDelete($client);
if ($response->succeeded()) {
    output("User deleted: " . $response);
} else {
    output("User deletion failed: " . join(", ", $response->getErrors()));
    exit;
}





function output($str, $new_lines = 2) {
    echo $str . str_repeat("<br />", $new_lines);
}