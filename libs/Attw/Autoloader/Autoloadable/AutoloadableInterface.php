<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Autoloader\Autoloadable;

interface AutoloadableInterface
{
    /**
     * @return callable
     */
    public function getCallable();
}
