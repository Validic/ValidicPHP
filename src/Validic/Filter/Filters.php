<?php
/**
 * Key names for the \Validic\Filter\Filter class.
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
namespace Validic\Filter;

/**
 * Lists the key names for the \Validic\Filter\Filter class.
 *
 * @author Aleksandar Jocic <aleks.jocic@validic.com>
 * @see \Validic\Filter\Filter
 */
class Filters
{

    /**
     * filters: (string) The collection name for filters
     */
    const __FILTERS = "filters";

    /**
     * uid: (string) The key name of the uid filter.
     */
    const UID = 'uid';

    /**
     * limit: (string) The key name of the limit filter.
     */
    const LIMIT = 'limit';

    /**
     * page: (string) The key name of the page filter.
     */
    const PAGE = 'page';

    /**
     * offset: (string) The key name of the offset filter.
     */
    const OFFSET = 'offset';

    /**
     * access_token: (string) The key name of the access_token filter.
     */
    const ACCESS_TOKEN = 'access_token';

    /**
     * authentication_token: (string) The key name of the authentication_token
     * filter.
     */
    const AUTHENTICATION_TOKEN = 'authentication_token';

    /**
     * nonce: (string) The key name of the nonce filter.
     */
    const NONCE = 'nonce';

    /**
     * source: (string) The key name of the source filter.
     */
    const SOURCE = 'source';

    /**
     * status: (string) The key name of the status filter.
     */
    const STATUS = 'status';

    /**
     * format_redirect: (string) The key name of the format_redirect filter.
     */
    const FORMAT_REDIRECT = 'format_redirect';

    /**
     * redirect_uri: (string) The key name of the redirect_uri filter.
     */
    const REDIRECT_URI = 'redirect_uri';
}