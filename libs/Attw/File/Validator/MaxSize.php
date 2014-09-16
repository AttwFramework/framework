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
    protected $comparasion = 0;

    /**
     * Message to exception
     *
     * @var string
    */
    protected $exceptionMsg = 'The file is bigger than you max size: {SIZE}';
}