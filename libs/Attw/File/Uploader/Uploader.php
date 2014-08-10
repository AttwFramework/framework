<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\File\Uploader;

use Attw\File\FileInterface;
use \RuntimeException;

/**
 * Download files from user to server
*/
class Uploader
{
    /**
     * Download a file
     *
     * @param instanceof Attw\File\File $file File to upload
     * @param string $directory Directory to upload file
     * @return boolean
    */
    public function upload(FileInterface $file, $directory)
    {
        return move_uploaded_file($file->getTmpName(), $directory . DIRECTORY_SEPARATOR . $file->getName());
    }
}