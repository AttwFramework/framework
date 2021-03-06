<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Mvc\Model\Exception;

use \Exception;

class ModelException extends Exception
{
    public static function modelNotFound($model)
    {
        throw new ModelException('Model not found: ' . $model);
    }

    public static function invalidModel($model)
    {
        throw new ModelException('Invalid model: ' . $model);
    }

    public static function storageNotDefined()
    {
        throw new ModelException('Storage was not defined');
    }

    public static function entityStorageNotDefined()
    {
        throw new ModelException('Entity storage was not defined');
    }
}