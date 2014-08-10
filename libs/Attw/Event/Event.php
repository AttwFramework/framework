<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Event;

class Event
{
    /**
     * Params to a listener
     *
     * @var array
    */
    private $params = array();

    /**
     * Set params to listener
     *
     * @param array $params
    */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * Get all params
     *
     * @return array
    */
    public function getParams()
    {
        return $this->params;
    }
}