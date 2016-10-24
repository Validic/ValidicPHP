<?php
/**
 * Header for sending requests to the Validic API
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
 * HTTP header
 *
 * @author Aleksandar Jocic <aleks.jocic@validic.com>
 */
class Header
{

	/**
	 * The name (key) of the header.
	 * 
	 * @var string
	 */
    public $name;

    /**
     * The value of the header.
     * 
     * @var string
     */
    public $value;

    /**
     * Constructs an HTTP header.
     * 
     * @param string $name
     * @param string|number $value
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * The key value pair.
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->name . ":" . $this->value;
    }
}