<?php
namespace Attw\File\Validator;

use Attw\File\Validator\AbstractFileValidator;

abstract class AbstractSizeFileValidator extends AbstractFileValidator
{
	/**
	 * @var integer
	*/
	protected $size;

	/**
	 * @param integer $size
	*/
	public function __construct($size)
	{
		if (!is_int($size)) {
			throw new InvalidArgumentException('Size should me integer');
		}

		$this->size = 1024 * 1024 * $size;
	}
}