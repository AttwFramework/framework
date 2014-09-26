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

class StandartPaginatorRender implements PaginatorRenderInterface
{
    private $html = '<div>{NUMBER}</div>';

    /**
     * @param \Attw\Paginator\PaginatorInterface $paginator
     * @param string|null                        $pagiLink
     * @return string
    */
    public function render(PaginatorInterface $paginator, $pageLink = null)
    {
        $paginated = $paginator->getPaginated();
        $currentPage = $paginator->getCurrentPage();
        $count = $paginator->count();

        for ($i = 1; $i <= $count; $i++) {
            $num = $i == $currentPage ? '<b>' . $i . '</b>' : $i;
            $numbers[] = $pageLink === null ? $i : '<a href="' . $pageLink . '">' . $num . '</a>';
        }

        $numbersToShow = implode(' | ', $numbers);

        return str_replace('{NUMBER}', $numbersToShow, $this->html);
    }
}