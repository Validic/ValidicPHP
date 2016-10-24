<?php
/**
 * Options for the \Validic\Client class.
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
 * Lists the options for the \Validic\Client class.
 *
 * @author Aleksandar Jocic <aleks.jocic@validic.com>
 * @see \Validic\Client
 */
class ClientOptions
{

    /**
     * accept: (string, default=application/json) The value of the Accept
     * header sent with the request.
     */
    const ACCEPT = 'accept';

    /**
     * access_token: (string) The organization's access token.
     */
    const ACCESS_TOKEN = 'access_token';

    /**
     * base_uri: (string, default=https://api.validic.com/v1/) The base uri to
     * send the request to including the version number.
     */
    const BASE_URI = 'base_uri';

    /**
     * connect_timeout: (integer, default=3) The default number of seconds to
     * wait for a successful connection.
     */
    const CONNECT_TIMEOUT = 'connect_timeout';

    /**
     * error_logger: (\Validic\Error\ErrorLoggerInterface) The implementation of
     * the \Validic\Error\ErrorLoggerInterface to use for error logging
     */
    const ERROR_LOGGER = 'error_logger';

    /**
     * filters: (array) An array of default \Validic\Filter\Filter objects to
     * send with every request.
     */
    const FILTERS = 'filters';

    /**
     * headers: (array) An array of default \Validic\Header\Header objects to
     * send with every request.
     * Specifying the USER_AGENT will override the
     * UserAgentHeader if provided as part of the default headers.
     */
    const HEADERS = 'headers';

    /**
     * http_version: (string, default=1.1) The HTTP version to use when sending
     * the request.
     */
    const HTTP_VERSION = 'http_version';

    /**
     * organization_id: (string) The organization's id.
     */
    const ORGANIZATION_ID = 'organization_id';

    /**
     * retries: (integer, default=2) The maximum number of times to retry the
     * same request after the first failed attempt.
     */
    const RETRIES = 'retries';

    /**
     * retry_timeout: (integer, default=500) The time in milliseconds to wait
     * before attempting the same request after a failed attempt.
     */
    const RETRY_TIMEOUT = 'retry_timeout';

    /**
     * user_agent: (string) The value of the User-Agent header sent with the
     * request.
     */
    const USER_AGENT = 'user_agent';

    /**
     * validic_version: (string) The value of the Validic-Version header sent
     * with the request.
     */
    const VALIDIC_VERSION = 'validic_version';
}