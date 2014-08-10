<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Router;

/**
 * Route
*/
class Route
{
    /**
     * Data of route
     *
     * @var array
    */
    private $route;

    /**
     * Constructor
     *
     * @param string $name
     * @param array | string
     * @param array $controllerAndAction
    */
    public function __construct($name, $params, array $controllerAndAction, $requestMethod = 'GET')
    {
        if (!isset($controllerAndAction['controller'], $controllerAndAction['action'])) {
            throw new RouterException('Indicate a controller and an action to the route');
        }

        $controller = $controllerAndAction['controller'];
        $action = $controllerAndAction['action'];

        $controllerR = array();
        $actionR = array();

        if (is_array($controller)) {
            if (count($controller) >= 1) {
                $controllerArrReverse = array_reverse($controller);

                for ($i = 0; $i < count($controller) - 1; $i++) {
                    array_shift($controllerArrReverse);
                }

                foreach ($controllerArrReverse as $key => $value) {
                    $controllerArrReverse[ strtolower($key) ] = $value;
                }

                $controllerR = $controllerArrReverse;
            } else {
                throw new RouterException('Define a valid controller');
            }
        } else {
            $controllerR[ strtolower($controller) ] = $controller;
        }

        if (is_array($action)) {
            if (count($action) >= 1) {
                $actionArrReverse = array_reverse($action);

                for ($i = 0; $i < count($action) - 1; $i++) {
                    array_shift($actionArrReverse);
                }

                $actionR = $actionArrReverse;
            } else {
                throw new RouterException('Define a valid action');
            }
        } else {
            $actionR[ $action ] = $action;
        }

        $params = (is_array($params)) ? $params : explode('/', $params);
        $this->route = array(
            'name' => $name,
            'route' => $params,
            'controller' => $controllerR,
            'action' => $actionR,
            'request_method' => $requestMethod
       );
    }

    /**
     * Return the controller of route
     *
     * @return array
    */
    public function getController()
    {
        return $this->route['controller'];
    }

    /**
     * Return the action of route
     *
     * @return array
    */
    public function getAction()
    {
        return $this->route['action'];
    }

    /**
     * Return the name of route
     *
     * @return string
    */
    public function getName()
    {
        return $this->route['name'];
    }

    /**
     * Get the params to query
     *
     * @return array
    */
    public function getPath()
    {
        return $this->route['route'];
    }

    /**
     * Get the request method
     *
     * @return string
    */
    public function getRequestMethod()
    {
        return $this->route['request_method'];
    }
}