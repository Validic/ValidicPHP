<?php
/**
 * Endpoint Tests
 */

// Show all errors
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

require __DIR__ . '/../vendor/autoload.php';
require 'demo.config.php';

use \Validic\Endpoint;

// set the timezone in case it is not set in the ini file
date_default_timezone_set('UTC');

$client = new Validic\Client($config['validic']['client']);

$start_date = new \Validic\Filter\StartDateFilter("2016-01-01");


/**
 * Routine data
 */
output("Requesting routine data", 1);

$response = $client->buildAndSendRequest(new Endpoint\RoutineEndpoint(), ['filters' => [$start_date]]);

if ($response->succeeded()) {
    output("Routine data: " . substr($response, 0, 500));
} else {
    output("Routine data failed: " . join(", ", $response->getErrors()));
    exit;
}


/**
 * Fitness data
 */
output("Requesting fitness data", 1);

$response = $client->buildAndSendRequest(new Endpoint\FitnessEndpoint(), ['filters' => [$start_date]]);

if ($response->succeeded()) {
    output("Fitness data: " . substr($response, 0, 500));
} else {
    output("Fitness data failed: " . join(", ", $response->getErrors()));
    exit;
}


/**
 * Nutrition data
 */
output("Requesting nutrition data", 1);

$response = $client->buildAndSendRequest(new Endpoint\NutritionEndpoint(), ['filters' => [$start_date]]);

if ($response->succeeded()) {
    output("Nutrition data: " . substr($response, 0, 500));
} else {
    output("Nutrition data failed: " . join(", ", $response->getErrors()));
    exit;
}


/**
 * Weight data
 */
output("Requesting weight data", 1);

$response = $client->buildAndSendRequest(new Endpoint\WeightEndpoint(), ['filters' => [$start_date]]);

if ($response->succeeded()) {
    output("Weight data: " . substr($response, 0, 500));
} else {
    output("Weight data failed: " . join(", ", $response->getErrors()));
    exit;
}


/**
 * Biometrics data
 */
output("Requesting biometrics data", 1);

$response = $client->buildAndSendRequest(new Endpoint\BiometricsEndpoint(), ['filters' => [$start_date]]);

if ($response->succeeded()) {
    output("Biometrics data: " . substr($response, 0, 500));
} else {
    output("Biometrics data failed: " . join(", ", $response->getErrors()));
    exit;
}


/**
 * Diabetes data
 */
output("Requesting diabetes data", 1);

$response = $client->buildAndSendRequest(new Endpoint\DiabetesEndpoint(), ['filters' => [$start_date]]);

if ($response->succeeded()) {
    output("Diabetes data: " . substr($response, 0, 500));
} else {
    output("Diabetes data failed: " . join(", ", $response->getErrors()));
    exit;
}


/**
 * Sleep data
 */
output("Requesting sleep data", 1);

$response = $client->buildAndSendRequest(new Endpoint\SleepEndpoint(), ['filters' => [$start_date]]);

if ($response->succeeded()) {
    output("Sleep data: " . substr($response, 0, 500));
} else {
    output("Sleep data failed: " . join(", ", $response->getErrors()));
    exit;
}


/**
 * Users data
 */
output("Requesting users data", 1);

$response = $client->buildAndSendRequest(new Endpoint\UsersEndpoint());

if ($response->succeeded()) {
    output("Users data: " . substr($response, 0, 500));
} else {
    output("Users data failed: " . join(", ", $response->getErrors()));
    exit;
}


/**
 * Organization data
 */
output("Requesting organization data", 1);

$response = $client->buildAndSendRequest(new Endpoint\OrganizationEndpoint());

if ($response->succeeded()) {
    output("Organization data: " . substr($response, 0, 500));
} else {
    output("Organization data failed: " . join(", ", $response->getErrors()));
    exit;
}


/**
 * Apps data
 */
output("Requesting apps data", 1);

$response = $client->buildAndSendRequest(new Endpoint\AppsEndpoint());

if ($response->succeeded()) {
    output("Apps data: " . substr($response, 0, 500));
} else {
    output("Apps data failed: " . join(", ", $response->getErrors()));
    exit;
}




function output($str, $new_lines = 2) {
    echo $str . str_repeat("<br />", $new_lines);
}