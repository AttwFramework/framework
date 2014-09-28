<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
 */

namespace Attw\Http;

use Attw\Http\Request\Method\RequestsCollection;
use Attw\Tool\Collection\ArrayCollection;
use Arrw\Http\Request\Exception\RequestException;

/**
 * Request handler
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
     * Querystrings ($_GET)
     *
     * @var \Attw\Http\Request\Method\RequestsCollection
     */
    public $query;

    /**
     * Posts ($_POST)
     *
     * @var \Attw\Http\Request\Method\RequestsCollection
     */
    public $post;

    /**
     * Files ($_FILES)
     *
     * @var \Attw\Http\Request\Method\RequestsCollection
     */
    public $files;

    /**
     * Server ($_SERVER)
     *
     * @var \Attw\Http\Request\Method\RequestsCollection
     */
    public $server;

    /**
     * Cookies ($_COOKIE)
     *
     * @var \Attw\Http\Request\Method\RequestsCollection
    */
    public $cookie;

    /**
     * Request method
     *
     * @var string
     */
    public $method;

    /**
     * @param array $query
     * @param array $post
     * @param array $files
     * @param array $server
     * @param array $cookies
     */
    public function __construct(
        array $query = array(),
        array $post = array(),
        array $files = array(),
        array $server = array(),
        array $cookies = array()
    ) {
        $this->query = (count($query) > 0) ? new RequestsCollection($query) : new RequestsCollection($_GET);
        $this->post = (count($post) > 0) ? new RequestsCollection($post) : new RequestsCollection($_POST);
        $this->files = (count($files) > 0) ? new RequestsCollection($files) : new RequestsCollection($_FILES);
        $this->server = (count($server) > 0) ? new RequestsCollection($server) : new RequestsCollection($_SERVER);
        $this->cookies = (count($cookies) > 0) ? new RequestsCollection($cookies) : new RequestsCollection($_COOKIE);
    }

    public function __set($property, $value)
    {
        $requestMethods = array('query', 'post', 'files', 'server', 'cookies');

        if (in_array($property, $requestMethods) && !$value instanceof ArrayCollection) {
            throw new RequestException('An property the represents some request method only can be an instance of \Attw\Tool\Collection\ArrayCollection');
        }

        $this->{$property} = $value;
    }

    /**
     * Returns the request method
     *
     * @return string
     */
    public function getMethod()
    {
        return ($this->server->exists('REQUEST_METHOD')) ? $this->server->get('REQUEST_METHOD') : false;
    }

    /**
     * Send a HTTP request
     *
     * @param string            $url
     * @param array|string|null $params
     * @param string|null       $header
     * @param boolean           $ssl
     * @param boolean           $post
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
        (is_null($header)) ?  : curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, $post);
        (!$post) ?  : curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $ssl);

        $return = curl_exec($ch);

        if (!$return) {
            throw new RuntimeException('An error occurred with the request: ' . curl_error($ch));
        }

        return $return;
    }
}