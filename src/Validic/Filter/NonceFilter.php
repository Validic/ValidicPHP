<?php
/**
 * Nonce filter for the Validic API.
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
 * Nonce query parameter filter.
 *
 * @author Aleksandar Jocic <aleks.jocic@validic.com>
 */
class NonceFilter extends Filter
{

	/**
	 * Constructs a nonce filter that creates a unique request when used to help
	 * prevent caching.
	 * 
	 * Note that the string is set at initialization, therefore retries on
	 * failed attempts will not have a unique nonce when using the
	 * \Validic\Client default retry mechanism or when calling
	 * \Validic\Response::getNextPageRequest()
	 * 
	 * @param number $length
	 */
    public function __construct($length = 10)
    {
        parent::__construct(Filters::NONCE, $this->randomString($length));
    }

    /**
     * Generate a random string.
     * 
     * @param number $length
     * @return string
     */
    private function randomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $options = strlen($characters) - 1;
        $random = '';
        
        for ($i = 0; $i < $length; $i ++) {
            $random .= $characters[mt_rand(0, $options)];
        }
        
        return $random;
    }
}