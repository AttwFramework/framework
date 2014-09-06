<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Router;

class RouteResult
{
    /**
     * Controller
     *
     * @var string
    */
    private $controller;

    /**
     * Action of controller
     *
     * @var string
    */
    private $action;

    /**
     * Params
     *
     * @var array
    */
    private $params;

    /**
     * @param string $controller
     * @param string $action
     * @param array  $params
    */
    public function __construct($controller, $action, array $params)
    {
        $this->setController($controller);
        $this->setAction($action);
        $this->setParams($params);
    }

    /**
     * Controller setter
     *
     * @param string $controller
    */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * Action setter
     *
     * @param string $action
    */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * Params setter
     *
     * @param array $params
    */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * Controller getter
     *
     * @return string
    */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Action getter
     *
     * @return string
    */
    public function getAction()
    {
        return $this->action;
    }


    /**
     * Params getter
     *
     * @return array
    */
    public function getParams()
    {
        return $this->params;
    }
}