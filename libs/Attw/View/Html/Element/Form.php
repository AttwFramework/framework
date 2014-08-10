<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\View\Html\Element;

use Attw\View\Html\AbstractHtmlElementNotLeaf;
use Attw\View\Html\Element\Input;

class Form extends AbstractHtmlElementNotLeaf
{
    protected $elementName = 'form';

    public function __construct($method = null, $action = null, $enctype = null)
    {
        (!is_null($method)) ? $this->addAttr('method', $method) : null;
        (!is_null($action)) ? $this->addAttr('action', $action) : null;
        (!is_null($enctype)) ? $this->addAttr('enctype', $enctype) : null;
    }
}