<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Tool\Collection;

use \Countable;
use \IteratorAggregate;

/**
 * Interface for collections
*/
interface CollectionInterface extends Countable, IteratorAggregate
{
    /**
     * Clear the collection
    */
    public function clear();

    /**
     * Removes an entry
    */
    public function remove($key);

    /**
     * Returns the value of an entry
     *
     * @return mixed
    */
    public function get($key);

    /**
     * Returns all entries
     *
     * @return mixed
    */
    public function getAll();

    /**
     * Insert an entry
    */
    public function set($key, $value);

    /**
     * Verify if an entry exists
     *
     * @return boolean
    */
    public function exists($key);

    /**
     * Verify if collection is empty
    */
    public function isEmpty();
}