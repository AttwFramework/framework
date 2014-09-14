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
     * Returns the name of the file
     *
     * @return string
    */
    public function getName();

    /**
     * Returns the temporary name of the file
     *
     * @return string
    */
    public function getTmpName();

    /**
     * Returns the mime type of the file
     *
     * @return string
    */
    public function getMimeType();

    /**
     * Returns the size of the file
     *
     * @return integer
    */
    public function getSize();

    /**
     * Returns the extension of the file
     *
     * @return string
    */
    public function getExtension();
}