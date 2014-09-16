<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Router\Exception;

use \Exception;

class RouterException extends Exception
{
    public static function routeNotFound()
    {
        throw new RouterException('Route not found');
    }
}