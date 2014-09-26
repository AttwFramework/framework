<?php
/**
 * AttwFramework
 *
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
 * @link http://attwframework.github.io
*/

namespace Attw\Paginator\Render;

use Attw\Paginator\PaginatorInterface;

interface PaginatorRenderInterface
{
    /**
     * Render some pagineted
     *
     * @param \Attw\Paginator\PaginatorInterface $paginator
    */
    public function render(PaginatorInterface $paginator);
}