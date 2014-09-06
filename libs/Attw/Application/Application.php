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
use Attw\HTTP\Request;
use Attw\HTTP\Response;
use Attw\Application\ControllerDispatcher;

/**
 * Attw Application
*/
class Application
{
    /**
     * Controller dispatcher
     * Will instantiate the controller
     *
     * @var \Attw\Application\ControllerDispatcher
    */
    private $dispatcher;

    /**
     * Handler for routes
     *
     * @var \Attw\Router\RoutingHandler
    */
    private $routingHandler;

    /**
     * Constructor
     *
     * @param \Attw\Application\ControllerDispatcher $dispatcher
     * @param \Attw\Router\RoutingHandler $routingHandler
    */
    public function __construct(ControllerDispatcher $dispatcher, RoutingHandler $routingHandler)
    {
        $this->dispatcher = $dispatcher;
        $this->routingHandler = $routingHandler;
    }

    /**
     * Executes the application
     *
     * @param \Attw\HTTP\Request $request
     * @param string $controllerNamespace Namespace for all controllers
     * @param string $defaultController
     * @param string $defaultAction
    */
    public function run(
        Response $response,
        Request $request,
        $controllerNamespace,
        $modelsNamespace,
        $defaultController = 'Index',
        $defaultAction = 'index'
   ) {
        $url = ($request->issetQuery('url')) ? $request->query('url') : null;
        $route = $this->routingHandler->setParams($url, $request->getMethod(), $defaultController, $defaultAction);
        $controller = $controllerNamespace . '\\' . ucfirst($route->getController());

        $request->addQuery($route->getParams());

        $this->dispatcher->dispatch(
            $controller,
            $route->getAction(),
            $this->routingHandler,
            $response,
            $request,
            $modelsNamespace
       );
    }
}