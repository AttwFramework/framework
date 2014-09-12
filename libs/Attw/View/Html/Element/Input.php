<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\View\Html\Element;

use Attw\View\Html\AbstractHtmlElementLeaf;

class Input extends AbstractHtmlElementLeaf
{
    protected $elementName = 'input';

    /**
	 * @param string|null $type
	 * @param string|null $value
    */
    public function __construct($type = null, $value = null)
    {
    	$type !== null ? $this->addAttr('type', $type) : null;
    	$value !== null ? $this->addAttr('value', $value) : null;
    }
}