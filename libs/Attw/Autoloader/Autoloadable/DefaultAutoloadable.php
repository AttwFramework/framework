<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Autoloader\Autoloadable;

use Attw\Autoloader\Autoloadable\AutoloadableInterface;

class DefaultAutoloadable implements AutoloadableInterface
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function getCallable()
    {
        return function ($class) {
            $file = $this->path . DIRECTORY_SEPARATOR . $class . '.php';

            if (file_exists($file)) {
                require_once $file;
            }
        };
    }
}