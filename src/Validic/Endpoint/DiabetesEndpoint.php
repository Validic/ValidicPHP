<?php
/**
 * Diabetes endpoint for the Validic API.
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
 * Diabetes endpoint.
 *
 * @author Aleksandar Jocic <aleks.jocic@validic.com>
 */
class DiabetesEndpoint extends Endpoint
{

    /**
     * Constructs a diabetes endpoint.
     * 
     * @param array $options
     * @see \Validic\Endpoint\EndpointOptions
     */
    public function __construct(array $options = [])
    {
        parent::__construct(Endpoints::DIABETES, $options);
    }
}