<?php
/**
 * The endpoints from Validic that use a standard route format.
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
 * Lists the endpoints from Validic that use a standard route format.
 *
 * @author Aleksandar Jocic <aleks.jocic@validic.com>
 * @see \Validic\Endpoint\Endpoint
 */
class Endpoints
{

    /**
     * apps: The apps endpoint.
     */
    const APPS = 'apps';

    /**
     * biometrics: The biometrics endpoint that contains.
     */
    const BIOMETRICS = 'biometrics';

    /**
     * diabetes: The diabetes endpoint that contains blood glucose measurments.
     */
    const DIABETES = 'diabetes';

    /**
     * fitness: The fitness endpoint that contains activities done for the.
     * explicit purpose of exercise.
     */
    const FITNESS = 'fitness';

    /**
     * nutrition: The nutrition endpoint that contains consumed food item.
     * nutritional information.
     */
    const NUTRITION = 'nutrition';

    /**
     * organization: The organization endpoint that contains organization stats.
     */
    const ORGANIZATION = 'organization';

    /**
     * refresh_token: The refresh_token endpoint.
     */
    const REFRESH_TOKEN = 'refresh_token';

    /**
     * routine: The routine endpoint that contains daily activity aggregates.
     */
    const ROUTINE = 'routine';

    /**
     * sleep: The sleep endpoint that contains sleep stats.
     */
    const SLEEP = 'sleep';

    /**
     * user: The user endpoint for updating, deleting or suspending the.
     * specified user
     */
    const USER = 'user';

    /**
     * users: The users endpoint that contains a listing of user ids and uids.
     */
    const USERS = 'users';

    /**
     * weight: The weight endpoint that contains weight and height measurments.
     */
    const WEIGHT = 'weight';
}
