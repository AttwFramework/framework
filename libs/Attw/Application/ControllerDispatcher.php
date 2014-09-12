<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Application;

use Attw\Router\RouterUrlGeneratorInterface;
use Attw\Application\Exception\ApplicationException;
use Attw\HTTP\Request;
use Attw\HTTP\Response;
use Attw\View\ViewInterface;

class ControllerDispatcher
{
    /**
     * Create an instance of controller and execute the action
     *
     * @param string $controller
     * @param string $action
     * @param \Attw\Router\RoutingManager
    */
    public function dispatch($controller, $action, RouterUrlGeneratorInterface $urlGenerator, Response $response, Request $request, ViewInterface $view, $modelsNamespace)
    {
        if (!class_exists($controller)) {
            throw new ApplicationException('Controller not found: ' . $controller);
        } elseif (!method_exists(new $controller($modelsNamespace, $view), $action)) {
            throw new ApplicationException(sprintf('Action not found: %s::%s',
                                        $controller,
                                        $action));
        }

        $controller = new $controller($modelsNamespace, $view);
        $controller->setRouterUrlGenerator($urlGenerator);
        $controller->setRequest($request);
        $controller->setResponse($response);
        $controller->{$action}();
    }
}