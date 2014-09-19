<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Mvc\Controller;

use Attw\Core\Object;
use \InvalidArgumentException;
use \RuntimeException;
use Attw\Mvc\View\ViewInterface;
use Attw\HTTP\Request;
use Attw\HTTP\Response;
use Attw\Router\RouterUrlGeneratorInterface;
use Attw\Event\EventManagerInterface;
use Attw\Mvc\Model\ModelDispatcher;

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
     * @var \Attw\View\ViewInterface
    */
    private $view;

    /**
     * @var \Attw\Event\EventManagerInterface
    */
    private $eventManager;

    /**
     * @var \Attw\Mvc\Model\ModelDispatcher
    */
    private $modelDispatcher;

    /**
     * Setter for models namespace
     *
     * @param string $namespace
    */
    public function setModelsNamespace($namespace)
    {
        $this->modelsNamespace = $namespace;
    }

    /**
     * Returns models namespace
     *
     * @return string
    */
    public function getModelsNamespace()
    {
        return $this->modelsNamespace;
    }

    /**
     * Instance a model
     *
     * @param string $model Model name to instance
     * @throws \InvalidArgumentException case param $model is not a string
     * @throws \RuntimeException case model do not exists
     * @return object
    */
    protected function model($model)
    {
        if ($this->modelDispatcher === null) {
            ControllerException::modelDispatcherNotDefined();
        } elseif ($this->modelsNamespace === null) {
            ControllerException::modelsNamespaceNotDefined();
        }

        return $this->modelDispatcher->dispatch($this->getModelsNamespace(), $model);
    }

    /**
     * Setter for model dispatcher
     *
     * @param \Attw\Mvc\Model\ModelDispatcher $modelDispatcher
    */
    public function setModelDispatcher(ModelDispatcher $modelDispatcher)
    {
        $this->modelDispatcher = $modelDispatcher;
    }

    /**
     * Render a view
     *
     * @param string $file
     * @param array $vars Vars to template
    */
    protected function render($file, array $vars = array())
    {
        if ($this->view == null) {
            ControllerException::viewsRenderNotDefined();
        }

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
    public function getRequest()
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
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Get URL for a route
     *
     * @return string
    */
    public function generateUrl($name, array $params = array())
    {
        return $this->urlGenerator->generate($name, $params);
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

    /**
     * Setter for views render
     *
     * @param \Attw\Mvc\View\ViewInterface $view
    */
    public function setViewsRender(ViewInterface $view)
    {
        $this->view = $view;
    }

    /**
     * Setter for evenet manager
     *
     * @param \Attw\Event\EventManagerInterface $eventManager
    */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    /**
     * Returns the event manager object
     *
     * @return \Attw\Event\EventManagerInterface
    */
    public function getEventManager()
    {
        if ($this->eventManager == null) {
            ControllerException::eventManagerNotDefined();
        }

        return $this->eventManager;
    }
}