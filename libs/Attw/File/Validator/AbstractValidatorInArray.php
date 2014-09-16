<?php
namespace Attw\File\Validator;

use Attw\File\Validator\AbstractFileValidator;
use Attw\File\FileInterface;

abstract class AbstractValidatorInArray extends AbstractFileValidator
{
	/**
     * @var array
    */
    protected $accepted;

    /**
	 * @var string
    */
    protected $fileMethod;

    /**
	 * @var array
    */
    protected $fileMethodParams = array();

    /**
     * Constructor
     *
     * @param array $accepted
    */
    public function __construct(array $accepted)
    {
        $this->accepted = $accepted;
        $this->createExceptionMessage($this->exceptionMsg, $accepted);
    }

    /**
     * @param \Attw\File\FileInterface
    */
    protected function realValidation(FileInterface $file)
    {
        return in_array(call_user_func_array(array($file, $this->fileMethod), $this->fileMethodParams), $this->accepted);
    }

    /**
     * @param string $message
     * @param array  $array
    */
    protected function createExceptionMessage($message, array $array)
    {
        $this->exceptionMsg = str_replace('{ARRAY}', implode(', ', $array), $message);
    }
}