<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Mvc\Model;

use Attw\DB\Storage\StorageInterface;
use Attw\DB\Entity\EntityStorageInterface;
use Attw\Core\Object;

/**
 * Interface to models
*/
abstract class AbstractModel extends Object
{
    /**
     * Use to data persistence
     *
     * @var \Attw\DB\Storage\Storage
    */
    protected $storage;

    /**
     * Use to data entity persistence
     *
     * @var \Attw\DB\Entity\EntityStorage
    */
    protected $entity;

    /**
     * Configure the storage and storage to entities
     *
     * @param \Attw\DB\Storage\StorageInterface      $storage
     * @param \Attw\DB\Entity\EntityStorageInterface $entityStorage
     * @throws \RuntimeException case is not defined a default connection
    */
    public function __construct(StorageInterface $storage, EntityStorageInterface $entityStorage)
    {
        $this->setStorage($storage);
        $this->setEntityStorage($entityStorage);
    }

    /**
     * Setter for storage object
     *
     * @param \Attw\DB\Storage\StorageInterface      $storage
    */
    public function setStorage(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Returns storage object
     *
     * @return \Attw\DB\Storage\StorageInterface
    */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Setter for entity storage object
     *
     * @param \Attw\DB\Entity\EntityStorageInterface $entityStorage
    */
    public function setEntityStorage(EntityStorageInterface $entityStorage)
    {
        $this->entityStorage = $entityStorage;
    }

    /**
     * Returns entity storage object
     *
     * @return \Attw\DB\Entity\EntityStorageInterface
    */
    public function getEntityStorage()
    {
        return $this->entityStorage;
    }
}