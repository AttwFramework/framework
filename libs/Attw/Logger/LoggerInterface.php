<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Logger;

/**
 * Interface to loggers
*/
interface LoggerInterface
{
    /**
     * Write a log
     *
     * @param string $type type of log
     * @param string $message message to log
    */
    public static function write($type, $message);
}