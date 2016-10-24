<?php
/**
 * Options for the \Validic\Endpoint class.
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
 * Lists the options for the \Validic\Endpoint class that will not be overridden
 * when the Client accesses the endpoint's uri.
 *
 * @author Aleksandar Jocic <aleks.jocic@validic.com>
 * @see \Validic\Endpoint\Endpoint
 * @see \Validic\Endpoint\ShortEndpoint
 */
class EndpointOptions
{

    /**
     * endpoint: (string) The endpoint to access.
     */
    const ENDPOINT = "endpoint";

    /**
     * path: (string) The path of endpoint excluding the version number.
     */
    const PATH = "path";

    /**
     * latest: (boolean) True to access the endpoint's latest feature.
     */
    const LATEST = "latest";

    /**
     * intraday: (boolean) True to access the endpoint's intraday feature.
     */
    const INTRADAY = "intraday";

    /**
     * base_uri: (string) The base uri of the endpoint.
     */
    const BASE_URI = 'base_uri';

    /**
     * organization_id: (string) The organization id to use for the endpoint.
     */
    const ORGANIZATION_ID = 'organization_id';

    /**
     * user_id: (string) The user id to add to the route.
     */
    const USER_ID = 'user_id';
}