<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Http;

use Attw\Http\Response;
use Attw\Http\Cookie;

class Cookies
{
    /**
     * @var \Attw\Http\Response
    */
    private $response;

    /**
     * @param \Attw\Http\Response
    */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * Sets an http cookie
     *
     * @param \Attw\Http\Cookie $cookie
    */
    public function set(Cookie $cookie)
    {
        $headerStructure .= 'name=' . $cookie->getName();
        $headerStructure .= ' value=' . $cookie->getValue();
        $headerStructure .= ' path=' . $cookie->getPath();
        $headerStructure .= ' expire=' . $cookie->getExpire();
        $headerStructure .= ' domain=' . $cookie->getDomain();
        $headerStructure .= ' httponly=' . $cookie->getHttpOnly();

        $this->response->sendHeader('Set-Cookie', $headerStructure);
    }
}