<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Http\Request\HttpReferer;

use Attw\Http\Request;
use Attw\Http\Request\Exception\HttpRefererException;
use Attw\Http\Request\HttpReferer\HttpRefererBlockerActionInterface;
use Attw\Http\Request\HttpReferer\HttpRefererValidatorInterface;

class HttpRefererBlocker implements HttpRefererValidatorInterface
{
    /**
     * Blocked referers
     *
     * @var array
    */
    private $blocked;

    /**
     * Adds a HTTP referer to block
     *
     * @param string                                                           $referer
     * @param \Attw\Http\Request\HttpReferer\HttpRefererBlockerActionInterface $action
     * @return \Attw\Http\Request\HttpReferer\AbstractHttpRefererValidator
    */
    public function add($referer, HttpRefererBlockerActionInterface $action)
    {
        $this->blocked[] = array('referer' => $referer, 'action' => $action);
        return $this;
    }

    /**
     * Validates the current HTTP referer
     *
     * @param \Attw\Http\Request $request
    */
    public function validate(Request $request)
    {
        if (!$request->server->exists('HTTP_REFERER')) {
            throw new HttpRefererException('Define an HTTP referer');
        }
        
        $referer = $request->server->get('HTTP_REFERER');

        foreach ($this->blocked as $blockedReferer)
        {
            if ($referer == $blockedReferer['referer']) {
                $action = $blockedReferer['action'];
                $action->execute();
            }
        }
    }
}