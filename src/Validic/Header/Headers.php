<?php
/**
 * Key names for the \Validic\Header\Header class.
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
namespace Validic\Header;

/**
 * Lists the key names for the \Validic\Header\Header class.
 *
 * @author Aleksandar Jocic <aleks.jocic@validic.com>
 * @see \Validic\Header\Header
 */
class Headers
{

    /**
     * headers: (string) The collection name for headers.
     */
    const __HEADERS = 'headers';

    /**
     * Accept: (string) The key name of the Accept header.
     */
    const ACCEPT = 'Accept';

    /**
     * Content-Type: (string) The key name of the Content-Type header.
     */
    const CONTENT_TYPE = 'Content-Type';

    /**
     * Content-Length: (string) The key name of the Content-Length header.
     */
    const CONTENT_LENGTH = 'Content-Length';

    /**
     * Authorization: (string) The key name of the Authorization header.
     */
    const AUTHORIZATION = 'Authorization';

    /**
     * User-Agent: (string) The key name of the User-Agent header.
     */
    const USER_AGENT = 'User-Agent';

    /**
     * Validic-Version: (string) The key name of the Validic-Version header.
     */
    const VALIDIC_VERSION = 'Validic-Version';
}