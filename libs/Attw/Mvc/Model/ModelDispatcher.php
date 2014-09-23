<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Mvc\Model;

use Attw\Db\Storage\StorageInterface;
use Attw\Db\Entity\EntityStorageInterface;
use Attw\Mvc\Model\Exception\ModelException;

class ModelDispatcher
{
    /**
     * Storage object
     *
     * @var \Attw\Db\Storage\StorageInterface
    */
    protected $storage;

    /**
     * Entity storage object
     *
     * @var \Attw\Db\Entity\EntityStorageInterface
    */
    protected $entityStorage;
    
    /**
     * @param \Attw\Db\Storage\StorageInterface      $storage
     * @param \Attw\Db\Entity\EntityStorageInterface $entityStorage
    */
    public function __construct(StorageInterface $storage = null, EntityStorageInterface $entityStorage = null)
    {
        $this->storage = $storage;
        $this->entityStorage = $entityStorage;
    }

    /**
     * @param string                                 $modelNamespace
     * @param string                                 $model
     * @return object
    */
    public function dispatch($modelNamespace, $model)
    {
        if ($this->storage === null) {
            ModelException::storageNotDefined();
        } elseif ($this->entityStorage === null) {
            ModelException::entityStorageNotDefined();
        }

        $objectName = $modelNamespace . '\\' . $model;

        if (!class_exists($objectName)) {
            ModelException::modelNotFound($objectName);
        }

        if (!(new $objectName($this->storage, $this->entityStorage) instanceof AbstractModel)) {
            ModelException::invalidModel($objectName);
        }

        return new $objectName($this->storage, $this->entityStorage);
    }
}