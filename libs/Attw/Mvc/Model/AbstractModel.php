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
use Attw\Core\Object;

/**
 * Interface to models
*/
abstract class AbstractModel extends Object
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
     * Configure the storage and storage to entities
     *
     * @param \Attw\Db\Storage\StorageInterface      $storage
     * @param \Attw\Db\Entity\EntityStorageInterface $entityStorage
    */
    public function __construct(StorageInterface $storage, EntityStorageInterface $entityStorage)
    {
        $this->setStorage($storage);
        $this->setEntityStorage($entityStorage);
    }

    /**
     * Setter for storage object
     *
     * @param \Attw\Db\Storage\StorageInterface $storage
    */
    public function setStorage(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Returns storage object
     *cd c:?workspace/var/www/
     * @return \Attw\Db\Storage\StorageInterface
    */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Setter for entity storage object
     *
     * @param \Attw\Db\Entity\EntityStorageInterface $entityStorage
    */
    public function setEntityStorage(EntityStorageInterface $entityStorage)
    {
        $this->entityStorage = $entityStorage;
    }

    /**
     * Returns entity storage object
     *
     * @return \Attw\Db\Entity\EntityStorageInterface
    */
    public function getEntityStorage()
    {
        return $this->entityStorage;
    }
}