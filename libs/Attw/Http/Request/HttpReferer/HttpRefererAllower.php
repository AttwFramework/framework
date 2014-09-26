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

class HttpRefererAllower implements HttpRefererValidatorInterface
{
    /**
     * Allowed referers
     *
     * @var array
    */
    private $allowed;

    /**
     * Action to execute when the validation failures
     *
     * @var \Attw\Http\Request\HttpReferer\HttpRefererBlockerActionInterface
    */
    private $setActionToBlockeds;

    /**
     * @param \Attw\Http\Request\HttpReferer\HttpRefererBlockerActionInterface $action
    */
    public function __construct(HttpRefererBlockerActionInterface $action)
    {
        $this->setActionToBlockeds($action);
    }

    /**
     * Sets the action to execute when the validation failures
     *
     * @param \Attw\Http\Request\HttpReferer\HttpRefererBlockerActionInterface $action
    */
    public function setActionToBlockeds(HttpRefererBlockerActionInterface $action)
    {
        $this->actionToBlockeds = $action;
    }

    /**
     * Adds a HTTP referer to block
     *
     * @param string $referer
     * @return \Attw\Http\Request\HttpReferer\AbstractHttpRefererValidator
    */
    public function add($referer)
    {
        $this->allowed[] = $referer;
        return $this;
    }

    /**
     * Validates the current HTTP referer
     *
     * @param \Attw\Http\Request $request
    */
    public function validate(Request $request)
    {
        if (!$request->issetServer('HTTP_REFERER')) {
            throw new HttpRefererException('Define an HTTP referer');
        }
        
        $referer = $request->server('HTTP_REFERER');

        if (!in_array($referer, $this->allowed)) {
            $this->actionToBlockeds->execute();
        }
    }
}