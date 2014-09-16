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
 * Checks if a file has reached its minimum size
*/
class MinSize extends AbstractSizeFileValidator
{
    protected $comparasion = 1;

    /**
     * Message to exception
     *
     * @var string
    */
    protected $exceptionMsg = 'The file is smaller than you min size: {SIZE}';
}