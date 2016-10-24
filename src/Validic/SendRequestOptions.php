<?php
/**
 * Options for the \Validic\Client sendRequest or buildAndSendRequest
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
 * Lists the options for the \Validic\Client sendRequest or buildAndSendRequest
 * functions. Any provided values will override the default value set in the
 * \Validic\Client.
 *
 * @author Aleksandar Jocic <aleks.jocic@validic.com>
 * @see \Validic\Client
 * @see \Validic\BuildRequestOptions
 */
class SendRequestOptions extends BuildRequestOptions
{

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
}