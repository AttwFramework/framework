<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Html\Element;

use Attw\Html\Element\AbstractHtmlElement;

abstract class AbstractHtmlElementLeaf extends AbstractHtmlElement
{
    /**
     * Render the element
     *
     * @return string
    */
    public function render()
    {
        $attrs = $this->createAttrs();

        return sprintf('<%s %s/>', $this->elementName, $attrs);
    }
}