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

        $controllerR = $this->defineProperty('controller', $controller);
        $actionR = $this->defineProperty('action', $action);

        $params = (is_array($params)) ? $params : explode('/', $params);
        $this->route = array(
            'name' => $name,
            'params' => $params,
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
    public function getParams()
    {
        return $this->route['params'];
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

    private function defineProperty($name, $property)
    {
        if (is_array($property)) {
            if (count($property) >= 1) {
                $controllerArrReverse = array_reverse($property);

                for ($i = 0; $i < count($property) - 1; $i++) {
                    array_shift($controllerArrReverse);
                }

                foreach ($controllerArrReverse as $key => $value) {
                    $controllerArrReverse[ strtolower($key) ] = $value;
                }

                $propertyR = $controllerArrReverse;
            } else {
                throw new RouterException('Define a valid ' . $name);
            }
        } else {
            $propertyR[ strtolower($property) ] = $property;
        }

        return $propertyR;
    }
}