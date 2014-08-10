<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\HTTP;

use Attw\HTTP\Request\RequestInterface;

/**
 * Request handler
 *
 * @resource Get request methods: POST, QUERY, FILES, PUT, DELETE and AJAX
 * @resource Verify request type
 * @resource Send a request with cUrl extension
*/
class Request
{
    const POST_METHOD = 'POST';
    const QUERY_METHOD = 'GET';
    const FILES_METHOD = 'FILES';
    const PUT_METHOD = 'PUT';
    const DELETE_METHOD = 'DELETE';
    const AJAX_METHOD = 'xmlhttprequest';

    /**
     * Querystrings
     *
     * @var array
    */
    private $query;

    /**
     * Posts
     *
     * @var array
    */
    private $post;

    /**
     * Files
     *
     * @var array
    */
    private $files;

    /**
     * Server
     *
     * @var array
    */
    private $server;

    /**
     * Request method
     *
     * @var string
    */
    private $method;

    /**
     * Constructor of Request
     * Define teh variables
    */
    public function __construct(
        array $query = array(),
        array $post = array(),
        array $files = array(),
        array $server = array()
   ) {
        $this->query = (count($query) > 0) ? $query : $_GET;
        $this->post = (count($post) > 0) ? $post : $_POST;
        $this->files = (count($files) > 0) ? $files : $_FILES;
        $this->server = (count($server) > 0) ? $server : $_SERVER;
    }

    /**
     * Get a querystring requet
     *
     * @param string $property
     * @return mixed
    */
    public function query($property)
    {
        return $this->query[ $property ];
    }

    /**
     * Get a post requet
     *
     * @param string $property
     * @return mixed
    */
    public function post($property)
    {
        return $this->post[ $property ];
    }

    /**
     * Get a server property
     *
     * @param string $property
     * @return mixed
    */
    public function server($property)
    {
        return $this->server[ $property ];
    }

    /**
     * Get a file property
     *
     * @param string $property
     * @return array
    */
    public function file($property)
    {
        return $this->files[ $property ];
    }

    /**
     * Verify if request is a post request
     *
     * @return boolean
    */
    public function isPost()
    {
        return (strtoupper($this->getMethod()) === self::POST_METHOD);
    }

    /**
     * Verify if request is a put request
     *
     * @return boolean
    */
    public function isPut()
    {
        return (strtoupper($this->getMethod()) === self::PUT_METHOD);
    }

    /**
     * Verify if request is a delete request
     *
     * @return boolean
    */
    public function isDelete()
    {
        return (strtoupper($this->getMethod()) === self::DELETE_METHOD);
    }

    /**
     * Verify if request is a file request
     *
     * @return boolean
    */
    public function isFiles()
    {
        return (strtoupper($this->getMethod()) === self::FILES_METHOD);
    }

    /**
     * Verify if request is a querystring request
     *
     * @return boolean
    */
    public function isQuery()
    {
        return (strtoupper($this->getMethod()) === self::QUERY_METHOD);
    }

    /**
     * Verify if request is a ajax request
     *
     * @return boolean
    */
    public function isAjax()
    {
        return ($this->issetServer('HTTP_X_REQUESTED_WITH')
            && strtolower($this->server('HTTP_X_REQUESTED_WITH')) === self::AJAX_METHOD);
    }

    /**
     * Verify if a post request exists
     *
     * @param string $property
     * @return boolean
    */
    public function issetPost($property)
    {
        return isset($this->post[ $property ]);
    }

    /**
     * Verify if a querystring request exists
     *
     * @param string $property
     * @return boolean
    */
    public function issetQuery($property)
    {
        return isset($this->query[ $property ]);
    }

    /**
     * Verify if a file request exists
     *
     * @param string $property
     * @return boolean
    */
    public function issetFile($property)
    {
        return isset($this->files[ $property ]);
    }

    /**
     * Verify if a server request exists
     *
     * @param string $property
     * @return boolean
    */
    public function issetServer($property)
    {
        return isset($this->server[ $property ]);
    }

    /**
     * Get the requet method
     *
     * @return string
    */
    public function getMethod()
    {
        return ($this->issetServer('REQUEST_METHOD')) ? $this->server('REQUEST_METHOD') : false;
    }

    /**
     * Send a HTTP request
     *
     * @param string        $url
     * @param array|string|null $params
     * @param string|null       $header
     * @param boolean       $ssl
     * @param boolean       $post
     * @return string
    */
    public function send($url, $params = null, $header = null, $ssl = false, $post = false)
    {
        if (!$post) {
            $url .= (is_array($params) && count($params) > 0) ? '?' . http_build_query($params) : $params;
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        (is_null($header)) ?: curl_setopt($ch, CURLOPT_HTTPHEADER, $header) ;
        curl_setopt($ch, CURLOPT_POST, $post);
        (!$post) ?: curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $ssl);

        $return = curl_exec($ch);

        if (!$return) {
            throw new RuntimeException('An error occurred with the request: ' . curl_error($ch));
        }

        return $return;
    }
}