<?php
/**
 * Writes errors to a file.
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
namespace Validic\Error;

/**
 * Writes \Validic\Error\RequestError information to a file.
 *
 * @author Aleksandar Jocic <aleks.jocic@validic.com>
 * @see \Validic\Client
 */
class ErrorLogWriter implements ErrorLoggerInterface
{

    /**
     * The location of the log file to write to. Ensure that PHP has write
     * access to the file.
     * 
     * @var string
     */
    private $log_src;

    /**
     * Constructs the log writer with information about the file to write to.
     * 
     * @param string $log_src
     */
    public function __construct($log_src)
    {
        $this->log_src = $log_src;
    }

    /**
     * Appends a line with error details to the configured file
     * 
     * @param \Validic\Response $response
     * @see \Validic\Error\ErrorLoggerInterface::logError()
     */
    public function logError(\Validic\Response $response)
    {
        file_put_contents($this->log_src, $response->getLastError() . "; While attempting to connect to " . $response->getRequest() . "\r\n", FILE_APPEND);
    }
}