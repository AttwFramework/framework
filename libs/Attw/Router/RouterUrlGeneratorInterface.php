<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Router;

interface RouterUrlGeneratorInterface
{
    /**
     * Generate an url by a registred route
     *
     * @param string $routeName
     * @param array  $params
     * @return string
    */
    public function generate($routeName, array $params = array());
}