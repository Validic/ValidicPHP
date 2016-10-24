<?php
/**
 * Options for the \Validic\Client buildRequest or buildAndSendRequest
 * functions.
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
 * Lists the options for the \Validic\Client buildRequest or buildAndSendRequest
 * functions. Any provided values will override the default value set in the
 * \Validic\Client.
 *
 * @author Aleksandar Jocic <aleks.jocic@validic.com>
 * @see \Validic\Client
 */
class BuildRequestOptions
{

    /**
     * filters: (array) An array of \Validic\Filter\Filter objects.
     * Overrides
     * any filters set in the \Validic\Client.
     *
     * @see \Validic\Filter\Filter
     */
    const FILTERS = 'filters';

    /**
     * verb: (string, default=GET) A standard REST verbs of either GET, POST,
     * PUT, DELETE also listed in the \Validic\RequestVerbs class.
     *
     * @see \Validic\RequestVerbs
     */
    const VERB = 'verb';

    /**
     * body: (array) An associative array that will be converted into a json
     * encoded string using json_encode in the \GuzzleHttp\Client class.
     */
    const BODY = 'body';

    /**
     * headers: (array) An array of \Validic\Header\Header objects.
     * Content-Type of application/json and Content-Length headers will be set
     * automatically for requests with a verb of either POST, PUT, or DELETE.
     * Overrides any headers set in the client.
     *
     * @see \Validic\Header\Header
     */
    const HEADERS = 'headers';

    /**
     * user: (\Validic\User\User) A \Validic\User\User object that will be
     * used to set the route to the specific user for \Validic\Endpoints using
     * the user's id and the authentication_token for \Validic\ShortEndpoints.
     * Suppling the \Validic\User\User will not override the user_id and
     * authentication_token if supplied.
     *
     * @see \Validic\User\User
     */
    const USER = 'user';

    /**
     * user_id: (string) A Validic user id that will be used to set the route to
     * the specific user for \Validic\Endpoint\Endpoint.
     */
    const USER_ID = 'user_id';

    /**
     * authentication_token: (string) A Validic user's authentiation_token that
     * will be used to sign the request for a specific user if a
     * \Validic\User\User or user_id is supplied when requesting a
     * \Validic\Endpoint\ShortEndpoint.
     */
    const AUTHENTICATION_TOKEN = 'authentication_token';

    /**
     * guzzle: (array) An associative array of options as specified in the
     * \GuzzleHttp\RequestOptions that will directly set or override specified
     * options when the request is made.
     *
     * @see \GuzzleHttp\RequestOptions
     */
    const GUZZLE = 'guzzle';
}