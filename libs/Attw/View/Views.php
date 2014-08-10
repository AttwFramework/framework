<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\View;

use Attw\View\ViewInterface;
use Attw\Config\Configs;
use Attw\Core\Object;
use \Exception;
use \InvalidArgumentException;
use \RuntimeException;

/**
 * Constructor for views
*/
class Views extends Object implements ViewInterface
{
    /**
     * Template file
     *
     * @var string
    */
    private $tplFile;

    /**
     * Vars to template
     *
     * @var array
    */
    protected $vars = array();

    /**
     * Set the template file to view
     *
     * @param string $file template file .tpl
     * @throws \InvalidArgumentException case param $file is not a string
     * @throws \Exception case is not defined a path for templates
    */
    protected function setTplFile($file)
    {
        if (!is_string($file)) {
            throw new InvalidArgumentException(sprintf('%s::%s: the file must be a string',
                                get_class($this),
                                __METHOD__));
        }

        $configs = Configs::getInstance();

        $paths = $configs->get('Paths');

        if (!isset($paths['Templates'])) {
            throw new Exception('Define a path for templates');
        }

        $templatesPath = $paths['Templates'];

        $file = $templatesPath . DS . $file;

        if (!is_file($file)) {
            throw new RuntimeException('Template not found: ' . $file);
        }

        $this->tplFile = $file;
    }

    /**
     * Renderer the view
     *
     * @param string $tplFile Template file to render
     * @param array $vars variables to template
     * @return mixed view rendered
    */
    public function render($tplFile, array $vars = array())
    {
        $this->setTplFile($tplFile);

        extract($vars);

        include_once $this->tplFile;
    }
}