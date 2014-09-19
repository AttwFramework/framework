<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Controller;

use \Exception;

class ControllerException extends Exception
{
    public static function viewsRenderNotDefined()
    {
        self::someWasNotDefinedYet('Views render');
    }

    public static function eventManagerNotDefined()
    {
        self::someWasNotDefinedYet('Event manager');
    }

    public static function modelDispatcherNotDefined()
    {
        self::someWasNotDefinedYet('Model dispatcher');
    }

    public static function modelsNamespaceNotDefined()
    {
        self::someWasNotDefinedYet('Models namespace');
    }

    public static function invalidController($controller)
    {
        throw new ControllerException('Invalid controller: ' . $controller);
    }

    public static function controllerNotFound($controller)
    {
        throw new ControllerException('Controller not found: ' . $controller);
    }

    public static function actionNotFound($controller, $action)
    {
        throw new ControllerException('Action not found: ' . $controller . '::' . $action);
    }

    /**
     * @var string $thing
    */
    private static function someWasNotDefinedYet($thing)
    {
        throw new ControllerException($thing . ' was not defined yet');
    }
}