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

abstract class AbstractHtmlElementNotLeaf extends AbstractHtmlElement
{
    /**
     * Children of elements that are not leafs
     *
     * @var array
    */
    private $children = array();

    /**
     * Add a child to element that is not a leaf
     *
     * @param instanceof Attw\View\Html\AbstractHtmlElement $component
     * @return $this
    */
    public function addChild(AbstractHtmlElement $component)
    {
        $this->children[] = $component;

        return $this;
    }

    /**
     * Create a HTML code with children
    */
    private function createChildren()
    {
        $render = null;

        foreach ($this->children as $child) {
            $render .= $child->render() . "\n";
        }

        return $render;
    }

    /**
     * Render the element
     *
     * @return string
    */
    public function render()
    {
        $children = $this->createChildren();
        $attrs = $this->createAttrs();

        return sprintf('<%s %s>%s</%s>', $this->elementName, $attrs, $children, $this->elementName);
    }
}