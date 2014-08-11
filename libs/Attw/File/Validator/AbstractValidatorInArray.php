<?php
namespace Attw\File\Validator;

use Attw\File\Validator\AbstractFileValidator;

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
    }

    /**
     * @param \Attw\File\FileInterface
    */
    protected function realValidation(FileInterface $file)
    {
        return in_array(call_user_func_array(array($file, $this->fileMethod), $this->fileMethodParams), $this->accepted);
    }
}