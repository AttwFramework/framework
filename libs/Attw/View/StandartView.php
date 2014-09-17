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
use Attw\Core\Object;
use \Exception;
use \InvalidArgumentException;
use \RuntimeException;

/**
 * Constructor for views
*/
class StandartView extends Object implements ViewInterface
{
    /**
     * Template file
     *
     * @var string
    */
    private $tplFile;

    /**
     * Templates path
     *
     * @var string
    */
    private $templatesPath;

    /**
     * Setter for templates path
     *
     * @param string $path
    */
    public function setTemplatesPath($path)
    {
        $this->templatesPath = $path;
    }

    /**
     * Validate file
     *
     * @param string $file
     * @return string
    */
    private function validateFile($file)
    {
        $fileWithPath = $this->templatesPath . DIRECTORY_SEPARATOR . $file;

        if (!is_file($fileWithPath)) {
            throw new RuntimeException('Template not found: ' . $fileWithPath);
        }

        return $fileWithPath;
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
        $file = $this->validateFile($tplFile);
        extract($vars);
        include_once $file;
    }
}