<?php
/**
 * Describes a \Validic\Response of a request
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

/**
 * This class describes a \Validic\Response of a request that is returned by the
 * \Validic\Client
 *
 * @author Aleksandar Jocic <aleks.jocic@validic.com>
 * @see \Validic\Client
 */
class Response
{

    /**
     * An array of \Validic\Error\RequestError objects
     *
     * @var array
     */
    protected $errors = [];

    protected $request;

    protected $time = null;

    protected $guzzle_response;

    protected $json = null;

    public function __construct(\Validic\Request $request, \GuzzleHttp\Psr7\Response $guzzle_response = null)
    {
        $this->request = $request;
        $this->guzzle_response = $guzzle_response;
    }

    public function setError(\Validic\Error\RequestError $error)
    {
        array_push($this->errors, $error);
    }

    /*
     * public function setBody($body) {
     * $this->body = $body;
     * $this->json = json_decode($this->body, true);
     * }
     */
    public function getBody()
    {
        return isset($this->guzzle_response) ? $this->guzzle_response->getBody() : null;
    }

    public function getJson()
    {
        // cache json to prevent reparsing
        if (! isset($this->json)) {
            if (isset($this->guzzle_response))
                $this->json = json_decode($this->guzzle_response->getBody(), true);
        }
        
        return $this->json;
    }

    /**
     * An array of \Validic\Error\RequestError objects that were thrown while
     * attempting to retrieve a response to the \Valdic\Request
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Gets the last \Validic\Error\RequestError object that was thrown while
     * attempting to retrieve a response to the \Valdic\Request
     *
     * @return \Validic\Error\RequestError
     */
    public function getLastError()
    {
        return end($this->errors);
    }

    /**
     * Gets the error count while attempting to retrieve a response to the
     * \Valdic\Request
     *
     * @return number
     */
    public function getFailedAttempts()
    {
        return count($this->errors);
    }

    /**
     * Returns true if any error was thrown while attempting to retrieve a
     * response to the \Valdic\Request, false otherwise
     *
     * @return boolean
     */
    public function hasErrors()
    {
        return ! empty($this->errors);
    }

    public function succeeded()
    {
        foreach ($this->errors as $error) {
            if ($error->getCode() == 1002)
                return false;
        }
        return true;
    }

    /**
     * Sets the total time that the request took
     *
     * @param float $seconds            
     */
    public function setCompletionDuration($seconds)
    {
        $this->time = $seconds;
    }

    /**
     * The total time the request took for stats tracking purposes
     *
     * @return float
     */
    public function getCompletionDuration()
    {
        return $this->time;
    }

    /**
     * Sets the \GuzzleHttp\Psr7\Response
     *
     * @param \GuzzleHttp\Psr7\Response $guzzle_response            
     */
    public function setGuzzleResponse(\GuzzleHttp\Psr7\Response $guzzle_response)
    {
        $this->guzzle_response = $guzzle_response;
    }

    /**
     * Gets the \GuzzleHttp\Psr7\Response for the \Validic\Request
     *
     * @return \GuzzleHttp\Psr7\Response
     */
    public function getGuzzleResponse()
    {
        return $this->guzzle_response;
    }

    /**
     * Returns the response body
     *
     * @return string
     */
    public function __toString()
    {
        return isset($this->guzzle_response) ? (string) $this->guzzle_response->getBody() : "";
    }

    /**
     * Gets the response headers as an associative array where the key is the
     * header name and the value is an array of values
     *
     * @return array
     */
    public function getHeaders()
    {
        return isset($this->guzzle_response) ? $this->guzzle_response->getHeaders() : [];
    }

    /**
     * Gets the \Validic\Request associated with the response
     *
     * @return \Validic\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Checks the response summary for a 'next' value
     *
     * @return boolean
     */
    public function hasMorePages()
    {
        $json = $this->getJson();
        
        if (! isset($json['summary']))
            return false;
        
        return isset($summary['next']);
    }

    /**
     * Gets a \Validic\Request ready to send using the \Validic\Client or
     * false if there is no next page
     *
     * @return boolean|\Validic\Request
     */
    public function getNextPageRequest()
    {
        return $this->getPage('next');
    }

    /**
     * Gets a \Validic\Request ready to send using the \Validic\Client or
     * false if there is no previous page
     *
     * @return boolean|\Validic\Request
     */
    public function getPreviousPageRequest()
    {
        return $this->getPage('previous');
    }

    /**
     * Gets a new \Validic\Request for the next or previous page
     *
     * @param string $previous_or_next            
     * @return boolean|\Validic\Request
     */
    private function getPage($previous_or_next)
    {
        $json = $this->getJson();
        
        if (! isset($json['summary']))
            return false;
        
        $summary = $json['summary'];
        
        if (! isset($summary[$previous_or_next]))
            return false;
        
        $url = parse_url($summary[$previous_or_next]);
        $params = array();
        parse_str($url['query'], $params);
        
        $options = $this->request->getOptions();
        $options[\GuzzleHttp\RequestOptions::QUERY][\Validic\Filter\Filters::PAGE] = $params[\Validic\Filter\Filters::PAGE];
        
        return new \Validic\Request($this->request->getVerb(), $this->request->getUri(), $options);
    }
}

