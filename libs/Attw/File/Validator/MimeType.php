<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\File\Validator;

use Attw\File\Validator\AbstractFileValidator;
use Attw\File\FileInterface;

class MimeType extends AbstractFileValidator
{
    /**
     * Array with valid types
     *
     * @var array
    */
    private $types;

    /**
     * Constructor
     *
     * @param array $types Valid types
    */
    public function __construct(array $types)
    {
        $this->types = $types;
        $this->exceptionMsg = sprintf(
            'The type of file is invalid. Valid types: %s',
            implode(', ', $this->types)
       );
    }

    protected function realValidation(FileInterface $file)
    {
        return in_array($file->getMimeType(), $this->types);
    }
}