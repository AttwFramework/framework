<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\File\Validator;

use Attw\File\Validator\AbstractSizeFileValidator;
use Attw\File\FileInterface;
use \InvalidArgumentException;

/**
 * Checks if a file has reached its maximum size
*/
class MaxSize extends AbstractSizeFileValidator
{
    /**
     * Constructor
     *
     * @param integer $maxSize
     * @throws \InvalidArgumentException case The size is not an integer
    */
    public function __construct($maxSize)
    {
        parent::__construct($maxSize);
        $this->exceptionMsg = sprintf('The file is bigger than you max size: %s', $this->size);
    }

    /**
     * The validation of file
     *
     * @param instanceof Attw\File\File $file
     * @return boolean
    */
    protected function realValidation(FileInterface $file)
    {
        if ($this->size >= $file->getSize()) {
            return true;
        }

        return false;
    }
}