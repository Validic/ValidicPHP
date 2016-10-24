# Validic PHP Wrapper

The Validic PHP Wrapper is an easy to use wrapper with many customizable options
to help you get started with Validic. The Client class performs retries and
returns the response and errors from Validic. The User class has many helper
functions to make managing Validic users easier.

This project uses GuzzleHttp. You may use Composer to handle your dependencies
and provide an autoloader for the Validic PHP Wrapper.

## Basic Client Setup

You can configure a new client to have many default options that can be overriden
by individual requests.

```php
require __DIR__ . '/vendor/autoload.php';

use Validic\Client;

/**
 * @see Validic\ClientOptions for all options
 */
$config = [
    'organization_id' => 'ORGANIZATION_ID',
    'access_token' => 'ORGANIZATION_ACCESS_TOKEN'
];

$validic_client = new Client($config);
```

## Routine data retrieval example

Any buildAndSend function can use options from Validic\BuildRequestOptions and 
SendRequest options. Using these options you can specify query parameters, a.k.a. filters,
a user's id, or headers.

```php
use Validic\Endpoint\RoutineEndpoint;
use Validic\Filter\StartDateFilter;

/**
 * @see Validic\Endpoint\Endpoints for all available endpoints
 * @see Validic\BuildRequestOptions for all available build options and
 * references to available filters and headers
 * @see Validic\SendRequestOptions for all available send options
 */
$response = $validic_client->buildAndSendRequest(
    new RoutineEndpoint(),
    [
        'filters' => [
            new StartDateFilter(date('Y-m-d'))
        ]
    ]
);

if ( $response->succeeded() ) {

    // save the data
    $routine_json = $response->getJson();
    
} else {

    // you can save the request and try again later
    $request = serialize($response->getRequest());

}
```

## Paginated routine data retrieval example

```php
$request = $validic_client->buildRequest(
    new RoutineEndpoint(),
    [
        'filters' => [
            new StartDateFilter(date('Y-m-d'))
        ]
    ]
);

do {
    
    $response = $validic_client->sendRequest($request);
    
    if ( $response->succeeded() ) {
    
        // save the data
        // the json response will contain the entire json response including
        // the summary
        $routine_json = $response->getJson();
    
    } else {
    
        // you can save the request and try again later
        $request = serialize($response->getRequest());
    
    }
    
} while ($request = $response->getNextPageRequest());
```

## Create User Example

```php
use Validic\User\User;
use Validic\User\UserOptions;

$user = new User([
    'uid' => 'phpWrapperTestUser'
]);

$response = $user->buildAndSendRequestCreate($validic_client);

if ( $response->succeeded() ) {

    // user's authentication token and validic id
    $validic_id = $user->validic_id;
    $authentication_token = $user->authentication_token;

} else {

    // you can save the request and try again later
    $request = serialize($response->getRequest());  

}
```
