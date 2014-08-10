<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Logger;

use Attw\Logger\AbstractLogger;
use \RuntimeException;
use \InvalidArgumentException;
use \DateTime;
use \DateTimeZone;

/**
 * File logger
*/
class FileLogger extends AbstractLogger
{
    /**
     * File to registry the logs
     *
     * @var string
    */
    private static $file;

    /**
     * Log to registry in file
     *
     * @var string
    */
    private static $log;

    /**
     * Replace log content to the ultimate
     *
     * @var boolean false to append a new log
    */
    private static $replace = false;

    /**
     * Locals to save logs of specific type
     *
     * @var array
    */
    private static $locals = array();

    /**
     * Set where the log will be registred
     *
     * @param string $file
     *  if file doesn't exists, create empty
     * @throws \RuntimeException case file not exists
     * @throws \RuntimeException case file is not writeable
    */
    public static function setFile($file)
    {
        if (!file_exists($file)) {
            throw new RuntimeException('File not found: ' . $file);
        }

        if (!is_writable($file)) {
            throw new RuntimeException('File not writeable: ' . $file);
        }

        self::$file = (string) $file;
    }

    /**
     * Choose if the new log will replace the file to it
     *
     * @param boolean $replace
     * @throws \InvalidAgumentException case param $replace is not boolean
    */
    public static function replace($replace)
    {
        if (!is_bool($replace)) {
            throw new InvalidArgumentException('The first argument must be boolean');
        }

        self::$replace = $replace;
    }

    /**
     * Write a log in a file
     *
     * @param string $type
     * @param string $message
     * @return void
    */
    public static function write($type, $message)
    {
        self::logConstruct($type, $message);

        if (is_null(self::$file)) {
            if (count(self::$locals) > 0) {
                foreach (self::$locals as $logType => $local) {
                    if ($logType == $type) {
                        self::setFile($local);
                    }
                }

                if (is_null(self::$file)) {
                    throw new RuntimeException('Define a file to save the logs or a file to save the logs');
                }
            }
        }

        return (!self::$replace) ? file_put_contents(self::$file, self::$log . "\n", FILE_APPEND) :
                        file_put_contents(self::$file, self::$log . "\n");
    }

    /**
     * Construct a log by the log structure
     *
     * @param string $type
     * @param string $message
    */
    private static function logConstruct($type, $message)
    {
        $types = array_flip(self::$types);

        if (isset($types[ $type ])) {
            $type = $types[ $type ];
        }

        $date = new DateTime();
        $date = $date->format('Y/m/d H:i:s');

        $arr = array_merge(self::$customizedCamps, array(
            ':type' => ucfirst($type), ':date' => $date, ':message' => $message
        ));

        self::$log = self::$logStructure;

        foreach ($arr as $camp => $value) {
            self::$log  = str_replace($camp, $value, self::$log);
        }
    }

    /**
     * Set local for specific types of logs
     *
     * @param array $locals
    */
    public static function setLogsLocals(array $locals)
    {
        self::$locals = array_merge(self::$locals, $locals);
    }
}