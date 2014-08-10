<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\File;

/**
 * Interface to files
*/
interface FileInterface
{
    /**
     * Get the name of the file
     *
     * @return string
    */
    public function getName();

    /**
     * Get the temporary name of the file
     *
     * @return string
    */
    public function getTmpName();

    /**
     * Get the mime type of the file
     *
     * @return string
    */
    public function getMimeType();

    /**
     * Get the size of the file
     *
     * @return integer
    */
    public function getSize();

    /**
     * Get the extension of the file
     *
     * @return string
    */
    public function getExtension();
}