<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Core;

use \RuntimeException;
use Attw\Logger\FileLogger;
use Attw\Application\Configs;

abstract class Object
{
    /**
     * Get the name of object
     *
     * @return string
    */
    public function __toString()
    {
        return get_class($this);
    }

    /**
     * Call a method of this object
     *
     * @param string $method Method to call
     * @param array $params Params to method
     * @return mixed Return the return of method called
    */
    public function callMethod($method, array $params = array())
    {
        if (!method_exists($method, $this)) {
            throw new RuntimeException(sprintf('Method doesn\'t exists: %s::%s()',
                                get_class($this),
                                (string) $method));
        }

        return call_user_func_array(array($this, $method), $params);
    }

    /**
     * Write a log
     * The log will be save on file defined in Configs
     *
     * @param string $message Message to log
     * @param string | integer $type Log type
     * @throws \RuntimeException case logs is not actived
     * @return mixed Return of Logger\Log\File::write()
    */
    public function writeLog($message, $type = LOG_ERR)
    {
        return FileLogger::write($type, print_r($message, true));
    }
}