<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Router;

use Attw\Router\RoutesCollection;
use Attw\Router\RouteResult;
use Attw\Router\Exception\RouterException;

/**
 * Routing handler
*/
class RoutingHandler
{
    /**
     * All routes from Attw\Router\RoutesCollection
     *
     * @var array
    */
    private $routes = array();

    /**
     * Current controller
     *
     * @var string
    */
    private $controller;

    /**
     * Current controller's action
     *
     * @var string
    */
    private $action;

    /**
     * Current Get params
     *
     * @var array
    */
    private $params = array();

    /**
     * RoutesCollection
    */
    public function __construct(RoutesCollection $collection)
    {
        $this->routes = $collection->getAll();
    }

    /**
     * Define the controller, the action and the params
     *
     * @param string $url               URL to use
     * @param string $requestMethod
     * @param string $defaultController Default controller to application
     * @param string $defaultAction     Default action to controllers
    */
    public function setParams($url, $requestMethod = 'GET', $defaultController, $defaultAction)
    {
        $params = explode('/', $url);

        $cController = (isset($params[0]) && $params[0] !== null && $params[0] !== '') ? $params[0] : $defaultController;
        $cAction = (isset($params[1]) && $params[1] !== null && $params[1] !== '') ? $params[1] : $defaultAction;

        $cController = strtolower($cController);
        $cAction = strtolower($cAction);

        $validControllers = 0;
        $validActions = 0;

        if (count($this->routes) == 0) {
            $this->throwExceptionRouteNotFound();
        } else {
            $cControllerT = null;
            $cActionT = null;
            foreach ($this->routes as $route) {
                if (is_array($route->getController())) {
                    foreach ($route->getController() as $key => $value) {
                        if ($key == $cController) {
                            $cControllerT = $value;
                            $cControllerR = $key;
                            $validControllers++;
                        }
                    }
                }

                if (is_array($route->getAction())) {
                    foreach ($route->getAction() as $key => $value) {
                        if ($key == $cAction) {
                            $cActionT = $value;
                            $cActionR = $key;
                            $validActions++;
                        }
                    }
                }


                if ($validControllers < 0 || $validActions < 0) {
                    $this->throwExceptionRouteNotFound();
                }

                if (isset($cControllerR, $cActionR)) {
                    if (
                        strtolower($cController) != strtolower($cControllerR) 
                        || strtolower($cAction) != strtolower($cActionR) 
                        || strtolower($requestMethod) != strtolower($route->getRequestMethod())
                    ) {
                        $this->throwExceptionRouteNotFound();
                    }

                    $cController = $cControllerT;
                    $cAction = $cActionT;

                    $paramsSetted = $route->getPath();

                    if (count($params) === 1 || count($params) === 2) {
                        $this->params = array();
                    } else {
                        unset($params[0], $params[1]);

                        foreach ($params as $key => $value) {
                            $params[ $key - 2 ] = $value;
                            unset($params[ $key ]);
                        }

                        if (count($params) > count($paramsSetted)) {
                            foreach ($params as $key => $value) {
                                if ($key + 1 > count($paramsSetted)) {
                                unset($params[ $key ]);
                                }
                            }
                        }

                        $params = array_combine($paramsSetted, $params);
                    }
                }
            }
        }

        return new RouteResult($cController, $cAction, $params);
    }

    /**
     * @throws \Attw\Router\Exception\RouterException
    */
    private function throwExceptionRouteNotFound()
    {
        throw new RouterException('Route not found');
    }
}