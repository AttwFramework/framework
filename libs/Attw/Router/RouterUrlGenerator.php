<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Router;

use Attw\Router\RouterUrlGeneratorInterface;
use Attw\Router\RoutesCollection;
use Attw\Router\Exception\RouterException;

class RouterUrlGenerator implements RouterUrlGeneratorInterface
{
    /**
     * Routes collection
     *
     * @var \Attw\Router\RoutesCollection
    */
    private $collection;

    /**
     * @param \Attw\Router\RoutesCollection $collection
     * @param \Attw\Router\RoutingHandler   $handler
    */
    public function __construct(RoutesCollection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Generate an url by a registred route
     *
     * @param string $routeName
     * @param array  $params
     * @return string
    */
    public function generate($routeName, array $params = array())
    {
        if (!$this->collection->has($routeName)) {
            throw new RouterException('Route not registred: ' . $routeName);
        }

        $routes = $this->collection->getAll();
        $route = $routes[$routeName];
        $controllerUrl = null;
        $actionUrl = null;

        foreach ($route->getController() as $key => $value) {
            $controllerUrl = $key;
        }

        foreach ($route->getAction() as $key => $value) {
            $actionUrl = $key;
        }

        return $controllerUrl . '/' . $actionUrl . '/' . implode('/', $this->detectParams($route, $params));
    }

    /**
     * @param \Attw\Router\Route $route
     * @param array              $params
     * @return array
    */
    private function detectParams($route, array $params = array())
    {
        $paramsUrl = array();
        foreach ($route->getParams() as $param) {
            foreach ($params as $key => $value) {
                if ($param == $key) {
                    $paramsUrl[] = $value;
                }
            }
        }

        return $paramsUrl;
    }
}