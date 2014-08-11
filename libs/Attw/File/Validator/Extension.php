<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\File\Validator;

use Attw\File\Validator\AbstractValidatorInArray;

/**
 * Check if the file have a valid extension
*/
class Extension extends AbstractValidatorInArray
{
    protected $fileMethod = 'getExtension';

    public function __construct(array $extensions)
    {
        parent::__construct($extensions);
        $this->exceptionMsg = sprintf(
            'Invalid extension. The file must have an of these extensions: %s',
            implode(', ', $extensions)
       );
    }
}