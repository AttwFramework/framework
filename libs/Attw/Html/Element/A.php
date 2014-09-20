<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Html\Element;

use Attw\Html\Element\AbstractHtmlElementNotLeaf;

class A extends AbstractHtmlElementNotLeaf
{
    protected $elementName = 'a';

    public function __construct($href = null, $target = null)
    {
        $href !== null ? $this->addAttr('href', $href) : null;
        $target !== null ? $this->addAttr('target', $target) : null;
    }
}