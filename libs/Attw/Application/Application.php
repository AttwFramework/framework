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
use Attw\Router\RouterUrlGeneratorInterface;
use Attw\Http\Request;
use Attw\Http\Response;
use Attw\Mvc\Controller\ControllerDispatcher;
use Attw\Mvc\View\ViewInterface;
use Attw\Event\EventManagerInterface;
use Attw\Mvc\Model\ModelDispatcher;

/**
 * Attw Application
*/
class Application
{
    /**
     * Controller dispatcher
     * Will instantiate the controller
     *
     * @var \Attw\Mvc\Controller\ControllerDispatcher
    */
    private $dispatcher;

    /**
     * Model dispatcher
     *
     * @var \Attw\Mvc\Model\ModelDispatcher
    */
    private $modelDispatcher;

    /**
     * Handler for routes
     *
     * @var \Attw\Router\RoutingHandler
    */
    private $routingHandler;

    /**
     * Constructor
     *
     * @param \Attw\Mvc\Controller\ControllerDispatcher $dispatcher
     * @param \Attw\Mvc\Model\ModelDispatcher           $modelDispatcher
     * @param \Attw\Router\RoutingHandler               $routingHandler
    */
    public function __construct(ControllerDispatcher $dispatcher, ModelDispatcher $modelDispatcher, RoutingHandler $routingHandler)
    {
        $this->dispatcher = $dispatcher;
        $this->modelDispatcher = $modelDispatcher;
        $this->routingHandler = $routingHandler;
    }

    /**
     * Executes the application
     *
     * @param \Attw\Http\Response                      $response 
     * @param \Attw\Http\Request                       $request
     * @param \Attw\Router\RouterUrlGeneratorInterface $urlGenerator
     * @param \Attw\Mvc\View\ViewInterface             $view
     * @param \Attw\Event\EventManagerInterface        $eventManager
     * @param string                                   $controllerNamespace
     * @param string                                   $defaultController
     * @param string                                   $defaultAction
     * @param string|null                              $modelsNamespace
    */
    public function run(
        Response $response,
        Request $request,
        RouterUrlGeneratorInterface $urlGenerator,
        ViewInterface $view,
        EventManagerInterface $eventManager,
        $controllerNamespace,
        $defaultController = 'Index',
        $defaultAction = 'index',
        $modelsNamespace = null
    ) {
        $url = ($request->issetQuery('url')) ? $request->query('url') : null;
        $route = $this->routingHandler->getRoute($url, $request->getMethod(), $defaultController, $defaultAction);

        $request->addQuery($route->getParams());

        $this->dispatcher->dispatch(
            $controllerNamespace,
            ucfirst($route->getController()),
            $route->getAction(),
            $urlGenerator,
            $response,
            $request,
            $view,
            $eventManager,
            $this->modelDispatcher,
            $modelsNamespace
       );
    }
}