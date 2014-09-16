<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\HTTP;

use \UnexpectedValueException;

/**
 * Manage HTTP cookies
*/
class Cookies
{
    /**
     * All cookies created by this class
     *
     * @var array
    */
    private $cookies;

    /**
     * Create a cookie
     *
     * @param string $name Cookie name
     * @param mixed $value Cookie value
     * @param integer $expire Cookie timeout
     * @param string $path Path to save the cookie
     * @param string $domain Domine that cookie will be available
     * @param boolean $secure TRUE case the cookie only can be
     *  transmitted in  secure connections (HTTPS)
     * @param boolean $httponly Transmitted only in HTTP protocols
    */
    public function set($name, $value = null, $expire = 0, $path = '/', $domain = null, $secure = false, $httponly = false)
    {
        $this->cookies[] = func_get_args();

        setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }

    /**
     * Read a cookie
     *
     * @param string $name Cookie name
     * @throws \UnexpectedValueException case cookie name doesn't exists
     * @return mixed Cookie value
    */
    public function get($name)
    {
        $this->exceptionCookieNotFound($name);
        return $_COOKIE[$name];
    }

    /**
     * Delete a cookie
     *
     * @param string $name
     * @throws \UnexpectedValueException case cookie name doesn't exists
    */
    public function remove($name)
    {
        $this->exceptionCookieNotFound($name);
        setcookie($name, null, time() - 3600);
    }

    /**
     * Delete all cookies
    */
    public function closeAll()
    {
        foreach ($_COOKIE as $name => $value) {
            $this->remove($name);
        }
    }

    /**
     * Verify if a cookie exists
     *
     * @param string $name Cookie name
     * @return boolean
    */
    public function has($name)
    {
        return array_key_exists($name, $_COOKIE);
    }

    private function exceptionCookieNotFound($name)
    {
        if (!$this->has($name)) {
            throw new UnexpectedValueException(sprintf('Cookie named %s doesn\'t exists', $name));
        }
    }
}