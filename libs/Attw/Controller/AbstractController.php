<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Controller;

use Attw\Core\Object;
use \InvalidArgumentException;
use \RuntimeException;
use Attw\View\ViewInterface;
use Attw\HTTP\Request;
use Attw\HTTP\Response;
use Attw\Router\RouterUrlGeneratorInterface;

/**
 * Abstract controller to be a base to the other controllers
*/
abstract class AbstractController extends Object
{
    /**
     * HTTP Request handler
     *
     * @var \Attw\HTTP\Request
    */
    private $request;

    /**
     * HTTP Response handler
     *
     * @var \Attw\HTTP\Response
    */
    private $response;

    /**
     * Namespace to instance models
     *
     * @var string
    */
    private $modelsNamespace;

    /**
     * Url generator
     *
     * @var \Attw\Router\RouterUrlGeneratorInterface
    */
    private $urlGenerator;

    /**
     * @var string $modelsNamespace
    */
    public function __construct($modelsNamespace, ViewInterface $view)
    {
        $this->modelsNamespace = $modelsNamespace;
        $this->view = $view;
    }

    /**
     * Method that will called when a action be not defined by user
     * Allowed to be replaced
    */
    public function index()
    {
    }

    /**
     * Instance a model
     *
     * @param string $model Model name to instance
     * @throws \InvalidArgumentException case param $model is not a string
     * @throws \RuntimeException case model do not exists
     * @return instanceof $model
    */
    protected function loadModel($model)
    {
        if (!is_string($model)) {
            throw new InvalidArgumentException('Model argument must be an string');
        }

        $namespace = (substr($this->modelsNamespace, -1, 1) == '\\') ? $this->modelsNamespace : $this->modelsNamespace . '\\';
        $model_name = $namespace . $model;

        if (!class_exists($model_name)) {
            throw new RuntimeException('Model not found: ' . $model_name);
        }

        $model_instance = new $model_name();

        return $model_instance;
    }

    /**
     * Render a view
     *
     * @param string $file
     * @param array $vars Vars to template
    */
    protected function render($file, array $vars = array())
    {
        $this->view->render($file, $vars);
    }

    /**
     * Set the request handler
     *
     * @param \Attw\HTTP\Request $request
    */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get HTTP requests
     *
     * @return \Attw\HTTP\Request
    */
    protected function getRequest()
    {
        return $this->request;
    }

    /**
     * Set the response handler
     *
     * @param \Attw\HTTP\Response $response
    */
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    /**
     * Get HTTP responses
     *
     * @return \Attw\HTTP\Response
    */
    protected function getResponse()
    {
        return $this->response;
    }

    /**
     * Get URL for a route
     *
     * @return string
    */
    protected function generateUrl($name, array $params = array())
    {
        $this->urlGenerator->getRouteUrl($name, $params);
    }

    /**
     * Setter for url generator
     *
     * @param \Attw\Router\RouterUrlGeneratorInterface $urlGenerator
    */
    public function setRouterUrlGenerator(RouterUrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }
}