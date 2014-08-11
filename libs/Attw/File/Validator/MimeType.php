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
     * Constructor
     *
     * @param array $types Valid types
    */
    public function __construct(array $types)
    {
        parent::__construct($types);
        $this->exceptionMsg = sprintf(
            'The type of file is invalid. Valid types: %s',
            implode(', ', $types)
       );
    }
}