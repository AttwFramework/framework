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
use \InvalidArgumentException;

/**
 * Check if the file have a valid extension
*/
class Extension extends AbstractFileValidator
{
    /**
     * Array with the valid extensions
     *
     * @var array
    */
    private $extensions;

    public function __construct(array $extensions)
    {
        $this->extensions = $extensions;
        $this->exceptionMsg = sprintf(
            'Invalid extension. The file must have an of these extensions: %s',
            implode(', ', $this->extensions)
       );
    }

    /**
     * The validation of file
     *
     * @param instanceof Attw\File\File $file
     * @return boolean
    */
    protected function realValidation(FileInterface $file)
    {
        return in_array($file->getExtension(), $this->extensions);
    }
}