<?php
/**
 * Describes a \Validic\Client ready Request.
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
 * This class describes a \Validic\Request that is ready for the \Validic\Client
 * sendRequest function.
 *
 * @author Aleksandar Jocic <aleks.jocic@validic.com>
 * @see \Validic\Client
 */
class Request
{

    /**
     * The verb to be used.
     *
     * @var string
     */
    private $verb;

    /**
     * The uri to access.
     *
     * @var string
     */
    private $uri;

    /**
     * An array of GuzzleHttp\RequestOptions.
     *
     * @var array
     */
    private $options;

    /**
     * Constructs a new \Validic\Request.
     *
     * @param string $verb            
     * @param string $uri            
     * @param array $options            
     */
    public function __construct($verb, $uri, $options)
    {
        $this->verb = $verb;
        $this->uri = $uri;
        $this->options = $options;
    }

    /**
     * Gets the uri of the request.
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Gets the verb of the request.
     *
     * @return string
     */
    public function getVerb()
    {
        return $this->verb;
    }

    /**
     * Gets the \GuzzleHttp\RequestOptions of the request.
     *
     * @return multitype:
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Gets a string representation of the verb, uri, query and http version.
     *
     * @return string
     */
    public function __toString()
    {
        if (! empty($this->options[\GuzzleHttp\RequestOptions::QUERY]))
            return $this->verb . " " . $this->uri . "?" . http_build_query($this->options[\GuzzleHttp\RequestOptions::QUERY]) . " HTTP/" . $this->options[\GuzzleHttp\RequestOptions::VERSION];
        
        return $this->verb . " " . $this->uri . " HTTP/" . $this->options[\GuzzleHttp\RequestOptions::VERSION];
    }
}
