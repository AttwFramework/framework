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
                    if ($cController != $cControllerR || $cAction != $cActionR || $requestMethod != $route->getRequestMethod()) {
                        $this->throwExceptionRouteNotFound();
                    }

                    $this->controller = $cControllerT;
                    $this->action = $cActionT;

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

                        $this->params = array_combine($paramsSetted, $params);
                    }
                }
            }
        }
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getParams()
    {
        return $this->params;
    }

    /**
     * Get an url by a route registred on Attw\Router\RoutesCollection
     *
     * @param string $name
     * @param array $params
     * @return string Url
    */
    public function getRouteUrl($name, array $params = array())
    {
        $route = $this->routes[ $name ];

        $controllerUrl = null;
        $actionUrl = null;

        foreach ($route['controller'] as $key => $value) {
            $controllerUrl = $key;
        }

        foreach ($route['action'] as $key => $value) {
            $actionUrl = $key;
        }

        $paramsUrl = array();
        foreach ($route['route'] as $param) {
            foreach ($params as $key => $value) {
                if ($param == $key) {
                    $paramsUrl[] = $value;
                }
            }
        }

        $url = $controllerUrl . '/' . $actionUrl . '/' . implode('/', $paramsUrl);

        return $url;
    }

    /**
     * Return the query strings from a URL
     *
     * @param string $url
     * @return array Queries
    */
    public function getQueryStrings($url)
    {
        $params = explode('?', $url);
        $queries = array();

        if (count($params) > 1) {
            $params = end($params);
            $relations = explode('&', $params);

            $queries = array();

            foreach ($relations as $relation) {
                $camps = explode('=', $relation);
                $queries[ $camps[0] ] = $camps[1];
            }
        }

        return $queries;
    }

    private function throwExceptionRouteNotFound()
    {
        throw new RouterException('Route not found');
    }
}