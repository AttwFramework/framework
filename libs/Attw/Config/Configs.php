<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Config;

use \ArrayObject;
use \InvalidArgumentException;
use \RuntimeException;
use Attw\Tool\Collection\ArrayCollection;

/**
 * Configuration collention of application
*/
class Configs extends ArrayCollection
{
    /**
     * Instance to Singleton pattern
     *
     * @var \Attw\Config\Configs
    */
    private static $instance;

    private function __construct() {}

    private function __clone() {}

    /**
     * Return the instance of configs
     *
     * @return \Attw\Config\Configs
    */
    public static function getInstance()
    {
        if (!(self::$instance instanceof Configs)) {
            self::$instance = new Configs();
        }

        return self::$instance;
    }
}