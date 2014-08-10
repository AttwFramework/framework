<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Tool\Collection;

use Attw\Tool\Collection\CollectionInterface;
use \ArrayIterator;

/**
 * Collection implementes on array
*/
class ArrayCollection implements CollectionInterface
{
    /**
     * All entries will be registred here
     *
     * @var array
    */
    private $array = array();

    /**
     * @param string $key
     * @param mixed  $value
    */
    public function set($key, $value)
    {
        $this->array[ $key ] = $value;
    }

    /**
     * @param string $key
    */
    public function get($key)
    {
        if ($this->exists($key)) {
            return $this->array[ $key ];
        }

        return null;
    }

    /**
     * @param string $key
    */
    public function remove($key)
    {
        unset($this->array[ $key ]);
    }

    /**
     *
    */
    public function clear()
    {
        $this->array = array();
    }

    /**
     * @param string $key
    */
    public function exists($key)
    {
        return isset($this->array[ $key ]);
    }

    /**
     * @return boolean
    */
    public function isEmpty()
    {
        return ($this->count() > 0);
    }

    /**
     * @return integer
    */
    public function count()
    {
        return count($this->array);
    }

    /**
     * @return \ArrayIterator
    */
    public function getIterator()
    {
        return new ArrayIterator($this->array);
    }
}