<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\File;

use \UnexpectedValueException;
use \RuntimeException;
use Attw\File\FileInterface;

/**
 * File to object
*/
class File implements FileInterface
{
    /**
     * File compoenents
     *
     * @var array
    */
    private $file;

    /**
     * Set the file
     *
     * @param array $file File ($_FILES['file'])
     * @throws \UnexpectedValueException case param $file is not a file
    */
    public function __construct(array $file)
    {
        $this->file = $file;

        if (!isset($file['tmp_name']) && !file_exists($file['tmp_name'])) {
            throw new UnexpectedValueException('Invalid file: ' . print_r($file, true));
        }

        $this->detectExtension();
    }

    /**
     * Returns the name of the file
     *
     * @return string
    */
    public function getName()
    {
        return $this->file['name'];
    }

    /**
     * Returns the name of the file
     *
     * @param string $name
    */
    public function setName($name)
    {
        $this->file['name'] = (string) $name;
    }

    /**
     * Returns the temporary name of the file
     *
     * @return string
    */
    public function getTmpName()
    {
        return $this->file['tmp_name'];
    }

    /**
     * Returns the mime type of the file
     *
     * @return string
    */
    public function getMimeType()
    {
        return $this->file['type'];
    }

    /**
     * Returns the size of the file
     *
     * @return integer
    */
    public function getSize()
    {
        return $this->file['size'];
    }

    /**
     * Returns the extension of the file
     *
     * @return string
    */
    public function getExtension()
    {
        return $this->file['extension'];
    }

    /**
     * Returns the extension
     *
     * @param string $extension
    */
    public function setExtension($extension)
    {
        $this->file['extension'] = $extension;
    }

    /**
     * To detect the file extension
    */
    private function detectExtension()
    {
        $arr = explode('.', $this->file['name']);
        $this->file['extension'] = end($arr);
    }
}