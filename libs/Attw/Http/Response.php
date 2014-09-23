<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Http;

/**
 * HTTP Responses
*/
class Response
{
    /**
     * Messages to status codes
     *
     * @var array
    */
    private $messages = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
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
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'Unsupported Version'
   );

    /**
     * HTTP Protocol default
     *
     * @var string
    */
    private $protocol = 'HTTP/1.1';

    /**
     * HTTP Status Code
     *
     * @var integer
    */
    private $statusCode;

    /**
     * Header to be send
     *
     * @var array
    */
    private $headersToSend = array();

    /**
     * Constructor of response
     *
     * @param integer $statusCode Set a status
    */
    public function __construct($statusCode = null, $protocol = null)
    {
        $statusCode !== null ? $this->setStatusCode($statusCode) : $this->setStatusCode($statusCode);
        $protocol !== null ? $this->setProtocol($protocol) : null;
    }

    /**
     * Set HTTP protocol
     *
     * @param string $protocol
    */
    public function setProtocol($protocol)
    {
        $this->protocol = (string) $protocol;
    }

    /**
     * Send a HTTP Response
     *
     * @param string $name
     * @param string $value
     * @return mixed Header function
    */
    public function sendHeader($name, $value = null)
    {
        return ($value == null) ? header($name) : header(sprintf('%s: %s', $name, $value));
    }

    /**
     * Send all header registred
    */
    public function sendAllHeaders()
    {
        foreach ($this->headersToSend as $header) {
            $headerName = $header['name'];
            $headerValue = $header['value'];

            $this->sendHeader($headerName, $headerValue);
        }
    }

    /**
     * Set the status code
     *
     * @param integer $code
    */
    public function setStatusCode($code)
    {
        $this->statusCode = $code;
    }

    /**
     * Get the current status code
     *
     * @return integer
    */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Attach a HTTP Reponse to send
     *
     * @param string | array $name
     * @param string $value
    */
    public function addHeader($name, $value = null)
    {
        $this->headersToSend[] = array('name' => $name, 'value' => $value);
    }

    /**
     * Send a HTTP status code
     *
     * @param int $statusCode
    */
    public function sendStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        if (in_array($statusCode, array_keys($this->messages))) {
            $this->sendHeader(sprintf('%s %s %s', $this->protocol,
                                $statusCode,
                                $this->messages[ $statusCode ]));
        } else {
            $this->sendHeader(sprintf('%s %s', $this->protocol, $statusCode));
        }
    }
}