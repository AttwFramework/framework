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