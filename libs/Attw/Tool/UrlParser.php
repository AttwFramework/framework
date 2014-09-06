<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Tool;

use  Attw\Tool\Exception\UrlParserException;

class UrlParser
{
    /**
     * Return the query strings from a URL
     *
     * @param string $url
     * @return array Queries
    */
    public function getQueries($url)
    {
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

    private function verifyUrl($url)
    {
        if (!filter_Var($url, FILTER_VALIDATE_URL)) {
            UrlParserException::invalidUrl($url);
        }
    }
}