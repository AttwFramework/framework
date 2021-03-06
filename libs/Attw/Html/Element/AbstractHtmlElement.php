<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Html\Element;

use Attw\Html\Exception\HtmlException;
use Attw\Html\RenderizableInterface;

/**
 * Interface to html elements
*/
abstract class AbstractHtmlElement implements RenderizableInterface
{
    /**
     * Name of HTML element
     *
     * @var string
    */
    protected $elementName;

    /**
     * Attributes of html element
     *
     * @var array
    */
    private $attrs = array();

    /**
     * Add an attribute to element
     *
     * @param string $attrubute
     * @param string $value
     * @return $this
    */
    public function addAttr($attribute, $value)
    {
        $this->attrs[$attribute] = $value;

        return $this;
    }

    /**
     * Create a HTML code with attributes
    */
    protected function createAttrs()
    {
        $render = null;

        foreach ($this->attrs as $attr => $value) {
            $render .= $attr . '="' . $value . '" ';
        }

        return $render;
    }
}