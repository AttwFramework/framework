<?php
namespace Attw\File\Validator;

use Attw\File\Validator\AbstractFileValidator;
use Attw\File\FileInterface;

abstract class AbstractSizeFileValidator extends AbstractFileValidator
{
	/**
	 * @var integer
	*/
	protected $size;

    /**
     * @var integer
    */
    protected $comparison;

	/**
	 * @param integer $size
	*/
	public function __construct($size)
	{
		if (!is_int($size)) {
			throw new InvalidArgumentException('Size should be integer');
		}

		$this->size = 1024 * 1024 * $size;
	}

	/**
     * The validation of file
     *
     * @param instanceof Attw\File\File $file
     * @return boolean
    */
    protected function realValidation(FileInterface $file)
    {
        if ($this->comparison == 0) {
        	return $this->size >= $file->getSize();
        }

        return $this->size <= $file->getSize();
    }
}