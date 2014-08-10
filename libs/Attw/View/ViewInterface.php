<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\View;

/**
 * Interface to views
*/
interface ViewInterface
{
    /**
     * Render a view
     *
     * @param array $params params to template of Smarty
    */
    public function render($tplFile, array $vars = array());
}