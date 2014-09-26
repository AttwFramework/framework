<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Http\Request\HttpReferer;

use Attw\Http\Request\HttpReferer\HttpRefererBlockerActionInterface;

abstract class AbstractRedirectHttpRefererBlockerAction implements HttpRefererBlockerActionInterface
{
    /**
     * URL to redirect
     *
     * @var string
    */
    protected $url;

    /**
     * @param string $url
    */
    public function __construct($url)
    {
        $this->url = $url;
    }
}