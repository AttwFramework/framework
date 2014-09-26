<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Http\Cookie;

use Attw\Http\Cookie;
use Attw\Tool\Collection\ArrayCollection;

class Cookies
{
    public function __construct()
    {
        $this->cookie = new ArrayCollection();
    }

    /**
     * Sets an http cookie
     *
     * @param \Attw\Http\Cookie $cookie
    */
    public function offsetSet(Cookie $cookie)
    {
        $this->cookies[$cookie->getDomain()][$cookie->getName()] = $cookie;
        setcookie($cookie->getName(), $cookie->getValue(), $cookie->getPath(), $cookie->getExpire(), $cookie->getDomain(), $cookie->getHttpOnly());
    }

    public function offsetUnset()
    {

    }

    public function getCookies()
    {
        return $this->cookies;
    }
}