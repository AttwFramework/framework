<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\File\Validator;

use Attw\File\Validator\FileValidatorInterface;
use Attw\File\Validator\Exception\FileValidatorException;
use Attw\File\FileInterface;

/**
 * Abstract file validator
*/
abstract class AbstractFileValidator implements FileValidatorInterface
    {
    /**
     * To activate or no the exception case the validation fail
     *
     * @var boolean
    */
    private $exception = false;

    /**
     * Message to exception
     *
     * @var string
    */
    protected $exceptionMsg;

    /**
     * Activate the exceptions
     *
     * @param boolean $on
    */
    public function exception($on = false)
    {
        $this->exception = $on;
    }

    /**
     * Validate the file
     *
     * @param \Attw\File\FileInterface $file
     * @return boolean
     * @throws \Attw\File\Validator\Exception\FileValidatorException case fail and the exception
     *  are activated
    */
    public function validate(FileInterface $file)
    {
        if ($this->realValidation($file)) {
            return true;
        } else {
            if ($this->exception) {
                throw new FileValidatorException('Invalid file: ' . $this->exceptionMsg);
            } else {
                return false;
            }
        }
    }

    /**
     * Real validation
     *
     * @param instanceof Attw\File\File $file
     * @return boolean
    */
    abstract protected function realValidation(FileInterface $file);
}