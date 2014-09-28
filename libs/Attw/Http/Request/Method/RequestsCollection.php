<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
 */

namespace Attw\Http\Request\Method;

use Attw\Tool\Collection\ArrayCollection;

class RequestsCollection extends ArrayCollection
{
    /**
     * @param array $fields
    */
    public function __construct(array $fields = array())
    {
        foreach ($fields as $key => $value) {
            $this->set($key, $value);
        }
    }
}