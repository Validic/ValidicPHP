<?php
/**
 * Describes a Validic endpoint.
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
namespace Validic\Endpoint;

/**
 * Describes a Validic endpoint.
 *
 * @author Aleksandar Jocic <aleks.jocic@validic.com>
 * @see \Validic\Client
 */
class Endpoint
{

    /**
     * The path of the request exluding the version.
     *
     * @var string
     */
    protected $path;

    /**
     * The name of the endpoint.
     *
     * @var string
     */
    protected $endpoint;

    /**
     * The base uri including the version.
     *
     * @var string
     */
    protected $base_uri;

    /**
     * The organization's id to be included in the path.
     *
     * @var string
     */
    protected $organization_id;

    /**
     * The user's id to be included in the path.
     *
     * @var string
     */
    protected $user_id;

    /**
     * Constructs a new \Validic\Endpoint\Endpoint object where
     * \Validic\Endpoint\EndpointOptions can be specified that will not be
     * overriden by the \Validic\Client settings.
     *
     * @param string $endpoint
     * @param array $options
     * @see \Validic\Endpoint\EndpointOptions
     */
    public function __construct($endpoint, array $options = [])
    {
        $this->endpoint = $endpoint;
        
        if (isset($options[EndpointOptions::BASE_URI]))
            $this->base_uri = $options[EndpointOptions::BASE_URI];
        
        if (isset($options[EndpointOptions::ORGANIZATION_ID]))
            $this->$organization_id = $options[EndpointOptions::ORGANIZATION_ID];
        
        if (isset($options[EndpointOptions::USER_ID]))
            $this->user_id = $options[EndpointOptions::USER_ID];
        
        if (isset($options[EndpointOptions::INTRADAY]) && $options[EndpointOptions::INTRADAY])
            $this->endpoint .= "/intraday";
        
        if (isset($options[EndpointOptions::LATEST]) && $options[EndpointOptions::LATEST])
            $this->endpoint .= "/latest";
        
        $this->path = isset($options[EndpointOptions::PATH]) ? $options[EndpointOptions::PATH] : "organizations/";
    }

    /**
     * Gets information about how an endpoint should be signed; headers and/or
     * filters.
     *
     * @return array
     */
    public function signWith()
    {
        return [
            \Validic\Filter\Filters::__FILTERS => [
                \Validic\Filter\Filters::ACCESS_TOKEN
            ]
        ];
    }

    /**
     * Gets the uri for the endpoint using the \Validic\Endpoint\EndpointOptions
     * when the \Validic\Endpoint\Endpoint was created with. Any options
     * provided at the time this function is called will not overwrite options
     * set at the time the endpoint is constructed.
     *
     * @param array $options
     * @return string
     * @see \Validic\Endpoint\EndpointOptions
     */
    public function getUri(array $options = [])
    {
        $this->setUriOptions($options);
        
        if (! empty($this->user_id))
            return $this->base_uri . $this->path . $this->organization_id . "/users/" . $this->user_id . "/" . $this->endpoint;
        
        return $this->base_uri . $this->path . $this->organization_id . "/" . $this->endpoint;
    }

    /**
     * Helper function to set runtime values passed from \Validic\Client.
     *
     * @param array $options
     * @see \Validic\Endpoint\EndpointOptions
     */
    protected function setUriOptions(array $options = [])
    {
        if (! isset($this->base_uri))
            $this->base_uri = $options[EndpointOptions::BASE_URI];
        
        if (! isset($this->organization_id) && isset($options[EndpointOptions::ORGANIZATION_ID]))
            $this->organization_id = $options[EndpointOptions::ORGANIZATION_ID];
        
        if (! isset($this->user_id) && isset($options[EndpointOptions::USER_ID]))
            $this->user_id = $options[EndpointOptions::USER_ID];
    }

    /**
     * The full name of the endpoint.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->endpoint;
    }
}

