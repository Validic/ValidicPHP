<?php
/**
 * Paging Tests
 */

// Show all errors
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

require __DIR__ . '/../vendor/autoload.php';
require 'demo.config.php';

use \Validic\Endpoint;
use \Validic\Filter;

define('PAGE_LIMIT', 10);

// set the timezone in case it is not set in the ini file
date_default_timezone_set('UTC');

$client = new Validic\Client($config['validic']['client']);

$start_date = new \Validic\Filter\StartDateFilter("2016-01-01");


/**
 * Routine data
 */
output("Requesting routine data with " . PAGE_LIMIT . " records per page.", 1);

$page_count = 0;
$total_pages = 0;

$request = $client->buildRequest(new Endpoint\RoutineEndpoint(), ['filters' => [$start_date, new \Validic\Filter\LimitFilter(PAGE_LIMIT)]]);

do {
    $response = $client->sendRequest($request);

    // get the result count from the summary
    if ($total_pages == 0) {
        $total_pages = ceil($response->getJson()['summary']['results'] / PAGE_LIMIT);
    }
    
    $page_count++;
    
} while ($request = $response->getNextPageRequest());

if ($page_count == $total_pages) {
    output($page_count . " of " . $total_pages . " pages retrieved.");
} else {
    output("Failed to retrieve " . $total_pages - $page_count . " pages.");
    exit;
}



function output($str, $new_lines = 2) {
    echo $str . str_repeat("<br />", $new_lines);
}