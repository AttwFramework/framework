<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Application;

use Attw\Router\RoutingHandler;
use Attw\Application\Exception\ApplicationException;
use Attw\HTTP\Request;
use Attw\HTTP\Response;

class ControllerDispatcher
{
    /**
     * Create an instance of controller and execute the method
     *
     * @param string $controller
     * @param string $action
     * @param \Attw\Router\RoutingManager
    */
    public function dispatch($controller, $action, RoutingHandler $routingHandler, Response $response, Request $request, $modelsNamespace)
    {
        if (!class_exists($controller)) {
            throw new ApplicationException('Controller not found: ' . $controller);
        } elseif (!method_exists(new $controller( $modelsNamespace ), $action)) {
            throw new ApplicationException(sprintf('Action not found: %s::%s',
                                        $controller,
                                        $action));
        }

        $controller = new $controller($modelsNamespace);
        $controller->setRouter($routingHandler);
        $controller->setRequest($request);
        $controller->setResponse($response);
        $controller->{$action}();
    }
}