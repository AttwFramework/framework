<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Mvc\Controller;

use Attw\Router\RouterUrlGeneratorInterface;
use Attw\Mvc\Controller\Exception\ControllerException;
use Attw\Http\Request;
use Attw\Http\Response;
use Attw\Mvc\View\ViewInterface;
use Attw\Event\EventManagerInterface;
use Attw\Mvc\Model\ModelDispatcher;

class ControllerDispatcher
{
    /**
     * Create an instance of controller and execute the action
     *
     * @param string $controller
     * @param string $action
     * @param \Attw\Router\RoutingManager
    */
    public function dispatch(
        $controllerNamespace,
        $controller, 
        $action, 
        RouterUrlGeneratorInterface $urlGenerator, 
        Response $response, 
        Request $request, 
        ViewInterface $view, 
        EventManagerInterface $eventManager,
        ModelDispatcher $modelDispatcher,
        $modelsNamespace = null
    ) {
        $objectName = $controllerNamespace . '\\' . $controller;

        if (!class_exists($objectName)) {
            ControllerException::controllerNotFound($objectName);
        } elseif (!method_exists(new $objectName(), $action)) {
            ControllerException::actionNotFound($objectName, $action);
        } elseif (!(new $objectName instanceof AbstractController)) {
            ControllerException::invalidController($objectName);
        }

        $controller = new $objectName();
        $controller->setViewsRender($view);
        $controller->setModelsNamespace($modelsNamespace);
        $controller->setModelDispatcher($modelDispatcher);
        $controller->setRouterUrlGenerator($urlGenerator);
        $controller->setRequest($request);
        $controller->setResponse($response);
        $controller->setEventManager($eventManager);
        $controller->{$action}();
    }
}