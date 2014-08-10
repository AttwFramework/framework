<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Router;

use Attw\Router\Route;
use Attw\Core\Collection;

/**
 * Routes collection
*/
class RoutesCollection
{
    /**
     * All routes addeds
     *
     * @var array
    */
    private $routes = array();

    /**
     * Attach a route to collection
     *
     * @param instanceof Attw\Router\Route $route
    */
    public function add(Route $route)
    {
        $this->routes[ $route->getName() ] = $route;
    }

    /**
     * Get all routes
     *
     * @return array
    */
    public function getAll()
    {
        return $this->routes;
    }
}