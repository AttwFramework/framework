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
        $cController = (isset($params[0]) && $params[0] !== null && $params[0] !== '') ? strtolower($params[0]) : strtolower($defaultController);
        $cAction = (isset($params[1]) && $params[1] !== null && $params[1] !== '') ? strtolower($params[1]) : strtolower($defaultAction);

        if (count($this->routes) == 0) {
            $this->throwExceptionRouteNotFound();
        }

        foreach ($this->routes as $route) {
            $controllerData = $this->detectActionOrController($route->getController(), $cController, 'controller');
            $actionData = $this->detectActionOrController($route->getAction(), $cAction, 'action');

            if ($controllerData['valids'] < 0 || $actionData['valids'] < 0) {
                $this->throwExceptionRouteNotFound();
            }

            if (isset($controllerData['controller_r'], $actionData['action_r'])) {
                if (
                    strtolower($cController) != strtolower($controllerData['controller_r']) 
                    || strtolower($cAction) != strtolower($actionData['action_r']) 
                    || strtolower($requestMethod) != strtolower($route->getRequestMethod())
                ) {
                    $this->throwExceptionRouteNotFound();
                }

                $cController = $controllerData['controller_t'];
                $cAction = $actionData['action_t'];
                $paramsSetted = array($controllerData['controller_r'] => $controllerData['controller_t']) == $route->getController() 
                                && array($actionData['action_r'] => $actionData['action_t']) == $route->getAction() 
                                && strtolower($requestMethod) != strtolower($route->getRequestMethod()) 
                                ? $route->getParams() : array();
                $params = array();

                if (!count($params) === 1 || !count($params) === 2) {
                    unset($params[0], $params[1]);

                    foreach ($params as $key => $value) {
                        $params[ $key - 2 ] = $value;
                        unset($params[$key]);
                    }

                    if (count($params) > count($paramsSetted)) {
                        foreach ($params as $key => $value) {
                            if ($key + 1 > count($paramsSetted)) {
                                unset($params[$key]);
                            }
                        }
                    }

                    $params = array_combine($paramsSetted, $params);
                }
            }
        }

        return new RouteResult($cController, $cAction, $params);
    }

    /**
     * @param string $property
     * @param string $currentProperty
     * @param string $name
    */
    private function detectActionOrController($property, $currentProperty, $name)
    {
        $return = array('valids' => 0);

        if (is_array($property)) {
            foreach ($property as $key => $value) {
                if ($key == $currentProperty) {
                    $return[$name . '_t'] = $value;
                    $return[$name . '_r'] = $key;
                    $return['valids']++;
                }
            }
        }

        return $return;
    }

    /**
     * @throws \Attw\Router\Exception\RouterException
    */
    private function throwExceptionRouteNotFound()
    {
        throw new RouterException('Route not found');
    }
}