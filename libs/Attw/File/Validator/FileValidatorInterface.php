<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\File\Validator;

use Attw\File\FileInterface;

/**
 * Interface to file validators
*/
interface FileValidatorInterface
{
    /**
     * Validate a file
     *
     * @param instanceof Attw\File\File $file
     * @return boolean case exception is not on
    */
    public function validate(FileInterface $file);
}
