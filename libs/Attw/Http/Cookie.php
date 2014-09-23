<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Http;

class Cookie
{
    /**
     * Cookie name
     *
     * @var string
    */
    private $name;

    /**
     * Cookie value
     *
     * @var mixed
    */
    private $value;

    /**
     * Cookie timeout
     *
     * @var integer
    */
    private $expire;

    /**
     * Path to save the cookie
     *
     * @var string
    */
    private $path;

    /**
     * Domain that cookie will be available
     *
     * @var string|null
    */
    private $domain;

    /**
     * TRUE case the cookie only can be
     *  transmitted in  secure connections (HTTPS)
     *
     * @var boolean
    */
    private $secure;

    /**
     * Transmitted only in HTTP protocols
     *
     * @var boolean
    */
    private $httpOnly;

    /**
     * @param string  $name Cookie name
     * @param mixed   $value Cookie value
     * @param integer $expire Cookie timeout
     * @param string  $path Path to save the cookie
     * @param string|null  $domain Domain that cookie will be available
     * @param boolean $secure TRUE case the cookie only can be
     *  transmitted in  secure connections (HTTPS)
     * @param boolean $httponly Transmitted only in HTTP protocols
    */
    public function __construct($name, $value = null, $expire = 0, $path = '/', $domain = null, $secure = false, $httpOnly = false)
    {
        $this->name = $name;
        $this->value = $value;
        $this->expire = $expire;
        $this->path = $path;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->httpOnly = $httpOnly;
    }

    /**
     * @return string
    */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string|null
    */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return integer
    */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * @return string
    */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string|null
    */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @return boolean
    */
    public function getSecure()
    {
        return $this->secure;
    }

    /**
     * @return boolean
    */
    public function getHttpOnly()
    {
        return $this->httpOnly;
    }
}