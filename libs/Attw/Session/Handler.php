<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Session;

use \SessionHandlerInterface;
use \SplFileObject;

class Handler implements SessionHandlerInterface
{
    private $sessionPath;

    public function open($save_path, $name)
    {
        if (!is_dir($save_path)) {
            mkdir($save_path, 0777);
        }

        $this->sessionPath = $save_path;

        return true;
    }

    public function close()
    {
        return true;
    }

    public function read($session_id)
    {
        $fileDir = $this->sessionPath . '/sess_' . $session_id;

        $fileIterator = new SplFileObject($fileDir);
        $string = '';

        while (!$fileIterator->eof()) {
            $string .= $fileIterator->fgets();
        }

        return (string) $string;
    }

    public function write($session_id, $session_data)
    {
        $fileDir = $this->sessionPath . '/sess_' . $session_id;

        $fileIterator = new SplFileObject($fileDir);

        return ($fileIterator->fwrite($session_data) === false) ? false : true;
    }

    public function destroy($session_id)
    {
        $fileDir = $this->sessionPath . '/sess_' . $session_id;

        if (file_exists($fileDir)) {
            return unlink($fileDir);
        }
    }

    public function gc($maxlifetime)
    {
        $fileDir = $this->sessionPath . 'sess_*';

        foreach (glob($fileDir) as $file) {
            if (filemtime($file) + $maxlifetime < time() && file_exists($file)) {
                return unlink($file);
            }
        }
    }
}