<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Event;

use Attw\Event\Event;

/**
 * Event manager interface
*/
interface EventManagerInterface
{
    public function listen($name, $listener, $priority = 0);
    public function unlisten($name = null, $listener = null);
    public function trigger($name, Event $event);
}