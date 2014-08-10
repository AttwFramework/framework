<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Model;

use Attw\DB\Storage\Storage;
use Attw\DB\Entity\EntityStorage;
use Attw\Core\Object;
use Attw\DB\Collection as DBCollection;
use Attw\Config\Configs;
use \RuntimeException;

/**
 * Interface to models
*/
abstract class AbstractModel extends Object
{
    /**
     * Connection instance
     *
     * @var \Attw\DB\Connection\ConnectorInterface
    */
    protected $connection;

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
     * @throws \RuntimeException case is not defined a default connection
    */
    public function __construct()
    {
        $dbcollection = DBCollection::getInstance();

        if ($dbcollection->exists('Default')) {
        $connection = $dbcollection->get('Default');
        } else {
        throw new RuntimeException('Define a default connection in Configs class');
        }

        $configs = Configs::getInstance();
        $sqlGenerators = $configs->get('SQLGenerators');

        if (!isset($sqlGenerators[ strtolower($connection->getDriver()) ])) {
        throw new RuntimeException('SQL generator to this driver type not founded');
        }

        $this->connection = $connection;
        $this->storage = new Storage($connection,
        $sqlGenerators[ strtolower($connection->getDriver()) ]
       );
        $this->entity = new EntityStorage($this->storage);
    }
}