<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Tool\Url;

use \BadMethodCallException;
use Attw\Tool\Exception\UrlParserExcpetion;

class UrlParser
{
    /**
     * URL to make the work on
     *
     * @var string
    */
    private $url;

    /**
     * @param string|null $url
    */ 
    public function __construct($url = null)
    {
        $this->url = $url;
    }

    /**
     * Return the query strings from a URL
     *
     * @param string $url
     * @return array Queries
    */
    public function getQueryParams($url = null)
    {
        $url = $this->identifyUrl($url);
        $params = explode('?', $url);
        $queries = array();

        if (count($params) > 1) {
            $params = end($params);
            $relations = explode('&', $params);

            $queries = array();

            foreach ($relations as $relation) {
                $camps = explode('=', $relation);
                $queries[ $camps[0] ] = $camps[1];
            }
        }

        return $queries;
    }

    /**
     * Returns the domain name of an URL
     *
     * @example - http://google.com/search?q=foo
     *          - Returns: google.com
     *          - Protocol 'true': http://google.com
     * @param string  $url
     * @param boolean $protocol
     * @return string
    */
    public function getHost($url = null)
    {
        $url = $url = $this->identifyUrl($url);
        $urlE = explode('/', $url);

        if (isset($urlE[2])) {
            return $urlE[2];
        }

        UrlParserExcpetion::invalidUrl($url);
    }

    /**
     * Returns the domain (.com, .net, etc.) of an URL
     *
     * @example - http://google.com/
     *          - Returns: com
     *          - http://google.com.br/
     *          - Returns: com.br
     *          - http://subdomain.google.com
     *          - $hasSubdomain must be true
     *          - Case true: com
     *          - Case false: google.com
     * @param string  $url
     * @param boolean $hasSubdomain
     * @return string
    */
    public function getDomain($url = null, $hasSubdomain = false)
    {
        $url = $this->identifyUrl($url);
        $urlE = explode('/', $url);

        if (isset($urlE[2])) {
            $url = $urlE[2];
            $urlDot = explode('.', $url);
            if ($hasSubdomain) {
                if (count($urlDot) <= 2) {
                    throw new UrlParserExcpetion('Invalid URL');
                }

                unset($urlDot[0], $urlDot[1]);

                return '.' . implode('.', $urlDot);
            }

            unset($urlDot[0]);
            return '.' . implode('.', $urlDot);
        }
    }

    /**
     * Returns the page of an URL
     *
     * @example - http://google.com/search?q=foo/bar
     *          - Returns: search?q=foo/bar
     *          - QueryString off: search
     * @param string  $url
     * @param boolean $querystring
     * @return string|array
    */
    public function getPath($url = null, $array = false, $querystrings = true)
    {
        $url = $this->identifyUrl($url);
        $urlE = explode('/', $url);

        if (isset($urlE[3])) {
            if (!$querystrings) {
                $urlE2 = explode('?', $url);
                $urlWithoutQs = $urlE2[0];
                $urlWithoutQsE = explode('/', $urlWithoutQs);
                unset($urlWithoutQsE[0], $urlWithoutQsE[1], $urlWithoutQsE[2]);
                return implode('/', $urlWithoutQsE);
            }

            unset($urlE[0], $urlE[1], $urlE[2]);
            return $array ? $urlE : implode('/', $urlE);
        }
    }

    /**
     * Returns the protocol used
     *
     * @example - http://google.com
     *          - Returns: http
     *          - https://google.com
     *          - Returns: https
     * @param string $url
     * @return string
    */
    public function getProtocol($url = null)
    {
        $url = $this->identifyUrl($url);
        $urlE = explode('/', $url);
        $err = false;

        if (isset($urlE[2]) && is_null($urlE[1])) {
            return substr($url, 0, -1);
        }

        UrlParserExcpetion::invalidUrl($url);
    }

    /**
     * @param string|null $url
     * @return string
    */
    private function identifyUrl($url = null)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            UrlParserExcpetion::invalidUrl($url);
        }

        if (is_null($url) && is_null($this->url)) {
            throw new BadMethodCallException('Indicate an URL on instance or as a param to this method');
        }

        return is_null($url) ? $this->url : $url;
    }
}