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
     * @return \Attw\Router\RouteResult
    */
    public function getRoute($url, $requestMethod = 'GET', $defaultController, $defaultAction)
    {
        $params = explode('/', $url);
        $cController = (isset($params[0]) && $params[0] !== null && $params[0] !== '') ? strtolower($params[0]) : strtolower($defaultController);
        $cAction = (isset($params[1]) && $params[1] !== null && $params[1] !== '') ? strtolower($params[1]) : strtolower($defaultAction);

        if (count($this->routes) == 0) {
            RouterException::routeNotFound();
        }

        foreach ($this->routes as $route) {
            $result = $this->detectAll($route, $cController, $cAction, $requestMethod, $params);
        }

        return new RouteResult($result['controller'], $result['action'], $result['params']);
    }

    /**
     * @param \Attw\Router\Route $route
     * @param string             $cController
     * @param string             $cAction
     * @param string             $requestMethod
     * @return array
    */
    private function detectAll(Route $route, $cController, $cAction, $requestMethod, array $params){
        $controllerData = $this->detectActionOrController($route->getController(), $cController, 'controller');
        $actionData = $this->detectActionOrController($route->getAction(), $cAction, 'action');

        if (isset($controllerData['controller_r'], $actionData['action_r'])) {
            if (
                strtolower($cController) != strtolower($controllerData['controller_r']) 
                || strtolower($cAction) != strtolower($actionData['action_r']) 
                || strtolower($requestMethod) != strtolower($route->getRequestMethod())
            ) {
                RouterException::routeNotFound();
            }

            $cController = $controllerData['controller_t'];
            $cAction = $actionData['action_t'];
            $paramsSetted = array($controllerData['controller_r'] => $controllerData['controller_t']) == $route->getController() 
                            && array($actionData['action_r'] => $actionData['action_t']) == $route->getAction() 
                            && strtolower($requestMethod) == strtolower($route->getRequestMethod()) 
                            ? $route->getParams() : array();

            $params = $this->detectParams($params, $paramsSetted);
        }

        return array('controller' => $cController, 'action' => $cAction, 'params' => $params);
    }

    /**
     * @param string $property
     * @param string $currentProperty
     * @param string $name
     * @return array
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
     * @param array $params
     * @param array $routeParams
     * @return array
    */
    private function detectParams(array $params, array $routeParams)
    {
        if (count($params) > 2) {
            unset($params[0], $params[1]);

            foreach ($params as $key => $value) {
                $params[$key - 2] = $value;
                unset($params[$key]);
            }

            if (count($params) > count($routeParams)) {
                foreach ($params as $key => $value) {
                    if ($key + 1 > count($routeParams)) {
                        unset($params[$key]);
                    }
                }
            }

            return array_combine($routeParams, $params);
        }

        return array();
    }
}