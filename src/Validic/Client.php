<?php
/**
 * The client for making requests to Validic.
 *
 * PHP version 5
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 *
 * @author     Aleksandar Jocic <aleks.jocic@validic.com>
 * @copyright  2016 Motivation Science, Inc.
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    1.0
 * @since      File available since Release 1.0
 * @link       https://github.com/gotun/ValidicPHP
 */
namespace Validic;

use GuzzleHttp;
use GuzzleHttp\RequestOptions;
use Validic\Header\Header;
use Validic\Header\Headers;
use Validic\Header\AuthorizationHeader;
use Validic\Header\UserAgentHeader;
use Validic\Header\AcceptHeader;
use Validic\Header\ValidicVersionHeader;
use Validic\Endpoint\EndpointOptions;
use Validic\Filter\Filters;
use Validic\Filter\AccessTokenFilter;
use Validic\Filter\AuthenticationTokenFilter;
use Validic\Error\RequestError;

/**
 * The client for making requests to Validic.
 *
 * @author Aleksandar Jocic <aleks.jocic@validic.com>
 */
class Client
{

    /**
     * The organization access token.
     *
     * @var string
     */
    protected $access_token;

    /**
     * The organization id
     *
     * @var string
     */
    protected $organization_id;

    /**
     * An implementation of the \Validic\Error\ErrorLoggerInterface.
     *
     * @var \Validic\Error\ErrorLoggerInterface
     */
    protected $error_logger = null;

    /**
     * The default User-Agent header value.
     *
     * @var string
     */
    protected $user_agent = 'Validic PHP v1.0';

    /**
     * The default Accept header value
     *
     * @var string
     */
    protected $accept = 'application/json';

    /**
     * The default base uri with version.
     *
     * @var string
     */
    protected $base_uri = 'https://api.validic.com/v1/';

    /**
     * The default HTTP version
     *
     * @var string
     */
    protected $http_version = '1.1';

    /**
     * The default number of seconds to wait for a successful connection.
     *
     * @var integer
     */
    protected $connect_timeout = 3;

    /**
     * The default maximum number of retries after the initial failed attempt.
     *
     * @var integer
     */
    protected $retries = 2;

    /**
     * The default number of milliseconds to wait before retrying after a failed
     * attempt.
     *
     * @var integer
     */
    protected $retry_timeout = 500;

    /**
     * Array of default \Validic\Filter\Filter objects to send.
     *
     * @var array
     */
    protected $default_filters = [];

    /**
     * Array of default \Validic\Header\Header objects to send.
     *
     * @var array
     */
    protected $default_headers = [];
    
    /**
     * The GuzzleHttp client used to send requests.
     * 
     * @var \GuzzleHttp\Client
     */
    private static $guzzle_client;

    /**
     * Constructs a new \Validic\Client object using \Validic\ClientOptions
     * where the access token and organization id are required and will throw an
     * error if omitted. Other settings will override the defaults.
     *
     * @param array $options            
     * @throws \Exception
     * @see \Validic\ClientOptions
     */
    public function __construct(array $options = [])
    {
        // access token is required
        if (! isset($options[ClientOptions::ACCESS_TOKEN]))
            throw new \Exception("Client requires an access token.");
            
        // organization id is required
        if (! isset($options[ClientOptions::ORGANIZATION_ID]))
            throw new \Exception("Client requires an organzation id.");
            
        // set the access token
        $this->access_token = $options[ClientOptions::ACCESS_TOKEN];
        
        // set the organization id
        $this->organization_id = $options[ClientOptions::ORGANIZATION_ID];
        
        // override the default base uri including the version
        if (isset($options[ClientOptions::BASE_URI]))
            $this->base_uri = $options[ClientOptions::BASE_URI];
            
        // override the default http version
        if (isset($options[ClientOptions::HTTP_VERSION]))
            $this->http_version = $options[ClientOptions::HTTP_VERSION];
            
        // override the default connect timeout
        if (isset($options[ClientOptions::CONNECT_TIMEOUT]))
            $this->connect_timeout = $options[ClientOptions::CONNECT_TIMEOUT];
            
        // override the retry count
        if (isset($options[ClientOptions::RETRIES]))
            $this->retries = $options[ClientOptions::RETRIES];
            
        // override the retry timeout
        if (isset($options[ClientOptions::RETRY_TIMEOUT]))
            $this->retry_timeout = $options[ClientOptions::RETRY_TIMEOUT];
            
        // set the error logger
        if (isset($options[ClientOptions::ERROR_LOGGER]))
            $this->error_logger = $options[ClientOptions::ERROR_LOGGER];
            
        // set the default filters to add
        if (isset($options[ClientOptions::FILTERS]))
            $this->default_filters = $options[ClientOptions::FILTERS];
            
        // override the default user agent for the UserAgentHeader
        if (isset($options[ClientOptions::USER_AGENT]))
            $this->user_agent = $options[ClientOptions::USER_AGENT];
            
        // override the default user agent for the UserAgentHeader
        if (isset($options[ClientOptions::ACCEPT]))
            $this->accept = $options[ClientOptions::ACCEPT];
            
        // set validic version
        if (isset($options[ClientOptions::VALIDIC_VERSION]))
            array_push($this->default_headers, new ValidicVersionHeader($options[ClientOptions::VALIDIC_VERSION]));
        
        array_push($this->default_headers, new UserAgentHeader($this->user_agent));
        array_push($this->default_headers, new AcceptHeader($this->accept));
    }

    /**
     * Builds a request using buildRequest and then sends it using sendRequest.
     *
     * @param Endpoint\Endpoint $endpoint            
     * @param array $options An array of \Validic\SendRequestOptions
     * @return \Validic\Response
     * @see \Validic\BuildRequestOptions
     * @see \Validic\SendRequestOptions
     */
    public function buildAndSendRequest(Endpoint\Endpoint $endpoint, array $options = [])
    {
        $request = $this->buildRequest($endpoint, $options);
        
        return $this->sendRequest($request, $options);
    }

    /**
     * Builds the GuzzleHTTP options and signs the Validic API request.
     *
     * @param Endpoint\Endpoint $endpoint            
     * @param array $options An array of \Validic\BuildRequestOptions
     * @throws \Exception An authentication token must be provided for endpoints that reqiure it
     * @return \Validic\Request
     * @see \Validic\BuildRequestOptions
     */
    public function buildRequest(Endpoint\Endpoint $endpoint, array $options = [])
    {
        $guzzle_options = [];
        $filters = $this->default_filters;
        $headers = $this->default_headers;
        
        // set the protocal version
        $guzzle_options[GuzzleHttp\RequestOptions::VERSION] = $this->http_version;
        $guzzle_options[GuzzleHttp\RequestOptions::CONNECT_TIMEOUT] = $this->connect_timeout;
        
        // Set the request verb. defaults to GET
        $verb = isset($options[BuildRequestOptions::VERB]) ? $options[BuildRequestOptions::VERB] : RequestVerbs::GET;
        
        // set the user information
        if (isset($options[BuildRequestOptions::USER])) {
            $user = $options[BuildRequestOptions::USER];
            
            // if user is not of User class, try to create it as though it were an array of UserOptions
            if (get_class($user) != "User" && is_array($user))
                $user = new User($user);
            
            if (! isset($options[BuildRequestOptions::USER_ID]))
                $options[BuildRequestOptions::USER_ID] = $user->validic_id;
            if (! isset($options[BuildRequestOptions::AUTHENTICATION_TOKEN]))
                $options[BuildRequestOptions::AUTHENTICATION_TOKEN] = $user->authentication_token;
        }
        
        // Set the uri from the Endpoint and set org_id, user_id, and base_uri to defaults if endpoint does not have them set
        $uri = $endpoint->getUri([
            EndpointOptions::ORGANIZATION_ID => $this->organization_id,
            EndpointOptions::USER_ID => isset($options[BuildRequestOptions::USER_ID]) ? $options[BuildRequestOptions::USER_ID] : null,
            EndpointOptions::BASE_URI => $this->base_uri
        ]);
        
        // automatically sign the request
        if ($verb == RequestVerbs::GET) {
            if (isset($endpoint->signWith()[Filters::__FILTERS])) {
                foreach ($endpoint->signWith()[Filters::__FILTERS] as $filter) {
                    if ($filter == Filters::ACCESS_TOKEN)
                        array_push($filters, new AccessTokenFilter($this->access_token));
                        
                    // throw error if no authentication token if endpoint requires it
                    if ($filter == Filters::AUTHENTICATION_TOKEN) {
                        if (isset($options[BuildRequestOptions::AUTHENTICATION_TOKEN])) {
                            array_push($filters, new AuthenticationTokenFilter($options[BuildRequestOptions::AUTHENTICATION_TOKEN]));
                        } else {
                            throw new \Exception("Authentication token required for \"" . $endpoint . "\"");
                        }
                    }
                }
            }
            
            if (isset($endpoint->signWith()[Headers::__HEADERS])) {
                foreach ($endpoint->signWith()[Headers::__HEADERS] as $header) {
                    if ($header == Headers::AUTHORIZATION)
                        array_push($headers, new AuthorizationHeader($this->access_token));
                }
            }
        } else {
            // post, put, or delete
            // Content-Type: application/json will automatically be added if not supplied to Guzzle
            // Content-Length header automatically added, and overrides set header
            
            if (! isset($options[BuildRequestOptions::BODY]))
                $options[BuildRequestOptions::BODY] = [];
            
            if (is_array($options[BuildRequestOptions::BODY])) {
                if (! isset($options[BuildRequestOptions::BODY][Filters::ACCESS_TOKEN]))
                    $options[BuildRequestOptions::BODY][Filters::ACCESS_TOKEN] = $this->access_token;
                
                $guzzle_options[GuzzleHttp\RequestOptions::JSON] = $options[BuildRequestOptions::BODY];
            } else {
                // string passed - no auto signing
                // add default Content-Type header if not supplied
                if (! $this->isFieldSet(Headers::CONTENT_TYPE, $options[BuildRequestOptions::HEADERS]))
                    array_push($headers, new ContentTypeHeader("application/json"));
                
                $guzzle_options[GuzzleHttp\RequestOptions::BODY] = $options[BuildRequestOptions::BODY];
            }
        }
        
        // override values with provided headers and filters
        if (isset($options[BuildRequestOptions::FILTERS]))
            foreach ($options[BuildRequestOptions::FILTERS] as $filter)
                array_push($filters, $filter);
        if (isset($options[BuildRequestOptions::HEADERS]))
            foreach ($options[BuildRequestOptions::HEADERS] as $header)
                array_push($headers, $header);
            
        // combine headers
        $guzzle_options[GuzzleHttp\RequestOptions::HEADERS] = is_array($headers) ? $this->buildAssoc($headers) : $this->buildAssoc([$headers]);
        
        // combine filters
        $guzzle_options[GuzzleHttp\RequestOptions::QUERY] = is_array($filters) ? $this->buildAssoc($filters) : $this->buildAssoc([$filters]);
        
        // Override values passed specifically for guzzle
        if (isset($options[BuildRequestOptions::GUZZLE]) && is_array($options[BuildRequestOptions::GUZZLE])) {
            foreach ($options[BuildRequestOptions::GUZZLE] as $key => $value) {
                $guzzle_options[$key] = $value;
            }
        }
        
        return new Request($verb, $uri, $guzzle_options);
    }

    /**
     * Sends a \Validic\Request with options to retry.
     *
     * @param Request $request            
     * @param array $options An array of \Validic\SendRequestOptions
     * @return \Validic\Response
     * @see \Validic\SendRequestOptions
     */
    public function sendRequest(Request $request, array $options = [])
    {
        // overrides client default retries and retry timeout
        $retry_limit = isset($options[SendRequestOptions::RETRIES]) ? $options[SendRequestOptions::RETRIES] : $this->retries;
        $retry_timeout = isset($options[SendRequestOptions::RETRY_TIMEOUT]) ? $options[SendRequestOptions::RETRY_TIMEOUT] : $this->retry_timeout;
        
        $response = new Response($request);
        if (! isset(self::$guzzle_client)) self::$guzzle_client = new GuzzleHttp\Client();
        
        for ($attempts = 0; $attempts <= $retry_limit; $attempts ++) {

            // wait before retrying
            if ($attempts > 0)
                usleep($retry_timeout * 1000);
                
            try {
                $start = microtime(true);
                $g_response = self::$guzzle_client->request($request->getVerb(), $request->getUri(), $request->getOptions());
                $response->setCompletionDuration(microtime(true) - $start);
                
                $response->setGuzzleResponse($g_response);
               
                break;
            } catch (GuzzleHttp\Exception\BadResponseException $e) {
                $g_response = $e->getResponse();

                // Check if error message is returned in JSON format
                if ($error = json_decode($g_response->getBody()->getContents(), true)) {
                    if (isset($error['errors']))
                        $response->setError(new RequestError($error['code'], $error['message'], $error['errors']));
                    
                    else
                        $response->setError(new RequestError($error['code'], $error['message']));
                } else {
                    // Use the HTTP status code and message to generate the error
                    $response->setError(new RequestError($g_response->getStatusCode(), $g_response->getReasonPhrase()));
                }
                
                if (isset($this->error_logger))
                    $this->error_logger->logError($response);
            } catch (\Exception $e) {
                $response->setError(new RequestError(1001, "", $e->getMessage()));
                if (isset($this->error_logger))
                    $this->error_logger->logError($response);
            }
        }
        
        // check if no requests were successful and add to errors
        if (count($response->getErrors()) > $retry_limit) {
            $response->setError(new RequestError(1002));
            if (isset($this->error_logger))
                $this->error_logger->logError($response);
        }
        
        return $response;
    }

    /**
     * Finds an object by it's name.
     *
     * @param string $needle            
     * @param array $haystack            
     * @return boolean
     */
    private function isFieldSet($needle, array $haystack)
    {
        foreach ($haystack as $field) {
            if ($field->name == $needle)
                return true;
        }
        
        return false;
    }

    /**
     * Convert an array of headers or filters into an associative array where
     * arr[$obj->name] => $obj->value. If duplicate names are present, the last
     * added will be used.
     *
     * @param array $fields            
     * @return array
     */
    private function buildAssoc(array $fields)
    {
        $assoc = array();
        
        foreach ($fields as $field) {
            $assoc[$field->name] = $field->value;
        }
        
        return $assoc;
    }
}
