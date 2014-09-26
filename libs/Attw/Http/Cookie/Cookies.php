<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Http\Cookie;

use Attw\Http\Cookie\Cookie;
use Attw\Tool\Collection\ArrayCollection;

class Cookies
{
    /**
     * Cookies
     *
     * @var array
    */
    private $cookies = array();

    /**
     * Sets an http cookie
     *
     * @param \Attw\Http\Cookie $cookie
    */
    public function set(Cookie $cookie)
    {
        $this->cookies[$cookie->getDomain()][$cookie->getName()] = $cookie;
        setcookie($cookie->getName(), $cookie->getValue(), $cookie->getPath(), $cookie->getExpire(), $cookie->getDomain(), $cookie->getHttpOnly());
    }

    /**
     * @return array
    */
    public function getAll()
    {
        return $this->cookies;
    }
}