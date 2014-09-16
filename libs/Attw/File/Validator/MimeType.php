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

class MimeType extends AbstractValidatorInArray
{
    /**
     * @var string
    */
    protected $fileMethod = 'getMimeType';

    /**
     * Message to exception
     *
     * @var string
    */
    protected $exceptionMsg = 'The type of file is invalid. Valid types: {ARRAY}';
}