<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Http\Request\HttpReferer;

use Attw\Http\RedirectHttpRefererBlockerAction;
use Attw\Http\Response;

class RedirectWithHttpLocationHeaderHttpRefererBlockerAction extends RedirectHttpRefererBlockerAction
{
    /**
     * HTTP response
     *
     * @var \Attw\Http\Response
    */
    private $response;

    /**
     * @param string              $url
     * @param \Attw\Http\Response $response
    */
    public function __construct($url, Response $response)
    {
        parent::__construct($url);
        $this->response = $response;
    }

    /**
     * Executes the action
    */
    public function execute()
    {
        $this->response->sendHeader('Location', $this->url);
    }
}