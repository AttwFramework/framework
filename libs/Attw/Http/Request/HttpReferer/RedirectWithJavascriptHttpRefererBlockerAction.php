<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Http\Request\HttpReferer;

use Attw\Http\Request\HttpReferer\AbstractRedirectHttpRefererBlockerAction;

class RedirectWithJavascriptHttpRefererBlockerAction extends AbstractRedirectHttpRefererBlockerAction
{
    /**
     * Executes the action
    */
    public function execute()
    {
        echo '<script>location.href=\'' . $this->url . '\';</script>';
    }
}