<?php
/**
 * Error details about failed requests when using the \Validic\Client.
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
 * Contains information about an error when making a request to the Validic API
 * returned in the \Validic\Client sendRequest function's \Validic\Response
 * return.
 *
 * @author Aleksandar Jocic <aleks.jocic@validic.com>
 * @see \Validic\Client
 * @see \Validic\Response
 */
class RequestError
{

	/**
	 * The HTTP status code or other code number.
	 * 
	 * @var number
	 */
    private $code;

    /**
     * The text portion of the HTTP status code or other error message.
     * 
     * @var string
     */
    private $message;

    /**
     * 
     * @var string|array
     */
    private $description;

    /**
     * Map of standard HTTP status code/reason phrases.
     *
     * @var array
     */
    private static $codes = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-status',
        208 => 'Already Reported',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Large',
        415 => 'Unsupported Media Type',
        416 => 'Requested range not satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        511 => 'Network Authentication Required',
        1000 => 'Rate Limit Reached',
        1001 => 'Unknown',
        1002 => 'All Attempts Failed'
    ];

    /**
     * Constructs the error with details.
     *
     * @param number $code
     * @param string $message
     * @param string $description
     */
    public function __construct($code, $message = "", $description = "")
    {
        $this->code = (int) $code;
        if (empty($message))
            $this->message = self::$codes[$this->code];
        else
            $this->message = $message;
        $this->description = $description;
    }

    /**
     * Gets the HTTP status code of the error returned or an error code of 1000
     * or higher for other errors.
     *
     * @return number
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Gets the HTTP status code text of the error returned.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Gets additional details about the error that occurred.
     *
     * @return string|array
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * All details about the error.
     *
     * @return string
     */
    public function __toString()
    {
        if (empty($this->description))
            return $this->code . " " . $this->message;
        else 
            if (is_array($this->description))
                return $this->code . " " . $this->message . " - " . join(", ", $this->description);
        return $this->code . " " . $this->message . " - " . $this->description;
    }
}